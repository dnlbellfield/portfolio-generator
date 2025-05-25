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
    <div class="custom-section-block custom-block-header p-4 border rounded-md bg-gray-50 mb-4"> {{-- Added styling --}}
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="header">
        <div class="mb-2"> {{-- Added spacing --}}
            <label class="block text-gray-700 text-sm font-bold mb-1">Header Content:</label> {{-- Added styling --}}
            <input type="text" name="BLOCK_NAME[BLOCK_INDEX][content]" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"> {{-- Added styling --}}
        </div>
        <button type="button" class="remove-custom-block mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove Block</button> {{-- Added styling --}}
    </div>
`;

const paragraphBlockTemplate = `
    <div class="custom-section-block custom-block-paragraph p-4 border rounded-md bg-gray-50 mb-4"> {{-- Added styling --}}
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="paragraph">
        <div class="mb-2"> {{-- Added spacing --}}
            <label class="block text-gray-700 text-sm font-bold mb-1">Paragraph Content:</label> {{-- Added styling --}}
            <textarea name="BLOCK_NAME[BLOCK_INDEX][content]" rows="3" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea> {{-- Added styling --}}
        </div>
         <button type="button" class="remove-custom-block mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove Block</button> {{-- Added styling --}}
    </div>
`;

const imageBlockTemplate = `
    <div class="custom-section-block custom-block-image p-4 border rounded-md bg-gray-50 mb-4"> {{-- Added styling --}}
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="image">
        <div class="mb-2"> {{-- Added spacing --}}
            <label class="block text-gray-700 text-sm font-bold mb-1">Image File:</label> {{-- Added styling --}}
            <input type="file" name="BLOCK_NAME[BLOCK_INDEX][content]" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">  {{-- Added styling --}}
        </div>
         <button type="button" class="remove-custom-block mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove Block</button> {{-- Added styling --}}
    </div>
`;


const paragraphImageBlockTemplate = `
    <div class="custom-section-block custom-block-paragraph-image p-4 border rounded-md bg-gray-50 mb-4" style="width:100%;"> {{-- Added styling --}}
        <input type="hidden" name="BLOCK_NAME[BLOCK_INDEX][type]" value="paragraph_image">
        <div class="paragraph-image-container flex flex-col md:flex-row gap-4">  {{-- Added styling --}}
            <div class="paragraph-content flex-1">  {{-- Added styling --}}
                <label class="block text-gray-700 text-sm font-bold mb-1">Paragraph Content:</label> {{-- Added styling --}}
                <textarea name="BLOCK_NAME[BLOCK_INDEX][content][paragraph]" rows="4" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>  {{-- Added styling --}}
            </div>
            <div class="image-content flex-1">  {{-- Added styling --}}
                <label class="block text-gray-700 text-sm font-bold mb-1">Image File:</label> {{-- Added styling --}}
                <input type="file" name="BLOCK_NAME[BLOCK_INDEX][content][image]" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">  {{-- Added styling --}}
            </div>
        </div>
        <button type="button" class="remove-custom-block mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove Block</button> {{-- Added styling --}}
    </div>
