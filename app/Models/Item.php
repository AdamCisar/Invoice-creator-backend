<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = ['name', 'price', 'url', 'imageUrl'];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_item')
                    ->withPivot('amount');
    }
}
