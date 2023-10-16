<?php
require_once(dirname(__DIR__) . '/config/autoload.php');

$follow = new Follow();
$notification = new Notifications();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $follower = $_SESSION['user_id'];
    $following = $_POST['user_id'];

    $context = "Follow";
    $content = "started following you";

    if ($follower === $following) {
        echo json_encode(['success' => false, 'message' => 'You cannot follow yourself.']);
        exit();
    }

    if ($follow->isFollowing($follower, $following)) {
        if ($follow->unfollowUser($follower, $following)) {

            $res = $notification->deleteNotificationByFollowing($follower, $following, $context, $content);

            echo json_encode(['success' => true, 'message' => 'You have unfollowed this user.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to unfollow this user.']);
        }
    } else {
        if ($follow->followUser($follower, $following)) {

            $res = $notification->createNotification($context, $content, "", $following, $follower);
            if ($res) {
                echo json_encode(['success' => true, 'message' => 'You are now following this user.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to follow this user.']);
        }
    }
}
