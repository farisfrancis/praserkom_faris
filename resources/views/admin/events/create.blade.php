<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Event Baru</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-lg text-sm">
                <div class="font-semibold mb-1">Periksa kembali isian formulir:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
            @csrf

            <div>
                <label for="title" class="block font-medium text-sm text-gray-700 mb-1">Nama Event</label>
                <input type="text" name="title" id="title" value="{{ old('title', old('name')) }}" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Konser Sheila on 7" required>
            </div>

            <div>
                <label for="category" class="block font-medium text-sm text-gray-700 mb-1">Kategori</label>
                <select name="category" id="category" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="musik" {{ old('category') == 'musik' ? 'selected' : '' }}>Musik</option>
                    <option value="festival" {{ old('category') == 'festival' ? 'selected' : '' }}>Festival</option>
                    <option value="seminar" {{ old('category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
            </div>

            <div>
                <label for="ticket_price" class="block font-medium text-sm text-gray-700 mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price', old('price')) }}" min="0" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 150000" required>
            </div>

            <div>
                <label for="description" class="block font-medium text-sm text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tuliskan deskripsi lengkap mengenai event..." required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="image" class="block font-medium text-sm text-gray-700 mb-1">Gambar Banner Event</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP (Maks. 4MB)</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('events.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</x-app-layout>