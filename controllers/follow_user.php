<?php
require_once(dirname(__DIR__) . '/config/autoload.php');

$follow = new Follow();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $follower = $_SESSION['user_id'];
    $following = $_POST['user_id'];

    if ($follower === $following) {
        echo json_encode(['success' => false, 'message' => 'You cannot follow yourself.']);
        exit();
    }

    if ($follow->isFollowing($follower, $following)) {
        if ($follow->unfollowUser($follower, $following)) {
            echo json_encode(['success' => true, 'message' => 'You have unfollowed this user.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to unfollow this user.']);
        }
    } else {
        if ($follow->followUser($follower, $following)) {
            echo json_encode(['success' => true, 'message' => 'You are now following this user.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to follow this user.']);
        }
    }
}
