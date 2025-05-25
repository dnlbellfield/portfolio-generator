<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio; // We'll use this later to save data
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Project;
use App\Models\Recommendation;
use App\Models\OnlinePresence; // <-- Add this line for the new model
use App\Models\CustomSection;
use App\Models\CustomSectionBlock;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr; // Ensure this is imported if you use Arr::except


class PortfolioController extends Controller
{
    /**
     * Display the portfolio creation form.
     */
    public function create()
    {
        // For now, we'll just return a simple message or placeholder view
        return view('portfolio.create'); // We will create this view next
    }

    /**
     * Store a newly created portfolio in storage.
     */
    /**
 * Store a newly created portfolio in storage.
 */
public function store(Request $request)
{
    // dd($request->all()); // Keep this commented or remove it once you start saving

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'job_title' => 'nullable|string|max:255',
        'landing_page_summary' => 'nullable|string|max:500', // Adjust max length as needed
        'about_me_heading' => 'nullable|string|max:255',
        'about_me_content' => 'nullable|string',
 
        'email' => 'nullable|email|max:255', // 'nullable' if not required
 
        'theme_basic' => 'nullable|string|max:255',
        'font_basic' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image upload
        'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional second about image
        'skills_heading' => 'nullable|string|max:255',
        'skills_list' => 'nullable|string',

        // Validation for the NEW repeatable Online Presence section
        'online_presences' => 'nullable|array',
        'online_presences.*.label' => 'required_with:online_presences|string|max:255',
        'online_presences.*.url' => 'required_with:online_presences|url|max:255',


        // Validation for repeatable sections (work_experiences, education, etc.)
        'work_experiences' => 'nullable|array', // The array itself is optional
        'work_experiences.*.job_title' => 'required_with:work_experiences|string|max:255', // If array is present, job_title is required for each entry
        'work_experiences.*.company' => 'required_with:work_experiences|string|max:255',
        'work_experiences.*.start_date' => 'nullable|string|max:255', // Now string due to form change
        'work_experiences.*.end_date' => 'nullable|string|max:255', // Now string
        'work_experiences.*.description' => 'nullable|string', // Added missing validation rule


        'education' => 'nullable|array',
        'education.*.degree' => 'required_with:education|string|max:255',
        'education.*.institution' => 'required_with:education|string|max:255',
        'education.*.graduation_date' => 'nullable|string|max:255', // Now string
        'education.*.description' => 'nullable|string',

        'projects' => 'nullable|array',
        'projects.*.title' => 'required_with:projects|string|max:255',
        'projects.*.description' => 'nullable|string',
        'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Project image upload
        'projects.*.live_demo_url' => 'nullable|url|max:255',
        'projects.*.github_url' => 'nullable|url|max:255',
        'projects.*.technologies' => 'nullable|string|max:255',

        'recommendations' => 'nullable|array',
        'recommendations.*.quote' => 'required_with:recommendations|string',
        'recommendations.*.recommender_name' => 'required_with:recommendations|string|max:255',
        'recommendations.*.recommender_title' => 'nullable|string|max:255',

        // Validation for custom sections and their blocks
        'custom_sections' => 'nullable|array',
        'custom_sections.*.title' => 'required_with:custom_sections|string|max:255',
        'custom_sections.*.order' => 'nullable|integer', // If you added ordering

        'custom_sections.*.blocks' => 'nullable|array', // Blocks array within a custom section is optional
        'custom_sections.*.blocks.*.type' => ['required', 'string', Rule::in(['header', 'paragraph', 'image', 'paragraph_image'])], // Block type is required and must be one of these

        // Validation for content based on block type
        // Note: 'content' for image and paragraph_image is an array containing the uploaded file
        'custom_sections.*.blocks.*.content' => 'nullable', // The main content field is nullable

        // Validation for specific content types based on block type
        'custom_sections.*.blocks.*.content.paragraph' => 'required_if:custom_sections.*.blocks.*.type,paragraph_image|nullable|string', // Paragraph text required if type is paragraph_image
        'custom_sections.*.blocks.*.content.image' => 'required_if:custom_sections.*.blocks.*.type,paragraph_image|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image file required if type is paragraph_image

        // Validation for header/paragraph content (non-combo)
        'custom_sections.*.blocks.*.content' => Rule::forEach(function ($value, $attribute, $data) {
            $blockType = Arr::get($data, str_replace('.content', '.type', $attribute));
            if ($blockType === 'header' || $blockType === 'paragraph') {
                return ['nullable', 'string'];
            }
            if ($blockType === 'image') {
                 // Validation for the single image block type
                 return ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
            }
             // No validation needed for content of paragraph_image type at this level
            return [];
        }),


    ]);

    // Log::info('Validated Data:', $validatedData); // Useful for debugging after validation

    // --- 4. Handle File Uploads and Create the Main Portfolio Record ---

    // Handle profile picture upload
    $profilePicturePath = null;
    if ($request->hasFile('profile_picture')) {
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public'); // Store in 'storage/app/public/profile_pictures'
    }

    // Handle second about image upload
    $aboutImagePath = null;
    if ($request->hasFile('about_image')) {
         $aboutImagePath = $request->file('about_image')->store('about_images', 'public'); // Store in 'storage/app/public/about_images'
    }

