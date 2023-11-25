<?php
require_once(dirname(__DIR__) .  '\config\database.php');

class Posts
{
    function create_post($content, $image_src, $origin, $author)
    {
        $db = new Database();

        $post_type = "Announcement";

        $query = 'INSERT INTO posts (post_content, post_type, image_src, author_barangay, author, created_at) VALUES (?, ?, ?, ?, ?, NOW())';

        $params = [$content, $post_type, $image_src, $origin, $author];

        $result = $db->save($query, $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_post($post_id, $content, $image_src)
    {
        $db = new Database();

        $query = 'UPDATE posts SET post_content = ?, image_src = ? WHERE post_id = ?';

        $params = [$content, $image_src, $post_id];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }

    public function delete_post($post_id, $author)
    {
        $db = new Database();

        $query = 'DELETE FROM posts WHERE post_id = ? AND author = ?';

        $params = [$post_id, $author];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }

    public function get_all_posts()
    {
        $db = new Database();

        $query = 'SELECT * FROM posts';

        $result = $db->read($query);

        if ($result->num_rows > 0) {
            $posts = [];
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            return $posts;
        } else {
            return [];
        }
    }

    function update_profile($image_src, $author, $post_type)
    {
        $db = new Database();

        $query = 'INSERT INTO posts (post_content, image_src, author, post_type, created_at) VALUES (?, ?, ?, ?, NOW())';

        $content = '';

        $params = [$content, $image_src, $author, $post_type];

        $result = $db->save($query, $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_posts_by_barangay($barangay)
    {
        $db = new Database();

        $query = "SELECT posts.*, users.first_name, users.last_name, users.barangay, users.role, users.gender,
                        (SELECT COUNT(*) FROM likes WHERE like_type = 'post' AND related_to = posts.post_id) AS like_count,
                        (SELECT COUNT(*) FROM comments WHERE parent_post = posts.post_id) AS comment_count
                  FROM posts
                  INNER JOIN users ON posts.author = users.id
                  WHERE posts.author_barangay = ? AND posts.post_type != 'Profile'
                  ORDER BY created_at DESC";

        $params = [$barangay];

        $result = $db->read($query, $params);

        if ($result) {
            if ($result->num_rows > 0) {
                $posts = [];
                while ($row = $result->fetch_assoc()) {
                    $posts[] = $row;
                }
                return $posts;
            }
        }
        return [];
    }

    public function get_last_post()
    {
        $db = new Database();

        $query = 'SELECT * FROM posts ORDER BY created_at DESC LIMIT 1';

        $result = $db->read($query);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function get_all_posts_with_author_info()
    {
        $db = new Database();

        $query = 'SELECT posts.*, users.first_name, users.last_name, users.barangay, users.role, users.gender,
                             (SELECT COUNT(*) FROM likes WHERE like_type = "post" AND related_to = posts.post_id) AS like_count,
                             (SELECT COUNT(*) FROM comments WHERE parent_post = posts.post_id) AS comment_count
              FROM posts
              INNER JOIN users ON posts.author = users.id
              WHERE posts.post_type != "Profile"
              ORDER BY created_at DESC';

        $result = $db->read($query);

        if ($result->num_rows > 0) {
            $posts = [];
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            return $posts;
        } else {
            return [];
        }
    }

    public function get_post($id)
    {
        $db = new Database();

        $query = 'SELECT * FROM posts WHERE post_id = ?';
        $params = [$id];

        $result = $db->read($query, $params);

        if ($result->num_rows === 1) {
            $post = $result->fetch_assoc();
            return $post;
        } else {
            return null;
        }
    }

    public function get_post_with_likes($post_id)
    {
        $db = new Database();

        $query = 'SELECT posts.*, users.first_name, users.last_name, users.barangay, users.role, users.gender,
                 COUNT(likes.like_id) AS num_likes,
                 (SELECT COUNT(*) FROM comments WHERE parent_post = posts.post_id) AS num_comments
              FROM posts
              INNER JOIN users ON posts.author = users.id
              LEFT JOIN likes ON posts.post_id = likes.related_to AND likes.like_type = "post"
              WHERE posts.post_id = ?
              GROUP BY posts.post_id';

        $params = [$post_id];

        $result = $db->read($query, $params);

        if ($result->num_rows === 1) {
            $post = $result->fetch_assoc();
            return $post;
        } else {
            return null;
        }
    }

    public function delete_posts_by_author($author_id)
    {
        $db = new Database();

        $query = 'DELETE FROM posts WHERE author = ?';

        $params = [$author_id];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }
}
