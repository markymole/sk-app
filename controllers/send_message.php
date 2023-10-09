<?php
require_once(dirname(__DIR__) . '/config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = new Messages();

    $senderId = $_SESSION['user_id'];
    $receiverId = $_POST['receiverId'];
    $messageText = $_POST['message'];

    $result = $message->sendMessage($senderId, $receiverId, $messageText);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error sending message']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
