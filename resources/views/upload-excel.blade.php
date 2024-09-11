<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <form action="{{ route('upload.excel.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">Upload Excel File</label>
                <input type="file" name="file" id="file" accept=".xlsx, .xls"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                @error('file')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Upload</button>
            </div>
        </form>

        @isset($data)
            <div class="mt-6 overflow-x-scroll">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            @foreach ($data[0] as $header)
                                <th class="border border-gray-300 px-4 py-2">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_slice($data, 1) as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td class="border border-gray-300 px-4 py-2">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endisset
    </div>
</x-layout>
