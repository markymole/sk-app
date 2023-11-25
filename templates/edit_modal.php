<div class="modal" id="editModal">
    <div class="modal-content w-11/12 md:w-1/3 mx-auto py-6 rounded-lg border">
        <div class="flex items-center justify-between px-6">
            <div class="flex items-center space-x-3 mt-3 mb-2">
                <img id="modalImg" class="h-9 w-9 rounded-full" src="" alt="">
                <div>
                    <div class="text-base font-semibold text-slate-700" id="modalPostAuthor">Author</div>
                    <div class="flex items-center space-x-8">
                        <div class="text-xs text-neutral-500" id="modalDate">Date</div>
                    </div>
                </div>
            </div>
            <span class="close-modal text-2xl cursor-pointer" id="closeEditModal2">&times;</span>
        </div>
        <form action="" class="px-6" method="POST" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="post_id" id="editPostId" value="">
            <input type="hidden" name="action" value="edit_post">
            <div class="bg-white mt-6 mx-auto flex flex-col text-gray-800 rounded-lg border-gray-300 py-4 shadow-sm w-full">
                <textarea name="post_content_edit" required class="description bg-gray-100 rounded-lg sec p-3 min-h-30 border border-gray-300 outline-none" spellcheck="false" placeholder="Describe everything about this post here"></textarea>

                <!-- Image Preview Container -->
                <div id="editImageContainer" class="image-preview mt-2">
                    <input type="hidden" name="editImagePreviewContainer" id="editImagePreviewContainer" value="">
                    <div id="image-container" class="relative">
                        <img src="" id="editImagePreview" alt="" class="max-w-full max max-h-96 object-cover rounded-lg shadow-sm mb-2">
                        <div class="p-1 bg-white rounded-full absolute top-2 right-2">
                            <svg id="removeImage" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="icons flex text-gray-500 m-2">
                    <div class="flex">
                        <input type="file" name="new_post_image" accept="image/*" id="fileInputEdit" style="display:none;">
                        <label for="fileInputEdit" class="flex items-center">
                            <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <p id="selectedFileName2" class="text-xs">No files selected</p>
                        </label>
                    </div>
                    <div class="count ml-auto text-gray-400 text-xs font-semibold">0/300</div>
                </div>

                <div class="buttons flex justify-end gap-2">
                    <!-- <button class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto rounded">Cancel</button> -->
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Post</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#removeImage').click(function(e) {
            var imageSrc = $(this).data('image-src');
            $('#editImagePreviewContainer').val('');
            $('#editImagePreview').attr('src', '');
        })

        $('.edit-post-btn').click(function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var postContent = $(this).data('post-content');
            var imageSrc = $(this).data('image-src');
            var postImage = $(this).data('post-image');
            var firstName = $(this).data('first-name');
            var lastName = $(this).data('last-name');
            var formattedDate = $(this).data('formatted-date');

            $('#modalImg').attr('src', imageSrc);
            $('#editPostId').val(postId);
            $('textarea[name="post_content_edit"]').val(postContent);
            $('#modalPostAuthor').text(firstName + ' ' + lastName);
            $('#modalDate').text(formattedDate);
            $('#editImagePreviewContainer').val(postImage);

            if (postImage !== "") {
                $('#editImagePreview').attr('src', postImage);
            } else {
                $('#editImageContainer').hide();
            }

            $('#editModal').fadeIn();
        });

        $('#closeEditModal2').click(function() {
            $('#editModal').fadeOut();
        });

        $(window).click(function(e) {
            if (e.target == $('#editModal')[0]) {
                $('#editModal').fadeOut();
            }
        });

        document.getElementById('fileInputEdit').addEventListener('change', function() {
            const selectedFile = this.files[0];
            if (selectedFile) {
                document.getElementById('selectedFileName2').textContent = selectedFile.name;
            } else {
                document.getElementById('selectedFileName2').textContent = 'No files selected';
            }
        });
    });
</script>