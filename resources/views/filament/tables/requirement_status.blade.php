<div class="ml-3">

    @if ($getRecord()->student->studentRequirements->where('status', null)->count() > 0)
        <x-badge flat slate icon="clock" label="In-progress" />
    @else
        <x-badge flat positive icon="document-check" label="Completed" />
    @endif
</div>
