<div class="modal2" id="deleteModal">
    <div class="modal-content2 w-1/5 mx-auto rounded-lg">
        <form action="../../controllers/posts/delete_post.php" method="POST" enctype="multipart/form-data" id="deleteForm">
            <input type="hidden" name="post_id" id="deletePostID" value="">
            <div class="bg-white mt-6 mx-auto flex flex-col text-gray-800 rounded-lg border-gray-300 p-4 shadow-sm w-full">
                <p class="mb-4 font-medium">Delete this post? </p>

                <div class="mt-6 buttons mx-auto flex gap-2">
                    <button id="closeDeleteModal" type="button" class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto rounded">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .modal2 {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content2 {
        position: absolute;
        width: 20%;
        min-height: 20vh;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
    }
</style>


<script>
    $(document).ready(function() {

        // functions for the edit button
        $('.delete-post-btn').click(function(e) {
            e.preventDefault();
            // Retrieve the post data for editing
            var postId = $(this).data('post-id');

            // Set the form fields with the post data
            $('#deletePostID').val(postId);
            // Show the edit modal
            $('#deleteModal').fadeIn();
        });

        // Close the edit modal when clicking the close button
        $('#closeDeleteModal').click(function() {
            $('#deleteModal').fadeOut();
        });

        // Close the edit modal when clicking outside the modal content
        $(window).click(function(e) {
            if (e.target == $('#deleteModal')[0]) {
                $('#deleteModal').fadeOut();
            }
        });
    });
</script>