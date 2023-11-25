<?php

class Database
{
    private $db;

    function parseEnv($filePath)
    {
        $env = [];

        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $env[trim($key)] = trim($value);
                }
            }
        }

        return $env;
    }

    public function __construct()
    {
        $envConfig = $this->parseEnv(dirname(__DIR__) . '/.env');

        $host = $envConfig['DB_HOST'];
        $dbname = $envConfig['DB_NAME'];
        $user = $envConfig['DB_USER'];
        $pass = $envConfig['DB_PASS'];

        $this->db = new mysqli($host, $user, $pass, $dbname);

        if ($this->db->connect_error) {
            error_log("Database connection failed: " . $this->db->connect_error);
            die("Database connection failed: " . $this->db->connect_error);
        }
    }

    public function read($query, $params = [])
    {
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            error_log("Query preparation failed: " . $this->db->error);
            return false;
        }

        if (!empty($params)) {
            $paramTypes = '';
            $paramValues = [];

            foreach ($params as $param) {
                if (is_int($param)) {
                    $paramTypes .= 'i';
                } elseif (is_double($param)) {
                    $paramTypes .= 'd';
                } else {
                    $paramTypes .= 's';
                }

                $paramValues[] = $param;
            }

            array_unshift($paramValues, $paramTypes);
            call_user_func_array([$stmt, 'bind_param'], $this->refValues($paramValues));
        }

        $stmt->execute();

        if ($stmt->error) {
            error_log("Query execution failed: " . $stmt->error);
            return false;
        }

        return $stmt->get_result();
    }

    public function save($query, $params = [])
    {
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            error_log("Query preparation failed: " . $this->db->error);
            return false;
        }

        if (!empty($params)) {
            $paramTypes = '';
            $paramValues = [];

            foreach ($params as $param) {
                if (is_int($param)) {
                    $paramTypes .= 'i';
                } elseif (is_double($param)) {
                    $paramTypes .= 'd';
                } else {
                    $paramTypes .= 's';
                }

                $paramValues[] = $param;
            }

            array_unshift($paramValues, $paramTypes);
            call_user_func_array([$stmt, 'bind_param'], $this->refValues($paramValues));
        }

        $stmt->execute();

        if ($stmt->error) {
            error_log("Query execution failed: " . $stmt->error);
            return false;
        }

        return true;
    }

    private function refValues($arr)
    {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
}
