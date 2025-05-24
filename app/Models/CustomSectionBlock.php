<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSectionBlock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'block_type',
        'content',
        'order', // Ensure this matches your migration if you added it
        'custom_section_id', // Foreign key
    ];

    /**
     * Get the custom section that owns the block.
     */
    public function customSection()
    {
        return $this->belongsTo(CustomSection::class);
    }
}
