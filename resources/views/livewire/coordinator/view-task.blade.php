<div>
    <div class="mb-5 flex space-x-3 items-center">
        <x-button label="Back" squared class="font-medium" slate icon="arrow-left" outline
            href="{{ auth()->user()->user_type == 'coordinator' ? route('coordinator.students-dtr') : route('supervisor.attendance') }}" />
        <span>|</span>
        <span class="uppercase text-lg font-semibold text-main">{{ $trainee_name }}</span>
    </div>
    <div>
        {{ $this->table }}
    </div>
</div>
