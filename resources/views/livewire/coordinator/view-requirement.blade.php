@section('title', 'VIEW REQUIREMENTS - ' . $student_name)

<div>
    <x-button label="Back" squared href="{{ route('coordinator.requirements') }}" outline class="font-medium" negative
        icon="arrow-left" />
    <div class="mt-5">
        {{ $this->table }}
    </div>
</div>
