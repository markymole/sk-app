<?php

require_once '../config/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
    $receiverId = $_GET['userId'];

    $search = new Search();
    $image = new Images();

    $results = $search->searchUser($receiverId);

    if ($results  !== false) {
        $image_src = $image->getUserProfileImage($results['id'], $results['gender']);
        $results['image_src'] = $image_src;

        echo json_encode($results);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch messages']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
