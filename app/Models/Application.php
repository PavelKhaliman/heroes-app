<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            'pa',
            'pz',
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

    public function votes(): HasMany
    {
        return $this->hasMany(ApplicationVote::class);
    }

    public function recalcTallies(): void
    {
        $this->votes_for = (int) $this->votes()->where('vote', 'for')->count();
        $this->votes_against = (int) $this->votes()->where('vote', 'against')->count();
        $this->save();
    }
}
            