<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;

class StudentChat extends Component implements HasForms
{
    use InteractsWithForms;
    public $search;
    public $user_id;
    public $user_data;

    public $chat_id;
    public $message;
    public $chat_data;

    public $images = [];
    public $upload_modal = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('images')->required()
            ]);
    }

    public function chat($id){

    
        $chat = Chat::where('id', $id)->first();
        $this->chat_id = $chat->id;
       $this->chat_data = $chat;
       $userIds = json_decode($chat->user_ids, true);
       $this->user_id = collect($userIds)->first(fn($id) => $id != auth()->user()->id);
       $this->user_data = User::where('id', $this->user_id)->first();
           
          
        }

    public function chatUser($id){
        $ids = collect([auth()->user()->id, $id])->sort()->values()->all();
        $data = Chat::where('user_ids', json_encode($ids))->first();
        if ($data) {
            dd('meron');
        }else{
           $chat =  Chat::create([
                'user_id' => auth()->user()->id,
                'user_ids' => json_encode([auth()->user()->id, $id]),
            ]);
            $this->chat($chat->id);
            $this->user_id = $id;

        }
    }

    public function fileUpload(){
        $this->upload_modal = true;
    }

    public function sendChat(){
        if ($this->images) {
            foreach ($this->images as $key => $value) {
                Message::create([
                    'chat_id' => $this->chat_id,
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $this->user_id,
                   'message' => $this->message,
                   'image' => $value->store('Chat Images', 'public'),
                ]);
            }
        }else{
            Message::create([
                'chat_id' => $this->chat_id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $this->user_id,
               'message' => $this->message,
            ]);
        }
        $chat = Chat::where('id', $this->chat_id)->first();
        $this->chat_data = $chat;
        $this->message = null;
        $this->images = [];
        $this->upload_modal = false;
        
    }

    public function render()
    {
        return view('livewire.student-chat',[
            'users' => User::where('id', '!=', auth()->user()->id)->where('name', 'like', '%'. $this->search. '%')->get(),
            'chats' => Chat::whereJsonContains('user_ids', auth()->user()->id)->whereHas('messages', function($record){
                $record->orderByDesc('created_at');
            })->get(),
        ]);
    }
}
