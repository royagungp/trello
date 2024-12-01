<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'naspads',
        'name_customer',
        'total_price',
    ];

    protected $casts = [
        'naspads' => 'array',
    ];

    public function user(){
        // menghubungkas ke primary key nya
        // dalam kurung meruoakan nama model tempt penyimpanan dari Pk nya si FK yg ada di model ini
        return $this->belongsTo(User::class);
    }
}
