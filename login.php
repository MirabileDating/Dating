<?php

require_once 'libs/functions.php';

	if (isset($_SESSION["sessionid"]) && isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
		header("Location: member.php");
		return;
	} else {

		$T = new View('templates/login.tpl');

		$T->loadDefault(0);

		echo $T->display(array('login' => 1,'A1'=>_('Onnea - dating')
		));
	}
?>
