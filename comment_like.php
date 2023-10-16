<?php
require_once('./config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $likes = new Likes();
        $comment = new Comments();
        $notification = new Notifications();

        // Attempt to insert a like, it will return false if the user has already liked it
        $result = $likes->insertLike($user_id, 'comment', $post_id);

        $comment_res = $comment->get_comment($post_id);

        if ($comment_res) {
            $author = $comment_res['comment_author'];
        }

        $context = "Like Comment";
        $content = "Liked your comment";

        if ($result) {
            // Like was successfully inserted
            if ($user_id != $author) {
                $res = $notification->createNotification($context, $content, $post_id, $author, $_SESSION['user_id']);
            }

            echo 'Liked';
        } else {
            // User has already liked the post, so delete the like
            $deleted = $likes->deleteLike($user_id, 'comment', $post_id);
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
