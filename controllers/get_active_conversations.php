<?php
require_once(dirname(__DIR__) . '/config/autoload.php');

$userId = $_SESSION['user_id'];

$messagesHandler = new Messages();
$image = new Images();

$conversations = $messagesHandler->getUsersWithLastMessage($userId);


if ($conversations !== false) {
    foreach ($conversations as &$message) {
        $message['image_src'] = $image->getUserProfileImage($message['receiver_id'], $message['receiver_gender']);
    }

    echo json_encode($conversations);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch messages']);
}
