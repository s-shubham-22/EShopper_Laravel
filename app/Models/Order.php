<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'b_fname',
        'b_lname',
        'b_email',
        'b_mobile',
        'b_addr_1',
        'b_addr_2',
        'b_country',
        'b_city',
        'b_state',
        'b_zip',
        's_fname',
        's_lname',
        's_email',
        's_mobile',
        's_addr_1',
        's_addr_2',
        's_country',
        's_city',
        's_state',
        's_zip',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
