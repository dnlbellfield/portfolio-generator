<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'degree',
        'institution',
        'graduation_date',
        'description',
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the education entry.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
