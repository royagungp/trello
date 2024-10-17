<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naspad extends Model
{
    use HasFactory;
    public $table = 'naspads';

    protected $fillable = [
        'type',
        'price',
        'porsi',
        'name',
    ];
}
