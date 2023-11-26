<?php
class Comments

{
    public function updateComment($comment_id, $comment_content, $image_src)
    {
        $db = new Database();

        if ($image_src == "") {
            $query = 'UPDATE comments SET comment_content = ? WHERE comment_id = ?';
            $params = [$comment_content, $comment_id];
        } else if ($image_src == "removed") {
            $query = 'UPDATE comments SET comment_content = ?, image_src = ? WHERE comment_id = ?';
            $params = [$comment_content, "", $comment_id];
        } else {
            $query = 'UPDATE comments SET comment_content = ?, image_src = ? WHERE comment_id = ?';
            $params = [$comment_content, $image_src, $comment_id];
        }

        $result = $db->save($query, $params);

        if ($result) {
            return true;
        }

        return false;
    }

    public function get_last_comment()
    {
        $db = new Database();

        $query = 'SELECT * FROM comments ORDER BY created_at DESC LIMIT 1';

        $result = $db->read($query);

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function get_parent_post_of_comment($comment_id)
    {
        $db = new Database();

        $query = 'SELECT parent_post FROM comments WHERE comment_id = ?';
        $params = [$comment_id];

        $result = $db->read($query, $params);

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            return $data['parent_post'];
        } else {
            // Comment not found or error occurred
            return null;
        }
    }

    public function createComment($post_id, $comment_author, $comment_content, $image_src = null)
    {
        $db = new Database();

        // Prepare and execute the SQL query to insert a new comment
        $query = 'INSERT INTO comments (parent_post, comment_author, comment_content, image_src, created_at)
                  VALUES (?, ?, ?, ?, NOW())';

        // Bind the parameters
        $params = [$post_id, $comment_author, $comment_content, $image_src];

        $result = $db->save($query, $params);

        if ($result) {
            // Comment created successfully
            return true;
        }

        // Comment creation failed
        return false;
    }

    public function get_comment($comment_id)
    {
        $db = new Database();

        $query = 'SELECT * FROM comments WHERE comment_id = ?';
        $params = [$comment_id];

        $result = $db->read($query, $params);

        if ($result->num_rows === 1) {
            // Fetch the post data
            $post = $result->fetch_assoc();
            return $post;
        } else {
            // Post not found
            return null;
        }
    }

    public function get_comments($parent_post)
    {
        $db = new Database();

        $query = 'SELECT * FROM comments WHERE parent_post = ?';
        $params = [$parent_post];

        $result = $db->read($query, $params);

        if ($result->num_rows > 0) {

            $comments = [];
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
            return $comments;
        } else {

            return [];
        }
    }

    public function getCommentsWithLikes($post_id)
    {
        $db = new Database();

        $query = 'SELECT comments.*, users.first_name, users.last_name, users.role, users.gender, users.barangay, COUNT(likes.like_id) as like_count
                  FROM comments
                  LEFT JOIN likes ON comments.comment_id = likes.related_to AND likes.like_type = "comment"
                  LEFT JOIN users ON comments.comment_author = users.id
                  WHERE comments.parent_post = ?
                  GROUP BY comments.comment_id
                  ORDER BY comments.created_at ASC';

        // Bind the parameter
        $params = [$post_id];

        $result = $db->read($query, $params);

        if ($result) {
            $comments = [];

            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }

            return $comments;
        }

        return [];
    }

    public function delete_comment($comment_id, $comment_author)
    {
        $db = new Database();

        $query = 'DELETE FROM comments WHERE comment_id = ? AND comment_author = ?';

        $params = [$comment_id, $comment_author];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }

    public function delete_comments($parent_post)
    {
        $db = new Database();

        $query = 'DELETE FROM comments WHERE parent_post = ?';

        $params = [$parent_post];

        return $db->save($query, $params);
    }

    public function deleteCommentsByAuthor($comment_author)
    {
        $db = new Database();

        $query = 'DELETE FROM comments WHERE comment_author = ?';
        $params = [$comment_author];

        $result = $db->save($query, $params);

        return $result ? true : false;
    }
}
