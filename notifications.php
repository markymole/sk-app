<?php

require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$message = new Messages();
$notifications = new Notifications();


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

<head>
    <Title>SK Webby App</Title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="bg-gray-900 h-screen overflow-hidden flex flex-col">
        <?php include(__DIR__ . '/components/nav.php'); ?>

        <div class="h-screen overflow-hidden w-full mx-auto bg-white">
            <header class="p-4 border-b border-t flex justify-between items-center text-gray-700 px-5">
                <h1 class="text-xl font-semibold">Notifications</h1>
            </header>
            <div id="mobile-notifications-container" class="relative divide-y divide-gray-100 dark:divide-gray-700 px-2 mt-2">

            </div>

        </div>
</body>

</html>

<script>
    function loadNotifications() {
        $.ajax({
            type: 'GET',
            url: './controllers/get_notifications.php',
            success: function(response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.error('Error parsing JSON: ' + e);
                }

                if (response.notifications) {
                    $('#mobile-notifications-container').html(response.notifications);
                } else if (response.error) {
                    console.log('error');
                }
                setTimeout(loadNotifications, 1000);
            },
            error: function(xhr, status, error) {
                console.error('Error loading notifications: ' + error);

                setTimeout(loadNotifications, 1000);
            }
        });
    }

    // Initial call to load notifications
    loadNotifications();
</script>