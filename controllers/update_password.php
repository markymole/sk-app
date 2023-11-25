<?php
require_once '../config/autoload.php';

$user = new Users();

if (isset($_SESSION['user_id']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $userId = $_SESSION['user_id'];
    $oldpassword = $_POST['old_password'];
    $newpassword = $_POST['new_password'];
    $confirmpassword = $_POST['confirm_password'];

    $user_info = $user->getLoggedInUserInfo($userId);

    if (password_verify($oldpassword, $user_info['password'])) {
        if ($confirmpassword === $newpassword) {
            $res = $user->updatePassword($userId, $newpassword);
            echo json_encode(array('success' => true, 'message' => 'Password Updated!'));
            exit();
        } else {
            echo json_encode(array('success' => false, 'message' => 'New password does not match.'));
            exit();
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Original password does not match.'));
        exit();
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Error receiving the data'));
}
