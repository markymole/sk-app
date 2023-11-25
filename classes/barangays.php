<?php
class Barangays
{
    public function getAllBarangays()
    {
        $db = new Database();

        $query = 'SELECT * FROM barangays';

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

    public function getBarangaySecret($barangay_name)
    {
        $db = new Database();

        $query = 'SELECT secret_key FROM barangays WHERE name = ?';
        $params = [$barangay_name];

        $result = $db->read($query, $params);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['secret_key'];
        } else {
            return null;
        }
    }
}
