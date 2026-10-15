<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">Master Data Event</h2>
                <p class="text-xs text-gray-500 mt-0.5">Kelola tiket konser, seminar, dan festival</p>
            </div>
            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Tambah Event
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if(session('success'))
            <div class="flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm">
                <svg class="w-5 h-5 mr-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-slate-600 uppercase text-xs font-bold tracking-wider">
                            <th class="py-4 px-6 text-center">Gambar</th>
                            <th class="py-4 px-6">Nama Event</th>
                            <th class="py-4 px-6 text-center">Kategori</th>
                            <th class="py-4 px-6 text-right">Harga Tiket</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @if(count($events) > 0)
                            @foreach($events as $event)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-6 text-center">
                                    {{-- Perbaikan path gambar storage --}}
                                    @php
                                        $img = $event->gambar ?? $event->image;
                                    @endphp

                                    @if($img)
                                        <img src="{{ asset('storage/' . $img) }}" class="w-14 h-14 object-cover mx-auto rounded-lg shadow-sm border border-gray-200">
                                    @else
                                        <div class="w-14 h-14 bg-gray-100 border border-dashed border-gray-300 rounded-lg flex items-center justify-center mx-auto text-gray-400 text-xs">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-6 font-semibold text-gray-900">
                                    {{ $event->nama_event ?? $event->nama_konser ?? $event->name ?? $event->title }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $category = strtolower($event->kategori ?? $event->category ?? '');
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold capitalize shadow-xs
                                        {{ $category == 'musik' ? 'bg-purple-100 text-purple-700 border border-purple-200' : '' }}
                                        {{ $category == 'festival' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                        {{ $category == 'seminar' ? 'bg-sky-100 text-sky-700 border border-sky-200' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $event->kategori ?? $event->category }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-right font-bold text-emerald-600 text-base">
                                    Rp {{ number_format($event->harga_tiket ?? $event->harga_per_tiket ?? $event->price ?? $event->ticket_price ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('events.edit', $event->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 rounded-md font-semibold text-xs transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 rounded-md font-semibold text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400 font-medium">Belum ada data event yang terdaftar.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($events, 'links'))
            <div class="mt-4">{{ $events->links() }}</div>
        @endif
    </div>
</x-app-layout>