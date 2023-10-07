<?php

require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$message = new Messages();

$posts = $post->get_all_posts();

$user_data = $user->authenticate($_SESSION['user_id']);

if ($user_data) {
    $id = $user_data['id'];
    $firstname = $user_data['first_name'];
    $lastname = $user_data['last_name'];
    $username = $user_data['username'];
    $barangay = $user_data['barangay'];
    $gender = $user_data['gender'];
    $role = $user_data['role'];
    $bio = $user_data['bio'];
} else {
    $firstname = 'Unknown';
    $lastname = 'Unknown';
    $barangay = 'Unknown';
    $username = 'Unknown';
    $role = 'Guest';
}
?>

<!doctype html>
<html lang="en">

<body>

    <head>
        <Title>SK Webby App</Title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        <div class="bg-gray-900 min-h-screen">
            <?php include(__DIR__ . '/components/profile_nav.php'); ?>


            <div class="container flex flex-col lg:flex-row gap-8 w-full lg:max-w-7xl py-10 mx-auto">

            <div id="left-section" class="w-full lg:w-1/4 h-[100vh] px-3">
            
            </div>

            <div class="w-full px-3 lg:px-0 lg:w-3/4">
                <div id="message-container" class="bg-white rounded-lg p-4 shadow-md p-4">
                    <h1>message</h1>
                </div>
            </div>


        </div>
    </body>
</body>

</html>

<script>
  
</script>