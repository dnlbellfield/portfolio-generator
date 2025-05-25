<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Portfolio</title>
    <!-- Link your main app CSS (might include Tailwind) -->
    @vite('resources/css/app.css')
    {{-- Add some basic inline styles for the preview container if not handled by Tailwind --}}
    <style>
        #portfolio-preview {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            min-height: 400px; /* Ensure minimum height */
            overflow-y: auto; /* Allow scrolling within the preview */
        }
        /* Add basic styling for preview elements to resemble show page */
        #portfolio-preview h1, #portfolio-preview h2, #portfolio-preview h3 { font-weight: bold; margin-bottom: 1rem; }
         #portfolio-preview img { max-width: 100%; height: auto; }
         #portfolio-preview .paragraph-image-container { display: flex; gap: 20px; flex-wrap: wrap; }
         #portfolio-preview .paragraph-content, #portfolio-preview .image-content { flex: 1; min-width: 200px; }

         /* Style for placeholder image previews */
         #portfolio-preview img.preview-placeholder-img {
             display: none; /* Initially hidden */
             /* Add other placeholder styling like background color or border */
             background-color: #eee;
             border: 1px dashed #ccc;
         }
    </style>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success" role="alert" style="color: green; margin-bottom: 20px; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto px-4 py-8 max-w-5xl"> {{-- Tailwind container --}}
        <div class=" "> {{-- Responsive grid for 2 columns --}}

            {{-- Left Column: The Form --}}
            <div class=" "> {{-- Takes one column on large screens --}}
                <h1 class="text-2xl font-bold mb-6">Create Your Portfolio</h1> {{-- Basic styling --}}
                <form id="portfolio-form" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- CSRF token for security --}}

                    {{-- Single-Instance Sections --}}

                    {{-- 1. Personal & Contact Info --}}
                    <section class="mb-8 p-4  rounded-md"> {{-- Added styling --}}
                        <h2>Personal & Contact Info</h2>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label> {{-- Tailwind form styling --}}
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('name')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span> {{-- Tailwind error styling --}}
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('email')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="job_title" class="block text-gray-700 text-sm font-bold mb-2">Job Title/Headline:</label>
                            <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('job_title')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-4">
                            <label for="landing_page_summary" class="block text-gray-700 text-sm font-bold mb-2">Short Landing Page Summary (1-2 sentences):</label>
                            <textarea id="landing_page_summary" name="landing_page_summary" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('landing_page_summary') }}</textarea>
                             @error('landing_page_summary')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-4">
                            <label for="profile_picture" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture:</label>
                            <input type="file" id="profile_picture" name="profile_picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('profile_picture')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                         {{-- Add  basic contact fields like city, etc. --}}
                    </section>


                    {{-- 2. About Me Section --}}
                    <section class="mb-8 p-4  rounded-md"> {{-- Added styling --}}
                        <h2>About Me</h2>
                         <div class="mb-4">
                            <label for="about_me_heading" class="block text-gray-700 text-sm font-bold mb-2">About Me Heading:</label>
                            <input type="text" id="about_me_heading" name="about_me_heading" value="{{ old('about_me_heading', 'About Me') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('about_me_heading')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="about_me_content" class="block text-gray-700 text-sm font-bold mb-2">About Me Content:</label>
                            <textarea id="about_me_content" name="about_me_content" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('about_me_content') }}</textarea>
                             @error('about_me_content')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-4">
                            <label for="about_image" class="block text-gray-700 text-sm font-bold mb-2">Second About Image:</label>
                            <input type="file" id="about_image" name="about_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('about_image')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                    </section>


                    {{-- 3. Online Presence (Repeatable) --}}
                    <section id="online-presence-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
                        <h2>Online Presence</h2>
                        <div id="online-presence-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
                            {{-- Initial Online Presence Entry --}}
                            <div class="online-presence-entry p-4 border rounded-md bg-gray-50"> {{-- Added styling --}}
                                <h3>Link #1</h3>
                                <div class="mb-2">
                                    <label for="online_presences_0_label" class="block text-gray-700 text-sm font-bold mb-1">Label (e.g., LinkedIn, Website):</label>
                                    <input type="text" id="online_presences_0_label" name="online_presences[0][label]" value="{{ old('online_presences.0.label') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('online_presences.0.label')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="online_presences_0_url" class="block text-gray-700 text-sm font-bold mb-1">URL:</label>
                                    <input type="url" id="online_presences_0_url" name="online_presences[0][url]" value="{{ old('online_presences.0.url') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('online_presences.0.url')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="remove-online-presence-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button> {{-- Added styling --}}
                                <hr class="my-4"> {{-- Added styling --}}
                            </div>
                        </div>
                        <button type="button" id="add-online-presence-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add Another Link</button> {{-- Added styling and ID --}}
                    </section>


                    {{-- 4. Contact Section --}}
                    <section class="mb-8 p-4  rounded-md"> {{-- Added styling --}}
                        <h2>Contact Info</h2>
                         <div class="mb-4">
                            <label for="contact_heading" class="block text-gray-700 text-sm font-bold mb-2">Contact Section Heading:</label>
                            <input type="text" id="contact_heading" name="contact_heading" value="{{ old('contact_heading', 'Get in Touch') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('contact_heading')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Email is already in Personal Info, add other contact methods if needed --}}
                    </section>

                    {{-- 5. Optional: Basic Styling/Meta Info --}}
                     <section class="mb-8 p-4  rounded-md"> {{-- Added styling --}}
                        <h2>Appearance (Optional)</h2>
                         <div class="mb-4">
                            <label for="portfolio_title" class="block text-gray-700 text-sm font-bold mb-2">Browser Tab Title:</label>
                            <input type="text" id="portfolio_title" name="portfolio_title" value="{{ old('portfolio_title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('portfolio_title')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                         {{-- Add fields for basic theme/font choices here later --}}
                    </section>


                    {{-- Repeatable sections (Work Experience, Education, Projects, Recommendations, Custom Sections) --}}
                    {{-- These sections will now be placed directly here --}}


                    {{-- 6. Optional: Skills Section (Keeping it simple as a single textarea) --}}
                    <section id="skills-section" class="mb-8 p-4  rounded-md"> {{-- Added styling --}}
                        <h2>Skills</h2>
                        <div class="mb-4">
                            <label for="skills_heading" class="block text-gray-700 text-sm font-bold mb-2">Skills Section Heading:</label>
                            <input type="text" id="skills_heading" name="skills_heading" value="{{ old('skills_heading', 'Skills') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('skills_heading')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="skills_list" class="block text-gray-700 text-sm font-bold mb-2">List of Skills (Comma-separated or bullet points):</label>
                            <textarea id="skills_list" name="skills_list" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('skills_list') }}</textarea>
                             @error('skills_list')
                                <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                    </section>


                    {{-- 7. Work Experience Section --}}
                    <section id="work-experience-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
                         <h2>Work Experience</h2>
                         <div id="work-experience-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
                             {{-- Initial Work Experience Entry --}}
                            <div class="work-experience-entry p-4 border rounded-md bg-gray-50"> {{-- Added styling --}}
                                <h3>Work Experience #1</h3>
                                <div class="mb-2">
                                    <label for="work_experiences_0_job_title" class="block text-gray-700 text-sm font-bold mb-1">Job Title:</label>
                                    <input type="text" id="work_experiences_0_job_title" name="work_experiences[0][job_title]" value="{{ old('work_experiences.0.job_title') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('work_experiences.0.job_title')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="work_experiences_0_company" class="block text-gray-700 text-sm font-bold mb-1">Company:</label>
                                    <input type="text" id="work_experiences_0_company" name="work_experiences[0][company]" value="{{ old('work_experiences.0.company') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('work_experiences.0.company')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                 <div class="mb-2">
                                    <label for="work_experiences_0_start_date" class="block text-gray-700 text-sm font-bold mb-1">Start Date (e.g., Spring 2023):</label>
                                    <input type="text" id="work_experiences_0_start_date" name="work_experiences[0][start_date]" value="{{ old('work_experiences.0.start_date') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('work_experiences.0.start_date')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                 <div class="mb-2">
                                    <label for="work_experiences_0_end_date" class="block text-gray-700 text-sm font-bold mb-1">End Date (e.g., Present):</label>
                                    <input type="text" id="work_experiences_0_end_date" name="work_experiences[0][end_date]" value="{{ old('work_experiences.0.end_date') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('work_experiences.0.end_date')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="work_experiences_0_description" class="block text-gray-700 text-sm font-bold mb-1">Description:</label>
                                    <textarea id="work_experiences_0_description" name="work_experiences[0][description]" rows="4" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('work_experiences.0.description') }}</textarea>
                                     @error('work_experiences.0.description')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="remove-work-experience-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button>
                                <hr class="my-4">
                            </div>
                         </div>
                         <button type="button" id="add-work-experience-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add  Work Experience</button>
                     </section>


                    {{-- 8. Education Section --}}
                    <section id="education-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
                        <h2>Education</h2>
                        <div id="education-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
                            {{-- Initial Education Entry --}}
                            <div class="education-entry p-4 border rounded-md bg-gray-50"> {{-- Added styling --}}
                                <h3>Education #1</h3>
                                <div class="mb-2">
                                    <label for="education_0_degree" class="block text-gray-700 text-sm font-bold mb-1">Degree:</label>
                                    <input type="text" id="education_0_degree" name="education[0][degree]" value="{{ old('education.0.degree') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('education.0.degree')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="education_0_institution" class="block text-gray-700 text-sm font-bold mb-1">Institution:</label>
                                    <input type="text" id="education_0_institution" name="education[0][institution]" value="{{ old('education.0.institution') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('education.0.institution')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                 <div class="mb-2">
                                    <label for="education_0_graduation_date" class="block text-gray-700 text-sm font-bold mb-1">Graduation Date (e.g., May 2017 or Ongoing):</label>
                                    <input type="text" id="education_0_graduation_date" name="education[0][graduation_date]" value="{{ old('education.0.graduation_date') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('education.0.graduation_date')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="education_0_description" class="block text-gray-700 text-sm font-bold mb-1">Description (Optional):</label>
                                    <textarea id="education_0_description" name="education[0][description]" rows="4" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('education.0.description') }}</textarea>
                                     @error('education.0.description')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="remove-education-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button>
                                <hr class="my-4">
                            </div>
                        </div>
                        <button type="button" id="add-education-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add  Education</button>
                    </section>

                    {{-- 9. Projects Section --}}
                    <section id="projects-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
                         <h2>Projects</h2>
                         <div id="project-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
                            {{-- Initial Project Entry --}}
                            <div class="project-entry p-4 border rounded-md bg-gray-50"> {{-- Added styling --}}
                                <h3>Project #1</h3>
                                <div class="mb-2">
                                    <label for="projects_0_title" class="block text-gray-700 text-sm font-bold mb-1">Project Title:</label>
                                    <input type="text" id="projects_0_title" name="projects[0][title]" value="{{ old('projects.0.title') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('projects.0.title')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="projects_0_description" class="block text-gray-700 text-sm font-bold mb-1">Description:</label>
                                    <textarea id="projects_0_description" name="projects[0][description]" rows="4" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('projects.0.description') }}</textarea>
                                     @error('projects.0.description')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="projects_0_image" class="block text-gray-700 text-sm font-bold mb-1">Project Image:</label>
                                    <input type="file" id="projects_0_image" name="projects[0][image]" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('projects.0.image')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="projects_0_live_demo_url" class="block text-gray-700 text-sm font-bold mb-1">Live Demo URL:</label>
                                    <input type="url" id="projects_0_live_demo_url" name="projects[0][live_demo_url]" value="{{ old('projects.0.live_demo_url') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('projects.0.live_demo_url')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="projects_0_github_url" class="block text-gray-700 text-sm font-bold mb-1">GitHub URL:</label>
                                    <input type="url" id="projects_0_github_url" name="projects[0][github_url]" value="{{ old('projects.0.github_url') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('projects.0.github_url')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="projects_0_technologies" class="block text-gray-700 text-sm font-bold mb-1">Technologies Used (Comma-separated):</label>
                                    <input type="text" id="projects_0_technologies" name="projects[0][technologies]" value="{{ old('projects.0.technologies') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('projects.0.technologies')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="remove-project-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button>
                                <hr class="my-4">
                            </div>
                         </div>
                         <button type="button" id="add-project-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add  Project</button>
                     </section>

                    {{-- 10. Recommendations/Testimonials Section --}}
                    <section id="recommendations-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
                        <h2>Recommendations</h2>
                        <div id="recommendation-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
                            {{-- Initial Recommendation Entry --}}
                            <div class="recommendation-entry p-4 border rounded-md bg-gray-50"> {{-- Added styling --}}
                                <h3>Recommendation #1</h3>
                                <div class="mb-2">
                                    <label for="recommendations_0_quote" class="block text-gray-700 text-sm font-bold mb-1">Quote:</label>
                                    <textarea id="recommendations_0_quote" name="recommendations[0][quote]" rows="4" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('recommendations.0.quote') }}</textarea>
                                     @error('recommendations.0.quote')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="recommendations_0_recommender_name" class="block text-gray-700 text-sm font-bold mb-1">Recommender's Name:</label>
                                    <input type="text" id="recommendations_0_recommender_name" name="recommendations[0][recommender_name]" value="{{ old('recommendations.0.recommender_name') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('recommendations.0.recommender_name')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="recommendations_0_recommender_title" class="block text-gray-700 text-sm font-bold mb-1">Recommender's Title (Optional):</label>
                                    <input type="text" id="recommendations_0_recommender_title" name="recommendations[0][recommender_title]" value="{{ old('recommendations.0.recommender_title') }}" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                     @error('recommendations.0.recommender_title')
                                        <span class="error text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="remove-recommendation-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button>
                                <hr class="my-4">
                            </div>
                        </div>
                        <button type="button" id="add-recommendation-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add  Recommendation</button>
                    </section>

                      {{-- 11. Custom Sections --}}
   <section id="custom-sections-section" class="mb-8 p-4  rounded-md"> {{-- Added styling and ID --}}
       <h2>Custom Sections</h2>
       <div id="custom-section-entries" class="space-y-4"> {{-- Added space-y for spacing repeatable entries --}}
           {{-- Initial Custom Section Entry (added dynamically) --}}
       </div>
       <button type="button" id="add-custom-section-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add Custom Section</button>
   </section>


   <button type="submit" class="mt-8 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Create Portfolio</button> {{-- Basic button styling --}}


</form> {{-- Closing form tag --}}
</div> {{-- Closing div for the left column (lg:col-span-1) --}}

 

</div> {{-- Closing div for the grid (grid grid-cols-1 lg:grid-cols-2 gap-8) --}}
</div> {{-- Closing div for the container (container mx-auto px-4 py-8) --}}

{{-- Link your main app JavaScript (including dynamic form logic and preview script) --}}
@vite('resources/js/app.js')

</body> {{-- Closing body tag --}}
</html> {{-- Closing html tag --}}
