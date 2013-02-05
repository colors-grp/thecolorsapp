<?php
/**
  * Error Controller is a class to handel errors (i.e access wrong page)
  */
class ErrorController extends Controller
{
	/**
      * This method called when user access page when he isn't logged in 
      *
      * @param string $description A text with a maximum of 80 characters.
      *
      * @return void
      */
	public function actionFaildUserID()
	{
		$this->render('faildUserID');
	}
}
?>