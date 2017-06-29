<?php
class LoginController extends BaseController {
    public function indexAction($db, $user) {
        global $twig;

        if (!isset($_POST['username'], $_POST['password']))
            throw new Exception("Please supply a username and password");

        $username = mysqli_real_escape_string($db->conn, trim($_POST['username']));

        $data = $db->select("*", "user", "WHERE name='$username' LIMIT 1");

        if (empty($data)) {
            $this->vars['message'] = "User does not exist";
        } else {
            $pass = $_POST['password'];
            if (hash("sha256", $pass) === $data[0]['password']) {
                $id = $data[0]['userid'];
                $hash = $data[0]['password'];
                $user->setUser($id, $hash);
                $user->setLoggedIn(1);
                $user->setAdmin($data[0]['admin']);
            } else {
                $this->vars['message'] = "Wrong password";
            }
        }

        $this->vars['admin'] = $user->isAdmin();
        $this->vars['logged_in'] = $user->isLoggedIn();
        $this->vars['active'] = 'Dashboard';

        $template = $twig->loadTemplate("dashboard.twig");
        echo $template->render($this->vars);
        exit(0);
    }

    public function logoutAction($db, $user) {
        global $twig;

        setcookie('user_id', '', time()-3600);
        setcookie('user_hash', '', time()-3600);
        setcookie('user_mac', '', time()-3600);

        $user->setAdmin(0);
        $user->setLoggedIn(0);

        $this->vars['admin'] = $user->isAdmin();
        $this->vars['logged_in'] = $user->isLoggedIn();
        $this->vars['active'] = 'Dashboard';

        $template = $twig->loadTemplate("dashboard.twig");
        echo $template->render($this->vars);

        exit(0);
    }
}
?>
