<?php
require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$date = new General();
$uploads = new Uploads();
$comments = new Comments();


$user_data = null;
if (isset($_SESSION['user_id'])) {
    $user_data = $user->check_login($_SESSION['user_id']);

    if ($user_data) {
        $id = $user_data['id'];
        $firstname = $user_data['first_name'];
        $lastname = $user_data['last_name'];
        $username = $user_data['username'];
        $barangay = $user_data['barangay'];
        $gender = $user_data['gender'];
        $role = $user_data['role'];
    } else {
        $id = $firstname = $lastname = $username = $barangay = $gender = $role = 'Unknown';
    }
} else {
    $id = $firstname = $lastname = $username = $barangay = $gender = $role = 'Guest';
}

$post_id = $_GET['post_id'];

$post = $post->get_post_with_likes($post_id);
$post_comment = $comments->getCommentsWithLikes($post_id);

?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create_comment') {
            if (isset($_FILES['comment_image']) && $_FILES['comment_image']['error'] === UPLOAD_ERR_OK) {
                $image_src = $uploads->addCommentImage($id);

                if ($comments->createComment($post_id, $_SESSION['user_id'], $_POST['comment_content'], $image_src)) {
                    header("Location: post.php?post_id=$post_id");
                    exit();
                } else {
                    echo "Error creating post.";
                }
            } else {
                if ($comments->createComment($post_id, $_SESSION['user_id'], $_POST['comment_content'])) {
                    header("Location: post.php?post_id=$post_id");
                    exit();
                } else {
                    echo "Error creating post.";
                }
            }
        } elseif ($action === 'edit_post') {
        } else {
        }
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>


<body class="bg-gray-900">
    <div class="sticky top-0">
        <?php include './components/nav.php' ?>
    </div>
    <div>
        <?php include './components/post-section.php' ?>
    </div>

</body>

</html>


<script>
    $(document).ready(function() {
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

        document.getElementById('fileInput').addEventListener('change', function() {
            // Get the selected file name and display it in the paragraph
            const selectedFile = this.files[0];
            if (selectedFile) {
                document.getElementById('selectedFileName').textContent = selectedFile.name;
            } else {
                document.getElementById('selectedFileName').textContent = 'No files selected';
            }
        });

        $('#post-setting').click(function() {
            $('#post-action').toggle();
        })
    })
</script>