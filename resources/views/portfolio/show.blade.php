<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{   $portfolio->name . "'s Portfolio" }}</title>

    <!-- Standard SEO Meta Tags -->
    <meta name="author" content="{{ $portfolio->name }}">
    {{-- Consider adding dynamic meta descriptions and keywords from portfolio data if you collected them --}}
    {{-- <meta name="description" content="{{ $portfolio->landing_page_summary }}"> --}}
    {{-- <meta name="keywords" content="{{ $portfolio->skills_list }}"> --}}

    {{-- Open Graph (OG) and Twitter Meta Tags (Adapt these dynamically if you collected data) --}}
    <meta property="og:site_name" content="Portfolio of {{ $portfolio->name }}">
    <meta property="og:title" content="{{ $portfolio->name }} | {{ $portfolio->job_title }}">
    <meta name="twitter:title" content="{{ $portfolio->name }} | {{ $portfolio->job_title }}">
    <meta property="og:description" content="{{ $portfolio->landing_page_summary }}">
    <meta name="twitter:description" content="{{ $portfolio->landing_page_summary }}">
    {{-- If you have a default image or let users upload one for sharing, add here --}}
    {{-- <meta property="og:image" content="{{ asset('storage/' . $portfolio->profile_picture_url) }}"> --}}
    {{-- <meta name="twitter:image" content="{{ asset('storage/' . $portfolio->profile_picture_url) }}"> --}}
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image"> {{-- Use summary_large_image if you have a hero image --}}
    {{-- <link rel="canonical" href="{{ url()->current() }}"> --}} {{-- Canonical URL if needed --}}


    <!-- Link to your compiled Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Embedded Styles (for dynamic or complex CSS not easily done with utility classes, or if mimicking specific complex styles) -->
    <style>
        /* CSS for dynamic text sizing based on name length */
        .text-size-short {
            font-size: 3rem; /* text-4xl equivalent */
            font-weight: bold;
            line-height: 1.1;
        }

        @media (min-width: 640px) {
            .text-size-short {
                font-size: 3.5rem; /* sm */
            }
        }

        @media (min-width: 768px) {
            .text-size-short {
                font-size: 4rem; /* md */
            }
        }

        @media (min-width: 1024px) {
            .text-size-short {
                font-size: 5rem; /* lg */
            }
        }

        @media (min-width: 1280px) {
            .text-size-short {
                font-size: 6rem; /* xl */
            }
        }

        /* Medium names */
        .text-size-medium {
            font-size: 2.5rem; /* text-3xl equivalent */
            font-weight: bold;
            line-height: 1.1;
        }

        @media (min-width: 640px) {
            .text-size-medium {
                font-size: 3rem; /* sm */
            }
        }

        @media (min-width: 768px) {
            .text-size-medium {
                font-size: 3.5rem; /* md */
            }
        }

        @media (min-width: 1024px) {
            .text-size-medium {
                font-size: 4rem; /* lg */
            }
        }

    

        /* Long names */
        .text-size-long {
            font-size: 2rem; /* text-2xl equivalent */
            font-weight: bold;
            line-height: 1.1;
        }

        @media (min-width: 640px) {
            .text-size-long {
                font-size: 2.5rem; /* sm */
            }
        }

        @media (min-width: 768px) {
            .text-size-long {
                font-size: 3rem; /* md */
            }
        }

        @media (min-width: 1024px) {
            .text-size-long {
                font-size: 3.5rem; /* lg */
            }
        }

        @media (min-width: 1280px) {
            .text-size-long {
                font-size: 4rem; /* xl */
            }
        }

        /* Basic styling for embedded sections to resemble example */
         .section-spacing {
             padding: 80px 0; /* Adjusted padding */
         }
         /* Add other specific styles from your example's style/template CSS as needed */
         .reference-card, .reference-card-2 {
             background: white;
             border: 1px solid rgba(0, 0, 0, 0.1);
             border-radius: 16px;
             transition: all 0.3s ease;
         }
         .reference-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); }
         .reference-card-2:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
         .skill-tag {
             background: #f5f5f5; /* Light gray */
             padding: 0.75rem 1.5rem;
             border-radius: 9999px; /* Full rounded */
             transition: all 0.3s ease;
         }
          .skill-tag:hover {
              background: white;
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
              transform: translateY(-2px);
          }
          /* Add more custom styles or overrides as needed */
    </style>

    {{-- Keep Bootstrap/jQuery if needed for very specific complex components, but ideally replicate with Tailwind/vanilla JS --}}
    {{-- <script src="https://portfolio-up.com/js/jquery-3.5.1.min.js"></script> --}}
    {{-- <script src="https://portfolio-up.com/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://portfolio-up.com/js/scrollIt.min.js"></script> --}}

     <!-- Embedded JavaScript for functionality -->
     <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Dynamic Text Sizing Script (Adapted)
            function applyTextSize(selector) {
                document.querySelectorAll(selector).forEach(element => {
                    // Get the dynamic first name and last name from the data attributes
                    let firstName = element.getAttribute('data-first-name') || '';
                    let lastName = element.getAttribute('data-last-name') || '';

                    // Calculate the maximum length between first and last names
                    let maxLength = Math.max(firstName.length, lastName.length);

                    // Remove existing size classes
                    element.classList.remove('text-size-short', 'text-size-medium', 'text-size-long');

                    // Dynamically assign the appropriate size class
                     if (maxLength >= 13) {
                        element.classList.add('text-size-long');
                    } else if (maxLength >= 10) { // Adjusted threshold for medium
                        element.classList.add('text-size-medium');
                    } else {
                        element.classList.add('text-size-short');
                    }
                });
            }

            // Call the function on elements with the dynamic-text class after data is loaded
            // This might need to be called after content is dynamically loaded if applicable,
            // but for a static Blade view, DOMContentLoaded is usually fine.
            applyTextSize('.dynamic-text');

             // You could add the scroll smooth script here (vanilla JS)
             // And the fixed header script here (vanilla JS)
             // And the notification bar script here (vanilla JS)
        });
     </script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans leading-relaxed"> {{-- Added leading-relaxed --}}

    {{-- Example Fixed Header (Requires JS to add 'fixed-header' class on scroll) --}}
    {{-- <header class="main-header fixed w-full top-0 z-50 py-4 bg-white shadow-md hidden"> --}}
         {{-- Add content like name/logo and navigation links here --}}
    {{-- </header> --}}


    <main class="wrapper"> {{-- Optional wrapper if needed for overall layout --}}

          {{-- Hero/Intro Section --}}
         {{-- Added section-spacing, bg, flex, items-center --}}
         <section id="home" class="hero-section section-spacing bg-gray-50 flex items-center relative"> {{-- Added relative to the section --}}
             {{-- Responsive container, auto margins, padding, max-w --}}
             {{-- Simplified structure for overlay on mobile --}}
             <div class="container mx-auto px-0 lg:px-10 py-8 max-w-7xl w-full relative z-1 "> {{-- Reverted container classes --}}
                 {{-- Use a grid for desktop, but simpler structure for mobile overlay --}}
                 <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-12 items-center relative"> {{-- Added relative here --}}

                     {{-- Profile Picture / Hero Image - Takes full width on mobile --}}
                     {{-- Image container that will hold the image and the overlaid text --}}
                     <div class="relative w-full lg:order-2 z-10"> {{-- Added w-full --}}
                         @if ($portfolio->profile_picture_url)
                             <img src="{{ asset('storage/' . $portfolio->profile_picture_url) }}"
                                 alt="{{ $portfolio->name }} Profile Picture"
                                 class="  shadow-xl w-full h-auto object-cover"> {{-- Kept h-auto for proportionality --}}
                         @endif
                     </div>

                     {{-- Text content becomes a centered overlay within the image on mobile --}}
                     {{-- Absolute positioning for overlay, Flexbox for centering --}}
                     <div class="absolute inset-0 flex flex-col items-center justify-center z-20 p-4 text-center lg:static lg:space-y-6 lg:mx-auto lg:p-0 lg:rounded-none lg:inset-auto lg:bottom-auto lg:text-left "> {{-- Key styling changes here --}}
                         {{-- Inner container for space-y and content alignment on mobile --}}
                         <div class="space-y-6 w-full max-w-lg mx-auto lg:w-auto lg:max-w-none lg:mx-0 "> {{-- Added width and max-width for mobile containment --}}

                              {{-- Dynamic Name Heading --}}
                              @php
                                   $firstName = strtok($portfolio->name, ' ');
                                   $lastName = strtok('');
                              @endphp
                              <h1 class="dynamic-text font-bold relative z-10 text-white lg:text-black"> {{-- Set text white on mobile --}}
                                  {{ $firstName }} <br> {{ $lastName }} {{-- Display name broken into two lines --}}
                              </h1>

                              @if ($portfolio->job_title)
                                  <p class="text-3xl text-white lg:text-gray-700">{{ $portfolio->job_title }}</p> {{-- Set text white on mobile --}}
                              @endif
                              @if ($portfolio->landing_page_summary)
                                  <p class="text-lg font-normal max-w-xl text-white lg:text-gray-600">{{ $portfolio->landing_page_summary }}</p> {{-- Set text white on mobile --}}
                              @endif

                              {{-- Learn More Button (Adapt href for your smooth scroll) --}}
                              {{-- Button styling, no underline --}}
                              <a href="#about" class="inline-block px-6 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors text-md no-underline mt-6">
                                  Learn More
                              </a>
                         </div>
                     </div>
                 </div>
             </div>
         </section>


         {{-- Skills Section --}}
         @if ($portfolio->skills_list)
             <section id="skills" class="section-spacing bg-white">
                 <div class="container mx-auto px-4 py-8 max-w-5xl">
                     <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">
                         {{ $portfolio->skills_heading ?? 'Skills' }} {{-- Use saved heading or default --}}
                     </h2>
                     @php
                         $skills = explode(',', $portfolio->skills_list);
                     @endphp
                     @if (!empty($skills))
                         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-w-5xl mx-auto px-6"> {{-- Flex container, wrap items, center justify, gap --}}
                             @foreach ($skills as $skill)
                                 <span class="skill-tag inline-block bg-gray-100 text-gray-700 text-sm font-medium px-4 py-2 rounded-full hover:bg-white hover:shadow-md transition-all duration-30 w-80  w-full mx-auto text-center"> {{-- Skill tag styling --}}
                                     {{ trim($skill) }}
                                 </span>
                             @endforeach
                         </div>
                     @endif
                 </div>
             </section>
         @endif


          <!-- About Section -->
         @if ($portfolio->about_me_content)
             <section id="about" class="section-spacing bg-white">
                 {{-- Container with horizontal padding for the whole section --}}
                 <div class="container mx-auto px-4 lg:px-10 py-8 max-w-7xl">
                     {{-- Use a grid with 2 columns for larger screens --}}
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                         {{-- About Image (Desktop view - first column, takes full height) --}}
                         @if ($portfolio->about_image_url)
                             {{-- Reverted image container styling to be constrained on mobile --}}
                             <div class="order-2 lg:order-1 block mx-auto max-w-xl lg:max-w-none flex justify-center lg:justify-start">
                                 <img src="{{ asset('storage/' . $portfolio->about_image_url) }}"
                                     alt="About Image"
                                     class=" shadow-xl w-full h-auto lg:h-full object-cover lg:max-w-none">
                             </div>
                         @endif

                         {{-- About Me Info (Desktop view - second column) --}}
                         {{-- Added mx-auto and max-w-xl to constrain and center text on mobile, removed px-4 --}}
                         <div class="order-1 lg:order-2 space-y-6 mx-auto max-w-xl"> {{-- Removed px-4 here --}}
                             <h2 class="text-4xl md:text-5xl font-bold border-b-2 border-blue-600 pb-2 mb-4">
                                 {{ $portfolio->about_me_heading ?? 'About Me' }}
                             </h2>
                             <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
                                 {{ $portfolio->about_me_content }}
                             </p>

                             {{-- Optional Buttons (Adapt hrefs if needed) --}}
                             <div class="flex flex-wrap gap-4 mt-6">
                                 {{-- Download Resume Button (Adapt URL) --}}
                                 {{-- Contact Me Button --}}
                                 @if ($portfolio->email)
                                     <a href="mailto:{{ $portfolio->email }}"
                                         class="inline-block px-6 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors text-md no-underline">
                                         Contact Me
                                     </a>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
             </section>
         @endif
         <!-- End About Section -->






         <!-- Work Experience Section -->
         @forelse ($portfolio->workExperiences as $workExperience)
             <section id="work-experience" class="section-spacing bg-white">
                 <div class="container mx-auto px-4 py-8 max-w-6xl">
                     <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">Work Experience</h2>
                     <div class="space-y-8"> {{-- Vertical space between entries --}}
                         @foreach ($portfolio->workExperiences as $entry)
                             <div class="reference-card-2 bg-gray-50 rounded-xl px-6 py-8 border border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-lg max-w-3xl mx-auto">
                                <div class="space-y-2"> {{-- Space between title/company/dates --}}
                                    <h3 class="text-xl font-bold text-gray-700">{{ $entry->job_title }}</h3>
                                     <h4 class="text-lg font-medium text-gray-600">{{ $entry->company }}</h4>
                                     @if ($entry->start_date || $entry->end_date)
                                         <p class="text-gray-600 text-md">{{ $entry->start_date }} – {{ $entry->end_date }}</p>
                                     @endif
                                    <hr class="my-4 border-gray-300"> {{-- Horizontal rule --}}
                                    @if ($entry->description)
                                        {{-- Assuming description might contain line breaks for list items --}}
                                         <p class="text-gray-700 whitespace-pre-wrap">{{ $entry->description }}</p> {{-- Preserve line breaks --}}
                                    @endif
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </section>
             @break {{-- Stop after displaying the section once --}}
         @empty
             {{-- Section not displayed if no work experiences --}}
         @endforelse


         <!-- Education Section -->
          @forelse ($portfolio->education as $education)
             <section id="education" class="section-spacing bg-white">
                 <div class="container mx-auto px-4 py-8 max-w-6xl">
                     <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">Education</h2>
                     <div class="space-y-8"> {{-- Vertical space between entries --}}
                         @foreach ($portfolio->education as $entry)
                             <div class="reference-card-2 bg-gray-50 rounded-xl px-6 py-8 border border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-lg max-w-3xl mx-auto">
                                 <div class="space-y-2"> {{-- Space between degree/institution/date --}}
                                     <h3 class="text-xl font-bold text-gray-700">{{ $entry->degree }}</h3>
                                      <h4 class="text-lg font-medium text-gray-600">{{ $entry->institution }}</h4>
                                     @if ($entry->graduation_date)
                                          <p class="text-gray-600 text-md">{{ $entry->graduation_date }}</p>
                                      @endif
                                     <hr class="my-4 border-gray-300"> {{-- Horizontal rule --}}
                                     @if ($entry->description)
                                          <p class="text-gray-700 whitespace-pre-wrap">{{ $entry->description }}</p> {{-- Preserve line breaks --}}
                                     @endif
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </section>
             @break {{-- Stop after displaying the section once --}}
         @empty
             {{-- Section not displayed if no education --}}
         @endforelse

      {{-- Projects Section --}}
