<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Active extends Model
{
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
}
