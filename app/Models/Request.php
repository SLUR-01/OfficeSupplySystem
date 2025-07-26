<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_name',
        'department',
        'date',
        'item_name',
        'quantity',
        'status', // If you have a status field for approval
       
    ];
}
