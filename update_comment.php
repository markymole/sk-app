<?php


require_once './config/autoload.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comments = new Comments();
    $uploads = new Uploads();

    if (isset($_POST['postParent'])) {
        $commentId = $_POST['commentId'];
        $commentContent = $_POST['commentContent'];
        $commentImage = "";
        $imageRemoved = false;

        if (isset($_FILES['commentImage'])) {
            $commentImage = $_FILES['commentImage'];
        } else {
            $commentImage = null;
        }

        if (isset($_POST['imageRemoved'])) {
            $removed = $_POST['imageRemoved'];
            if ($removed === true || $removed === 'true') {
                $imageRemoved = true;
            }
        }

        if ($imageRemoved) {
            $image_path = "removed";
        } else {
            if ($commentImage['error'] === UPLOAD_ERR_OK) {
                $image_path = $uploads->updateCommentImage($_SESSION['user_id'], $commentId);

                if (!$image_path) {
                    echo json_encode(array('status' => 'error', 'message' => 'Error uploading file!'));
                    exit();
                }
            } else {
                $image_path = "";
            }
        }

        $result = $comments->updateComment($commentId, $commentContent, $image_path);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment updated successfully.'));
            exit();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update comment.'));
        }
    } else {
    }
}
