<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = ['name'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'invoice_item')
                    ->withPivot('amount');
    }

    public function customItems()
    {
        return $this->hasMany(CustomItem::class, 'invoice_id');
    }
}
