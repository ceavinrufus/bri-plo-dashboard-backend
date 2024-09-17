<x-layout>
    <!-- Root div with Alpine.js -->
    <div x-data="{ isOpen: false }">
        <!-- Button to Open Drawer -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
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
                            @foreach (array_keys($data->first()) as $header)
                                <th class="border border-gray-300 px-4 py-2">{{ ucfirst($header) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Menampilkan setiap baris data -->
                        @foreach ($data as $row)
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

        <!-- Drawer Component -->
        <x-drawer>
            <!-- Form Pengadaan -->
            <form method="POST" action="{{ route('pengadaan.store') }}" class="space-y-4">
                @csrf

                <!-- Select Departemen -->
                <x-select id="departemen" name="departemen" label="Departemen" :options="['bcp' => 'BCP', 'igp' => 'IGP', 'psr' => 'PSR']" required />

                <!-- Nama Pengadaan -->
                <x-input id="nama_pengadaan" name="nama_pengadaan" label="Nama Pengadaan" required />

                <!-- Tanggal Nodin -->
                <x-input id="tanggal_nodin" name="tanggal_nodin" type="date" label="Tanggal Nodin" />

                <!-- Tanggal SPK -->
                <x-input id="tanggal_spk" name="tanggal_spk" type="date" label="Tanggal SPK" />

                <!-- Hari Pengerjaan -->
                <x-input id="hari_pengerjaan" name="hari_pengerjaan" type="number" label="Hari Pengerjaan" />

                <!-- Select Metode -->
                <x-select id="metode" name="metode" label="Metode" :options="[
                    'Pemilihan Langsung' => 'Pemilihan Langsung',
                    'Penunjukkan Langsung' => 'Penunjukkan Langsung',
                    'Lelang' => 'Lelang',
                ]" />

                <!-- Progres -->
                <x-input id="progres" name="progres" label="Progres" />

                <!-- Hari Proses -->
                <x-input id="hari_proses" name="hari_proses" type="number" label="Hari Proses" />

                <!-- Progres Pengadaan -->
                <x-input id="progres_pengadaan" name="progres_pengadaan" label="Progres Pengadaan" />

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </form>
        </x-drawer>
    </div>
</x-layout>
