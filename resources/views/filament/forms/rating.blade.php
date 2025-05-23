<div>
    <div class="bg-gray-100 h-96 grid place-content-center">
        <div x-data="{
            disabled: false,
            max_stars: 5,
            stars: @entangle('rating'),
            value: 0,
            hoverStar(star) {
                if (this.disabled) {
                    return;
                }
        
                this.stars = star;
            },
            mouseLeftStar() {
                if (this.disabled) {
                    return;
                }
        
                this.stars = this.value;
            },
            rate(star) {
                if (this.disabled) {
                    return;
                }
        
                this.stars = star;
                this.value = star;
        
                $refs.rated.classList.remove('opacity-0');
                setTimeout(function() {
                    $refs.rated.classList.add('opacity-0');
                }, 2000);
            },
            reset() {
                if (this.disabled) {
                    return;
                }
        
                this.value = 0;
                this.stars = 0;
            }
        }" x-init="this.stars = this.value">
            <div class="flex flex-col items-center max-w-6xl mx-auto jusitfy-center">
                <div x-ref="rated"
                    class=" text-xs font-medium text-gray-900 duration-300 ease-out -translate-y-full opacity-0">
                    Rated <span x-text="value"></span> Stars</div>
                <ul class="flex mt-10">
                    <template x-for="star in max_stars">
                        <li @mouseover="hoverStar(star)" @mouseleave="mouseLeftStar" @click="rate(star)"
                            class="px-1 cursor-pointer" :class="{ 'text-gray-400 cursor-not-allowed': disabled }">
                            <svg x-show="star > stars" class="w-10 h-10 text-gray-900"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none" />
                                <path
                                    d="M128,189.09l54.72,33.65a8.4,8.4,0,0,0,12.52-9.17l-14.88-62.79,48.7-42A8.46,8.46,0,0,0,224.27,94L160.36,88.8,135.74,29.2a8.36,8.36,0,0,0-15.48,0L95.64,88.8,31.73,94a8.46,8.46,0,0,0-4.79,14.83l48.7,42L60.76,213.57a8.4,8.4,0,0,0,12.52,9.17Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="16" />
                            </svg>
                            <svg x-show="star <= stars" class="w-10 h-10 text-yellow-500 fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none" />
                                <path
                                    d="M234.29,114.85l-45,38.83L203,211.75a16.4,16.4,0,0,1-24.5,17.82L128,198.49,77.47,229.57A16.4,16.4,0,0,1,53,211.75l13.76-58.07-45-38.83A16.46,16.46,0,0,1,31.08,86l59-4.76,22.76-55.08a16.36,16.36,0,0,1,30.27,0l22.75,55.08,59,4.76a16.46,16.46,0,0,1,9.37,28.86Z" />
                            </svg>
                        </li>
                    </template>
                </ul>

            </div>
        </div>

    </div>
</div>
