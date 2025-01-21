<div>
    @if (!auth()->user()->student->trainee)
        <div
            class="relative mb-2 animate-pulse w-full rounded-lg border border-red-600 bg-white p-4 [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] [&:has(svg)]:pl-11 text-neutral-900">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="4 17 10 11 4 5"></polyline>
                <line x1="12" x2="20" y1="19" y2="19"></line>
            </svg>
            <h5 class="mb-1 font-medium text-red-700 leading-none tracking-tight">Alert Message</h5>
            <div class="text-sm ">This page is only available during your On-the-Job Training deployment.</div>
        </div>
    @endif
    <div>
        {{ $this->table }}
    </div>
</div>
