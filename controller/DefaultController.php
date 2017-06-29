<?php
class DefaultController extends BaseController {
    public function indexAction($db, $user) {
        global $twig;

        $this->vars['admin'] = $user->isAdmin();
        $this->vars['logged_in'] = $user->isLoggedIn();
        $this->vars['active'] = 'Dashboard';

        $template = $twig->loadTemplate($this->site.".twig");
        echo $template->render($this->vars);

        exit(0);
    }
}
?>
