<div>
    @php
        $moa = \App\Models\SupervisorMoa::where('supervisor_id', auth()->user()->supervisor->id)->first();
    @endphp
    @if ($moa)
        <ul class="space-y-4">
            <li>
                <h1 class="font-bold uppercase">SCHOOL NAME</h1>
                <h1 class="ml-5">Laguna State Polytechnic University – Siniloan Campus </h1>
            </li>
            <li>
                <h1 class="font-bold uppercase">School Address </h1>
                <h1 class="ml-5">L. de Leon Street, Siniloan, Laguna, Philippines </h1>
            </li>
            <li>
                <h1 class="font-bold uppercase">College Department </h1>
                <h1 class="ml-5">College of Computer Studies </h1>
            </li>
            <li>
                <h1 class="font-bold uppercase">Contact Person</h1>
                <h1 class="ml-5">{{ $moa->coordinator->user->name }}</h1>
            </li>
            <li>
                <h1 class="font-bold uppercase">Contact Number</h1>
                <h1 class="ml-5">{{ $moa->coordinator->contact_number }}</h1>
            </li>
            <li>
                <div class="grid grid-cols-2 gap-5 w-1/2">
                    <div>
                        <h1 class="font-bold uppercase">MOA File</h1>
                        <x-button href="{{ Storage::url($moa->moa_file_path) }}" target="_blank" label="View Upload" sm
                            squared outline slate right-icon="eye" class="font-semibold uppercase mt-2" />
                    </div>
                    <div>
                        <h1 class="font-bold uppercase">Expiration Date</h1>
                        <h1 class="ml-5 mt-2">{{ \Carbon\Carbon::parse($moa->expiration)->format('F d, Y') }}</h1>
                    </div>
                </div>
            </li>
            <li>
                <div class="flex space-x-3 w-1/2">
                    <x-button label="Approve" squared positive class="font-semibold" sm wire:click="approve" />
                    {{-- <x-button label="For the Review" squared yellow class="font-semibold" sm
                        @click="$dispatch('open-modal', { id: 'for-review' })" /> --}}
                    <x-button label="For the Review" squared yellow class="font-semibold" sm wire:click="forReview" />
                    <x-button label="Request for Revision" squared info class="font-semibold" sm
                        @click="$dispatch('open-modal', { id: 'for-revision' })" />
                    <x-button label="Reject" squared negative class="font-semibold" sm
                        @click="$dispatch('open-modal', { id: 'for-reject' })" />
                </div>

                <x-filament::modal id="for-revision">
                    <x-slot name="heading">
                        Create Remarks
                    </x-slot>
                    <x-slot name="description">
                        Please input your remarks below.
                    </x-slot>
                    <div>
                        <x-textarea placeholder="enter your remarks." wire:model="remarks" />
                    </div>
                    <x-slot name="footer">
                        <x-filament::button wire:click="requestRevision" wire:loading.attr="disabled"
                            wire:target="requestRevision">
                            Submit Remarks
                        </x-filament::button>
                    </x-slot>
                </x-filament::modal>

                <x-filament::modal id="for-reject">
                    <x-slot name="heading">
                        Create Remarks
                    </x-slot>
                    <x-slot name="description">
                        Please input your remarks below.
                    </x-slot>
                    <div>
                        <x-textarea placeholder="enter your remarks." wire:model="remarks" />
                    </div>
                    <x-slot name="footer">
                        <x-filament::button wire:click="reject" wire:loading.attr="disabled" wire:target="reject">
                            Submit Remarks
                        </x-filament::button>
                    </x-slot>
                </x-filament::modal>
            </li>
        </ul>
    @else
        <div class="p-5 flex flex-col justify-center items-center text-center">
            <x-shared.moa class="h-64" />
            <span>No Memorandum Of Agreement!</span>
        </div>
    @endif
</div>
