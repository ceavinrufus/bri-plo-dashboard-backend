<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

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
</x-layout>
