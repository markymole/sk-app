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
        <?php include './components/nav.php' ?>
    </div>

    <main class="h-screen w-full flex flex-col justify-center items-center bg-gray-900">
        <h1 class="text-8xl lg:text-9xl font-extrabold text-white tracking-widest">404</h1>
        <div class="bg-yellow-400 px-2 text-xs lg:text-sm rounded rotate-12 absolute">
            Page Not Found
        </div>
        <button class="mt-5">
            <a href="index.php" class="hidden lg:flex text-gray-800 bg-yellow-400 dark:text-white hover:bg-yellow-500 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Return</a>

        </button>
    </main>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>