<?php
class AdminController extends BaseController {
	public function indexAction($db, $user) {
		global $twig;

		$this->vars['admin'] = $user->isAdmin();
		$this->vars['active'] = 'Admin';

		$template = $twig->loadTemplate($this->site.".twig");
		echo $template->render($this->vars);

		exit(0);
	}
}
?>
