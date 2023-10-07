<?php

require_once './config/autoload.php';

$search = new Search();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['query'])) {
        $query = $_POST['query'];

        $results = $search->searchUsers($query);
        echo json_encode($results);
    }
}
?>