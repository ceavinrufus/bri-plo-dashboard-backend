@props(['active' => false, 'isMobile' => false, 'children' => null])

@if ($children)
    @if (!$isMobile)
        <div x-data="{ isExpanded: false }" class="relative" @mouseleave="isExpanded = false">
            <button type="button" @mouseover="isExpanded = true"
                class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} text-sm rounded-md px-3 py-2 font-medium flex items-center justify-between"
                aria-controls="disclosure-1" aria-expanded="false">
                {{ $slot }}
                <svg :class="{ 'rotate-180': isExpanded }" class="h-5 w-5 flex-none" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="isExpanded" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute -left-8 top-full z-10 pt-3 w-screen max-w-md ">

                <div class="p-4 rounded-3xl bg-white ring-1 ring-gray-900/5 shadow-lg overflow-hidden">
                    @foreach ($children as $child)
                        <div
                            class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                            {{-- <div
                            class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                            
                        </div> --}}
                            <div class="flex-auto">
                                <a href="{{ $child['url'] }}" class="block font-semibold text-gray-900">
                                    {{ $child['name'] }}
                                    <span class="absolute inset-0"></span>
                                </a>
                                <p class="mt-1 text-gray-600">{{ $child['description'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
    @else
        <div x-data="{ isExpanded: false }" class="relative">
            <button type="button" @click="isExpanded = !isExpanded"
                class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center text-base rounded-md px-3 py-2 font-medium w-full"
                aria-controls="disclosure-1" aria-expanded="false">
                {{ $slot }}
                <svg :class="{ 'rotate-180': isExpanded }" class="h-5 w-5 flex-none" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="isExpanded" class="mt-2 space-y-2">
                @foreach ($children as $child)
                    <div
                        class="relative flex items-center gap-x-6 rounded-md py-2 pl-6 pr-3 text-sm leading-7 hover:text-white font-medium text-gray-300 hover:bg-gray-700">
                        <a href="{{ $child['url'] }}" class="rounded-md font-medium">
                            {{ $child['name'] }}
                            {{ array_key_exists('description', $child) ? '(' . $child['description'] . ')' : '' }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@else
    <a {{ $attributes }}
        class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} {{ $isMobile ? 'block text-base' : 'text-sm' }} rounded-md px-3 py-2 font-medium"
        aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>
@endif
