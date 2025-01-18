@section('title', 'Upload ' . $file_name)
<div>
    <div class="w-96">
        {{ $this->form }}
    </div>
    <div class="mt-5">
        <div class="flex justify-start space-x-3">
            <x-button label="Upload" wire:click="uploadFile" squared positive class="font-medium"
                right-icon="arrow-right" />
            <x-button label="Close" squared slate class="font-medium" outline />
        </div>

    </div>
</div>
