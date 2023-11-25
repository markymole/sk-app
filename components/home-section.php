<section class="min-h-screen bg-gray-900">
    <div class="container flex flex-col lg:flex-row gap-8 w-full lg:max-w-7xl py-10 mx-auto">

        <!-- mobile user container -->
        <div id="user-modal" class="modal w-full">
            <div class="modal-content w-11/12 md:w-1/3 mx-auto py-6 rounded-lg border">
                <div class="user-container px-4">
                    <?php require_once './templates/users_template.php';
                    renderUsers($barangayUsers);
                    ?>
                </div>
                <div class="w-full flex justify-end px-4">
                    <button id="closeUserModal" class="text-white bg-red-500 rounded-md px-4 py-1 mt-4">Close</button>

                </div>
            </div>
        </div>

        <!-- desktop user container -->
        <div id="left-section" class="w-full lg:w-1/4 h-[100vh] px-3">
            <h1 id="barangay_name" class="text-xl lg:text-2xl text-white font-bold lg:font-medium">Barangay <?php echo $barangay ?></h1>
            <div class="user-container hidden lg:flex bg-white w-full mt-6 rounded-lg p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <?php require_once './templates/users_template.php';
                renderUsers($barangayUsers);
                ?>
            </div>
        </div>


        <div class="w-full px-3 lg:px-0 lg:w-3/4">
            <div class="flex flex-row lg:flex-row-reverse gap-6 items-end lg:items-center justify-between">

                <div class="flex flex-col lg:flex-row items-start gap-2">
                    <label for="barangay-select" class="text-white">Select Barangay:</label>
                    <select id="barangay-select" class="text-white bg-gray-600 rounded-md px-4 py-1">
                        <?php
                        foreach ($barangay_list as $bar) {
                            $selected = ($bar['name'] === $barangay) ? 'selected' : '';
                            echo "<option value='{$bar['name']}' $selected>{$bar['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button id="showUserModal" class="flex lg:hidden text-white bg-gray-600 rounded-md px-4 py-1 text-sm">
                    <p> Show SK Members</p>
                </button>

            </div>
            <input id="current_user_barangay" type="text" class="hidden" value="<?php echo $barangay ?>">

            <div id="create_post_container">
                <?php include './templates/create_post.php' ?>
            </div>
            <div id="post-container">
                <?php require_once './templates/post_template.php';

                renderPosts($posts);
                ?>

            </div>
        </div>
    </div>

</section>
<?php include './templates/edit_modal.php' ?>
<?php include './templates/delete_modal.php' ?>


<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        position: absolute;
        min-height: 20vh;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
    }

    .modal-image {
        max-width: 100%;
        max-height: 60%;
        margin: auto;
        display: block;
    }
</style>

<script>
    $(document).ready(function() {
        $('#barangay-select').change(function() {
            var selectedBarangay = $(this).val();
            var userBarangay = $('#current_user_barangay').val();
            $('#barangay_name').text('Barangay ' + selectedBarangay);

            if (selectedBarangay != userBarangay) {
                $('#create_post_container').addClass('hidden');
            } else {
                $('#create_post_container').removeClass('hidden');
            }

            $.ajax({
                type: 'POST',
                url: './filter_barangay.php',
                data: {
                    barangay: selectedBarangay
                },
                success: function(response) {
                    $('#post-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });

            $.ajax({
                type: 'POST',
                url: './filter_users.php',
                data: {
                    barangay: selectedBarangay
                },
                success: function(userResponse) {
                    $('.user-container').html(userResponse);
                },
                error: function(xhr, status, error) {
                    console.error('User AJAX Error: ' + error);
                }
            });
        });

        $('#closeModal').click(function() {
            $('#imageModal').fadeOut();
        });

        $(window).click(function(e) {
            if (e.target == $('#imageModal')[0]) {
                $('#imageModal').fadeOut();
            }
        });

        $('.like-post-btn').click(function() {
            var $button = $(this);
            var postId = $button.data('post-id');
            var likeCount = $button.find('.like-count');

            $.ajax({
                type: 'POST',
                url: 'like.php',
                data: {
                    post_id: postId
                },
                success: function(response) {
                    if (response === 'Liked') {

                        $('#likeButton' + postId).addClass('text-blue-600');
                        likeCount.text(parseInt(likeCount.text()) + 1);
                    } else if (response === 'Unliked') {

                        $('#likeButton' + postId).removeClass('text-blue-600');
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

        $('.comment-button').click(function(e) {
            e.preventDefault();
            var imageUrl = $(this).data('image-url');
            var postId = $(this).data('post-id');
            var postContent = $(this).data('post-content');
            var firstName = $(this).data('first-name');
            var lastName = $(this).data('last-name');
            var likes = $(this).data('likes');
            var comments = $(this).data('comments');
            var formattedDate = $(this).data('formatted-date');

            $('#modalImage').attr('src', './posts/' + imageUrl);
            $('#modalPostAuthor').text(firstName + ' ' + lastName);
            $('#modalDate').text(formattedDate);
            $('#modalContent').text(postContent);
            $('#modalLikes').text(likes);
            $('#modalComments').text(comments);

            $('#imageModal').fadeIn();

        });

        $('#showUserModal').click(function() {
            $('#user-modal').fadeIn();
        });

        $('#closeUserModal').click(function() {
            $('#user-modal').fadeOut();
        });

        var activePostAction = null;

        function closeActivePostAction() {
            if (activePostAction !== null) {
                activePostAction.hide();
                activePostAction = null;
            }
        }

        $('.post-setting-button').click(function() {
            var postId = $(this).data('key-setting');
            var postActionDiv = $('#post-action-' + postId);

            if (postActionDiv.is(':visible')) {
                postActionDiv.hide();
                activePostAction = null;
            } else {
                closeActivePostAction();

                postActionDiv.show();
                activePostAction = postActionDiv;
            }

            return false;
        });

        $(document).click(function(e) {
            if (activePostAction !== null && !activePostAction.is(e.target) && activePostAction.has(e.target).length === 0) {
                closeActivePostAction();
            }
        });


    });
</script>