`;


// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {

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


    // --- Online Presence ---
    // Constants defined at the top

    // Event listener for adding online presence links
    if (addOnlinePresenceBtn && onlinePresenceEntries) {
        addOnlinePresenceBtn.addEventListener('click', function() {
            const lastEntry = onlinePresenceEntries.querySelector(onlinePresenceEntrySelector + ':last-child');
            if (lastEntry) {
                 const newEntry = lastEntry.cloneNode(true);
                 const currentIndex = onlinePresenceEntries.children.length;

                 newEntry.querySelectorAll('input, textarea').forEach(input => {
                     if (input.type !== 'file') {
                        input.value = '';
                     }
                 });

                 updateIndices(newEntry, currentIndex, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);

                 // Add event listener to the new "Remove" button
                 newEntry.querySelector('.remove-online-presence-entry').addEventListener('click', function() {
                    removeEntry(this.closest(onlinePresenceEntrySelector), onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
                });

                 onlinePresenceEntries.appendChild(newEntry);
                 reindexEntries(onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
            }
        });
    }

    // Event listeners for initial Online Presence "Remove" buttons on DOM load
    if (onlinePresenceEntries) {
         onlinePresenceEntries.querySelectorAll('.remove-online-presence-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(onlinePresenceEntrySelector), onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
            });
        });
         // Re-index initial entries
         reindexEntries(onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
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
                    if (input.type !== 'file') {
                       input.value = '';
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
            }
        });
    }


    // Event listeners for initial "Remove" buttons on DOM load
    if (workExperienceEntries) {
         workExperienceEntries.querySelectorAll('.remove-work-experience-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(workExperienceEntrySelector), workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
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
                     }
                 });

                 updateIndices(newEntry, currentIndex, educationSectionName, educationIdPrefix, educationHeadingPrefix);

                 newEntry.querySelector('.remove-education-entry').addEventListener('click', function() {
                    removeEntry(this.closest(educationEntrySelector), educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
                });

                 educationEntries.appendChild(newEntry);
                 reindexEntries(educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
            }
        });
     }

    // Event listeners for initial Education "Remove" buttons
     if (educationEntries) {
         educationEntries.querySelectorAll('.remove-education-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(educationEntrySelector), educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
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
                     }
                 });

                 updateIndices(newEntry, currentIndex, projectSectionName, projectIdPrefix, projectHeadingPrefix);

                 newEntry.querySelector('.remove-project-entry').addEventListener('click', function() {
                    removeEntry(this.closest(projectEntrySelector), projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
                });

                 projectEntries.appendChild(newEntry);
                 reindexEntries(projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
            }
        });
     }

    // Event listeners for initial Projects "Remove" buttons
     if (projectEntries) {
         projectEntries.querySelectorAll('.remove-project-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(projectEntrySelector), projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
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
                     }
                 });

                 updateIndices(newEntry, currentIndex, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);

                 newEntry.querySelector('.remove-recommendation-entry').addEventListener('click', function() {
                    removeEntry(this.closest(recommendationEntrySelector), recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
                });

                 recommendationEntries.appendChild(newEntry);
                 reindexEntries(recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
            }
        });
     }

    // Event listeners for initial Recommendations "Remove" buttons
    if (recommendationEntries) {
         recommendationEntries.querySelectorAll('.remove-recommendation-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(recommendationEntrySelector), recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
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

     // --- START: The entire template string definition and insertion should be here ---
     const newSectionHtml = `
         <div class="custom-section-entry" data-index="${currentIndex}">
             <h3>Custom Section #${currentIndex + 1}</h3>
             <div>
                 <label for="custom_sections_${currentIndex}_title">Section Title:</label>
