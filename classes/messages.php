<?php

require_once(dirname(__DIR__) .  '\config\database.php');

class Messages
{

    function getMessages($userId)
    {

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

    public function fetchMessages($conversationId)
    {
        $db = new Database();
        // Create a query to fetch messages for the given conversation
        $query = "SELECT id, sender_id, message, timestamp
                  FROM messages
                  WHERE conversation_id = ?
                  ORDER BY timestamp ASC";

        $params = [$conversationId];

        $result = $db->read($query, $params);

        if ($result) {
            $messages = [];

            while ($row = $result->fetch_assoc()) {
                // You can format the message data as needed
                $messages[] = [
                    'id' => $row['id'],
                    'sender_id' => $row['sender_id'],
                    'message' => $row['message'],
                    'timestamp' => $row['timestamp']
                ];
            }

            return $messages;
        } else {
            // Handle database query error
            return false;
        }
    }

    public function getConversationMessages($receiverId, $senderId)
    {
        $db = new Database();

        $query = "SELECT *
                  FROM messages
                  WHERE (sender_id = ? AND receiver_id = ?)
                  OR (sender_id = ? AND receiver_id = ?)
                  ORDER BY created_at ASC";

        $params = [$senderId, $receiverId, $receiverId, $senderId];

        $result = $db->read($query, $params);

        if ($result) {
            $messages = [];

            while ($row = $result->fetch_assoc()) {
                // You can format the message data as needed
                $messages[] = $row;
            }

            return $messages;
        } else {
            // Handle database query error
            return false;
        }
    }

    public function sendMessage($senderId, $receiverId, $messageText)
    {
        $db = new Database();

        $query = "INSERT INTO messages (sender_id, receiver_id, message, created_at)
                  VALUES (?, ?, ?, NOW())";

        $params = [$senderId, $receiverId, $messageText];

        $result = $db->save($query, $params);

        if ($result) {
            return true;
        } else {
            // Handle database query error
            return false;
        }
    }
}
