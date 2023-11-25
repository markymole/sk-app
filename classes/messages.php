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
            $row = $result->fetch_assoc();

            $decryptedMessage = $this->decryptMessage($row['message']);

            $row['message'] = $decryptedMessage;

            return $row;
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
                $decryptedMessage = $this->decryptMessage($row['message']);

                $row['message'] = $decryptedMessage;
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

        $encryptedMessage = $this->encryptMessage($messageText);

        $query = "INSERT INTO messages (sender_id, receiver_id, message, created_at)
                  VALUES (?, ?, ?, NOW())";

        $params = [$senderId, $receiverId, $encryptedMessage];

        $result = $db->save($query, $params);

        if ($result) {
            return true;
        } else {
            // Handle database query error
            return false;
        }
    }

    private function encryptMessage($message)
    {
        $key = 'QyMLRL4VkCGA3m42krXk2cQX6XjrcWvA ';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $encrypted = openssl_encrypt($message, 'AES-256-CBC', $key, 0, $iv);
        $encoded = base64_encode($iv . $encrypted);

        return $encoded;
    }

    private function decryptMessage($encoded)
    {
        $key = 'QyMLRL4VkCGA3m42krXk2cQX6XjrcWvA ';
        $decoded = base64_decode($encoded);
        $iv = substr($decoded, 0, openssl_cipher_iv_length('AES-256-CBC'));
        $encrypted = substr($decoded, openssl_cipher_iv_length('AES-256-CBC'));
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);

        return $decrypted;
    }

    public function delete_user_messages($userId)
    {
        $db = new Database();

        $query = 'DELETE FROM messages WHERE sender_id = ? OR receiver_id = ?';

        $params = [$userId, $userId];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }
}
