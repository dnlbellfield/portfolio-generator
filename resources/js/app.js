import './bootstrap';


// --- Online Presence ---
const onlinePresenceEntries = document.getElementById('online-presence-entries');
const addOnlinePresenceBtn = document.getElementById('add-online-presence-btn');
const onlinePresenceEntrySelector = '.online-presence-entry';
const onlinePresenceSectionName = 'online_presences';
const onlinePresenceIdPrefix = 'online_presences';
const onlinePresenceHeadingPrefix = 'Link';  



// HTML Templates for Custom Section Blocks
const headerBlockTemplate = `
    <div class="custom-section-block custom-block-header">
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="header">
        <div>
            <label>Header Content:</label>
            <input type="text" name="BLOCK_NAME[BLOCK_INDEX][content]">
        </div>
        <button type="button" class="remove-custom-block">Remove Block</button>
    </div>
`;

const paragraphBlockTemplate = `
    <div class="custom-section-block custom-block-paragraph">
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="paragraph">
        <div>
            <label>Paragraph Content:</label>
            <textarea name="BLOCK_NAME[BLOCK_INDEX][content]" rows="3"></textarea>
        </div>
         <button type="button" class="remove-custom-block">Remove Block</button>
    </div>
`;

const imageBlockTemplate = `
    <div class="custom-section-block custom-block-image">
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="image">
        <div>
            <label>Image File:</label>
            <input type="file" name="BLOCK_NAME[BLOCK_INDEX][content]">
        </div>
         <button type="button" class="remove-custom-block">Remove Block</button>
    </div>
`;


const paragraphImageBlockTemplate = `
    <div class="custom-section-block custom-block-paragraph-image" style="width:100%;"> {{-- Removed max-width here, use Tailwind on preview if needed --}}
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="paragraph_image">
        <div class="paragraph-image-container" style="display: flex; gap: 10px; flex-wrap: no-wrap;">
            <div class="paragraph-content" style="flex: 1;"> {{-- Removed min-width here --}}
                <label>Paragraph Content:</label>
                <textarea name="BLOCK_NAME[BLOCK_INDEX][content][paragraph]" rows="4"></textarea>
            </div>
            <div class="image-content" style="flex: 1;"> {{-- Removed min-width here --}}
                <label>Image File:</label>
                <input type="file" name="BLOCK_NAME[BLOCK_INDEX][content][image]">
            </div>
        </div>
        <button type="button" class="remove-custom-block">Remove Block</button>
    </div>
`;


// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {

  // --- Preview Area Elements for First 6 Sections ---
const personalInfoPreviewContent = document.getElementById('personal-info-preview').querySelector('.preview-content');
const aboutMePreviewContent = document.getElementById('about-me-preview').querySelector('.preview-content');
const onlinePresencePreviewContent = document.getElementById('online-presence-preview').querySelector('.preview-content');
const contactPreviewContent = document.getElementById('contact-preview').querySelector('.preview-content');
const appearancePreviewContent = document.getElementById('appearance-preview').querySelector('.preview-content');
const skillsPreviewContent = document.getElementById('skills-preview').querySelector('.preview-content');
// --- Section-Specific Preview Generation Functions ---

function generatePersonalInfoPreview() {
    const name = document.getElementById('name').value;
    const jobTitle = document.getElementById('job_title').value;
    const landingPageSummary = document.getElementById('landing_page_summary').value;
    // Profile picture preview is handled by setupImagePreview

    let previewHtml = '';
    if (name || jobTitle || landingPageSummary || document.getElementById('profile_picture').files.length > 0) { // Only show if there's some content
         previewHtml += `
             <section> {{-- Basic section wrapper for preview --}}
                  ${document.getElementById('profile-picture-preview') && document.getElementById('profile-picture-preview').src ? `<img src="${document.getElementById('profile-picture-preview').src}" alt="Profile Picture Preview" class="preview-placeholder-img" style="max-width: 80px; border-radius: 50%; margin-bottom: 10px;">` : ''} {{-- Use placeholder img src --}}
                 <h3>${name || 'Your Name'}</h3>
                 ${jobTitle ? `<p>${jobTitle}</p>` : ''}
                 ${landingPageSummary ? `<p>${landingPageSummary}</p>` : ''}
                 {{-- Online Presence links will be in their own preview section --}}
             </section>
         `;
    }
    personalInfoPreviewContent.innerHTML = previewHtml;
}

