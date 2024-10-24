<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'active_id',
        'type',
        'quantity',
        'price',
        'total',
        'date',
    ];

    /**
     * Scope a query to only include transactions of the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTransactionUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function active(): BelongsTo
    {
        return $this->belongsTo(Active::class);
    }
}
