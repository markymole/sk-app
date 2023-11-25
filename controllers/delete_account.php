<?php
require_once(dirname(__DIR__) .  '/config/autoload.php');

$user = new Users();
$posts = new Posts();
$message = new Messages();
$follower = new Follow();
$likes = new Likes();
$comments = new Comments();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $password = $_POST['cpassworddel'] ?? null;

    if ($userId && $password) {
        $user_info = $user->getLoggedInUserInfo($userId);
        if (password_verify($password, $user_info['password'])) {
            $deleted = $posts->delete_posts_by_author($userId);
            $message_deleted = $message->delete_user_messages($userId);
            $follower_deleted = $follower->delete_follow_data($userId);
            $user_deleted = $user->delete_user($userId);
            $comments_deleted = $comments->deleteCommentsByAuthor($userId);
            $likes_deleted = $likes->deleteAllLikesByUser($userId);


            if ($deleted && $message_deleted && $follower_deleted && $user_deleted && $comments_deleted && $likes_deleted) {
                session_destroy();
                echo json_encode(['success' => true, 'message' => 'Account deleted']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user or associated data.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Password Incorrect']);
            exit;
        }
    }
}
