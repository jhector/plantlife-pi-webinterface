<?php
class Database {
    public $conn;

    public function __construct() {
        global $config;

        $this->conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

        if(mysqli_connect_errno())
            throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    public function exists($table, $condition) {
        global $config;

        $qry = "SELECT id FROM ".$config['db_prefix'].$table." ".$condition;
        $result = mysqli_query($this->conn, $qry);

        if (!$result)
            throw new Exception(mysqli_error($this->conn));

        if (mysqli_num_rows($result) > 0)
            return 1;
        else
            return 0;
    }

    public function select($what, $table, $condition) {
        global $config;

        if (preg_match('/[^a-zA-Z0-9_]information_schema[^a-zA-Z0-9_]/', strtolower($keys)))
            throw new Exception('Operation not allowed');

        $qry = "SELECT $what FROM ".$config['db_prefix'].$table." ".$condition;
        $result = mysqli_query($this->conn, $qry);

        if (!$result)
            throw new Exception(mysqli_error($this->conn));

        $ret = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            array_push($ret, $row);

        return $ret;
    }

    public function insert($table, $data) {
        global $config;

        $keys = array();
        $values = array();
        foreach($data as $key => $value) {
            array_push($keys, $key);
            array_push($values, $value);
        }

        $keys = "(".join(',', $keys).")";
        $values = "(".join(',', $values).")";

        if (preg_match('/[^a-zA-Z0-9_]information_schema[^a-zA-Z0-9_]/', strtolower($keys))) 
            throw new Exception("Operation not allowed");

        if (preg_match('/[^a-zA-Z0-9_]information_schema[^a-zA-Z0-9_]/', strtolower($values)))
            throw new Exception("Operation not allowed");

        $qry = "INSERT INTO ".$config['db_prefix'].$table." $keys VALUES $values";
        $result = mysqli_query($this->conn, $qry);

        if (!$result)
            throw new Exception(mysqli_error($this->conn));

        return mysqli_insert_id($this->conn);
    }

    public function delete($table, $condition) {
        global $config;

        $qry = "DELETE FROM ".$config['db_prefix'].$table." ".$condition;
        $result = mysqli_query($this->conn, $qry);

        if (!$result)
            throw new Exception(mysqli_error($this->conn));

        return true;
    }

    public function update($table, $data, $condition) {
        global $config;

        $set = '';
        $tmp = array();
        foreach($data as $key => $value) {
            array_push($tmp, $key."=".$value);
        }

        $set = join(", ", $tmp);
        $qry = "UPDATE ".$config['db_prefix'].$table." SET $set $condition";
        $result = mysqli_query($this->conn, $qry);

        if (!$result)
            throw new Exception(mysqli_error($this->conn));
    }
}
?>
