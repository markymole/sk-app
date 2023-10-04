<?php
class Comments

{
    public function updateComment($comment_id, $comment_content, $image_src)
    {
        $db = new Database();

        if ($image_src == "") {
            $query = 'UPDATE comments SET comment_content = ? WHERE comment_id = ?';
            $params = [$comment_content, $comment_id];
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

    public function getCommentsWithLikes($post_id)
    {
        $db = new Database();

        $query = 'SELECT comments.*, users.first_name, users.last_name, users.role, users.gender, users.barangay, COUNT(likes.like_id) as like_count
                  FROM comments
                  LEFT JOIN likes ON comments.comment_id = likes.related_to AND likes.like_type = "comment"
                  LEFT JOIN users ON comments.comment_author = users.id
                  WHERE comments.parent_post = ?
                  GROUP BY comments.comment_id
                  ORDER BY comments.created_at DESC';

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
}
