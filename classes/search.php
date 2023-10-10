<?php

require_once(dirname(__DIR__) .  '\config\database.php');

class Search
{

    function searchUsers($searchTerm, $loggedInUserId)
    {

        $db = new Database();

        $query = "SELECT * FROM users 
        WHERE (username LIKE ? OR first_name LIKE ? OR last_name LIKE ?)
        AND id != ?
        LIMIT 5"; // Use a parameter for the LIMIT        

        $param = '%' . $searchTerm . '%';
        $params = [$param, $param, $param, $loggedInUserId];

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

    function searchUser($userId)
    {
        $db = new Database();

        $query = 'SELECT * FROM users WHERE id = ?';
        $params = [$userId];

        $result = $db->read($query, $params);

        if ($result && $result->num_rows === 1) {

            $user_data = $result->fetch_assoc();
            return $user_data;
        } else {
            return false;
        }
    }
}
