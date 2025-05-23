<div class="ml-3">
    @php
        $student = $getRecord()->student;
        $total_spent = 0;
    @endphp

    @foreach ($student->studentJournals->where('journal_status', 'approved') as $item)
        @php
            $am_time_in = strtotime($item->am_timein);
            $am_time_out = strtotime($item->am_timeout);
            $pm_time_in = strtotime($item->pm_timein);
            $pm_time_out = strtotime($item->pm_timeout);

            $am_duration = ($am_time_out - $am_time_in) / 3600;
            $pm_duration = ($pm_time_out - $pm_time_in) / 3600;

            $total_spent = $am_duration + $pm_duration;

        @endphp
    @endforeach

    <p class="text-sm">
        {{ round(400 - $total_spent) }}
    </p>
</div>
