<section class="min-h-screen bg-gray-900">
    <div class="container flex flex-col lg:flex-row gap-10 w-full lg:max-w-7xl py-10 mx-auto">
        <div id="left-section" class="w-1/4 hidden lg:block">

        </div>
        <div class="w-full px-3 lg:px-0 lg:w-3/4">
            <div class="flex gap-6 items-end lg:items-center justify-between">
                <h1 class="text-xl lg:text-2xl text-white font-bold lg:font-medium">Barangay <?php echo $barangay ?></h1>

                <div class="flex flex-col lg:flex-row items-center gap-2">
                    <label for="barangay-select" class="text-white">Select Barangay:</label>
                    <select id="barangay-select" class="text-white bg-gray-600 rounded-md px-4 py-1">
                        <option value="Amsic" <?php echo ($barangay === 'Amsic') ? 'selected' : ''; ?>>Amsic</option>
                        <option value="Balibago" <?php echo ($barangay === 'Balibago') ? 'selected' : ''; ?>>Balibago</option>
                        <option value="Anunas" <?php echo ($barangay === 'Anunas') ? 'selected' : ''; ?>>Anunas</option>
                        <option value="Lourdes Northwest" <?php echo ($barangay === 'Lourdes Northwest') ? 'selected' : ''; ?>>Lourdes Northwest</option>
                        <option value="Malabanias" <?php echo ($barangay === 'Malabanias') ? 'selected' : ''; ?>>Malabanias</option>
                        <option value="Margot" <?php echo ($barangay === 'Margot') ? 'selected' : ''; ?>>Margot</option>
                        <option value="Pampang" <?php echo ($barangay === 'Pampang') ? 'selected' : ''; ?>>Pampang</option>
                        <option value="Sapangbato" <?php echo ($barangay === 'Sapangbato') ? 'selected' : ''; ?>>Sapangbato</option>
                        <option value="Sta. Teresita" <?php echo ($barangay === 'Sta. Teresita') ? 'selected' : ''; ?>>Sta. Teresita</option>
                    </select>
                </div>

            </div>

            <?php include './templates/create_post.php' ?>
            <div id="post-container">
                <?php require_once './templates/post_template.php';

                if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
                    $currentPage = intval($_GET['page']);
                } else {
                    $currentPage = 1;
                }
                renderPosts($posts);
                ?>

            </div>
            <div id="filtered-post-container" style="display: none;">
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
        function filterPostsByBarangay(barangay) {
            $.ajax({
                type: 'POST',
                url: 'filter.php', // Replace with the actual URL for filtering
                data: {
                    barangay: barangay
                },
                success: function(response) {
                    // Display the filtered posts in the filtered-post-container
                    $('#filtered-post-container').html(response);
                    $('#filtered-post-container').show();

                    // Hide the original post container
                    $('#post-container').hide();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        }

        $('#filter-button').click(function() {
            var selectedBarangay = $('#barangay-select').val();
            filterPostsByBarangay(selectedBarangay);
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
            var $button = $(this); // Store the button element
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

        var activePostAction = null;

        // Function to close the active post-action
        function closeActivePostAction() {
            if (activePostAction !== null) {
                activePostAction.hide();
                activePostAction = null;
            }
        }

        // Event handler for post-setting-button click
        $('.post-setting-button').click(function() {
            var postId = $(this).data('key-setting');
            var postActionDiv = $('#post-action-' + postId);

            // Toggle post-action visibility
            if (postActionDiv.is(':visible')) {
                postActionDiv.hide();
                activePostAction = null;
            } else {
                // Close any previously active post-action
                closeActivePostAction();

                // Show the clicked post-action
                postActionDiv.show();
                activePostAction = postActionDiv;
            }

            // Prevent the event from propagating and closing immediately
            return false;
        });

        // Close the active post-action when clicking outside
        $(document).click(function(e) {
            if (activePostAction !== null && !activePostAction.is(e.target) && activePostAction.has(e.target).length === 0) {
                closeActivePostAction();
            }
        });


    });
</script>