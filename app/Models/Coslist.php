<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coslist extends Model
{
    use HasFactory;

    protected $fillable = [
    'nicname',
    'guild',
    'master',
    'reason',
    'repayment',

    ];
}
