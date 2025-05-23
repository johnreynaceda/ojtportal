<div>
    <div class="w-1/2">
        {{ $this->form }}
    </div>
    @if (!$record)
        <div class="mt-5">
            <x-button label="Submit" wire:click="submit" class="font-semibold uppercase" squared positive
                right-icon="arrow-right" />
        </div>
    @endif
</div>
