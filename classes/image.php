<?php
require_once(dirname(__DIR__) .  '\config\database.php');

class Images
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserProfileImage($id, $gender)
    {
        $query = 'SELECT image_src FROM posts WHERE author = ? AND post_type = "Profile" ORDER BY created_at DESC LIMIT 1';
        $params = [$id];

        $result = $this->db->read($query, $params);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['image_src'];
        } else {
            if ($gender === 'male') {
                return './assets/user_male.jpg'; // Default male image
            } else {
                return  './assets/user_female.jpg'; // Default female image
            }
        }
    }

    public function getUserProfileImages($id)
    {
        $query = 'SELECT image_src FROM posts WHERE author = ? AND post_type = "Profile" ORDER BY created_at DESC';
        $params = [$id];

        $result = $this->db->read($query, $params);

        $profileImages = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $profileImages[] = $row['image_src'];
            }
        }

        return $profileImages;
    }

    public function countUserProfileImages($id)
    {
        $query = 'SELECT COUNT(*) AS image_count FROM posts WHERE author = ? AND post_type = "Profile"';
        $params = [$id];

        $result = $this->db->read($query, $params);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['image_count'];
        } else {
            return 0;
        }
    }

    public function deleteProfileImage($user_id, $image_src)
    {
        $query = "DELETE FROM posts WHERE author = ? AND post_type = 'Profile' AND image_src = ?";
        $params = [$user_id, $image_src];

        return $this->db->save($query, $params);
    }
}
