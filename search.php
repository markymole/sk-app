<?php

require_once './config/autoload.php';

$search = new Search();
$image = new Images();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['query'])) {
        $query = $_POST['query'];

        $results = $search->searchUsers($query);
        echo json_encode($results);
    }

    if (isset($_POST['message_search'])) {
        $message_search = $_POST['message_search'];

        $results = $search->searchUsers($message_search);

        foreach ($results as &$user) {
            // Assuming $user['id'] contains the user's ID and $user['gender'] contains the user's gender
            $image_src = $image->getUserProfileImage($user['id'], $user['gender']);
            $user['image_src'] = $image_src;
        }

        echo json_encode($results);
    }
}
