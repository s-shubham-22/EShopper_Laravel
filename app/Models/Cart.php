<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'price',
        'quantity',
        'created_by',
        'update_by',
        'deleted_by'
    ];
}
