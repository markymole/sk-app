<?php

require_once '../config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$date = new General();
$uploads = new Uploads();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        $post_content = $_POST['post_content_edit'];


        if (isset($_FILES['new_post_image']) && $_FILES['new_post_image']['error'] === UPLOAD_ERR_OK) {
            $image_path = $uploads->updatePostImage($_SESSION['user_id'], $post_id);

            if (!$image_path) {
                echo "Error uploading file!";
            }
        } else {
            $image_path = $_POST['editImagePreviewContainer'];
        }

        $result = $post->edit_post($post_id, $post_content, $image_path);

        if ($result) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error updating post!";
        }
    } else {
    }
}
