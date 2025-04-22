<div>
    <div x-data="{
        tabSelected: 1,
        tabId: $id('tabs'),
        tabButtonClicked(tabButton) {
            this.tabSelected = tabButton.id.replace(this.tabId + '-', '');
            this.tabRepositionMarker(tabButton);
        },
        tabRepositionMarker(tabButton) {
            this.$refs.tabMarker.style.width = tabButton.offsetWidth + 'px';
            this.$refs.tabMarker.style.height = tabButton.offsetHeight + 'px';
            this.$refs.tabMarker.style.left = tabButton.offsetLeft + 'px';
        },
        tabContentActive(tabContent) {
            return this.tabSelected == tabContent.id.replace(this.tabId + '-content-', '');
        }
    }" x-init="tabRepositionMarker($refs.tabButtons.firstElementChild);" class="relative w-full ">

        <div x-ref="tabButtons"
            class="relative inline-grid items-center justify-center w-full h-10 grid-cols-2 p-1 text-gray-500 bg-gray-100 rounded-lg select-none">
            <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                class="relative z-20 inline-flex items-center justify-center w-full  h-8 px-3 text-sm font-bold transition-all rounded-md cursor-pointer whitespace-nowrap">STUDENT</button>
            <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-bold transition-all rounded-md cursor-pointer whitespace-nowrap">SUPERVISOR</button>
            <div x-ref="tabMarker" class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out" x-cloak>
                <div class="w-full h-full bg-white rounded-md shadow-sm"></div>
            </div>
        </div>
        <div class="relative w-full mt-2 content">
            <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative">
                <!-- Tab Content 1 - Replace with your content -->
                <div class="border rounded-lg shadow-sm bg-card text-neutral-900">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-lg font-semibold leading-none tracking-tight">Create Student Account</h3>
                        <p class="text-sm text-neutral-500">Put all the required inputs. Click save when you're
                            done.</p>
                    </div>
                    <div class="p-6 pt-0 grid grid-cols-3 gap-3 ">
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First
                                Name</label><input type="text" wire:model="firstname"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('firstname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Middle
                                Name</label><input type="text" wire:model="middlename"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('middlename')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Last
                                Name</label><input type="text" wire:model="lastname"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('lastname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Course</label>
                            <select name="" id="" wire:model="course_id"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select an Option</option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-sm text-red-500">
                                @error('course_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Major</label>
                            <select name="" id="" wire:model="major"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select an Option</option>
                                <option value="Intelligent System">Intelligent System</option>
                                <option value="Graphics and Visualization">Graphics and Visualization</option>
                                <option value="Animation and Motion Graphics">Animation and Motion Graphics</option>
                                <option value="Network Administration">Network Administration</option>
                                <option value="Service Management Program">Service Management Program</option>
                                <option value="Web and Mobile Application Development">Web and Mobile Application
                                    Development</option>
                                <option value="None">None</option>
                            </select>
                            <div class="text-sm text-red-500">
                                @error('major')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Section</label><input
                                type="text" wire:model="section"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('section')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class=" px-6 pb-6 grid grid-cols-2 gap-3 ">
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Student
                                ID</label><input type="text" wire:model="student_id"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('student_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Institutional
                                Email</label><input type="email" wire:model="institutional_email"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('institutional_email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class=" px-6 pb-6 grid grid-cols-3 gap-3 ">
                        <div class="col-span-2"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Address</label><input
                                type="text" wire:model="address"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Contact
                                No.</label><input type="number" wire:model="student_contact"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('student_contact')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-2"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Guardian
                                Name</label><input type="text" wire:model="guardian_name"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('guardian_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Contact
                                No.</label><input type="number" wire:model="guardian_contact"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('guardian_contact')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-3"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label><input
                                type="password" wire:model="password"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div class="flex items-center p-6 pt-0">
                        {{-- <button wire:click="registerStudent"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-gray-700 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">Register
                            Account</button> --}}
                        <x-button label="Register Account" slate class="font-semibold" wire:click="registerStudent"
                            spinner="registerStudent" />
                    </div>
                </div>
                <!-- End Tab Content 1 -->
            </div>

            <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative" x-cloak>
                <!-- Tab Content 2 - Replace with your content -->
                <div class="border rounded-lg shadow-sm bg-card text-neutral-900">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-lg font-semibold leading-none tracking-tight">Create Supervisor Account</h3>
                        <p class="text-sm text-neutral-500">Put all the required inputs. Click save when you're
                            done.</p>
                    </div>
                    <div class="p-6 pt-0 grid grid-cols-3 gap-3 ">
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First
                                Name</label><input type="text" wire:model="firstname"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('firstname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Middle
                                Name</label><input type="text" wire:model="middlename"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('middlename')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Last
                                Name</label><input type="text" wire:model="lastname"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('lastname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-2"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Company
                                Name</label><input type="text" wire:model="company_name"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('company_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class=""><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Contact
                                No.</label><input type="text" wire:model="contact_no"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('contact_no')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-3"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Company
                                Address</label><input type="text" wire:model="company_address"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('company_address')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Company
                                Location</label><input type="file" wire:model="file"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('file')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-2">

                        </div>
                        <div class="col-span-2"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label><input
                                type="email" wire:model="email"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-1"><label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label><input
                                type="password" wire:model="password"
                                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                            <div class="text-sm text-red-500">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-3"></div>
                        <div class="col-span-3"></div>
                        <div class="col-span-3">
                            {{ $this->form }}
                        </div>
                    </div>
                    <div class="flex items-center p-6 pt-0">
                        {{-- <button wire:click="registerSupervisor"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-gray-700 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">Register
                            Account</button> --}}

                        <x-button label="Register Account" slate class="font-semibold"
                            wire:click="registerSupervisor" spinner="registerSupervisor" />
                    </div>
                </div>
                <!-- End Tab Content 2 -->
            </div>

        </div>
    </div>
