<!DOCTYPE html>
<html lang="en">
<head>
    {{-- ... head content ... --}}
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
     </style>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success" role="alert" style="color: green; margin-bottom: 20px; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto px-4 py-8"> {{-- Tailwind container --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8"> {{-- Responsive grid for 2 columns --}}

            {{-- Left Column: The Form --}}
            <div class="lg:col-span-1"> {{-- Takes one column on large screens --}}
                <h1 class="text-2xl font-bold mb-6">Create Your Portfolio</h1> {{-- Basic styling --}}
   <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- CSRF token for security --}}

            {{-- Single-Instance Sections --}}

            {{-- 1. Personal & Contact Info --}}
<section>
    <h2>Personal & Contact Info</h2>
    <div>
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required> {{-- Added value="{{ old('name') }}" --}}
        @error('name') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"> {{-- Added value="{{ old('email') }}" --}}
         @error('email') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="job_title">Job Title/Headline:</label>
        <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}"> {{-- Added value="{{ old('job_title') }}" --}}
         @error('job_title') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="landing_page_summary">Short Landing Page Summary (1-2 sentences):</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="landing_page_summary" name="landing_page_summary" rows="2">{{ old('landing_page_summary') }}</textarea> {{-- Added old() --}}
         @error('landing_page_summary') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture">
        {{-- old() does not work directly for file inputs. Errors work though. --}}
         @error('profile_picture') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     
</section>


            {{-- 2. About Me Section --}}
<section>
    <h2>About Me</h2>
     <div>
        <label for="about_me_heading">About Me Heading:</label>
        {{-- Use old() and fallback to the default value if no old input --}}
        <input type="text" id="about_me_heading" name="about_me_heading" value="{{ old('about_me_heading', 'About Me') }}">
         @error('about_me_heading') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="about_me_content">About Me Content:</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="about_me_content" name="about_me_content" rows="6">{{ old('about_me_content') }}</textarea>
         @error('about_me_content') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="about_image">Second About Image:</label>
        <input type="file" id="about_image" name="about_image">
        {{-- old() does not work directly for file inputs. Errors work though. --}}
         @error('about_image') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
</section>


{{-- 3. Online Presence (Repeatable) --}}
<div class="online-presence-entry">
     <h3>Link #1</h3>
    <div>
        <label for="online_presences_0_label">Label (e.g., LinkedIn, Website):</label>
        <input type="text" id="online_presences_0_label" name="online_presences[0][label]" value="{{ old('online_presences.0.label') }}"> {{-- Added old() --}}
         @error('online_presences.0.label') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="online_presences_0_url">URL:</label>
        <input type="url" id="online_presences_0_url" name="online_presences[0][url]" value="{{ old('online_presences.0.url') }}"> {{-- Added old() --}}
         @error('online_presences.0.url') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="remove-online-presence-entry">Remove</button>
    <hr>
</div>



            {{-- 4. Contact Section --}}
          <section>
    <h2>Contact Info</h2>
     <div>
        <label for="contact_heading">Contact Section Heading:</label>
        {{-- Use old() and fallback to the default value if no old input --}}
        <input type="text" id="contact_heading" name="contact_heading" value="{{ old('contact_heading', 'Get in Touch') }}">
         @error('contact_heading') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    {{-- Email is already in Personal Info, add other contact methods if needed --}}
</section>


            {{-- 5. Optional: Basic Styling/Meta Info --}}
             <section>
    <h2>Appearance (Optional)</h2>
     <div>
        <label for="portfolio_title">Browser Tab Title:</label>
        <input type="text" id="portfolio_title" name="portfolio_title" value="{{ old('portfolio_title') }}">
         @error('portfolio_title') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     {{-- Add fields for basic theme/font choices here later --}}
</section>



            {{-- Repeatable sections (Work Experience, Education, Projects, Recommendations, Custom Sections) will go here --}}
            {{-- We will add the structure for these and the "Add More" buttons in the next steps --}}

            {{-- Repeatable sections --}}

            {{-- 6. Optional: Skills Section (Keeping it simple as a single textarea) --}}
