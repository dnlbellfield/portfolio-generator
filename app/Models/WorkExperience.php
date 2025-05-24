<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_title',
        'company',
        'start_date',
        'end_date',
        'description',
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the work experience.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
