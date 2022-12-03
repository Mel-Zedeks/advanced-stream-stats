<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'braintree_id',
        'braintree_plan',
        'quantity',
        'trial_ends_at',
        'ends_at',
    ];

    protected $casts = [
        "trial_ends_at" => "datetime",
        "ends_at" => "datetime"
    ];
}
