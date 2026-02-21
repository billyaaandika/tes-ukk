<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    protected $fillable = [
        'name_tool',
        'category_tool',
        'stock',
    ];

    /**
     * Get the category this tool belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_tool');
    }

    /**
     * Get all borrowings for this tool
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'tool_id');
    }

    /**
     * Get all loan details for this tool
     */
    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class, 'tool_id');
    }
}
