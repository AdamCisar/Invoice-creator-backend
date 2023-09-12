<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomItem extends Model
{
    use HasFactory;
    protected $table = 'custom_items';
    public $timestamps = false;

    protected $fillable = ['name', 'price', 'amount', 'invoice_id'];
}
