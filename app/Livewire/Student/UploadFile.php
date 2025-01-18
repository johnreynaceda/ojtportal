<?php

namespace App\Livewire\Student;

use App\Models\StudentRequirement;
use App\Models\Post;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UploadFile extends Component implements HasForms
{
    use InteractsWithForms;

    public $file_id;
    public $file_name;
    public $upload = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('upload')->required(),
            ]);
    }

    public function uploadFile(){
        $data = StudentRequirement::where('id', $this->file_id)->first();
        foreach ($this->upload as $key => $value) {
            $data->update([
                'file_path' => $value->store('Requirement', 'public'),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('student.requirement.edited-docs');
    }

    public function mount(){
        $this->file_id = request('id');
        $data = StudentRequirement::where('id', $this->file_id)->first();
        $this->file_name = $data->name;
    }
    public function render()
    {
        return view('livewire.student.upload-file');
    }
}
