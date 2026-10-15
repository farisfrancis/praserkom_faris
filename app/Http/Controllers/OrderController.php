<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('customer.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ]);

        $orderedItems = array_filter($request->items ?? [], fn ($qty) => (int) $qty > 0);

        if (empty($orderedItems)) {
            return redirect()->back()->withErrors(['items' => 'Pilih satu atau lebih item untuk dipesan.']);
        }

        $order = DB::transaction(function () use ($request, $orderedItems) {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;

            foreach ($orderedItems as $eventId => $quantity) {
                $event = Event::findOrFail($eventId);
                
                // Pengecekan dinamis nama kolom harga di database (harga_tiket, harga_per_tiket, price, dll)
                $hargaEvent = $event->harga_tiket ?? $event->harga_per_tiket ?? $event->price ?? $event->ticket_price ?? 0;
                
                $subtotal = $hargaEvent * $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'event_id' => $event->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update([
                'total_price' => $totalPrice,
            ]);

            return $order;
        });

        return redirect()->route('customer.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function adminDahboard()
    {
        $orders = Order::with('orderdetails.event')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    public function dashboard()
    {
        $orders = Order::with('orderdetails.event')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    public function updateDashboard(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('dashboard')->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui.');
    }
}