<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'order', // Ensure this matches your migration if you added it
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the custom section.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Get the blocks for the custom section.
     */
    public function blocks()
    {
        // Assuming you have an 'order' column for blocks
        return $this->hasMany(CustomSectionBlock::class)->orderBy('order');
    }
}
