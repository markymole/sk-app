<?php
require_once(dirname(__DIR__) .  '/config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $images = new Images();

    $userId = $_POST['user_id'] ?? null;
    $imgSrc = $_POST['img_src'] ?? null;

    if ($userId && $imgSrc) {
        if (file_exists('.' . $imgSrc)) {
            if (unlink('.' . $imgSrc)) {
                $deleted = $images->deleteProfileImage($userId, $imgSrc);

                if ($deleted) {
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete image from database']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete image from storage']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'File does not exist']);
            exit;
        }
    }
}
