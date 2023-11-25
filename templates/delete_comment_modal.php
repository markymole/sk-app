<div class="comment-modal" id="deleteCommentModal">
    <div class="comment-modal-content w-1/5 mx-auto rounded-lg">
        <form action="" method="POST" enctype="multipart/form-data" id="deleteCommentForm">
            <input type="hidden" name="comment-id" id="deleteCommentId" value="">
            <div class="bg-white mt-6 mx-auto flex flex-col text-gray-800 rounded-lg border-gray-300 p-4 shadow-sm w-full">
                <p class="mb-4 font-medium">Delete this comment? </p>

                <div class="mt-6 buttons mx-auto flex gap-2">
                    <button id="closeCommentModal" type="button" class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto rounded">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .comment-modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .comment-modal-content {
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

        $('#closeCommentModal').click(function() {
            $('#deleteCommentModal').fadeOut();
        });

        $(window).click(function(e) {
            if (e.target == $('#deleteCommentModal')[0]) {
                $('#deleteCommentModal').fadeOut();
            }
        });

        $('#deleteCommentForm').submit(function(e) {
            e.preventDefault();
            const comment_id = $('#deleteCommentId').val();

            $.ajax({
                type: 'POST',
                url: './controllers/delete_comment.php',
                data: {
                    comment_id: comment_id
                },
                success: function(response) {

                    var response = JSON.parse(response);

                    if (response.success) {
                        $('#deleteCommentModal').fadeOut();

                        $('#comment-' + comment_id).remove();
                    } else {
                        console.error('Post deletion failed:', response.message);
                    }
                },
                error: function(error) {
                    console.error('Ajax request failed:', error);
                }
            });
        });
    });
</script>