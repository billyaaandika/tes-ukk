<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'tool_id',
        'borrowed_at',
        'returned_at',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'returned_at' => 'date',
    ];

    /**
     * Get the user who borrowed
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tool being borrowed
     */
    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }

    /**
     * Get the user who approved
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all loan details for this borrowing
     */
    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class, 'borrowing_id');
    }

    /**
     * Get all return items for this borrowing
     */
    public function returnItems(): HasMany
    {
        return $this->hasMany(ReturnItem::class, 'borrowing_id');
    }
}
