<?php

require_once '../config/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['receiverId'])) {
    $receiverId = $_GET['receiverId'];
    $senderId = $_SESSION['user_id'];

    $messagesHandler = new Messages();
    $conversation = $messagesHandler->getConversationMessages($receiverId, $senderId);

    if ($conversation !== false) {
        foreach ($conversation as &$message) {
            $message['isSender'] = ($message['sender_id'] == $senderId);
        }

        echo json_encode($conversation);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch messages']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
