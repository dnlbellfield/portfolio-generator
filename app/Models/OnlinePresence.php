<?php // Ensure this is the very first thing in the file, potentially after a BOM character if your editor adds one

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePresence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'url',
        'portfolio_id', // Foreign key
    ];

    /**
     * Get the portfolio that owns the online presence entry.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
