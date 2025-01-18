<div>
    @if ($requirements_count == 0)
        <div class="h-96 grid place-content-center">
            <x-button label="Upload Requirements Now!" class="font-semibold" lg squared negative outline
                wire:click="generateRequirement" />
        </div>
    @else
        {{ $this->table }}
    @endif
</div>
