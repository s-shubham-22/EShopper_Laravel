<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'slug',
        'image',
        'created_by',
        'update_by',
        'deleted_by'
    ];
}
