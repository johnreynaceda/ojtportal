<div>
    <div class="mb-3">
        <x-button label="Back" class="font-semibold" icon="arrow-left" slate href="{{ route('supervisor.ratings') }}" />
    </div>
    <div class="flex flex-col">
        <div class=" overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden border rounded-lg border-gray-300">
                    @if (!$has_rating)
                        <table class=" min-w-full  rounded-xl">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="p-2  text-center leading-6 font-bold text-gray-900 capitalize">
                                        CRITERIA FOR EVALUATION</th>
                                    <th scope="col"
                                        class=" w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        MAXIMUM POINTS </th>
                                    <th scope="col"
                                        class=" w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        POINTS EARNED
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 ">
                                @forelse ($criterias as $criteria)
                                    <tr class="bg-gray-50 border-t">
                                        <td scope="col"
                                            class="p-2 text-left text-main uppercase leading-6 font-semibold ">
                                            {{ $criteria->name }} </td>
                                        <td scope="col"
                                            class="w-40p-2  text-sm text-center text-main leading-6 font-semibold  capitalize">
                                            ({{ $criteria->criteriaQuestions->sum('max_point') }})
                                        </td>
                                        <td scope="col"
                                            class="w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        </td>

                                    </tr>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($criteria->criteriaQuestions as $item)
                                        <tr>
                                            <td class="p-2 text-sm leading-6 font-medium text-gray-900">
                                                <p class="pl-10">
                                                    <strong class="pr-2">{{ $loop->iteration }}.</strong>
                                                    {{ $item->question }}
                                                </p>
                                            </td>

                                            <td
                                                class="w-40 p-2 whitespace-nowrap text-sm leading-6 font-medium text-center text-gray-900">
                                                {{ $item->max_point }}
                                            </td>

                                            <td
                                                class="w-40 p-2 whitespace-nowrap text-sm leading-6 font-medium text-center text-gray-900">
                                                <input type="number"
                                                    wire:model.debounce.500ms="points.{{ $item->id }}.earned"
                                                    class="w-10 border rounded text-center p-1" min="0"
                                                    max="{{ $item->max_point }}" />

                                                <input type="hidden" wire:model="points.{{ $item->id }}.id"
                                                    value="{{ $item->id }}">

                                                @error("points.{{ $item->id }}.earned")
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                @endforelse



                            </tbody>
                        </table>
                    @else
                        <table class=" min-w-full  rounded-xl">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="p-2  text-center leading-6 font-bold text-gray-900 capitalize">
                                        CRITERIA FOR EVALUATION</th>
                                    <th scope="col"
                                        class=" w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        MAXIMUM POINTS </th>
                                    <th scope="col"
                                        class=" w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        POINTS EARNED
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 ">
                                @forelse ($criterias as $criteria)
                                    <tr class="bg-gray-50 border-t">
                                        <td scope="col"
                                            class="p-2 text-left text-main uppercase leading-6 font-semibold ">
                                            {{ $criteria->name }} </td>
                                        <td scope="col"
                                            class="w-40p-2  text-sm text-center text-main leading-6 font-semibold  capitalize">
                                            ({{ $criteria->criteriaQuestions->sum('max_point') }})
                                        </td>
                                        <td scope="col"
                                            class="w-40 p-2 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">
                                        </td>

                                    </tr>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($criteria->criteriaQuestions as $item)
                                        <tr>
                                            <td class="p-2 text-sm leading-6 font-medium text-gray-900">
                                                <p class="pl-10">
                                                    <strong class="pr-2">{{ $loop->iteration }}.</strong>
                                                    {{ $item->question }}
                                                </p>
                                            </td>

                                            <td
                                                class="w-40 p-2 whitespace-nowrap text-sm leading-6 font-medium text-center text-gray-900">
                                                {{ $item->max_point }}
                                            </td>

                                            <td
                                                class="w-40 p-2 whitespace-nowrap text-sm leading-6 font-medium text-center text-gray-900">
                                                <input type="number" class="w-10 border rounded text-center p-1"
                                                    min="0"
                                                    value="{{ $responses[$item->id]['earned'] ?? 0 }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                @endforelse



                            </tbody>
                        </table>
                    @endif

                </div>
                @if (!$has_rating)
                    <div class="mt-5">
                        <x-button label="sdasdasd" wire:click="submitRating" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
