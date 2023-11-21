<?php
require_once(dirname(__DIR__) .  '\config\database.php');

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register_user($username, $email, $password, $first_name, $last_name, $barangay, $role, $gender)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = 'INSERT INTO users (username, email, password, first_name, last_name, barangay, role, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = [$username, $email, $hashedPassword, $first_name, $last_name, $barangay, $role, $gender];

        $result = $this->db->save($query, $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function login($emailOrUsername, $password)
    {
        $query = 'SELECT id, username, email, password FROM users WHERE email = ? OR username = ?';
        $params = [$emailOrUsername, $emailOrUsername];

        $result = $this->db->read($query, $params);

        if ($result->num_rows === 1) {
            $userData = $result->fetch_assoc();

            if (password_verify($password, $userData['password'])) {
                $_SESSION['user_id'] = $userData['id'];
                unset($userData['password']);
                return $userData;
            }
        }

        return false;
    }

    public function check_login($id, $redirect = true)
    {
        if (is_numeric($id)) {
            $DB = new Database();

            $query = "SELECT * FROM users WHERE id = ?";
            $params = [$id];
            $result = $DB->read($query, $params);

            if ($result && $result->num_rows === 1) {
                $user_data = $result->fetch_assoc();
                return $user_data;
            } else {
                $_SESSION['mybook_userid'] = 0;
            }
        } else {
            $_SESSION['mybook_userid'] = 0;
        }
    }

    public function authenticate($id, $redirect = true)
    {
        if (is_numeric($id)) {
            $DB = new Database();

            $query = "SELECT * FROM users WHERE id = ?";
            $params = [$id];
            $result = $DB->read($query, $params);

            if ($result && $result->num_rows === 1) {
                $user_data = $result->fetch_assoc();
                return $user_data;
            } else {
                if ($redirect) {
                    header("Location: ./login.php");
                    die;
                } else {
                    $_SESSION['mybook_userid'] = 0;
                }
            }
        } else {
            if ($redirect) {
                header("Location: ./login.php");
                die;
            } else {
                $_SESSION['mybook_userid'] = 0;
            }
        }
    }

    public function getLoggedInUserInfo($userId)
    {
        $query = 'SELECT * FROM users WHERE id = ?';
        $params = [$userId];

        $result = $this->db->read($query, $params);

        if ($result && $result->num_rows === 1) {

            $user_data = $result->fetch_assoc();
            return $user_data;
        } else {
            return false;
        }
    }

    public function getUsersByBarangay($barangay)
    {
        $query = 'SELECT * FROM users WHERE barangay = ? AND role != "Member"';
        $params = [$barangay];

        $result = $this->db->read($query, $params);

        if ($result) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return false;
        }
    }

    public function getBarangayUsers($barangay, $user)
    {
        $query = 'SELECT * FROM users WHERE barangay = ? AND id != ?';
        $params = [$barangay, $user];

        $result = $this->db->read($query, $params);

        if ($result) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return false;
        }
    }



    public function updateUserInfo($userId, $first_name, $last_name, $username, $barangay, $role, $gender, $email)
    {
        $query = 'UPDATE users SET first_name = ?, last_name = ?, username = ?, barangay = ?, role = ?, gender = ?, email = ? WHERE id = ?';
        $params = [$first_name, $last_name, $username, $barangay, $role, $gender, $email, $userId];

        $result = $this->db->save($query, $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserBio($userId, $bio)
    {
        $query = 'UPDATE users SET bio = ? WHERE id = ?';
        $params = [$bio, $userId];

        $result = $this->db->save($query, $params);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkExistingUser($username, $email)
    {
        $query = 'SELECT id FROM users WHERE username = ? OR email = ?';
        $params = [$username, $email];

        $result = $this->db->read($query, $params);

        if ($result && $result->num_rows > 0) {
            return true; // Username or email already exists
        } else {
            return false; // Username and email are available
        }
    }

    public function logout()
    {
        session_destroy();

        header("Location: ./index.php");
    }
}
