<?php
require_once(dirname(__DIR__) .  '\config\database.php');

class Uploads
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addCommentImage($user_id)
    {
        $unique_filename = $this->generateUniqueFilename($_FILES['comment_image']['name']);
        $user_posts_directory = "./storage/uploads/$user_id";

        if (!file_exists($user_posts_directory)) {
            mkdir($user_posts_directory, 0777, true);
        }

        $image_path = "$user_posts_directory/$unique_filename";

        if (move_uploaded_file($_FILES['comment_image']['tmp_name'], $image_path)) {
            return $image_path;
        } else {
            return false;
        }
    }

    public function uploadProfilePicture($user_id)
    {
        if (isset($_FILES['profile_image'])) {
            $unique_filename = $this->generateUniqueFilename($_FILES['profile_image']['name']);
            $user_profile_directory = "./storage/profile_pictures/$user_id";

            if (!file_exists($user_profile_directory)) {
                mkdir($user_profile_directory, 0777, true);
            }

            $image_path = "$user_profile_directory/$unique_filename";

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path)) {
                return $image_path;
            }
        }

        return false; // File upload failed or no file was uploaded
    }

    public function updateCommentImage($user_id, $post_id)
    {
        $query = 'SELECT image_src FROM comments WHERE comment_id = ? LIMIT 1';
        $params = [$post_id];
        $result = $this->db->read($query, $params);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $old_image_path = $row['image_src'];

            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            $unique_filename = $this->generateUniqueFilename($_FILES['commentImage']['name']);
            $user_posts_directory = "./storage/uploads/$user_id";

            if (!file_exists($user_posts_directory)) {
                mkdir($user_posts_directory, 0777, true);
            }

            $image_path = "$user_posts_directory/$unique_filename";

            // Move the uploaded new image to the specified path
            if (move_uploaded_file($_FILES['commentImage']['tmp_name'], $image_path)) {
                // Return the new image path
                return $image_path;
            }
        }

        // If any error occurs, return false
        return false;
    }

    public function addPostImage($user_id)
    {
        $unique_filename = $this->generateUniqueFilename($_FILES['post_image']['name']);
        $user_posts_directory = "./storage/uploads/$user_id";

        if (!file_exists($user_posts_directory)) {
            mkdir($user_posts_directory, 0777, true);
        }

        $image_path = "$user_posts_directory/$unique_filename"; // Define the image path

        // Move the uploaded image to the specified path
        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $image_path)) {
            return $image_path; // Return the file path if image saved successfully
        } else {
            return false; // File upload failed
        }
    }

    public function updatePostImage($user_id, $post_id)
    {
        $query = 'SELECT image_src FROM posts WHERE post_id = ? LIMIT 1';
        $params = [$post_id];
        $result = $this->db->read($query, $params);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $old_image_path = $row['image_src'];

            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            $unique_filename = $this->generateUniqueFilename($_FILES['new_post_image']['name']);
            $user_posts_directory = "./storage/uploads/$user_id";

            if (!file_exists($user_posts_directory)) {
                mkdir($user_posts_directory, 0777, true);
            }

            $image_path = "$user_posts_directory/$unique_filename";

            // Move the uploaded new image to the specified path
            if (move_uploaded_file($_FILES['new_post_image']['tmp_name'], $image_path)) {
                // Return the new image path
                return $image_path;
            }
        }

        // If any error occurs, return false
        return false;
    }


    private function generateUniqueFilename($original_filename)
    {
        $extension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $unique_filename = time() . '_' . substr(md5(uniqid()), 0, 10) . '.' . $extension;
        return $unique_filename;
    }
}
