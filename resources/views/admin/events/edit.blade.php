<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-2xl mx-auto">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">Edit Event</h2>
            <a href="{{ route('events.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-900 transition">
                &larr; Kembali ke daftar
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-200 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Event</label>
                <input type="text" name="nama_konser" value="{{ old('nama_konser', $event->nama_konser ?? $event->name) }}" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="musik" {{ strtolower($event->category) == 'musik' ? 'selected' : '' }}>Musik</option>
                    <option value="festival" {{ strtolower($event->category) == 'festival' ? 'selected' : '' }}>Festival</option>
                    <option value="seminar" {{ strtolower($event->category) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="harga_per_tiket" value="{{ old('harga_per_tiket', $event->harga_per_tiket ?? $event->price) }}" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Banner</label>
                @if($event->image || $event->gambar)
                    <div class="mb-3 flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <img src="{{ asset('storage/' . ($event->image ?? $event->gambar)) }}" class="w-14 h-14 object-cover rounded-md border">
                        <span class="text-xs text-gray-500">Gambar saat ini. Unggah file baru di bawah jika ingin menggantinya.</span>
                    </div>
                @endif
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('events.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>

                        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-lg shadow-sm">
                    <p class="font-bold text-sm mb-1">Gagal menyimpan! Periksa kesalahan berikut:</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>