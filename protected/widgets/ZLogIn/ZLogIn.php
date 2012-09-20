<?php
/**
 * Log-in widget
 */
class ZLogIn extends CWidget
{

	public function run()
	{
		$loginFormModel = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($loginFormModel);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm']))
        {
            $loginFormModel->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($loginFormModel->validate() && $loginFormModel->login())
			{
				Yii::app()->controller->redirect(Yii::app()->user->returnUrl);
			}
        }

		$this->render('ZLogIn', array('loginFormModel' => $loginFormModel));
	}
}

?>
