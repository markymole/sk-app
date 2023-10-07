<?php

require_once(dirname(__DIR__) .  '\config\database.php');

class Messages{

    function getMessages($userId) {

        $db = new Database();

        $query = "SELECT DISTINCT m1.sender_id, m1.receiver_id, m1.message, m1.created_at, 
                         u.username AS receiver_username, u.id AS receiver_id
                  FROM messages m1
                  LEFT JOIN users u ON (m1.receiver_id = u.id)
                  WHERE m1.sender_id = ?
                  OR m1.receiver_id = ?
                  ORDER BY m1.created_at DESC";

        $params = [$userId, $userId];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        return $messages;
        } else {
        return [];
        }
    }
}
?>