Log::info('Attempting to create Portfolio record');
    // Create the main Portfolio record
    $portfolio = Portfolio::create([
        'name' => $validatedData['name'],
        'job_title' => $validatedData['job_title'] ?? null,
        'landing_page_summary' => $validatedData['landing_page_summary'] ?? null,
        'about_me_heading' => $validatedData['about_me_heading'] ?? null,
        'about_me_content' => $validatedData['about_me_content'] ?? null,
 
        'email' => $validatedData['email'] ?? null,
 
        'theme_basic' => $validatedData['theme_basic'] ?? null,
        'font_basic' => $validatedData['font_basic'] ?? null,
        'skills_heading' => $validatedData['skills_heading'] ?? null,
        'skills_list' => $validatedData['skills_list'] ?? null,
        'profile_picture_url' => $profilePicturePath, // Save the path
        'about_image_url' => $aboutImagePath, // Save the path
    ]);
Log::info('Portfolio record created successfully', ['id' => $portfolio->id]);
    // --- 5. Save Repeatable Sections ---
Log::info('Attempting to save Online Presences');
     // Save Online Presences (NEW SECTION)
    if (isset($validatedData['online_presences']) && is_array($validatedData['online_presences'])) {
        foreach ($validatedData['online_presences'] as $onlinePresenceData) {
             // Only create if at least one main field (label or url) is present
             if (!empty($onlinePresenceData['label']) || !empty($onlinePresenceData['url'])) {
                 // Both label and url are required if the array is present due to validation,
                 // but this check adds an extra layer to prevent near-empty entries.
                if (!empty($onlinePresenceData['label']) && !empty($onlinePresenceData['url'])) {
                   $portfolio->onlinePresences()->create($onlinePresenceData);
                }
             }
        }
    }
    Log::info('Finished saving Online Presences');

Log::info('Attempting to save Work Experiences');
    // Save Work Experiences
    if (isset($validatedData['work_experiences']) && is_array($validatedData['work_experiences'])) {
        foreach ($validatedData['work_experiences'] as $workExperienceData) {
            // Only create if at least one main field (like job_title or company) is present
             if (!empty($workExperienceData['job_title']) || !empty($workExperienceData['company'])) {
                 $portfolio->workExperiences()->create($workExperienceData);
             }
        }
    }
    Log::info('Finished saving Work Experiences');
Log::info('Attempting to save Education Experiences');
 
    // Save Education
    if (isset($validatedData['education']) && is_array($validatedData['education'])) {
        foreach ($validatedData['education'] as $educationData) {
            // Only create if at least one main field (like degree or institution) is present
             if (!empty($educationData['degree']) || !empty($educationData['institution'])) {
                $portfolio->education()->create($educationData);
            }
        }
    }    Log::info('Finished saving Education Experiences');


    Log::info('Attempting to save Project  Experiences');
    // Save Projects
    if (isset($validatedData['projects']) && is_array($validatedData['projects'])) {
        foreach ($validatedData['projects'] as $projectData) {
            // Only create if project title is present
             if (!empty($projectData['title'])) {
                 $projectImagePath = null;
                 // Handle project image upload
                 // Check if 'image' key exists and is an uploaded file instance
                 if (isset($projectData['image']) && $projectData['image'] instanceof \Illuminate\Http\UploadedFile) {
                     $projectImagePath = $projectData['image']->store('project_images', 'public');
                 }

                 // Prepare data for creation (excluding the file object to prevent mass assignment errors)
                 $projectDataToCreate = Arr::except($projectData, ['image']);

                 $portfolio->projects()->create(array_merge($projectDataToCreate, [
                     'image_url' => $projectImagePath, // Save the image path
                 ]));
             }
        }
    } Log::info('Finished saving Project Experiences');

    Log::info('Attempting to save Reccomendation');
    // Save Recommendations
    if (isset($validatedData['recommendations']) && is_array($validatedData['recommendations'])) {
        foreach ($validatedData['recommendations'] as $recommendationData) {
             // Only create if quote is present
             if (!empty($recommendationData['quote'])) {
                $portfolio->recommendations()->create($recommendationData);
            }
        }
    }Log::info('Finished saving Reccomendations');

    // --- 6. Save Custom Sections and their Blocks ---
