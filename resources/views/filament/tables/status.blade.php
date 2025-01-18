<div class="pl-3">
    @switch($getRecord()->status)
        @case('')
            <span class="text-gray-500 italic">Pending...</span>
        @break

        @case('deployed')
            <span class="text-green-600 italic">Deployed...</span>
        @break

        @default
    @endswitch
</div>
