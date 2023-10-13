<?php

require_once(dirname(__DIR__) .  '/config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $user = $_SESSION['user_id'];

    $comment = new Comments();
    $res = $comment->get_comment($comment_id);

    if ($res) {

        $old_image_path = $res['image_src'];

        if ($old_image_path) {
            if (file_exists('.' . $old_image_path)) {
                unlink('.' . $old_image_path);
            }
        }

        if ($comment->delete_comment($comment_id, $user)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete the comment.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Post not found.']);
    }
}
