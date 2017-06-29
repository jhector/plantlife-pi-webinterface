<?php
class User {
    public $id;
    public $admin;
    public $hash;
    public $mac;
    public $logged_in;

    public function __construct($db) {
        $this->admin = 0;
        $this->logged_in = 0;

        if (isset($_COOKIE['user_id'], $_COOKIE['user_hash'], $_COOKIE['user_mac'])) {
            $verify = SIGNATURE . $_COOKIE['user_id'] . $_COOKIE['user_hash'];

            if (hash('sha256', $verify) !== $_COOKIE['user_mac']) {
                setcookie('user_id', '', time()-3600);
                setcookie('user_hash', '', time()-3600);
                setcookie('user_mac', '', time()-3600);

                throw new Exception("Cookie has been modified");
            }

            $this->id = $_COOKIE['user_id'];
            $this->hash = $_COOKIE['user_hash'];
            $this->mac = $_COOKIE['user_mac'];
            $this->admin = $db->exists("user", "WHERE userid='".mysqli_real_escape_string($db->conn, $_COOKIE['user_id'])."' AND admin=1 LIMIT 1");
            $this->logged_in = 1;
        }
    }

    public function setUser($id, $hash) {
        $this->id = $id;
        $this->hash = $hash;
        $this->mac = hash('sha256', SIGNATURE . $this->id . $this->hash);

        $this->updateCookie();
    }

    public function updateCookie() {
        setcookie('user_id', $this->id);
        setcookie('user_hash', $this->hash);
        setcookie('user_mac', $this->mac);
    }

    public function getId() {
        return $this->id;
    }

    public function getHash() {
        return $this->hash;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function setAdmin($status) {
        $this->admin = $status;
    }

    public function isLoggedIn() {
        return $this->logged_in;
    }

    public function setLoggedIn($value) {
        $this->logged_in = $value;
    }
}
?>
