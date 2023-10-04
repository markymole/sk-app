<?php
require_once('./config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $likes = new Likes();

        // Attempt to insert a like, it will return false if the user has already liked it
        $result = $likes->insertLike($user_id, 'comment', $post_id);

        if ($result) {
            // Like was successfully inserted
            echo 'Liked';
        } else {
            // User has already liked the post, so delete the like
            $deleted = $likes->deleteLike($user_id, 'comment', $post_id);
            if ($deleted) {
                echo 'Unliked';
            } else {
                echo 'Error unliking post';
            }
        }
    } else {
        echo 'Invalid post_id';
    }
} else {
    echo 'Invalid request';
}
