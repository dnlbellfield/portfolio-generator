<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'name',
        'job_title',
        'landing_page_summary',
        'about_me_heading',
        'about_me_content',
        'contact_heading',
        'email',
        'portfolio_title',
        'theme_basic',
        'font_basic',
        // REMOVE THESE:
        // 'linkedin_url',
        // 'github_url',
        // 'twitter_url',
        'profile_picture_url',
        'about_image_url',
        'skills_heading',
        'skills_list',
    ];

    /**
     * Get the work experiences for the portfolio.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Get the education entries for the portfolio.
     */
    public function education()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the projects for the portfolio.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the recommendations for the portfolio.
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    /**
     * Get the custom sections for the portfolio.
     */
    public function customSections()
    {
        // Assuming you have an 'order' column for custom sections
        return $this->hasMany(CustomSection::class)->orderBy('order');
    }
    /**
 * Get the online presence links for the portfolio.
 */
public function onlinePresences()
{
    return $this->hasMany(OnlinePresence::class);
}

}

