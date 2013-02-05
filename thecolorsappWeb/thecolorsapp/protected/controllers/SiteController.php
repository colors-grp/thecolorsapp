<?php

class SiteController extends Controller {

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function actionIndex() {
		// redirect to user main Entry
		$this->redirect('http://colors-studios.com/thecolorsapp/index.php?r=user/mainEntry');
	}
}
