<?php

require_once(dirname(__DIR__) .  '\config\database.php');

class Search{

    function searchUsers($searchTerm){

        $db = new Database();

        $query = "SELECT * FROM users 
        WHERE username LIKE ? 
        OR first_name LIKE ? 
        OR last_name LIKE ?
        LIMIT 5"; // Use a parameter for the LIMIT        

        $param = '%' . $searchTerm . '%';
        $params = [$param, $param, $param];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }
}

?>
