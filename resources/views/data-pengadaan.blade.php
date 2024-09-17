<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Root div with Alpine.js -->
    <div x-data="{ isOpen: false }">

        <!-- Button to Open Drawer -->
        <div class="flex justify-between items-center mt-6">
            <h1>{{ $title }}</h1>
            <button @click="isOpen = true" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                Add Data
            </button>
        </div>

        @isset($data)
            <div class="mt-6 overflow-x-scroll">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <!-- Menampilkan nama kolom dari model Pengadaan -->
                            @foreach (array_keys($data->first()->getAttributes()) as $header)
                                <th class="border border-gray-300 px-4 py-2">{{ ucfirst($header) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Menampilkan setiap baris data -->
                        @foreach ($data as $row)
                            <tr>
                                @foreach ($row->getAttributes() as $cell)
                                    <td class="border border-gray-300 px-4 py-2">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endisset

        <!-- Drawer Component -->
        <x-drawer>
            <h1>Hi this is form</h1>
        </x-drawer>
    </div>
</x-layout>
