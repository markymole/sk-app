<?php
require_once(dirname(__DIR__) .  '\config\database.php');

class Follow
{


    public function followUser($follower, $following)
    {
        $db = new Database();

        $query = "INSERT INTO followers (follower, following, created_at) VALUES (?, ?, NOW())";
        $params = [$follower, $following];

        return $db->save($query, $params);
    }

    public function unfollowUser($follower, $following)
    {
        $db = new Database();

        $query = "DELETE FROM followers WHERE follower = ? AND following = ?";
        $params = [$follower, $following];

        return $db->save($query, $params);
    }

    public function getAllFollowers($user_id)
    {
        $db = new Database();

        $query = "SELECT follower FROM followers WHERE following = ?";
        $params = [$user_id];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            // Fetch all posts data into an array
            $followers = [];
            while ($row = $result->fetch_assoc()) {
                $followers[] = $row;
            }
            return $followers;
        } else {
            // No posts found
            return [];
        }
    }


    public function getAllFollowing($user_id)
    {
        $db = new Database();

        $query = "SELECT following FROM followers WHERE follower = ?";
        $params = [$user_id];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            // Fetch all posts data into an array
            $followings = [];
            while ($row = $result->fetch_assoc()) {
                $followings[] = $row;
            }
            return $followings;
        } else {
            // No posts found
            return [];
        }
    }

    public function isFollowing($follower, $following)
    {
        $db = new Database();

        $query = "SELECT follow_id FROM followers WHERE follower = ? AND following = ?";
        $params = [$follower, $following];

        $result = $db->read($query, $params);

        return $result->num_rows > 0;
    }

    public function countFollowers($user_id)
    {
        $db = new Database();

        $query = "SELECT COUNT(follower) AS follower_count FROM followers WHERE following = ?";
        $params = [$user_id];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data['follower_count'];
        } else {
            return 0;
        }
    }

    public function countFollowing($user_id)
    {
        $db = new Database();

        $query = "SELECT COUNT(following) AS following_count FROM followers WHERE follower = ?";
        $params = [$user_id];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data['following_count'];
        } else {
            return 0;
        }
    }

    public function delete_follow_data($user_id)
    {
        $db = new Database();

        $query = 'DELETE FROM followers WHERE follower = ? OR following = ?';

        $params = [$user_id, $user_id];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }
}
