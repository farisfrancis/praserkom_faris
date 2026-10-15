<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        // Tangkap input judul dan harga tiket apa pun nama input di form
        $title = $request->input('title') ?? $request->input('name') ?? $request->input('nama_konser');
        $ticketPrice = $request->input('ticket_price') ?? $request->input('price') ?? $request->input('harga_per_tiket');

        $request->merge([
            'title'        => $title,
            'ticket_price' => $ticketPrice,
        ]);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string',
            'ticket_price' => 'required|numeric|min:0',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'title'        => $validated['title'],
            'category'     => $validated['category'],
            'ticket_price' => $validated['ticket_price'],
            'description'  => $validated['description'],
            'image'        => $imagePath,
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        //
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $title = $request->input('title') ?? $request->input('name') ?? $request->input('nama_konser');
        $ticketPrice = $request->input('ticket_price') ?? $request->input('price') ?? $request->input('harga_per_tiket');

        $request->merge([
            'title'        => $title,
            'ticket_price' => $ticketPrice,
        ]);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string',
            'ticket_price' => 'required|numeric|min:0',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'title'        => $validated['title'],
            'category'     => $validated['category'],
            'ticket_price' => $validated['ticket_price'],
            'description'  => $validated['description'],
            'image'        => $imagePath,
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }
}