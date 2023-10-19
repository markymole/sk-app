<?php

require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();

$user_data = null;

if (isset($_SESSION['user_id'])) {
    $user_data = $user->check_login($_SESSION['user_id']);

    if ($user_data) {
        $id = $user_data['id'];
        $firstname = $user_data['first_name'];
        $lastname = $user_data['last_name'];
        $username = $user_data['username'];
        $barangay = $user_data['barangay'];
        $gender = $user_data['gender'];
        $role = $user_data['role'];
    } else {
        $id = $firstname = $lastname = $username = $barangay = $gender = $role = 'Unknown';
    }
} else {
    $id = $firstname = $lastname = $username = $barangay = $gender = $role = 'Guest';
}

?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>

    <div class="sticky top-0 border-b z-50">
        <?php include './components/navigation.php' ?>
    </div>
    <?php include './components/about-section.php' ?>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>