function generateAboutMePreview() {
    const aboutMeHeading = document.getElementById('about_me_heading').value;
    const aboutMeContent = document.getElementById('about_me_content').value;
    // Second about image preview is handled by setupImagePreview

     let previewHtml = '';
     if (aboutMeHeading || aboutMeContent || document.getElementById('about_image').files.length > 0) { // Only show if there's some content
         previewHtml += `
             <section>
                 <h2>${aboutMeHeading || 'About Me'}</h2>
                 ${aboutMeContent ? `<p>${aboutMeContent}</p>` : ''}
                 ${document.getElementById('about-image-preview') && document.getElementById('about-image-preview').src ? `<img src="${document.getElementById('about-image-preview').src}" alt="About Image Preview" class="preview-placeholder-img" style="max-width: 150px; margin-top: 10px;">` : ''} {{-- Use placeholder img src --}}
             </section>
         `;
     }
    aboutMePreviewContent.innerHTML = previewHtml;
}

 function generateOnlinePresencePreview() {
     const links = [];
     document.querySelectorAll('#online-presence-entries .online-presence-entry').forEach(entry => {
         const label = entry.querySelector('input[name$="[label]"]').value;
         const url = entry.querySelector('input[name$="[url]"]').value;
          if (label || url) { // Only include if there's some content
             links.push({ label: label, url: url });
         }
     });

      let previewHtml = '';
      if (links.length > 0) { // Only show section if there are links
          previewHtml += `
              <section>
                  <h2>Online Presence</h2>
                  <div class="space-x-4"> {{-- Tailwind spacing --}}
                       ${links.map(link => `<a href="${link.url}" target="_blank">${link.label || link.url}</a>`).join(' ')}
                  </div>
              </section>
          `;
      }
     onlinePresencePreviewContent.innerHTML = previewHtml;
 }

 function generateContactPreview() {
     const contactHeading = document.getElementById('contact_heading').value;
     const email = document.getElementById('email').value; // Email is in Personal Info form section

      let previewHtml = '';
      if (contactHeading || email) { // Only show if there's some content
          previewHtml += `
              <section>
                  <h2>${contactHeading || 'Get in Touch'}</h2>
                   ${email ? `<p>Email: <a href="mailto:${email}">${email}</a></p>` : ''}
                  {{-- Note: Online Presence links are in their own preview section --}}
              </section>
          `;
      }
     contactPreviewContent.innerHTML = previewHtml;
 }

  function generateAppearancePreview() {
      const portfolioTitle = document.getElementById('portfolio_title').value;
      // Theme and font are not form inputs yet

       let previewHtml = '';
       if (portfolioTitle) { // Only show if there's a title
           previewHtml += `
               <section>
                    <h3>Appearance Info</h3>
                    <p>Browser Title: ${portfolioTitle}</p>
               </section>
           `;
       }
      appearancePreviewContent.innerHTML = previewHtml;
  }

   function generateSkillsPreview() {
       const skillsHeading = document.getElementById('skills_heading').value;
       const skillsList = document.getElementById('skills_list').value;

        let previewHtml = '';
        if (skillsList) { // Only show if skills list has content
            // You might adapt the show page logic here to split the string and display as pills
             previewHtml += `
                <section>
                    <h2>${skillsHeading || 'Skills'}</h2>
                    <p>${skillsList}</p> {{-- Basic display as text --}}
                </section>
             `;
        }
       skillsPreviewContent.innerHTML = previewHtml;
   }


    // --- Portfolio Preview Logic ---
    const portfolioForm = document.getElementById('portfolio-form');
    const portfolioPreviewContent = document.getElementById('portfolio-preview').querySelector('.preview-content');

    // Function to generate and update the portfolio preview
    function updatePortfolioPreview() {
        // --- 1. Read Data from Form ---

        const portfolioData = {
            name: document.getElementById('name').value,
            job_title: document.getElementById('job_title').value,
            landing_page_summary: document.getElementById('landing_page_summary').value,
            about_me_heading: document.getElementById('about_me_heading').value,
            about_me_content: document.getElementById('about_me_content').value,
            contact_heading: document.getElementById('contact_heading').value,
            email: document.getElementById('email').value,
            portfolio_title: document.getElementById('portfolio_title').value,
            theme_basic: null, // Assuming these aren't user-selectable in the form yet
            font_basic: null, // Assuming these aren't user-selectable in the form yet
            skills_heading: document.getElementById('skills_heading').value,
            skills_list: document.getElementById('skills_list').value,
            profile_picture_url: null, // Handled by separate image preview logic
            about_image_url: null, // Handled by separate image preview logic
            onlinePresences: [],
            workExperiences: [],
            education: [],
            projects: [],
            recommendations: [],
            customSections: [],
        };

        // Read Repeatable Sections (Online Presence, Work Experience, etc.)
        document.querySelectorAll('#online-presence-entries .online-presence-entry').forEach(entry => {
            const label = entry.querySelector('input[name$="[label]"]').value; // Use attribute selector to find the name ending in [label]
            const url = entry.querySelector('input[name$="[url]"]').value;
            if (label || url) {
                portfolioData.onlinePresences.push({ label: label, url: url });
            }
        });
        document.querySelectorAll('#work-experience-entries .work-experience-entry').forEach(entry => {
            const job_title = entry.querySelector('input[name$="[job_title]"]').value;
            const company = entry.querySelector('input[name$="[company]"]').value;
            const start_date = entry.querySelector('input[name$="[start_date]"]').value;
            const end_date = entry.querySelector('input[name$="[end_date]"]').value;
            const description = entry.querySelector('textarea[name$="[description]"]').value;
            if (job_title || company || description) { // Basic check for empty entry
                portfolioData.workExperiences.push({ job_title, company, start_date, end_date, description });
            }
        });
        document.querySelectorAll('#education-entries .education-entry').forEach(entry => {
            const degree = entry.querySelector('input[name$="[degree]"]').value;
            const institution = entry.querySelector('input[name$="[institution]"]').value;
            const graduation_date = entry.querySelector('input[name$="[graduation_date]"]').value;
            const description = entry.querySelector('textarea[name$="[description]"]').value;
            if (degree || institution || description) {
                portfolioData.education.push({ degree, institution, graduation_date, description });
            }
        });
        document.querySelectorAll('#projects-section .project-entry').forEach(entry => { // Projects section has different selector
            const title = entry.querySelector('input[name$="[title]"]').value;
            const description = entry.querySelector('textarea[name$="[description]"]').value;
            const live_demo_url = entry.querySelector('input[name$="[live_demo_url]"]').value;
            const github_url = entry.querySelector('input[name$="[github_url]"]').value;
            const technologies = entry.querySelector('input[name$="[technologies]"]').value;
            // Image preview is handled separately below for project images
             const imgPreviewElement = entry.querySelector('img.project-image-preview'); // Find the project image preview element in the FORM entry
             const imageUrl = imgPreviewElement ? imgPreviewElement.src : null; // Use the data URL or null

            if (title || description || live_demo_url || github_url || technologies || imageUrl) {
                portfolioData.projects.push({ title, description, live_demo_url, github_url, technologies, image_url: imageUrl }); // Include the image URL
            }
        });
        document.querySelectorAll('#recommendation-entries .recommendation-entry').forEach(entry => {
            const quote = entry.querySelector('textarea[name$="[quote]"]').value;
            const recommender_name = entry.querySelector('input[name$="[recommender_name]"]').value;
            const recommender_title = entry.querySelector('input[name$="[recommender_title]"]').value;
            if (quote || recommender_name) {
                portfolioData.recommendations.push({ quote, recommender_name, recommender_title });
            }
        });

        // Read Custom Sections and Blocks
        document.querySelectorAll('#custom-section-entries .custom-section-entry').forEach(customSectionEntry => {
            const title = customSectionEntry.querySelector('input[name$="[title]"]').value;
            const blocks = [];
            customSectionEntry.querySelectorAll('.custom-section-block').forEach(blockElement => {
                const typeInput = blockElement.querySelector('input[name$="[type]"]');
                if (!typeInput) return; // Skip if type input not found

                const type = typeInput.value;
                let content = null;

                if (type === 'header' || type === 'paragraph') {
                    content = blockElement.querySelector('[name$="[content]"]').value;
                } else if (type === 'image') {
                    // Image preview handled separately, content will be the data URL or null
                    const imgPreviewElement = blockElement.querySelector('img.image-block-preview'); // Find the image preview element in the FORM entry
                    content = imgPreviewElement ? imgPreviewElement.src : null; // Use the data URL from the preview img
                } else if (type === 'paragraph_image') {
                    const paragraphContent = blockElement.querySelector('textarea[name$="[content][paragraph]"]').value;
                    // Image preview handled separately, content will be the data URL or null
                    const imgPreviewElement = blockElement.querySelector('img.paragraph-image-combo-preview'); // Find the image preview element in the FORM entry
                    const imageContent = imgPreviewElement ? imgPreviewElement.src : null; // Use the data URL

                    content = { paragraph: paragraphContent, image: imageContent }; // Store combo content as an object
                }

                 // Only add block if type is valid and it has content (handle image/combo where content might be just the image)
                 if (type && (content || (type === 'image' && content !== null) || (type === 'paragraph_image' && (content.paragraph || content.image !== null)))) {
                    blocks.push({ block_type: type, content: content }); // Store block data
                 }
            });

             if (title || blocks.length > 0) { // Only add custom section if it has title or blocks
                portfolioData.customSections.push({ title: title, blocks: blocks });
             }
        });


        // --- 2. Generate Preview HTML ---

        let previewHtml = '';

        // Hero/Intro Preview
        // --- Add Placeholder img tags for single image previews in the preview HTML ---
        const profilePicturePreview = document.getElementById('profile-picture-preview'); // Get preview img element
        const aboutImagePreview = document.getElementById('about-image-preview');     // Get preview img element

        portfolioData.profile_picture_url = profilePicturePreview ? profilePicturePreview.src : null; // Get data URL from preview img
        portfolioData.about_image_url = aboutImagePreview ? aboutImagePreview.src : null;     // Get data URL from preview img


        previewHtml += `
            <section class="py-8 px-4 text-center">
                ${portfolioData.profile_picture_url ? `<img src="${portfolioData.profile_picture_url}" alt="Profile Picture" style="max-width: 100px; border-radius: 50%; margin: 0 auto 10px;">` : ''}
                <h3 class="text-xl font-bold">${portfolioData.name || 'Your Name'}</h3>
                ${portfolioData.job_title ? `<p>${portfolioData.job_title}</p>` : ''}
                ${portfolioData.landing_page_summary ? `<p>${portfolioData.landing_page_summary}</p>` : ''}
                ${portfolioData.onlinePresences.map(link => `<a href="${link.url}" target="_blank">${link.label}</a>`).join(' ')}
            </section>
            <hr>`; // Basic separator

        // About Me Preview
        if (portfolioData.about_me_content) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>${portfolioData.about_me_heading || 'About Me'}</h2>
                    <p>${portfolioData.about_me_content}</p>
                    ${portfolioData.about_image_url ? `<img src="${portfolioData.about_image_url}" alt="About Image" style="max-width: 200px; margin-top: 10px;">` : ''}
                </section>
                 <hr>`;
        }

         // Skills Preview
         if (portfolioData.skills_list) {
              previewHtml += `
                  <section class="py-8 px-4">
                      <h2>${portfolioData.skills_heading || 'Skills'}</h2>
                       <p>${portfolioData.skills_list}</p>
                  </section>
                  <hr>`;
          }


        // Work Experience Preview
        if (portfolioData.workExperiences.length > 0) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>Work Experience</h2>
                    ${portfolioData.workExperiences.map(entry => `
                        <div>
                            <h3>${entry.job_title || 'Job Title'} @ ${entry.company || 'Company'}</h3>
                            ${(entry.start_date || entry.end_date) ? `<p>${entry.start_date} – ${entry.end_date}</p>` : ''}
                            ${entry.description ? `<p>${entry.description}</p>` : ''}
                        </div>
                    `).join('')}
                </section>
                 <hr>`;
        }

         // Education Preview
        if (portfolioData.education.length > 0) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>Education</h2>
                    ${portfolioData.education.map(entry => `
                        <div>
                            <h3>${entry.degree || 'Degree'} from ${entry.institution || 'Institution'}</h3>
                             ${entry.graduation_date ? `<p>${entry.graduation_date}</p>` : ''}
                            ${entry.description ? `<p>${entry.description}</p>` : ''}
                        </div>
                    `).join('')}
                </section>
                 <hr>`;
        }

         // Projects Preview
        if (portfolioData.projects.length > 0) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>Projects</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                        ${portfolioData.projects.map(entry => `
                            <div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                ${entry.image_url ? `<img src="${entry.image_url}" alt="Project preview" style="max-width: 100%; height: auto; margin-bottom: 10px;">` : ''}
                                <h3>${entry.title || 'Project Title'}</h3>
                                ${entry.description ? `<p>${entry.description}</p>` : ''}
                                ${(entry.live_demo_url || entry.github_url) ? `<div>${entry.live_demo_url ? `<a href="${entry.live_demo_url}" target="_blank">Demo</a>` : ''} ${entry.github_url ? `<a href="${entry.github_url}" target="_blank">GitHub</a>` : ''}</div>` : ''}
                                 ${entry.technologies ? `<p>Tech: ${entry.technologies}</p>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </section>
                 <hr>`;
        }

         // Recommendations Preview
        if (portfolioData.recommendations.length > 0) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>Recommendations</h2>
                    ${portfolioData.recommendations.map(entry => `
                         <div style="border-left: 4px solid #3490dc; padding-left: 10px; margin-bottom: 15px; font-style: italic;">
                             <blockquote>"${entry.quote || 'Quote'}"</blockquote>
                             <p>- ${entry.recommender_name || 'Name'} ${entry.recommender_title ? `, ${entry.recommender_title}` : ''}</p>
                         </div>
                    `).join('')}
                </section>
                <hr>`;
        }

         // Custom Sections Preview
        if (portfolioData.customSections.length > 0) {
            portfolioData.customSections.forEach(customSection => {
                if (customSection.blocks.length > 0 || customSection.title) {
                     previewHtml += `
                         <section class="py-8 px-4">
                             <h2>${customSection.title || 'Custom Section'}</h2>
                             <div class="space-y-4"> {{-- Space between blocks --}}
                                 ${customSection.blocks.map(block => {
                                     if (block.block_type === 'header') {
                                         return `<h3>${block.content || 'Header'}</h3>`;
                                     } else if (block.block_type === 'paragraph') {
                                         return `<p>${block.content || 'Paragraph'}</p>`;
                                     } else if (block.block_type === 'image' && block.content) {
                                         return `<img src="${block.content}" alt="Custom Image Preview" style="max-width: 200px; margin: 0 auto;">`; // Use the data URL
                                     } else if (block.block_type === 'paragraph_image' && (block.content.paragraph || block.content.image)) {
                                          return `
                                              <div class="paragraph-image-container flex flex-col md:flex-row gap-4">
                                                   ${block.content.paragraph ? `<div class="paragraph-content flex-1"><p>${block.content.paragraph}</p></div>` : ''}
                                                   ${block.content.image ? `<div class="image-content flex-1"><img src="${block.content.image}" alt="Combo Image Preview" style="max-width: 100%; height: auto;"></div>` : ''}
                                              </div>`;
                                     }
                                     return ''; // Return empty for unknown block types
                                 }).join('')}
                             </div>
                         </section>
                         <hr>`;
                }
            });
         }


        // Contact Preview (Simple)
        if (portfolioData.email) {
            previewHtml += `
                <section class="py-8 px-4">
                    <h2>${portfolioData.contact_heading || 'Get in Touch'}</h2>
                    <p>Email: ${portfolioData.email}</p>
                </section>`;
        }


        // --- 3. Update Preview Area ---
        portfolioPreviewContent.innerHTML = previewHtml || '<p>Fill out the form to see your portfolio preview!</p>'; // Display placeholder if preview is empty

        // Re-run any scripts that depend on the new HTML (like dynamic text sizing)
        // This part is still a bit conceptual and might need adaptation based on your dynamic text sizing script.
        // Example: Find the H1 in the preview and reapply sizing logic
         const previewHeroHeading = portfolioPreviewContent.querySelector('.hero-section h3'); // Adjust selector if needed
         if (previewHeroHeading) {
             // Assuming you can get first/last name from the form's name input
             const nameInput = document.getElementById('name');
              if (nameInput) {
                  const fullName = nameInput.value;
                  const firstName = fullName.split(' ')[0] || '';
                  const lastName = fullName.split(' ').slice(1).join(' ') || '';
                  // Assuming applyTextSize function can work on a single element and name parts
                  applyTextSizeSingleElement(previewHeroHeading, firstName, lastName); // Need to define/adapt applyTextSizeSingleElement
              }
         }
    }

    // --- Image Preview Logic (Handles showing selected images immediately) ---
    // This sets up the listener on the file input and updates the *corresponding preview image element*
    function setupImagePreview(fileInput, previewImgElement) {
        if (!fileInput || !previewImgElement) return;

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImgElement.src = e.target.result; // Set the src to the data URL
                    previewImgElement.style.display = 'block'; // Show the image
                    updatePortfolioPreview(); // Update main preview after image changes
                }
                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                previewImgElement.src = ''; // Clear preview if no file selected
                previewImgElement.style.display = 'none'; // Hide the image
                updatePortfolioPreview(); // Update main preview after image changes
            }
        });
    }

    // Function to setup image previews for dynamically added image inputs
// --- Setup Image Previews for Specific Placeholder Img Tags ---
// This links file inputs to specific, pre-existing img tags in the preview column.
function setupImagePreviewLinks() {
     const profilePictureInput = document.getElementById('profile_picture');
     const aboutImageInput = document.getElementById('about_image');

     // Ensure you have these placeholder img tags in your create.blade.php preview column HTML
     // They should be within the relevant section's preview area.
     // <img id="profile-picture-preview" src="" alt="Profile Picture Preview" class="preview-placeholder-img">
     // <img id="about-image-preview" src="" alt="About Image Preview" class="preview-placeholder-img">

     const profilePicturePreview = document.getElementById('profile-picture-preview');
     const aboutImagePreview = document.getElementById('about-image-preview');

     setupImagePreview(profilePictureInput, profilePicturePreview);
     setupImagePreview(aboutImageInput, aboutImagePreview);

     // Note: Repeatable and Custom Section image previews are harder with this approach
     // as the img tags are dynamically created within the preview HTML.
     // A simpler approach might be needed for those or deferring their preview.
     // Let's focus on single images for now.
}



    // --- Initial Setup and Event Listeners ---

    // Setup listeners for initial single image inputs
     const profilePictureInput = document.getElementById('profile_picture');
     const aboutImageInput = document.getElementById('about_image');

     // Need placeholder img tags for these in your create.blade.php preview HTML initially
     // <img id="profile-picture-preview" src="" alt="Profile Picture Preview" style="display:none;">
     // <img id="about-image-preview" src="" alt="About Image Preview" style="display:none;">

     const profilePicturePreview = document.getElementById('profile-picture-preview');
     const aboutImagePreview = document.getElementById('about-image-preview');

     setupImagePreview(profilePictureInput, profilePicturePreview);
     setupImagePreview(aboutImageInput, aboutImagePreview);


    // Initial call to update preview when the page loads
    updatePortfolioPreview();

    // Listen for changes in all form inputs (excluding files for standard update)
    portfolioForm.addEventListener('input', function(event) {
         if (event.target.type !== 'file') {
             updatePortfolioPreview();
        }
    });

    // Image file changes are handled by setupImagePreview which calls updatePortfolioPreview

    // Need to trigger updatePreview() and setupDynamicImagePreviews()
    // when repeatable sections or blocks are added/removed
    // Modify your existing JS functions (addWorkExperienceEntry, removeEntry, addCustomSectionBlock, removeCustomBlock)
    // to call these functions at the end of their execution.

    // Example: In addWorkExperienceEntry function, at the very end:
    // updatePortfolioPreview();
    // setupDynamicImagePreviews(); // Call this to setup new image input listeners

    // Example: In removeEntry function, at the very end:
    // updatePortfolioPreview();
    // setupDynamicImagePreviews(); // Call this to re-setup listeners if needed (less critical on remove)

    // Example: In addCustomSectionBlock function, at the very end:
    // updatePortfolioPreview();
    // setupDynamicImagePreviews(); // Call this to setup new image input listeners

    // Example: In removeCustomBlock function, at the very end:
    // updatePortfolioPreview();
    // setupDynamicImagePreviews(); // Call this to re-setup listeners if needed


    // --- Generic Helper Functions ---

    // Function to update indices in input names and IDs for a given element
    function updateIndices(element, index, sectionName, idPrefix, headingPrefix) {
        element.querySelectorAll('input, textarea, select, button').forEach(input => {
            const oldName = input.getAttribute('name');
            const oldId = input.getAttribute('id');
             const oldDataSectionIndex = input.getAttribute('data-section-index'); // Used for custom sections

            if (oldName) {
                // Use a regex to replace the section name and index in the name
                const newName = oldName.replace(`${sectionName}[\\d+]`, `${sectionName}[${index}]`);
                input.setAttribute('name', newName);
            }

            if (oldId) {
                 // Use a regex to replace the section name and index in the ID
                const newId = oldId.replace(`${idPrefix}_\\d+_`, `${idPrefix}_${index}_`);
                input.setAttribute('id', newId);
                 // Also update the 'for' attribute of the label
                const label = element.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newId);
                }
            }

             // Update data-section-index for custom section blocks
            if (oldDataSectionIndex !== null) {
                 input.setAttribute('data-section-index', index);
            }
        });

        // Update the heading number (if a heading exists)
        const heading = element.querySelector('h3');
        if (heading && headingPrefix) {
            heading.textContent = `${headingPrefix} #${index + 1}`;
        }
    }

     // Function to re-index all entries in a container
     function reindexEntries(containerElement, entrySelector, sectionName, idPrefix, headingPrefix) {
        containerElement.querySelectorAll(entrySelector).forEach((entry, index) => {
            updateIndices(entry, index, sectionName, idPrefix, headingPrefix);
        });
     }

     // Function to remove an entry
    function removeEntry(entryElement, containerElement, entrySelector, sectionName, idPrefix, headingPrefix) {
        // You might want to prevent removing the last entry here if desired
        // if (containerElement.children.length > 1) {
            entryElement.remove();
            // Re-index the remaining entries
            reindexEntries(containerElement, entrySelector, sectionName, idPrefix, headingPrefix);
        // } else {
            // alert("You must have at least one entry.");
        // }
    }


    // --- Work Experience ---
    const workExperienceEntries = document.getElementById('work-experience-entries');
    const addWorkExperienceBtn = document.getElementById('add-work-experience-btn');
    const workExperienceEntrySelector = '.work-experience-entry';
    const workExperienceSectionName = 'work_experiences';
    const workExperienceIdPrefix = 'work_experiences';
    const workExperienceHeadingPrefix = 'Work Experience';


    // Event listener for adding work experience
    if (addWorkExperienceBtn && workExperienceEntries) {
        addWorkExperienceBtn.addEventListener('click', function() {
            const lastEntry = workExperienceEntries.querySelector(workExperienceEntrySelector + ':last-child');
            if (lastEntry) {
                const newEntry = lastEntry.cloneNode(true); // Clone with children
                const currentIndex = workExperienceEntries.children.length; // Get the new index

                // Clear input values in the new entry
                newEntry.querySelectorAll('input, textarea').forEach(input => {
                    // Keep type="file" clear, others set to empty string
                    if (input.type !== 'file') {
                       input.value = '';
                    } else {
                        // Clear file input by resetting its value
                        input.value = null;
                         // Remove data-preview-listener attribute
                         input.removeAttribute('data-preview-listener');
                    }
                });

                // Update indices in the cloned entry
                updateIndices(newEntry, currentIndex, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);

                // Add event listener to the new "Remove" button
                newEntry.querySelector('.remove-work-experience-entry').addEventListener('click', function() {
                    removeEntry(this.closest(workExperienceEntrySelector), workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
                });

                // Append the new entry
                workExperienceEntries.appendChild(newEntry);
                 // Re-index all entries after adding (needed if removing before the end)
                 reindexEntries(workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);

                 // *** Trigger preview updates after adding ***
                  updatePortfolioPreview();
                  setupDynamicImagePreviews(); // Setup listener for the new file input
            }
        });
    }


    // Event listeners for initial "Remove" buttons on DOM load
    if (workExperienceEntries) {
         workExperienceEntries.querySelectorAll('.remove-work-experience-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(workExperienceEntrySelector), workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
                // *** Trigger preview updates after removing ***
                 updatePortfolioPreview();
                 setupDynamicImagePreviews(); // Re-setup listeners
            });
        });
         // Re-index initial entries just in case HTML wasn't perfectly indexed
         reindexEntries(workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
    }


    // --- Education ---
    const educationEntries = document.getElementById('education-entries');
    const addEducationBtn = document.getElementById('add-education-btn');
    const educationEntrySelector = '.education-entry';
    const educationSectionName = 'education';
    const educationIdPrefix = 'education';
    const educationHeadingPrefix = 'Education';

    // Event listener for adding education (Adapt the Work Experience pattern)
     if (addEducationBtn && educationEntries) {
        addEducationBtn.addEventListener('click', function() {
            const lastEntry = educationEntries.querySelector(educationEntrySelector + ':last-child');
            if (lastEntry) {
                 const newEntry = lastEntry.cloneNode(true);
                 const currentIndex = educationEntries.children.length;

                 newEntry.querySelectorAll('input, textarea').forEach(input => {
                     if (input.type !== 'file') {
                        input.value = '';
                     } else {
                         input.value = null;
                          input.removeAttribute('data-preview-listener');
                     }
                 });

                 updateIndices(newEntry, currentIndex, educationSectionName, educationIdPrefix, educationHeadingPrefix);

                 newEntry.querySelector('.remove-education-entry').addEventListener('click', function() {
                    removeEntry(this.closest(educationEntrySelector), educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
                });

                 educationEntries.appendChild(newEntry);
                 reindexEntries(educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);

                 // *** Trigger preview updates after adding ***
                  updatePortfolioPreview();
                   setupDynamicImagePreviews(); // Setup listener for new file inputs
            }
        });
     }

// continuation from the previous response

    // Event listeners for initial Education "Remove" buttons
     if (educationEntries) {
         educationEntries.querySelectorAll('.remove-education-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(educationEntrySelector), educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
                // *** Trigger preview updates after removing ***
                 updatePortfolioPreview();
                 setupDynamicImagePreviews(); // Re-setup listeners
            });
        });
        // Re-index initial entries
        reindexEntries(educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
     }


    // --- Projects ---
    const projectEntries = document.getElementById('project-entries');
    const addProjectBtn = document.getElementById('add-project-btn');
    const projectEntrySelector = '.project-entry';
    const projectSectionName = 'projects';
    const projectIdPrefix = 'projects'; // Matches input ID prefix
    const projectHeadingPrefix = 'Project';


     // Event listener for adding projects (Adapt the Work Experience pattern)
      if (addProjectBtn && projectEntries) {
        addProjectBtn.addEventListener('click', function() {
            const lastEntry = projectEntries.querySelector(projectEntrySelector + ':last-child');
            if (lastEntry) {
                 const newEntry = lastEntry.cloneNode(true);
                 const currentIndex = projectEntries.children.length;

                 newEntry.querySelectorAll('input, textarea').forEach(input => {
                     if (input.type !== 'file') {
                        input.value = '';
                     } else {
                         // Clear file input by resetting its value
                         input.value = null;
                         // Remove data-preview-listener attribute
                         input.removeAttribute('data-preview-listener');
                         // Remove any existing preview image element linked to this input
                         // This is complex and might require unique IDs/classes for preview images in the form
                         // and finding/removing them here. For simplicity, we'll just hide/clear in setupImagePreview.
                     }
                 });

                 // Update indices in the cloned entry
                 updateIndices(newEntry, currentIndex, projectSectionName, projectIdPrefix, projectHeadingPrefix);

                 // Add event listener to the new "Remove" button
                 newEntry.querySelector('.remove-project-entry').addEventListener('click', function() {
                    removeEntry(this.closest(projectEntrySelector), projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
                });

                 // Append the new entry
                 projectEntries.appendChild(newEntry);
                 // Re-index all entries after adding (needed if removing before the end)
                 reindexEntries(projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);

                 // *** Trigger preview updates after adding ***
                  updatePortfolioPreview();
                  setupDynamicImagePreviews(); // Setup listener for the new file input
            }
        });
     }

    // Event listeners for initial Projects "Remove" buttons
     if (projectEntries) {
         projectEntries.querySelectorAll('.remove-project-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(projectEntrySelector), projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
                // *** Trigger preview updates after removing ***
                 updatePortfolioPreview();
                 setupDynamicImagePreviews(); // Re-setup listeners
            });
        });
         // Re-index initial entries
        reindexEntries(projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
     }


    // --- Recommendations ---
    const recommendationEntries = document.getElementById('recommendation-entries');
    const addRecommendationBtn = document.getElementById('add-recommendation-btn');
    const recommendationEntrySelector = '.recommendation-entry';
    const recommendationSectionName = 'recommendations';
    const recommendationIdPrefix = 'recommendations'; // Matches input ID prefix
    const recommendationHeadingPrefix = 'Recommendation';

     // Event listener for adding recommendations (Adapt the Work Experience pattern)
      if (addRecommendationBtn && recommendationEntries) {
        addRecommendationBtn.addEventListener('click', function() {
            const lastEntry = recommendationEntries.querySelector(recommendationEntrySelector + ':last-child');
            if (lastEntry) {
                 const newEntry = lastEntry.cloneNode(true);
                 const currentIndex = recommendationEntries.children.length;

                 newEntry.querySelectorAll('input, textarea').forEach(input => {
                     if (input.type !== 'file') {
                        input.value = '';
                     } else {
                          input.value = null;
                          input.removeAttribute('data-preview-listener');
                     }
                 });

                 updateIndices(newEntry, currentIndex, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);

                 newEntry.querySelector('.remove-recommendation-entry').addEventListener('click', function() {
                    removeEntry(this.closest(recommendationEntrySelector), recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
                });

                 recommendationEntries.appendChild(newEntry);
                 reindexEntries(recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);

                 // *** Trigger preview updates after adding ***
                  updatePortfolioPreview();
                  setupDynamicImagePreviews(); // Setup listener for new file inputs
            }
        });
     }

    // Event listeners for initial Recommendations "Remove" buttons
    if (recommendationEntries) {
         recommendationEntries.querySelectorAll('.remove-recommendation-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(recommendationEntrySelector), recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
                // *** Trigger preview updates after removing ***
                 updatePortfolioPreview();
                 setupDynamicImagePreviews(); // Re-setup listeners
            });
        });
         // Re-index initial entries
         reindexEntries(recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
    }


    // --- Custom Sections ---
    // The logic for adding custom sections is slightly different as it uses insertAdjacentHTML
    // and the blocks within are handled separately.
    const customSectionEntries = document.getElementById('custom-section-entries');
    const addCustomSectionBtn = document.getElementById('add-custom-section-btn');
    const customSectionEntrySelector = '.custom-section-entry';
    const customSectionSectionName = 'custom_sections';
    const customSectionIdPrefix = 'custom_sections';
    const customSectionHeadingPrefix = 'Custom Section';

    // Function to add a new custom section entry (initial structure)
    function addCustomSectionEntry() {
        const currentIndex = customSectionEntries.children.length; // Get the new index

        const newSectionHtml = `
            <div class="custom-section-entry" data-index="${currentIndex}">
                <h3>Custom Section #${currentIndex + 1}</h3>
                <div>
                    <label for="custom_sections_${currentIndex}_title">Section Title:</label>
                    <input type="text" id="custom_sections_${currentIndex}_title" name="custom_sections[${currentIndex}][title]" value="${ old('custom_sections.' + currentIndex + '.title') }"> {{-- Added old() helper --}}
                </div>

                <div class="custom-section-blocks" data-section-index="${currentIndex}">
                    {{-- Blocks will be added here dynamically --}}
                </div>

                <div class="add-block-buttons-container">
                    <button type="button" class="add-block-btn add-header-block" data-block-type="header">Add Header Block</button>
                    <button type="button" class="add-block-btn add-paragraph-block" data-block-type="paragraph">Add Paragraph Block</button>
                    <button type="button" class="add-block-btn add-image-block" data-block-type="image">Add Image Block</button>
                    <button type="button" class="add-block-btn add-paragraph-image-block" data-block-type="paragraph_image">Add Paragraph + Image Block</button>
                </div>

                <button type="button" class="remove-custom-section-entry">Remove Custom Section</button>
                <hr>
            </div>
        `;

        customSectionEntries.insertAdjacentHTML('beforeend', newSectionHtml);

        // Add event listener to the new "Remove Custom Section" button that was just added
        const newEntry = customSectionEntries.lastElementChild;
        newEntry.querySelector('.remove-custom-section-entry').addEventListener('click', function() {
            removeEntry(this.closest(customSectionEntrySelector), customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
        });

        // Add event listeners for the new "Add Content Block" buttons that were just added.
        newEntry.querySelectorAll('.add-block-btn').forEach(button => {
            button.addEventListener('click', function() {
                const blockType = this.getAttribute('data-block-type');
                addCustomSectionBlock(this.closest(customSectionEntrySelector), blockType);
            });
        });


        // Re-index custom sections after adding
        reindexEntries(customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);

         // *** Trigger preview updates after adding ***
          updatePortfolioPreview();
         setupDynamicImagePreviews(); // Setup listeners for new file inputs
    }


    // Event listener for adding custom sections
    if (addCustomSectionBtn && customSectionEntries) {
        addCustomSectionBtn.addEventListener('click', addCustomSectionEntry);
    }


    // Event listeners for initial Custom Section "Remove" buttons
    if (customSectionEntries) {
        customSectionEntries.querySelectorAll('.remove-custom-section-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(customSectionEntrySelector), customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
                // *** Trigger preview updates after removing ***
                 updatePortfolioPreview();
                 setupDynamicImagePreviews(); // Re-setup listeners
            });
        });
        // Re-index initial entries (especially important if we allow deleting custom sections later)
        reindexEntries(customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);

        // Add event listeners to initial "Add Content Block" buttons if any exist (e.g., if editing later)
        customSectionEntries.querySelectorAll('.add-block-btn').forEach(button => {
            button.addEventListener('click', function() {
                const blockType = this.getAttribute('data-block-type');
                addCustomSectionBlock(this.closest(customSectionEntrySelector), blockType);
            });
        });

         // Add event listeners to initial "Remove Custom Block" buttons if any exist
         customSectionEntries.querySelectorAll('.remove-custom-block').forEach(button => {
              button.addEventListener('click', function() {
                   // Need to get the parent custom section and blocks container
                   const blockElement = this.closest('.custom-section-block');
                   const blocksContainer = blockElement.closest('.custom-section-blocks');
                   const customSectionElement = blocksContainer.closest(customSectionEntrySelector);
                   const sectionIndex = parseInt(customSectionElement.getAttribute('data-index')); // Get the index

                   removeCustomBlock(blockElement, blocksContainer, sectionIndex);
               });
          });

         // Re-index initial custom sections and their blocks (handled by reindexEntries and reindexCustomBlocks)
         customSectionEntries.querySelectorAll(customSectionEntrySelector).forEach((section, index) => {
            updateCustomSectionIndices(section, index); // Update section level
             reindexCustomBlocks(section.querySelector('.custom-section-blocks'), index); // Re-index blocks within
         });
    }


    // --- Logic for adding Blocks WITHIN a Custom Section ---
    // Function to add a block within a custom section
    function addCustomSectionBlock(customSectionElement, blockType) { // New signature
        const blocksContainer = customSectionElement.querySelector('.custom-section-blocks');
        const sectionIndex = parseInt(customSectionElement.getAttribute('data-index'));

        // Ensure the passed-in blockType is one of the valid types
         if (!['header', 'paragraph', 'image', 'paragraph_image'].includes(blockType)) {
             console.error("Invalid block type passed to addCustomSectionBlock:", blockType);
             return;
         }

        let blockHtml = '';
        let inputType = '';

        // Get the correct template based on the passed-in blockType
        if (blockType === 'header') {
            blockHtml = headerBlockTemplate;
        } else if (blockType === 'paragraph') {
            blockHtml = paragraphBlockTemplate;
        } else if (blockType === 'image') {
            blockHtml = imageBlockTemplate;
        } else if (blockType === 'paragraph_image') {
            blockHtml = paragraphImageBlockTemplate;
        } else {
            console.error("Unknown block type:", blockType);
            return;
        }

        const currentBlockIndex = blocksContainer.children.length;

        // Replace placeholders in the HTML template
        let newBlockHtml = blockHtml.replace(/BLOCK_NAME/g, `custom_sections[${sectionIndex}][blocks]`);
        newBlockHtml = newBlockHtml.replace(/BLOCK_INDEX/g, currentBlockIndex);

        // Insert the new block HTML
        blocksContainer.insertAdjacentHTML('beforeend', newBlockHtml);

        // Add event listener to the "Remove Block" button in the new block
        const newBlockElement = blocksContainer.lastElementChild;
        newBlockElement.querySelector('.remove-custom-block').addEventListener('click', function() {
            removeCustomBlock(this.closest('.custom-section-block'), blocksContainer, sectionIndex);
        });

        // Re-index the blocks within this custom section after adding
        reindexCustomBlocks(blocksContainer, sectionIndex);

        // *** Trigger preview updates after adding ***
         updatePortfolioPreview();
         setupDynamicImagePreviews(); // Setup listener for the new file input if it's an image type
    }

    // Function to remove a custom section block
    function removeCustomBlock(blockElement, blocksContainer, sectionIndex) {
        blockElement.remove();
        reindexCustomBlocks(blocksContainer, sectionIndex);
        // *** Trigger preview updates after removing ***
         updatePortfolioPreview();
         setupDynamicImagePreviews(); // Re-setup listeners
    }

    // Function to re-index blocks within a specific custom section
    function reindexCustomBlocks(blocksContainer, sectionIndex) {
        blocksContainer.querySelectorAll('.custom-section-block').forEach((block, blockIndex) => {
            block.querySelectorAll('input, textarea, select').forEach(input => {
                const oldName = input.getAttribute('name');
                // const oldId = input.getAttribute('id'); // IDs not strictly needed for blocks

                if (oldName) {
                    const newName = oldName.replace(/\[blocks\]\[\d+\]/, `[blocks][${blockIndex}]`);
                    input.setAttribute('name', newName);
                }
            });
            // Re-attach remove listeners if using cloning instead of insertion
        });
    }
     // We need a way to update the data-index attribute on the custom section entries themselves
     // This is done by reindexEntries, which is called after adding/removing custom sections.
     // The updateCustomSectionIndices function within reindexEntries handles this.


    // --- Dynamic Text Sizing for Preview ---
    // Need to adapt this script to work on the generated preview HTML
    function applyTextSizeSingleElement(element, firstName, lastName) {
         if (!element) return; // Exit if element is null

        let maxLength = Math.max(firstName.length, lastName.length);

        element.classList.remove('text-size-short', 'text-size-medium', 'text-size-long');

         if (maxLength >= 13) {
             element.classList.add('text-size-long');
         } else if (maxLength >= 10) {
             element.classList.add('text-size-medium');
         } else {
             element.classList.add('text-size-short');
         }
    }


    // --- Initial Event Listener Setup on DOM Load ---
    // Listen for changes in all form inputs (excluding files for standard update)
    if (portfolioForm) { // Check if form exists
         portfolioForm.addEventListener('input', function(event) {
              if (event.target.type !== 'file') {
                  updatePortfolioPreview();
             }
         });
    }

    // Initial setup for dynamic image previews on load (for editing)
    setupDynamicImagePreviews();

    // Initial call to update preview when the page loads
     if (portfolioForm && portfolioPreviewContent) { // Check if elements exist
         updatePortfolioPreview();
     }

}); // End DOMContentLoaded