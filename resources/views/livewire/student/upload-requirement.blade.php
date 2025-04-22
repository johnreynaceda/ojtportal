<div>
    @if ($requirements_count == 0)
        <div class="h-96 grid place-content-center">
            <x-button label="Upload Requirements Now!" class="font-semibold" lg squared negative outline
                wire:click="generateRequirement" />
        </div>
    @else
        <div class="glex space-x-3 items-center">
            <x-button label="Parent's Consent" sm class="font-semibold" slate wire:click="dlParentConsent" />
            <x-button label="Internship Training Plan" sm class="font-semibold" orange wire:click="dlInternshipPlan" />
            <x-button label="OJT-Time Frame" sm class="font-semibold" brown wire:click="dlTimeFrame" />
            <x-button label="Internship Contract" sm class="font-semibold" warning wire:click="dlContract" />
            <x-button label="Endorsement Letter" sm class="font-semibold" negative wire:click="dlEndorsement" />
        </div>
        <div class="mt-5">
            {{ $this->table }}
        </div>
    @endif
</div>
