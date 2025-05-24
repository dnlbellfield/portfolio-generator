<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quote',
        'recommender_name',
        'recommender_title',
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the recommendation.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
