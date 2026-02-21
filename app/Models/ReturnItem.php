<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnItem extends Model
{
    protected $fillable = [
        'borrowing_id',
        'returned_at',
        'fine_amount',
    ];

    protected $casts = [
        'returned_at' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    /**
     * Get the borrowing this return belongs to
     */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }
}
