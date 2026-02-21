<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_category',
        'description',
    ];

    /**
     * Get all tools in this category
     */
    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class, 'category_tool');
    }
}