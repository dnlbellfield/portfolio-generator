<body>
     <div class="container mx-auto px-4 py-8">
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8"> {{-- Stack on small screens, 2 columns on large, gap --}}

             {{-- Left Column: The Form --}}
             <div class="lg:col-span-1"> {{-- Takes one column on large screens --}}
                 <h1>Create Your Portfolio</h1>
                 <form id="portfolio-form" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     {{-- ... Your existing form sections (Personal Info, Repeatable Sections, etc.) ... --}}
                     <button type="submit">Create Portfolio</button>
                 </form>
             </div>

             {{-- Right Column: The Preview Area --}}
             <div class="lg:col-span-1"> {{-- Takes the other column on large screens --}}
                 <h2>Portfolio Preview</h2>
                 <div id="portfolio-preview" class="border p-4 rounded-lg bg-white shadow-md"> {{-- Add border/padding for the preview box --}}
                     {{-- The dynamically generated preview content will go here --}}
                     <div class="preview-content">
                         {{-- Initial placeholder or skeleton content --}}
                         <p>Start typing in the form to see your preview here!</p>
                     </div>
                 </div>
             </div>

         </div>
     </div>
     {{-- ... Scripts ... --}}
</body>
