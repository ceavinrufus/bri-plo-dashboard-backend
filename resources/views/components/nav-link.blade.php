@props(['active' => false, 'isMobile' => false])

<a {{ $attributes }}
    class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} {{ $isMobile ? 'block text-base' : 'text-sm' }} rounded-md px-3 py-2 font-medium"
    aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>
