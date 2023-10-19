<?php
require_once(dirname(__DIR__) .  '/config/autoload.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["notificationId"])) {
    $notificationId = $_POST["notificationId"];
    $userId = $_SESSION['user_id'];

    $notifications = new Notifications();

    $success = $notifications->markNotificationAsSeen($notificationId, $userId);

    if ($success) {
        echo json_encode(["success" => true]);
        exit();
    } else {
        echo json_encode(["error" => "Failed to mark notification as seen."]);
        exit();
    }
}
