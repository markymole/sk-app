<?php
class Likes
{
    public function insertLike($user_id, $like_type, $related_to)
    {
        $db = new Database();

        $existingLikeQuery = 'SELECT * FROM likes WHERE like_from = ? AND like_type = ? AND related_to = ?';
        $existingLikeParams = [$user_id, $like_type, $related_to];
        $existingLikeResult = $db->read($existingLikeQuery, $existingLikeParams);

        if ($existingLikeResult && $existingLikeResult->num_rows > 0) {
            return false;
        }

        $insertLikeQuery = 'INSERT INTO likes (like_from, like_type, related_to, created_at) VALUES (?, ?, ?, NOW())';
        $insertLikeParams = [$user_id, $like_type, $related_to];
        $insertLikeResult = $db->save($insertLikeQuery, $insertLikeParams);

        if ($insertLikeResult) {
            return true;
        }
        return false;
    }
    public function deleteLike($user_id, $like_type, $related_to)
    {
        $db = new Database();

        $existingLikeQuery = 'SELECT * FROM likes WHERE like_from = ? AND like_type = ? AND related_to = ?';
        $existingLikeParams = [$user_id, $like_type, $related_to];
        $existingLikeResult = $db->read($existingLikeQuery, $existingLikeParams);

        if ($existingLikeResult && $existingLikeResult->num_rows > 0) {
            $deleteLikeQuery = 'DELETE FROM likes WHERE like_from = ? AND like_type = ? AND related_to = ?';
            $deleteLikeParams = [$user_id, $like_type, $related_to];
            $deleteLikeResult = $db->save($deleteLikeQuery, $deleteLikeParams);

            if ($deleteLikeResult) {
                return true;
            }
        }

        return false;
    }

    public function deleteAllLikesByUser($user_id)
    {
        $db = new Database();

        $deleteLikesQuery = 'DELETE FROM likes WHERE like_from = ?';
        $deleteLikesParams = [$user_id];
        $deleteLikesResult = $db->save($deleteLikesQuery, $deleteLikesParams);

        if ($deleteLikesResult) {
            return true;
        }
        return false;
    }
}
