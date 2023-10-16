<?php
require_once(dirname(__DIR__) .  '\config\database.php');


class Notifications
{
    public function createNotification($context, $content, $postID, $user_id, $postAuthorID)
    {
        $db = new Database();
        $seen  = "0";

        $query = 'INSERT INTO notifications (context, content, post_id, notif_from, notif_to, seen) VALUES (?, ?, ?, ?, ?, ?)';
        $params = [$context, $content, $postID, $postAuthorID, $user_id, $seen];

        return $db->save($query, $params);
    }

    public function getUserNotification($user_id)
    {
        $db = new Database();

        $query = 'SELECT n.*, u.* FROM notifications n
        INNER JOIN users u ON n.notif_from = u.id
        WHERE n.notif_to = ? 
        ORDER BY created_at DESC LIMIT 10';
        $params = [$user_id];

        $result = $db->read($query, $params);

        $notifications = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
        }

        return $notifications;
    }

    public function deleteNotification($notificationID)
    {
        $db = new Database();

        $query = 'DELETE FROM notifications WHERE id = ?';
        $params = [$notificationID];

        return $db->save($query, $params);
    }

    public function deleteNotificationByFollowing($notify_from, $notify_to, $context, $content)
    {
        $db = new Database();

        $query = 'DELETE FROM notifications WHERE notif_from = ? AND notify_to = ? AND context = ? AND content = ?';
        $params = [$notify_from, $notify_to, $context, $content];

        return $db->save($query, $params);
    }

    public function deleteNotificationByPostID($post_id)
    {
        $db = new Database();

        $query = 'DELETE FROM notifications WHERE post_id = ?';
        $params = [$post_id];

        return $db->save($query, $params);
    }

    public function createNotificationsForUsers($notificationID, $userIDs)
    {
        $db = new Database();

        $insertValues = [];

        foreach ($userIDs as $userID) {
            $insertValues[] = "($notificationID, $userID, 0)";
        }

        $valuesString = implode(', ', $insertValues);

        $query = "INSERT INTO notification_user (notification_id, user_id, seen) VALUES $valuesString";

        return $db->save($query);
    }

    public function getNotificationIDByContent($context, $content, $postID, $postAuthorID, $userID)
    {
        $db = new Database();

        $query = 'SELECT id FROM notifications WHERE context = ? AND content = ? AND post_id = ? AND notif_from = ? AND notif_to = ?';
        $params = [$context, $content, $postID, $postAuthorID, $userID];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            return null;
        }
    }
}
