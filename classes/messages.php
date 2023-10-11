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

    public function getUsersWithLastMessage($userId)
    {
        $db = new Database();

        $query = "SELECT 
            IF(m1.sender_id = ?, m1.receiver_id, m1.sender_id) AS other_user_id,
            u.username AS receiver_username,
            u.id AS receiver_id,
            u.first_name AS receiver_first_name,
            u.last_name AS receiver_last_name,
            u.gender AS receiver_gender,
            MAX(m1.created_at) AS last_message_time,
            MAX(m1.message) AS last_message
        FROM messages m1
        LEFT JOIN users u ON (u.id = IF(m1.sender_id = ?, m1.receiver_id, m1.sender_id))
        WHERE (m1.sender_id = ? OR m1.receiver_id = ?)
        GROUP BY other_user_id
        ORDER BY last_message_time DESC";

        $params = [$userId, $userId, $userId, $userId];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $users = [];

            while ($row = $result->fetch_assoc()) {
                $receiverId = $row['receiver_id'];

                // Check if the receiver ID already exists in the result array
                if (!isset($users[$receiverId])) {
                    $latestMessage = $this->getLatestMessageForUser($db, $userId, $receiverId);

                    $users[$receiverId] = [
                        'receiver_id' => $receiverId,
                        'receiver_username' => $row['receiver_username'],
                        'receiver_first_name' => $row['receiver_first_name'],
                        'receiver_last_name' => $row['receiver_last_name'],
                        'receiver_gender' => $row['receiver_gender'],
                        'last_message' => [
                            'message' => $latestMessage['message'],
                            'created_at' => $row['last_message_time'],
                        ],
                    ];
                }
            }

            return array_values($users);
        } else {
            // Return an empty array if there are no results
            return [];
        }
    }

    private function getLatestMessageForUser($db, $userId, $receiverId)
    {
        $query = "SELECT message, created_at FROM messages
              WHERE (sender_id = ? OR receiver_id = ?)
              AND (sender_id = ? OR receiver_id = ?)
              ORDER BY created_at DESC
              LIMIT 1";

        $params = [$userId, $userId, $receiverId, $receiverId];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return [];
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
