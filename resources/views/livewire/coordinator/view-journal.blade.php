<div>
    <div class="mb-5 flex space-x-3 items-center">
        <x-button label="Back" squared class="font-medium" slate icon="arrow-left" outline
            href="{{ route('coordinator.journal') }}" />
        <span>|</span>
        <span class="uppercase text-lg font-semibold text-main">{{ $trainee_name }}</span>
    </div>
    <div>
        {{ $this->table }}
    </div>
</div>
