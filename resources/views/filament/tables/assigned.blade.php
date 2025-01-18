<div class="pl-3">
    <p class="text-sm">
        @foreach ($getRecord()->taskAssignedStudents as $item)
            {{ $item->trainee->student->user->name }}@if (!$loop->last)
                ,
            @endif
        @endforeach
    </p>
</div>