<input type="text" id="custom_sections_${currentIndex}_title" name="custom_sections[${currentIndex}][title]" value=""> {{-- old() helper cannot be used directly in JS template --}}

             </div>

             <div class="custom-section-blocks" data-section-index="${currentIndex}">

             </div>

             <div class="add-block-buttons-container">
                  <button type="button" class="add-block-btn add-header-block" data-block-type="header">Add Header Block</button>
                  <button type="button" class="add-block-btn add-paragraph-block" data-block-type="paragraph">Add Paragraph Block</button>
                  <button type="button" class="add-block-btn add-image-block" data-block-type="image">Add Image Block</button>
                  <button type="button" class="add-block-btn add-paragraph-image-block" data-block-type="paragraph_image">Add Paragraph + Image Block
                  <button type="button" class="add-block-btn add-image-block" data-block-type="image">Add Image Block</button>
             <button type="button" class="add-block-btn add-paragraph-image-block" data-block-type="paragraph_image">Add Paragraph + Image Block</button>
         </div>

         <button type="button" class="remove-custom-section-entry mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors">Remove Custom Section</button> {{-- Added styling --}}
         <hr class="my-4"> {{-- Added styling --}}
     </div>
 `;

     customSectionEntries.insertAdjacentHTML('beforeend', newSectionHtml);
     // --- END: The entire template string definition and insertion should be here ---


     // Add event listener to the new "Remove Custom Section" button that was just added
     const newEntry = customSectionEntries.lastElementChild;
      newEntry.querySelector('.remove-custom-section-entry').addEventListener('click', function() {
          removeEntry(this.closest(customSectionEntrySelector), customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
      });

     // Add event listeners for the new "Add Content Block" buttons that were just added.
newEntry.querySelectorAll('.add-block-btn').forEach(button => {
    button.addEventListener('click', function() {
        const blockType = this.getAttribute('data-block-type'); // Get the block type
         addCustomSectionBlock(this.closest(customSectionEntrySelector), blockType); // Pass both the custom section element and the blockType
    });
});


      // Re-index custom sections after adding
      reindexEntries(customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
 }

     
    // Event listener for adding custom sections
    if (addCustomSectionBtn && customSectionEntries) {
         addCustomSectionBtn.addEventListener('click', addCustomSectionEntry);
    }


    // Event listeners for initial Custom Section "Remove" buttons on DOM load
    if (customSectionEntries) {
         customSectionEntries.querySelectorAll('.remove-custom-section-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(customSectionEntrySelector), customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
            });
        });
        // Re-index initial entries (especially important if we allow deleting custom sections later)
        reindexEntries(customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);

         // Add event listeners to initial "Add Content Block" buttons if any exist (e.g., if editing later)
customSectionEntries.querySelectorAll('.add-block-btn').forEach(button => {
    button.addEventListener('click', function() {
        const blockType = this.getAttribute('data-block-type'); // Get the block type
        // Pass both the custom section element and the blockType
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
    }

    // Function to remove a custom section block
    function removeCustomBlock(blockElement, blocksContainer, sectionIndex) {
        blockElement.remove();
        reindexCustomBlocks(blocksContainer, sectionIndex);
    }

    // Function to re-index blocks within a specific custom section
    function reindexCustomBlocks(blocksContainer, sectionIndex) {
        blocksContainer.querySelectorAll('.custom-section-block').forEach((block, blockIndex) => {
            block.querySelectorAll('input, textarea, select').forEach(input => {
                const oldName = input.getAttribute('name');

                if (oldName) {
                    const newName = oldName.replace(/\[blocks\]\[\d+\]/, `[blocks][${blockIndex}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    // Need a way to update the data-index attribute on the custom section entries themselves
    // This is done by reindexEntries, which is called after adding/removing custom sections.
    // The updateCustomSectionIndices function within reindexEntries handles this.
    function updateCustomSectionIndices(element, index) {
        element.querySelectorAll('input, textarea, select, button').forEach(el => {
           const oldName = el.getAttribute('name');
           const oldId = el.getAttribute('id');
           const oldDataSectionIndex = el.getAttribute('data-section-index');

           if (oldName) {
                const newName = oldName.replace(/custom_sections\[\d+\]/, 'custom_sections[' + index + ']');
               el.setAttribute('name', newName);
           }

           if (oldId) {
               const newId = oldId.replace(/custom_sections_\d+_/, 'custom_sections_' + index + '_');
               el.setAttribute('id', newId);
                const label = element.querySelector(`label[for="${oldId}"]`);
               if (label) {
                   label.setAttribute('for', newId);
               }
           }

           if (oldDataSectionIndex !== null) {
                el.setAttribute('data-section-index', index);
           }
        });

        const heading = element.querySelector('h3');
        if (heading) {
            heading.textContent = `Custom Section #${index + 1}`;
        }
    }


    // --- Initial Event Listener Setup on DOM Load ---
    // Listen for changes in inputs for each section (will be done more selectively later)
    // For now, just ensuring initial listeners are attached

    // Personal Info inputs (no dynamic additions, so listeners are static)
    // About Me inputs (no dynamic additions, so listeners are static)
    // Contact inputs (no dynamic additions, so listeners are static)
    // Appearance inputs (no dynamic additions, so listeners are static)
    // Skills inputs (no dynamic additions, so listeners are static)

    // Dynamic listeners for repeatable sections (Work Experience, Education, Projects, Recommendations, Online Presence)
    // and Custom Sections are set up below when finding add/remove buttons

    // Initial setup for "Remove" buttons for sections present on page load
    // (e.g., initial Online Presence entry if you add one by default)
    if (onlinePresenceEntries) {
        onlinePresenceEntries.querySelectorAll('.remove-online-presence-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(onlinePresenceEntrySelector), onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
            });
        });
         reindexEntries(onlinePresenceEntries, onlinePresenceEntrySelector, onlinePresenceSectionName, onlinePresenceIdPrefix, onlinePresenceHeadingPrefix);
    }
     if (workExperienceEntries) {
        workExperienceEntries.querySelectorAll('.remove-work-experience-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(workExperienceEntrySelector), workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
            });
        });
         reindexEntries(workExperienceEntries, workExperienceEntrySelector, workExperienceSectionName, workExperienceIdPrefix, workExperienceHeadingPrefix);
    }
     if (educationEntries) {
         educationEntries.querySelectorAll('.remove-education-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(educationEntrySelector), educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
            });
        });
         reindexEntries(educationEntries, educationEntrySelector, educationSectionName, educationIdPrefix, educationHeadingPrefix);
    }
     if (projectEntries) {
         projectEntries.querySelectorAll('.remove-project-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(projectEntrySelector), projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
            });
        });
         reindexEntries(projectEntries, projectEntrySelector, projectSectionName, projectIdPrefix, projectHeadingPrefix);
    }
     if (recommendationEntries) {
         recommendationEntries.querySelectorAll('.remove-recommendation-entry').forEach(button => {
            button.addEventListener('click', function() {
                removeEntry(this.closest(recommendationEntrySelector), recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
            });
        });
         reindexEntries(recommendationEntries, recommendationEntrySelector, recommendationSectionName, recommendationIdPrefix, recommendationHeadingPrefix);
    }
     if (customSectionEntries) {
         // Listeners for remove buttons in existing custom sections and blocks
         customSectionEntries.querySelectorAll('.remove-custom-section-entry').forEach(button => {
              button.addEventListener('click', function() {
                   const customSectionElement = this.closest(customSectionEntrySelector);
                   removeEntry(customSectionElement, customSectionEntries, customSectionEntrySelector, customSectionSectionName, customSectionIdPrefix, customSectionHeadingPrefix);
               });
          });
          customSectionEntries.querySelectorAll('.remove-custom-block').forEach(button => {
               button.addEventListener('click', function() {
                    const blockElement = this.closest('.custom-section-block');
                    const blocksContainer = blockElement.closest('.custom-section-blocks');
                    const customSectionElement = blocksContainer.closest(customSectionEntrySelector);
                    const sectionIndex = parseInt(customSectionElement.getAttribute('data-index'));
                    removeCustomBlock(blockElement, blocksContainer, sectionIndex);
                });
           });
          // Re-index initial custom sections and their blocks
         customSectionEntries.querySelectorAll(customSectionEntrySelector).forEach((section, index) => {
            updateCustomSectionIndices(section, index);
             reindexCustomBlocks(section.querySelector('.custom-section-blocks'), index);
         });
     }


}); // End DOMContentLoaded