@php
    $projectCount = $portfolio->projects->count(); // Get count
@endphp

@if ($projectCount > 0) {{-- Only display section if there's at least one project --}}
    <section id="projects" class="section-spacing bg-white">
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">Projects</h2>

            @if ($projectCount === 1)
                {{-- 1 Project Entry: Single column, centered --}}
                <div class="grid grid-cols-1 gap-8 max-w-sm mx-auto"> {{-- Single column, centered, max-width --}}
                    @foreach ($portfolio->projects as $entry)
                         @include('portfolio._project_card', ['entry' => $entry])
                    @endforeach
                </div>
            @elseif ($projectCount === 2)
                {{-- 2 Project Entries: 2 columns above small, centered on larger --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-lg mx-auto"> {{-- Responsive 2 columns, centered, max-width --}}
                    @foreach ($portfolio->projects as $entry)
                         @include('portfolio._project_card', ['entry' => $entry])
                    @endforeach
                </div>
            @elseif ($projectCount === 3)
                 {{-- 3 Project Entries: 3 columns above small --}}
                 <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"> {{-- Standard responsive 3 columns, centered --}}
                     @foreach ($portfolio->projects as $entry)
                          @include('portfolio._project_card', ['entry' => $entry])
                     @endforeach
                 </div>
            @else {{-- 4 or more project entries --}}
                 {{-- 4+ Project Entries: Responsive grid up to 4 columns --}}
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8"> {{-- Standard responsive grid up to 4 columns --}}
                     @foreach ($portfolio->projects as $entry)
                          @include('portfolio._project_card', ['entry' => $entry])
                     @endforeach
                 </div>
            @endif

        </div> {{-- Closing container div --}}
    </section> {{-- Closing section tag --}}
@endif {{-- End of if projectCount > 0 --}}


          <!-- Recommendations Section -->
           @forelse ($portfolio->recommendations as $recommendation)
               <section id="recommendations" class="section-spacing bg-white">
                   <div class="container mx-auto px-4 py-8 max-w-6xl">
                       <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">Recommendations</h2>
                       <div class="space-y-8"> {{-- Vertical space between quotes --}}
                           @foreach ($portfolio->recommendations as $entry)
                               <div class="reference-card-2 max-w-3xl mx-auto px-6 py-8 border border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-lg">
                                   <div class="space-y-4"> {{-- Space within card --}}
                                       <p class="text-lg md:text-xl text-gray-700 italic">"{{ $entry->quote }}"</p>
                                       <p class="text-md font-medium text-gray-600">- {{ $entry->recommender_name }}
                                           @if ($entry->recommender_title)
                                               , {{ $entry->recommender_title }}
                                           @endif
                                       </p>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                   </div>
               </section>
                @break {{-- Stop after displaying the section once --}}
           @empty
               {{-- Section not displayed if no recommendations --}}
           @endforelse


          <!-- Custom Sections -->
           @forelse ($portfolio->customSections as $customSection)
               {{-- Only display custom section if it has blocks --}}
               @if ($customSection->blocks->count() > 0)
                    <section id="custom-section-{{ $customSection->id }}" class="section-spacing bg-white">
                       <div class="container mx-auto px-4 py-8 max-w-7xl">
                           <h2 class="text-4xl md:text-5xl font-bold mb-16 text-center">
                               {{ $customSection->title ?? 'Custom Section' }} {{-- Use saved title or default --}}
                           </h2>
                           <div class="space-y-8"> {{-- Vertical space between custom blocks --}}
                               @foreach ($customSection->blocks->sortBy('order') as $block)
                                   @if ($block->block_type === 'header')
                                       <h3 class="text-3xl font-semibold text-gray-800">{{ $block->content }}</h3>
                                   @elseif ($block->block_type === 'paragraph')
                                       <p class="text-lg text-gray-700 leading-relaxed">{{ $block->content }}</p>
                                   @elseif ($block->block_type === 'image')
                                       @if ($block->content)
                                           <img src="{{ asset('storage/' . $block->content) }}" alt="Custom Image" class="mx-auto max-w-md rounded-lg shadow-md">
                                       @endif
                                   @elseif ($block->block_type === 'paragraph_image')
                                       @php
                                           $comboContent = json_decode($block->content, true);
                                       @endphp
                                       <div class="paragraph-image-container flex flex-col md:flex-row gap-8 items-center"> {{-- Combo layout: flex, stack on small, row on medium+, gap, center items vertically --}}
                                           @if (!empty($comboContent['paragraph']))
                                               <div class="paragraph-content flex-1 order-2 md:order-1"> {{-- Flex item, takes space, order for responsiveness --}}
                                                    <p class="text-lg text-gray-700 leading-relaxed">{{ $comboContent['paragraph'] }}</p>
                                               </div>
                                           @endif
                                           @if (!empty($comboContent['image']))
                                                <div class="image-content flex-1 order-1 md:order-2"> {{-- Flex item, takes space, order for responsiveness --}}
                                                   <img src="{{ asset('storage/' . $comboContent['image']) }}" alt="Paragraph Image" class="rounded-lg shadow-md w-full h-auto object-cover max-h-96"> {{-- Image styling, max height --}}
                                               </div>
                                           @endif
                                       </div>
                                   @endif
                               @endforeach
                           </div>
                       </div>
                   </section>
               {{-- Only display if title exists and no blocks? Or adjust logic --}}
               @elseif (!empty($customSection->title))
                    {{-- Option: Display just the title if no blocks but title exists --}}
                     <section id="custom-section-{{ $customSection->id }}" class="py-8 px-4 bg-white shadow-lg rounded-lg mb-8">
                         <div class="container mx-auto max-w-7xl">
                             <h2 class="text-4xl md:text-5xl font-bold text-center">{{ $customSection->title }}</h2>
                             <p class="text-gray-600 italic text-center mt-4">No content blocks added to this section.</p>
                         </div>
                     </section>
               @endif
                @break {{-- Stop after displaying the section once --}}
           @empty
                {{-- Section not displayed if no custom sections --}}
           @endforelse
 

    </main>

<!-- Footer -->
 <footer class="py-8 bg-gray-800 text-white text-center"> {{-- Dark background, white text, padding, centered text --}}
     <div class="container mx-auto px-4"> {{-- Responsive container --}}
          <p>&copy; {{ date('Y') }} {{ $portfolio->name ?? 'Portfolio Generator' }}</p> {{-- Display copyright with current year and portfolio name --}}
          {{-- You can add social media links or other footer content here --}}
          {{-- Example:
          <div class="mt-4 space-x-4">
               <a href="#" class="text-gray-400 hover:text-white">Link 1</a>
               <a href="#" class="text-gray-400 hover:text-white">Link 2</a>
          </div>
           --}}
     </div>
 </footer>

 {{-- Optional: Back to Top Button HTML (Requires JS) --}}
 {{-- <a href="#home" class="fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
     </svg>
 </a> --}}


 {{-- Embedded JavaScript (including adapted scripts from the example) --}}
 <script>
     document.addEventListener("DOMContentLoaded", function() {
         // Dynamic Text Sizing Script (Adapted) - Already included in the previous response
         function applyTextSize(selector) {
             document.querySelectorAll(selector).forEach(element => {
                 let firstName = element.getAttribute('data-first-name') || '';
                 let lastName = element.getAttribute('data-last-name') || '';
                 let maxLength = Math.max(firstName.length, lastName.length);
                 element.classList.remove('text-size-short', 'text-size-medium', 'text-size-long');
                 if (maxLength >= 13) {
                     element.classList.add('text-size-long');
                 } else if (maxLength >= 10) {
                     element.classList.add('text-size-medium');
                 } else {
                     element.classList.add('text-size-short');
                 }
             });
         }
         applyTextSize('.dynamic-text');

         // Add your other embedded scripts here (e.g., for smooth scroll, fixed header if needed)
         // Be sure to convert any jQuery or Bootstrap JS dependencies to vanilla JS or use those libraries.
     });
 </script>