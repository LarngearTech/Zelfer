<?php
/**
 * Sign-up widget
 */
class ZSignUp extends CWidget
{
	// $courseId used for course subscription
	public $courseId;
	
	// $returnUrl used to redirect to course/view page after signing up
	public $returnUrl;

	public function run()
	{
		$userModel = new User;

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'signup-form')
		{
			echo CActiveForm::validate($userModel);
			Yii::app()->end();
		}

		if (isset($_POST['User']))
		{
			$userModel->attributes = $_POST['User'];

			// Default role is normal user
			$userModel->role = Yii::app()->params['normal_user'];

			// Default status is active
			$userModel->status = Yii::app()->params['active_status'];
			if ($userModel->save())
			{
				// auto log-in after registration
				if (Yii::app()->user->isGuest)
				{
					$identity = new UserIdentity($userModel->email, $_POST['User']['password']);
					$identity->authenticate();
					if($identity->errorCode === UserIdentity::ERROR_NONE)
					{
						$duration = 0; // no remember
						Yii::app()->user->login($identity, $duration);

						// subscribe to $courseId
						if (isset($_POST['courseId']))
						{
							$sqlStatement = 'INSERT INTO student_course VALUE(NULL, '.$userModel->id.', '.$_POST['courseId'].')';
							$command = Yii::app()->db->createCommand($sqlStatement);
							$command->execute();
						}

						// redirect to the page before registration
						if (isset($_POST['returnUrl']))
						{
							Yii::app()->controller->redirect($_POST['returnUrl']);
						}
					}
					else
					{
						// show error here
					}
				}
				else
				{
					//Yii::app()->controller->redirect(array('view', 'id' => $userModel->id));
					Yii::app()->controller->redirect(array('site/index'));
				}
			}
		}
		$this->render('ZSignUp', array(
			'userModel' => $userModel, 
			'courseId' => $this->courseId,
			'returnUrl' => $this->returnUrl,
		));
	}
}
