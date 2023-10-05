<?php

require_once './config/autoload.php';
require_once './templates/users_template.php';

$user = new Users();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedBarangay = $_POST['barangay'];

    $users = $user->getUsersByBarangay($selectedBarangay);

    renderUsers($users);
}
