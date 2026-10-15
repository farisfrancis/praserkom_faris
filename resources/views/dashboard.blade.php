<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">Daftar Pesanan Masuk</h2>
                <p class="text-xs text-gray-500 mt-0.5">Monitoring status transaksi tiket masuk</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Tambah Event
                </a>
                <a href="{{ route('customer.index') }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    + Buat Pesanan Tiket
                </a>
            </div>
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
                            <th class="py-4 px-6"># ID</th>
                            <th class="py-4 px-6">Pelanggan</th>
                            <th class="py-4 px-6">Email</th>
                            <th class="py-4 px-6">Rincian Tiket</th>
                            <th class="py-4 px-6 text-right">Total Tagihan</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-6 font-semibold text-gray-900">#{{ $order->id }}</td>
                            <td class="py-3 px-6 font-medium text-gray-800">{{ $order->customer_name }}</td>
                            <td class="py-3 px-6 text-gray-500">{{ $order->customer_email }}</td>
                            <td class="py-3 px-6 text-gray-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($order->orderdetails as $detail)
                                        <li>
                                            {{ $detail->event->nama_konser ?? $detail->event->name ?? 'Tiket' }} 
                                            <span class="text-xs font-semibold text-gray-500">({{ $detail->quantity }}x)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-6 text-right font-bold text-emerald-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $order->status == 'confirmed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $order->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $order->status == 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="text-xs border-gray-300 rounded-lg py-1 px-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="px-2.5 py-1 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 transition">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400 font-medium">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>