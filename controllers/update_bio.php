<?php
require_once '../config/autoload.php';

$user = new Users();

if (isset($_SESSION['user_id']) && isset($_POST['bio'])) {
    $userId = $_SESSION['user_id'];
    $bio = $_POST['bio'];

    if ($user->updateUserBio($userId, $bio)) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = ['success' => false];
    header('Content-Type: application/json');
    echo json_encode($response);
}
