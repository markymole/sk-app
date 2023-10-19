<?php
require_once(dirname(__DIR__) . '/config/autoload.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $userId = $_SESSION['user_id'];

    $notifications = new Notifications();

    $newNotifications = $notifications->getUserNotification($userId);

    if (isset($newNotifications)) {
        $unseenNotifications = array_filter($newNotifications, function ($notification) {
            return $notification['seen'] == false || $notification['seen'] == 0;
        });

        $response = [
            'count' => count($unseenNotifications),
            'notifications' => $unseenNotifications
        ];

        echo json_encode($response);
        exit();
    } else {
        echo json_encode(["error" => "Failed to fetch notifications."]);
        exit();
    }
}
