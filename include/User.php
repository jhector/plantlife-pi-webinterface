<?php
class User {
    public $id;
    public $admin;
    public $hash;
    public $mac;

    public function __construct($db) {
        if (!isset($_COOKIE['user_id'], $_COOKIE['user_hash'], $_COOKIE['user_mac'])) {
            $this->admin = 0;
            $this->id = random(16);
            $this->hash = sha1($this->id);
            $this->bugs = array();
            $this->mac = sha1(SIGNATURE . $this->id . $this->hash);

            setcookie('user_id', $this->id);
            setcookie('user_hash', $this->hash);
            setcookie('user_mac', $this->mac);
        } else {
            $verify = SIGNATURE . $_COOKIE['user_id'] . $_COOKIE['user_hash'];

            if (sha1($verify) != $_COOKIE['user_mac']) {
                setcookie('user_id', '', time()-3600);
                setcookie('user_hash', '', time()-3600);
                setcookie('user_mac', '', time()-3600);
                throw new Exception("Cookie has been modified");
            }

            $this->id = $_COOKIE['user_id'];
            $this->hash = $_COOKIE['user_hash'];
            $this->mac = $_COOKIE['user_mac'];
            $this->admin = $db->exists("user", "WHERE userid='".mysqli_real_escape_string($db->conn, $_COOKIE['user_id'])."' AND admin=1 LIMIT 1");
        }
    }

    public function setUser($id, $hash) {
        $this->id = $id;
        $this->hash = $hash;
        $this->mac = sha1(SIGNATURE . $this->id . $this->hash);

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
}
?>
