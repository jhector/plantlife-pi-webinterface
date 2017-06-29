<?php
class AdminController extends BaseController {
    public function indexAction($db, $user) {
        global $twig;

        if (!$user->isAdmin())
            throw new Exception("You don't have the permission to view this site", 1);

        $this->vars['admin'] = $user->isAdmin();
        $this->vars['logged_in'] = $user->isLoggedIn();
        $this->vars['active'] = 'Admin';

        $template = $twig->loadTemplate($this->site.".twig");
        echo $template->render($this->vars);

        exit(0);
    }
}
?>
