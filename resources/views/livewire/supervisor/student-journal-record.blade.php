@section('title', strtoupper($student->user->name) . "'s JOURNAL")
<div>
    {{ $this->table }}
</div>
