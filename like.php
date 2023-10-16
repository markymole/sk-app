<?php
require_once('./config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $likes = new Likes();
        $post = new Posts();
        $notification = new Notifications();

        // Attempt to insert a like, it will return false if the user has already liked it
        $result = $likes->insertLike($user_id, 'post', $post_id);

        $post_result = $post->get_post($post_id);

        if ($post_result) {
            $author = $post_result['author'];
        }

        //send notification
        $context = "Like Post";
        $content = "Liked your post";

        if ($result) {
            if ($user_id != $author) {
                $res = $notification->createNotification($context, $content, $post_id, $author, $_SESSION['user_id']);
            }

            echo 'Liked';
        } else {
            // User has already liked the post, so delete the like
            $deleted = $likes->deleteLike($user_id, 'post', $post_id);
            if ($deleted) {
                $notificationID = $notification->getNotificationIDByContent($context, $content, $post_id, $_SESSION['user_id'], $author);
                if ($notificationID) {
                    $notification->deleteNotification($notificationID);
                }
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