// In your JavaScript file (e.g., script.js)

document.addEventListener('DOMContentLoaded', () => {
    const aboutMeSection = document.getElementById('about-me-section');

    if (aboutMeSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // The section is in the viewport
                    // Add the class to trigger the animation
                    aboutMeSection.classList.add('fade-in-visible'); // Or 'fade-in-visible-transition'
                    // Optionally, unobserve the element if you only want the animation to happen once
                    observer.unobserve(entry.target);
                } else {
                    // The section is out of the viewport
                    // You might remove the class here if you want the animation to repeat on scroll
                    // aboutMeSection.classList.remove('fade-in-visible'); // Or 'fade-in-visible-transition'
                }
            });
        }, {
            // Options for the observer
            root: null, // Defaults to the viewport
            rootMargin: '0px', // No margin around the root
            threshold: 0.1 // Trigger when 10% of the target is visible
        });

        // Initially add the hidden class so the element is invisible before scrolling
        aboutMeSection.classList.add('fade-in-hidden');

        // Start observing the target element
        observer.observe(aboutMeSection);

        // You might also want to observe the elements *within* the section individually for staggered animations
        const contentElements = aboutMeSection.querySelectorAll('.mb-4, h2');
        contentElements.forEach((element, index) => {
            const contentObserver = new IntersectionObserver((entries) => {
                entries.forEach(contentEntry => {
                    if (contentEntry.isIntersecting) {
                        contentEntry.target.classList.add('fade-in-visible'); // Or your animation class
                         // Add delay based on index for staggered effect
                        contentEntry.target.style.animationDelay = `${index * 100}ms`; // Adjust delay as needed
                         contentObserver.unobserve(contentEntry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            });

            // Initially add the hidden class to content elements
             element.classList.add('fade-in-hidden');

            contentObserver.observe(element);
        });
    }
});
