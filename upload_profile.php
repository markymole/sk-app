<?php
require_once './config/autoload.php';

$db = new Database();
$uploads = new Uploads();
$posts = new Posts();

if (isset($_FILES['profile_image'])) {
    $user_id = $_SESSION['user_id'];

    $image_path = $uploads->uploadProfilePicture($user_id);

    if ($image_path) {
        $user_id = $_SESSION['user_id'];
        $image_src = $image_path;
        $post_type = 'Profile';

        $post_id = $posts->update_profile($image_src, $user_id, $post_type);

        if ($post_id) {
            echo 'success creating post.';
            exit();
        } else {
            echo 'Error creating post.';
        }
    } else {
        echo 'Error uploading profile picture.';
    }
} else {
    echo 'No file uploaded.';
}
