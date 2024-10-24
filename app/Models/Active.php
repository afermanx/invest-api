<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Active extends Model
{
     use HasFactory;
   protected $fillable = [
        'user_id',
        'name',
        'ticker',
        'purchase_date',
        'quantity',
        'price',
        'type',
    ];


    /**
     * Scope a query to only include actives of current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveWithUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    /**
     * The user that owns the Active
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The transactions that belong to the Active
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
