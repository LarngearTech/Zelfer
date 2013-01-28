<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// First page for guest
		if (Yii::app()->user->isGuest)
		{
			Yii::app()->clientScript->registerScript('placeholder','$("input[placeholder]").placeholder();',CClientScript::POS_END);

			$categories = Category::model()->findAll();

			// load all courses of each catgegory to display
			$courses_in_categories = array();
			foreach ($categories as $category) {
				$courses_in_categories[$category->id] = Course::model()->category($category->id)->status('publish')->findAll();
			}

	 		// renders the view file 'protected/views/site/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			$this->render('index', array(
					'categories' => $categories,
					'courses_in_categories' => $courses_in_categories,
			));
		}
		else // First page for logged in users
		{
			if (Yii::app()->user->isAdmin())
			{
				$this->redirect(array('site/admin'));
			}
			else
			{
				$this->redirect(array('user/dashboard'));
			}
		}	
	}

	/**
	 * Controller for administrator
	 */
	public function actionAdmin()
	{
		$users->students = User::model()->students()->findAll();
		$users->teachers = User::model()->teachers()->findAll();
		$userGroups = UserGroup::model()->findAll();

		$userMenu 		= array('id' => '1', 'name' => 'User', 'isGroupHeading' => true);
		$addUserMenu 	= array('id' => '2', 'name' => 'Add User', 'isGroupHeading' => false);
		$manageUserMenu	= array('id' => '3', 'name' => 'Manage User', 'isGroupHeading' => false);
		$courseMenu 	= array('id' => '4', 'name' => 'Course', 'isGroupHeading' => true);
		$addCourseMenu 	= array('id' => '5', 'name' => 'Add Course', 'isGroupHeading' => false);
		$manageCourseMenu = array('id' => '6', 'name' => 'Manage Course', 'isGroupHeading' => false);
		$settingMenu 	= array('id' => '7', 'name' => 'Setting', 'isGroupHeading' => true);
		$adminPwdMenu	= array('id' => '8', 'name' => 'Admin Password', 'isGroupHeading' => false);

		$menus = array($userMenu, $addUserMenu, $manageUserMenu, $courseMenu, $addCourseMenu, $manageCourseMenu, $settingMenu, $adminPwdMenu);
		$this->render('admin/index', array(
			'menus' => $menus,
			'users' => $users,
			'userGroups' => $userGroups,
		));		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->render('login');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
