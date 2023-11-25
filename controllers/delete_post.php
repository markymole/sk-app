<?php

require_once(dirname(__DIR__) .  '/config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user = $_SESSION['user_id'];

    $posts = new Posts();
    $comments = new Comments();

    $post = $posts->get_post($post_id);

    if ($post) {

        if ($post['image_src']) {
            $old_image_path = $post['image_src'];

            $image_file_path = '.' . $old_image_path;

            if (file_exists($image_file_path)) {
                unlink($image_file_path);
            }

            $post_comments = $comments->get_comments($post_id);

            foreach ($post_comments as $comment) {

                if ($comment['image_src']) {

                    $comment_image_path = '.' . $comment['image_src'];

                    if (file_exists($comment_image_path)) {
                        unlink($comment_image_path);
                    }
                }
            }
        }

        if ($posts->delete_post($post_id, $user) && $comments->delete_comments($post_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete the post.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Post not found.']);
    }
}
