<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Portfolio</title>
    <!-- Link your main app CSS (might include Tailwind) -->
    @vite('resources/css/app.css')
    {{-- Add some basic inline styles for the preview containers if not handled by Tailwind --}}
    <style>
        .preview-section {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            margin-bottom: 20px; /* Space between preview sections */
             min-height: 100px; /* Ensure minimum height */
             overflow-y: auto; /* Allow scrolling within individual previews if they get long */
        }

         /* Style for placeholder image previews within individual preview sections */
         .preview-section img.preview-placeholder-img {
             display: none; /* Initially hidden */
             /* Add other placeholder styling */
             background-color: #eee;
             border: 1px dashed #ccc;
         }

        /* Add basic styling for preview elements to resemble show page */
         .preview-section h1, .preview-section h2, .preview-section h3 { font-weight: bold; margin-bottom: 1rem; }
         .preview-section img { max-width: 100%; height: auto; }
         .preview-section .paragraph-image-container { display: flex; gap: 20px; flex-wrap: wrap; }
         .preview-section .paragraph-content, .preview-section .image-content { flex: 1; min-width: 200px; }

         /* You might need additional styles here to make the preview look more like the show page */
    </style>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success" role="alert" style="color: green; margin-bottom: 20px; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Left Column: The Form --}}
            <div class="lg:col-span-1 space-y-8">
                <h1 class="text-2xl font-bold mb-6">Create Your Portfolio</h1>

                <form id="portfolio-form" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 1. Personal & Contact Info (Form) --}}
                    <section id="personal-info-form" class="p-4 border rounded-md">
                        <h2>Personal & Contact Info</h2>
                         <div class="mb-4">
                             <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label>
                             <input type="text" id="name" name="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('name')
                                 <span class="error text-red-500 text-xs italic">{{ $message }}</span>
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
                         {{-- Add more basic contact fields like city, etc. --}}
                    </section>

                    {{-- 2. About Me Section (Form) --}}
                    <section id="about-me-form" class="p-4 border rounded-md">
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

                     {{-- 3. Online Presence (Form) --}}
                    <section id="online-presence-form" class="p-4 border rounded-md">
                        <h2>Online Presence</h2>
                        <div id="online-presence-entries" class="space-y-4">
                            {{-- Initial Online Presence Entry --}}
                            <div class="online-presence-entry p-4 border rounded-md bg-gray-50">
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
                                <button type="button" class="remove-online-presence-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove</button>
                                <hr class="my-4">
                            </div>
                        </div>
                        <button type="button" id="add-online-presence-btn" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Add Another Link</button>
                    </section>


                    {{-- 4. Contact Section (Form) --}}
                  <section id="contact-form" class="p-4 border rounded-md">
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

                    {{-- 5. Optional: Basic Styling/Meta Info (Form) --}}
                     <section id="appearance-form" class="p-4 border rounded-md">
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


                    {{-- 6. Optional: Skills Section (Form) --}}
                    <section id="skills-form" class="p-4 border rounded-md">
                        <h2>Skills</h2>
                        <div class="mb-4">
                            <label for="skills_heading" class="block text-gray-700 text-sm font-bold mb-2">Skills Section Heading:</label>
                            <input type="text" id="skills_heading" name="skills_heading" value="{{ old('skills_heading', 'My Skills') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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

                    {{-- 7. Work Experience Section (Form) - Add later --}}
                    {{-- 8. Education Section (Form) - Add later --}}
                    {{-- 9. Projects Section (Form) - Add later --}}
                    {{-- 10. Recommendations/Testimonials Section (Form) - Add later --}}
                    {{-- 11. Custom Sections (Form) - Add later --}}


                    <button type="submit" class="mt-8 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Create Portfolio</button>


                </form>
            </div> {{-- End left column div --}}

            {{-- Right Column: The Preview Area --}}
            <div class="lg:col-span-1 space-y-8"> {{-- Takes the other column on large screens, vertical space between preview sections --}}
                <h2 class="text-2xl font-bold mb-6">Portfolio Preview</h2>

                {{-- 1. Personal & Contact Info (Preview) --}}
                <section id="personal-info-preview" class="preview-section">
                     <h3>Personal Info Preview</h3>
                     <div class="preview-content">
      {{-- Preview will be generated here by JavaScript --}}
       <img id="profile-picture-preview" src="" alt="Profile Picture Preview" class="preview-placeholder-img"> {{-- Placeholder with ID --}}
 </div>

                </section>

                {{-- 2. About Me (Preview) --}}
                <section id="about-me-preview" class="preview-section">
                     <h3>About Me Preview</h3>
                     <div class="preview-content">
      {{-- Preview will be generated here by JavaScript --}}
       <img id="about-image-preview" src="" alt="About Image Preview" class="preview-placeholder-img"> {{-- Placeholder with ID --}}
 </div>

                </section>

                 {{-- 3. Online Presence (Preview) --}}
                 <section id="online-presence-preview" class="preview-section">
                      <h3>Online Presence Preview</h3>
                      <div class="preview-content">
                           {{-- Preview will be generated here by JavaScript --}}
                      </div>
                 </section>

                  {{-- 4. Contact Section (Preview) --}}
                  <section id="contact-preview" class="preview-section">
                       <h3>Contact Info Preview</h3>
                       <div class="preview-content">
                            {{-- Preview will be generated here by JavaScript --}}
                       </div>
                  </section>

                   {{-- 5. Optional: Basic Styling/Meta Info (Preview) --}}
                   <section id="appearance-preview" class="preview-section">
                        <h3>Appearance Preview</h3>
                        <div class="preview-content">
                             {{-- Preview will be generated here by JavaScript --}}
                        </div>
                   </section>

                    {{-- 6. Optional: Skills Section (Preview) --}}
                    <section id="skills-preview" class="preview-section">
                         <h3>Skills Preview</h3>
                         <div class="preview-content">
                              {{-- Preview will be generated here by JavaScript --}}
                         </div>
                    </section>

                     {{-- 7. Work Experience (Preview) - Add later --}}
                     {{-- 8. Education (Preview) - Add later --}}
                     {{-- 9. Projects (Preview) - Add later --}}
                     {{-- 10. Recommendations/Testimonials (Preview) - Add later --}}
                     {{-- 11. Custom Sections (Preview) - Add later --}}

            </div> {{-- End right column div --}}

        </div> {{-- End grid --}}
    </div> {{-- End container --}}

    {{-- Link your main app JavaScript --}}
    @vite('resources/js/app.js')

</body>
</html>