Log::info('Attempting to save Custom Sections');
    if (isset($validatedData['custom_sections']) && is_array($validatedData['custom_sections'])) {
        foreach ($validatedData['custom_sections'] as $customSectionIndex => $customSectionData) {
             // Only create custom section if title is present or it has blocks
             if (!empty($customSectionData['title']) || (isset($customSectionData['blocks']) && is_array($customSectionData['blocks']) && count($customSectionData['blocks']) > 0) ) {

                // Create the custom section
                $customSection = $portfolio->customSections()->create([
                    'title' => $customSectionData['title'] ?? null,
                    'order' => $customSectionIndex, // Use index for order
                ]);

                // Save blocks for this custom section
                if (isset($customSectionData['blocks']) && is_array($customSectionData['blocks'])) {
                    foreach ($customSectionData['blocks'] as $blockIndex => $blockData) {
                         // Only create block if type is valid
                         $allowedBlockTypes = ['header', 'paragraph', 'image', 'paragraph_image'];
                         if (isset($blockData['type']) && in_array($blockData['type'], $allowedBlockTypes)) {

                             $blockContent = null; // Initialize block content

                             if ($blockData['type'] === 'header' || $blockData['type'] === 'paragraph') {
                                 // For header and paragraph, content is a string
                                 $blockContent = $blockData['content'] ?? null;
                             } elseif ($blockData['type'] === 'image') {
                                 // For single image block, content is the uploaded file
                                 // Check if 'content' key exists and is an uploaded file instance
                                 if (isset($blockData['content']) && $blockData['content'] instanceof \Illuminate\Http\UploadedFile) {
                                     $blockContent = $blockData['content']->store('custom_images', 'public'); // Store the image
                                 }
                             } elseif ($blockData['type'] === 'paragraph_image') {
                                 // For paragraph_image combo
                                 $comboContent = [
                                     'paragraph' => $blockData['content']['paragraph'] ?? null,
                                     'image' => null, // Placeholder for image path
                                 ];
                                 // Handle image upload for the combo
                                 // Check if nested 'image' key exists and is an uploaded file instance
                                 if (isset($blockData['content']['image']) && $blockData['content']['image'] instanceof \Illuminate\Http\UploadedFile) {
                                      $comboContent['image'] = $blockData['content']['image']->store('custom_combo_images', 'public');
                                 }
                                 // Store combo content as JSON string
                                 $blockContent = json_encode($comboContent);
                             }

                              // Only create the block if there's some meaningful content saved
                              // This check avoids saving blocks with no data submitted (e.g., empty text fields, no file uploaded).
                              // For image/paragraph_image, if only the file was the input and upload failed/was empty,
                              // $blockContent might be null, but we still might want to record the block type.
                              // You might refine this check based on desired behavior for empty blocks.
                              // A simpler check: if the type is valid, try to create the block.
                               $customSection->blocks()->create([
                                   'block_type' => $blockData['type'],
                                   'content' => $blockContent, // Save the processed content/path/json
                                   'order' => $blockIndex, // Use index for order within the section
                               ]);

                         }
                    }
                }
             }
        }
    }
Log::info('Finished saving Custom Sections');

    // --- 7. Redirect or Respond ---

    // Redirect to a success page or the newly created portfolio page
    // For now, let's redirect back with a success message
Log::info('Data saving complete. Redirecting.');
// return redirect()->route('portfolio.create')->with('success', 'Portfolio created successfully!');
// Redirect to the show page of the newly created portfolio
return redirect()->route('portfolio.show', $portfolio)->with('success', 'Portfolio created successfully!');



    // You would typically redirect to a route that displays the portfolio, e.g.:
    // return redirect()->route('portfolio.show', $portfolio->id)->with('success', 'Portfolio created successfully!');
}

public function show(Portfolio $portfolio) // Laravel injects the Portfolio model instance
    {
        // The $portfolio variable now contains the fetched Portfolio model instance
        // with the ID from the URL.

        // We can eager load relationships here to avoid N+1 query problem
        $portfolio->load([
            'onlinePresences',
            'workExperiences',
            'education',
            'projects',
            'recommendations',
            'customSections.blocks' // Load blocks nested within custom sections
        ]);

        // Return the view and pass the portfolio data to it
        return view('portfolio.show', compact('portfolio'));
    }

}
