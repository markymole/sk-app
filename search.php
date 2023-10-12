<?php

require_once './config/autoload.php';

$search = new Search();
$image = new Images();

$logged_user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['query'])) {
        $query = $_POST['query'];

        $results = $search->searchUsers($query, $logged_user);

        $output = [];

        foreach ($results as $result) {
            // Generate a link to the user's profile page
            $profileLink = 'profile.php?user_id=' . $result['id'];

            // Create an array with the user's data and the profile link
            $userResult = [
                'id' => $result['id'],
                'first_name' => $result['first_name'],
                'last_name' => $result['last_name'],
                'image_src' => $result['image_src'],
                'profile_link' => $profileLink,
            ];

            $output[] = $userResult;
        }

        echo json_encode($output);
    }

    if (isset($_POST['message_search'])) {
        $message_search = $_POST['message_search'];
        $results = $search->searchUsers($message_search, $logged_user);

        foreach ($results as &$user) {
            // Assuming $user['id'] contains the user's ID and $user['gender'] contains the user's gender
            $image_src = $image->getUserProfileImage($user['id'], $user['gender']);
            $user['image_src'] = $image_src;
        }

        echo json_encode($results);
    }
}
