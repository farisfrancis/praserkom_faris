<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}