<section id="skills-section">
    <h2>Skills</h2>
    <div>
        <label for="skills_heading">Skills Section Heading:</label>
        {{-- Use old() and fallback to the default value if no old input --}}
        <input type="text" id="skills_heading" name="skills_heading" value="{{ old('skills_heading', 'My Skills') }}">
         @error('skills_heading') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="skills_list">List of Skills (Comma-separated or bullet points):</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="skills_list" name="skills_list" rows="4">{{ old('skills_list') }}</textarea>
         @error('skills_list') {{-- Added Error Directive --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
</section>


   {{-- 7. Work Experience Section --}}
<div class="work-experience-entry">
    <h3>Work Experience #1</h3>
    <div>
        <label for="work_experiences_0_job_title">Job Title:</label>
        <input type="text" id="work_experiences_0_job_title" name="work_experiences[0][job_title]" value="{{ old('work_experiences.0.job_title') }}"> {{-- Added old() with dot notation --}}
         @error('work_experiences.0.job_title') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="work_experiences_0_company">Company:</label>
        <input type="text" id="work_experiences_0_company" name="work_experiences[0][company]" value="{{ old('work_experiences.0.company') }}"> {{-- Added old() with dot notation --}}
         @error('work_experiences.0.company') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="work_experiences_0_start_date">Start Date (e.g., Spring 2023):</label> {{-- Updated Label --}}
        <input type="text" id="work_experiences_0_start_date" name="work_experiences[0][start_date]" value="{{ old('work_experiences.0.start_date') }}"> {{-- Added old() with dot notation --}}
         @error('work_experiences.0.start_date') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="work_experiences_0_end_date">End Date (e.g., Present):</label> {{-- Updated Label --}}
        <input type="text" id="work_experiences_0_end_date" name="work_experiences[0][end_date]" value="{{ old('work_experiences.0.end_date') }}"> {{-- Added old() with dot notation --}}
         @error('work_experiences.0.end_date') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="work_experiences_0_description">Description:</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="work_experiences_0_description" name="work_experiences[0][description]" rows="4">{{ old('work_experiences.0.description') }}</textarea> {{-- Added old() with dot notation --}}
         @error('work_experiences.0.description') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="remove-work-experience-entry">Remove</button>
    <hr> {{-- Separator --}}
</div>



            {{-- 8. Education Section --}}
<div class="education-entry">
    <h3>Education #1</h3>
    <div>
        <label for="education_0_degree">Degree:</label>
        <input type="text" id="education_0_degree" name="education[0][degree]" value="{{ old('education.0.degree') }}"> {{-- Added old() with dot notation --}}
         @error('education.0.degree') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="education_0_institution">Institution:</label>
        <input type="text" id="education_0_institution" name="education[0][institution]" value="{{ old('education.0.institution') }}"> {{-- Added old() with dot notation --}}
         @error('education.0.institution') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
     <div>
        <label for="education_0_graduation_date">Graduation Date (e.g., May 2017 or Ongoing):</label>
        <input type="text" id="education_0_graduation_date" name="education[0][graduation_date]" value="{{ old('education.0.graduation_date') }}"> {{-- Added old() with dot notation --}}
         @error('education.0.graduation_date') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="education_0_description">Description (Optional):</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="education_0_description" name="education[0][description]" rows="4">{{ old('education.0.description') }}</textarea> {{-- Added old() with dot notation --}}
         @error('education.0.description') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="remove-education-entry">Remove</button>
    <hr> {{-- Separator --}}
</div>


            {{-- 9. Projects Section --}}
   <div class="project-entry">
    <h3>Project #1</h3>
    <div>
        <label for="projects_0_title">Project Title:</label>
        <input type="text" id="projects_0_title" name="projects[0][title]" value="{{ old('projects.0.title') }}"> {{-- Added old() with dot notation --}}
         @error('projects.0.title') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="projects_0_description">Description:</label>
        {{-- For textarea, old() goes between tags --}}
        <textarea id="projects_0_description" name="projects[0][description]" rows="4">{{ old('projects.0.description') }}</textarea> {{-- Added old() with dot notation --}}
         @error('projects.0.description') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="projects_0_image">Project Image:</label>
        <input type="file" id="projects_0_image" name="projects[0][image]"> {{-- old() does not work for file inputs --}}
         @error('projects.0.image') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="projects_0_live_demo_url">Live Demo URL:</label>
        <input type="url" id="projects_0_live_demo_url" name="projects[0][live_demo_url]" value="{{ old('projects.0.live_demo_url') }}"> {{-- Added old() with dot notation --}}
         @error('projects.0.live_demo_url') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="projects_0_github_url">GitHub URL:</label>
        <input type="url" id="projects_0_github_url" name="projects[0][github_url]" value="{{ old('projects.0.github_url') }}"> {{-- Added old() with dot notation --}}
         @error('projects.0.github_url') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="projects_0_technologies">Technologies Used (Comma-separated):</label>
        <input type="text" id="projects_0_technologies" name="projects[0][technologies]" value="{{ old('projects.0.technologies') }}"> {{-- Added old() with dot notation --}}
         @error('projects.0.technologies') {{-- Added Error Directive with dot notation --}}
            <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="remove-project-entry">Remove</button>
    <hr> {{-- Separator --}}
</div>


            {{-- 10. Recommendations/Testimonials Section --}}
            <div class="recommendation-entry">
                <h3>Recommendation #1</h3>
                <div>
                    <label for="recommendations_0_quote">Quote:</label>
                    {{-- For textarea, old() goes between tags --}}
                    <textarea id="recommendations_0_quote" name="recommendations[0][quote]" rows="4">{{ old('recommendations.0.quote') }}</textarea> {{-- Added old() with dot notation --}}
                    @error('recommendations.0.quote') {{-- Added Error Directive with dot notation --}}
                        <span class="error" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="recommendations_0_recommender_name">Recommender's Name:</label>
                    <input type="text" id="recommendations_0_recommender_name" name="recommendations[0][recommender_name]" value="{{ old('recommendations.0.recommender_name') }}"> {{-- Added old() with dot notation --}}
                    @error('recommendations.0.recommender_name') {{-- Added Error Directive with dot notation --}}
                        <span class="error" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="recommendations_0_recommender_title">Recommender's Title (Optional):</label>
                    <input type="text" id="recommendations_0_recommender_title" name="recommendations[0][recommender_title]" value="{{ old('recommendations.0.recommender_title') }}"> {{-- Added old() with dot notation --}}
                    @error('recommendations.0.recommender_title') {{-- Added Error Directive with dot notation --}}
                        <span class="error" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <button type="button" class="remove-recommendation-entry">Remove</button>
                <hr> {{-- Separator --}}
            </div>


                       {{-- 11. Custom Sections --}}
            <section id="custom-sections-section">
                <h2>Custom Sections</h2>
                <div id="custom-section-entries">
           
                </div>
                <button type="button" id="add-custom-section-btn">Add Custom Section</button>
            </section>


 




                                <button type="submit" class="mt-8 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Create Portfolio</button> {{-- Basic button styling --}}


        </form>
            </div>

            {{-- Right Column: The Preview Area --}}
            <div class="lg:col-span-1"> {{-- Takes the other column on large screens --}}
                <h2 class="text-2xl font-bold mb-6">Portfolio Preview</h2> {{-- Basic styling --}}
                <div id="portfolio-preview">
                    <div class="preview-content">
                        {{-- Initial placeholder or skeleton content --}}
                        <p>Fill out the form to see your portfolio preview!</p>
                    </div>
                </div>
            </div>

        </div> {{-- End grid --}}
    </div> {{-- End container --}}

    {{-- Link your main app JavaScript (including dynamic form logic and preview script) --}}
    @vite('resources/js/app.js')

</body>
</html>
