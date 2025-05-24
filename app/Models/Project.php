<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'live_demo_url',
        'github_url',
        'technologies',
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the project.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
