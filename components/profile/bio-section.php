<div class="p-2 lg:px-8 lg:py-4">
    <h5>User's Bio</h5>
    <p id="bio-paragraph" class="mt-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 p-2.5 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <?php echo $bio ?>
    </p>
    <textarea id="bio-textarea" class="hidden mt-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 p-2.5 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write something about you..."><?php echo $bio ?></textarea>
    <button id="edit-button" class="mt-2 inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Edit</button>
    <div class="mt-4 flex flex-row-reverse justify-start">
        <button id="save-button" class="inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Save</button>
        <button id="cancel-button" class="inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-gray-600 border border-gray-500 rounded bg-white hover:bg-gray-300 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Cancel</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        const bioParagraph = $('#bio-paragraph');
        const bioTextarea = $('#bio-textarea');
        const editButton = $('#edit-button');
        const saveButton = $('#save-button');
        const cancelButton = $('#cancel-button');
        const isCurrentUserProfile = <?php echo ($user_id == $_SESSION['user_id']) ? 'true' : 'false'; ?>;

        bioParagraph.css('display', 'block');
        bioTextarea.css('display', 'none');
        saveButton.css('display', 'none');
        cancelButton.css('display', 'none');

        if (isCurrentUserProfile) {
            editButton.click(function() {
                bioParagraph.css('display', 'none');
                bioTextarea.css('display', 'block');
                saveButton.css('display', 'inline');
                cancelButton.css('display', 'inline');
                editButton.css('display', 'none');
            });
        } else {
            editButton.hide(); // Display a message or take another action
        }

        saveButton.click(function() {
            const updatedBio = bioTextarea.val();

            bioParagraph.text(updatedBio);

            bioParagraph.css('display', 'block');
            bioTextarea.css('display', 'none');
            saveButton.css('display', 'none');
            cancelButton.css('display', 'none');
            editButton.css('display', 'inline');

            $.ajax({
                type: 'POST',
                url: './controllers/update_bio.php',
                data: {
                    bio: updatedBio
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Bio updated successfully.');
                    } else {
                        console.log('Error updating bio.');
                    }
                },
                error: function() {
                    // Handle any AJAX errors here
                    console.log('Error updating bio.');
                }
            });
        });

        cancelButton.click(function() {
            bioTextarea.val(bioParagraph.text());

            bioParagraph.css('display', 'block');
            bioTextarea.css('display', 'none');
            saveButton.css('display', 'none');
            cancelButton.css('display', 'none');
            editButton.css('display', 'inline');
        });
    });
</script>