<div>
    <div>
        <div class="w-1/2">
            {{ $this->form }}
            @if (!$response)
                <div class="my-2">
                    <x-button label="Submit" wire:click="submit" class="font-semibold uppercase" squared positive
                        right-icon="arrow-right" />
                </div>
            @endif
        </div>
        <div>
            {{ $this->table }}
        </div>`
    </div>
</div>
