<?php
require_once('./config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = new Users();

    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $barangay = $_POST['barangay'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo json_encode(array('success' => false, 'message' => 'Passwords do not match.'));
        exit();
    }

    $userExists = $users->checkExistingUser($username, $email);

    if ($userExists) {
        echo json_encode(array('success' => false, 'message' => 'Username or email already exists.'));
        exit();
    }

    $result = $users->register_user($username, $email, $password, $first_name, $last_name, $barangay, $role, $gender);

    if ($result) {
        echo json_encode(array('success' => true, 'message' => 'Registration successful.'));
        exit();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Registration failed. Please try again.'));
        exit();
    }
}
