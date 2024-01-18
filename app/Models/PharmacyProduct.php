<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyProduct extends Model
{
    use HasFactory;
    protected $table = 'pharmacy_product';
    protected $fillable = ['product_id', 'pharmacy_id', 'price'];
}
