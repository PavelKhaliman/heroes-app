<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
    
            'name',
            'age',
            'nic_name',
            'level',
            'charecter_class',
            'info',
            'status',
            'strong',
            'survival',
            'prime_msk',
            'kos_list',
    ];

    public function getStatusLabelAttribute(): string
    {
        return [
            'new' => 'Новая',
            'accepted' => 'Принят',
            'pending' => 'В ожидании',
            'rejected' => 'Отклонен',
        ][$this->status] ?? $this->status;
    }
}
            