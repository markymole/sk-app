<?php

require_once(dirname(__DIR__) .  '\config\database.php');
require_once('image.php');

class Search
{

    function searchUsers($searchTerm, $loggedUser)
    {
        $db = new Database();
        $images = new Images();

        $query = "SELECT users.id, users.first_name, users.last_name, users.gender
                  FROM users 
                  WHERE (username LIKE ? 
                  OR first_name LIKE ? 
                  OR last_name LIKE ?)
                  AND id != ?
                  LIMIT 5";

        $param = '%' . $searchTerm . '%';
        $params = [$param, $param, $param, $loggedUser];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $image_src = $images->getUserProfileImage($row['id'], $row['gender']);

                $users[] = [
                    'id' => $row['id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'image_src' => $image_src,
                ];
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
