<?php

if (!empty($post_comment)) {
    foreach ($post_comment as $comment) {
        $comment_id = $comment['comment_id'];
        $parent = $comment['parent_post'];
        $comment_content = $comment['comment_content'];
        $image_url = $comment['image_src'];
        $created_at = $comment['created_at'];
        $comment_author = $comment['comment_author'];
        $author_gender = $comment['gender'];

        $author_image_src = $image->getUserProfileImage($comment_author, $author_gender);


        $likes = $comment['like_count'];

        $first_name = $comment['first_name'];
        $last_name = $comment['last_name'];

        $formatted_date = $date->formatDate($created_at);

        if (isset($_SESSION['user_id'])) {
            $isAuthor = ($_SESSION['user_id'] == $comment_author);
        } else {
            $isAuthor = false;
        }

        $image_html = '';
        $image_urls = '';
        if ($comment['image_src']) {
            $image_url = $comment['image_src'];
            $unique_id = uniqid();

            $image_html = <<<HTML
            <a class="comment-image-link">
                <img id="comment-image-$comment_id" src="$image_url" alt="" class="w-full max-h-96 object-cover mb-4 rounded-md">
            </a>
            HTML;
        } else {
            $image_html = <<<HTML
            <a>
            <img id="comment-image-$comment_id" src="" alt="" class="w-full max-h-96 object-cover mb-4">
        </a>
        HTML;
        }

        echo <<<HTML
        <div class='flex items-center justify-center w-full mx-auto mt-4 px-3 md:px-6' id="comment-$comment_id">
            <div class="rounded-xl border p-5 shadow-sm w-full bg-white" id="comment-container">
                <div class="flex items-center w-full items-center justify-between border-b pb-3">
                    <div class="flex items-center space-x-3">
                        <a href="profile.php?user_id=$comment_author">     
                            <img class="h-9 w-9 rounded-full" src="$author_image_src" alt="">
                        </a>
                        <div>                        
                            <div class="text-base font-semibold text-slate-700">$first_name $last_name</div>
                            <div class="flex items-center space-x-8">
                                    <div class="text-xs text-neutral-500">$formatted_date</div>
                            </div>
                        </div>
                        
                    </div>
HTML;
        if ($isAuthor) {
            echo <<<HTML
            <div div class="mt-4 flex justify-end space-x-2 relative">
                        <a class="edit-comment-btn flex text-gray-600 cursor-pointer items-center transition hover:text-yellow-600" data-comment-parent="$parent" data-comment-id="$comment_id" data-comment-content="$comment_content" data-comment-src="$image_url">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1.5 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                        <div class="delete-comment-btn text-gray-600 flex cursor-pointer items-center transition hover:text-red-600" data-comment-id="$comment_id">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1.5 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
            </div>
       
HTML;
        }
        echo <<<HTML
             </div>
                <div class="mt-4 mb-4 " >
                    <div class="comment">
                        <p class="text-base text-gray-700" id="comment-text">$comment_content</p>
                    </div>
                    <div class="edit-comment-form hidden">
                        <textarea class="edit-comment-textarea w-full" rows="4" placeholder="Edit your comment..."></textarea>
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-1">
                                <div class="icons flex text-gray-500 m-2">
                                    <div class="flex">
                                        <input type="file" name="comment_image" accept="image/*" id="editFileInput-$comment_id" style="display:none;">
                                        <label for="editFileInput-$comment_id" class="flex items-center">
                                            <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            <p id="commentFileName-$comment_id" class="text-xs">No files selected</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="cancel-comment-btn bg-gray-200 text-black text-sm border-gray-600 px-4 py-1 rounded mt-2">Cancel</button>
                                <button class="save-comment-btn bg-yellow-400 text-white text-sm px-4 py-1 rounded mt-2">Save</button>
                            </div>
                        </div>
                       
                    </div>
                </div>
              
                <div id="image-container" class="relative">
                    $image_html
                    <div id="removeImageContainer-$comment_id" class="hidden p-1 bg-white rounded-full absolute top-2 right-2">
                        <svg id="removeImage" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
              
                <div class="">
                    <div class="flex items-center justify-between text-slate-500">
                        <div class="flex space-x-4 md:space-x-8">
                            <button class="like-comment-btn flex cursor-pointer items-center transition hover:text-slate-600" data-comment-id="$comment_id">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span class="comment-like-count">$likes</span>
                            </button>
                           
                        </div>
                    </div>
                   
                </div>
               
            </div>
            
        </div>
        
       
        HTML;
    }
} else {
}
include './templates/delete_comment_modal.php';
?>
<script>
    $(document).ready(function() {
        $('.like-comment-btn').click(function() {
            var $button = $(this);
            var commentId = $button.data('comment-id');
            var likeCount = $button.find('.comment-like-count');

            $.ajax({
                type: 'POST',
                url: 'comment_like.php',
                data: {
                    post_id: commentId
                },
                success: function(response) {
                    if (response === 'Liked') {

                        likeCount.text(parseInt(likeCount.text()) + 1);
                    } else if (response === 'Unliked') {
                        likeCount.text(parseInt(likeCount.text()) - 1);

                    } else {

                        console.error('Error: ' + response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        });

        document.querySelectorAll('.delete-comment-btn').forEach((deleteBtn) => {
            deleteBtn.addEventListener('click', (event) => {
                const commentId = event.currentTarget.dataset.commentId;

                $('#deleteCommentId').val(commentId);

                $('#deleteCommentModal').fadeIn();
            })
        });


        document.querySelectorAll('.edit-comment-btn').forEach((editBtn) => {
            editBtn.addEventListener('click', (event) => {
                const container = editBtn.closest('#comment-container');
                const removeImageContainer = editBtn.closest('#image-container');

                const commentParent = event.currentTarget.dataset.commentParent;
                const commentId = event.currentTarget.dataset.commentId;
                const commentContent = event.currentTarget.dataset.commentContent;
                const imageContent = event.currentTarget.dataset.commentSrc;

                if (container) {
                    const commentText = container.querySelector('.comment');
                    const removeIcon = container.querySelector(`#removeImageContainer-${commentId}`);

                    if (removeIcon) {
                        removeIcon.style.display = 'block';
                    }

                    if (commentText) {
                        commentText.style.display = 'none';

                        const editForm = container.querySelector('.edit-comment-form');
                        if (editForm) {
                            editForm.style.display = 'block';

                            const textarea = editForm.querySelector('.edit-comment-textarea');
                            textarea.value = commentText.querySelector('p').textContent;
                        } else {
                            console.error('.edit-comment-form not found within the container');
                        }
                    } else {
                        console.error('.comment element not found within the container');
                    }


                } else {
                    console.error('Container with class "comment-container" not found');
                }

                const removeIcon = container.querySelector(`#removeImageContainer-${commentId}`);
                if (removeIcon) {
                    removeIcon.addEventListener('click', () => {
                        const commentImage = container.querySelector(`#comment-image-${commentId}`);

                        commentImage.setAttribute('data-original-src', commentImage.src);

                        commentImage.src = "";
                    })
                }

                const cancelButton = container.querySelector('.cancel-comment-btn');
                if (cancelButton) {
                    cancelButton.addEventListener('click', () => {
                        const editForm = container.querySelector('.edit-comment-form');
                        const commentText = container.querySelector('.comment');
                        const commentImage = container.querySelector(`#comment-image-${commentId}`);
                        const removeIcon = container.querySelector(`#removeImageContainer-${commentId}`);
                        const inputlabel = container.querySelector(`#commentFileName-${commentId}`);

                        const fileInput = container.querySelector(`#editFileInput-${commentId}`);
                        if (fileInput) {
                            if (fileInput.files.length > 0) {
                                fileInput.value = '';
                                const originalImageSrc = commentImage.getAttribute('data-original-src');
                                commentImage.src = originalImageSrc;
                            }
                        }

                        const originalImageSrc = commentImage.getAttribute('data-original-src');
                        commentImage.src = originalImageSrc;

                        inputlabel.textContent = "No files selected";
                        removeIcon.style.display = 'none';
                        editForm.style.display = 'none';
                        commentText.style.display = 'block';
                    });
                }

                const fileInput = container.querySelector(`#editFileInput-${commentId}`);
                if (fileInput) {
                    fileInput.addEventListener('change', (event) => {
                        const fileName = event.target.files[0].name;
                        const commentFileName = container.querySelector(`#commentFileName-${commentId}`);
                        const commentImage = container.querySelector(`#comment-image-${commentId}`);

                        commentFileName.textContent = fileName;

                        const reader = new FileReader();
                        reader.onload = function() {
                            commentImage.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);

                        commentImage.setAttribute('data-original-src', commentImage.src);
                    });
                }

                const saveButton = container.querySelector('.save-comment-btn');
                if (saveButton) {
                    saveButton.addEventListener('click', () => {
                        const editForm = container.querySelector('.edit-comment-form');
                        const textarea = editForm.querySelector('.edit-comment-textarea');
                        const updatedContent = textarea.value;

                        const fileInput = editForm.querySelector(`#editFileInput-${commentId}`);
                        const updatedImage = fileInput.files[0];

                        const formData = new FormData();
                        formData.append('postParent', commentParent);

                        formData.append('commentId', commentId);
                        formData.append('commentContent', updatedContent);

                        if (updatedImage) {
                            formData.append('commentImage', updatedImage);
                        }

                        $.ajax({
                            url: 'update_comment.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                const commentText = container.querySelector('.comment');
                                commentText.textContent = updatedContent;

                                commentText.style.display = 'block';
                                editForm.style.display = 'none';

                                fileInput.value = '';
                                const commentFileName = container.querySelector(`#commentFileName-${commentId}`);
                                commentFileName.textContent = 'No files selected';
                            },
                            error: function(error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                }

            });
        });



        $('.comment-setting-button').click(function() {
            var commentId = $(this).data('key-setting');

            var postActionDiv = $('#comment-action-' + commentId);
            postActionDiv.toggle();
        })

    })
</script>