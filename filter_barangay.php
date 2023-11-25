<?php

require_once './config/autoload.php';
require_once './templates/post_template.php';

$post = new Posts();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedBarangay = $_POST['barangay'];

    $posts = $post->get_posts_by_barangay($selectedBarangay);

    renderPosts($posts);
}

include './templates/edit_modal.php';
include './templates/delete_modal.php';
?>

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