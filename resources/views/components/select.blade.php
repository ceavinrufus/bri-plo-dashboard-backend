<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}"
        class='mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-1 border'>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @selected($key == old($name, $selected ?? ''))>{{ $option }}</option>
        @endforeach
    </select>
</div>
