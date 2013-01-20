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
		// if user logined as admin
		if (Yii::app()->user->isAdmin())
		{
			$user->students = User::model()->students()->findAll();
			$user->teachers = User::model()->teachers()->findAll();
			$this->render('index-admin', array(
				'user'=>$user,
			));
		}
		else
		{
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
			else
			{
				// select all taken courses
				$takenCourses = User::model()->findByPk(Yii::app()->user->id)->getTakenCourses();

				// select a number of chapters in each course
				$maxContentReader	= Yii::app()->db->createCommand()
					->select('c.course_id, COUNT(c.course_id) as num')
					->from('content c')
					->leftjoin('student_course sc', 'c.course_id=sc.course_id')
					->where('sc.user_id=:uid', array(':uid' => Yii::app()->user->id))
					->group('c.course_id')
					->query();
				$maxContent = array();
				while (($row = $maxContentReader->read()) !== false)
				{
					$maxContent[$row['course_id']] = $row['num'];
				}

				// classify completed and inprogress courses
				$completedCourses = array();
				$inprogressCourses = array();
				foreach ($takenCourses as $takenCourse)
				{
					$maxChapter = $maxContent[$takenCourse['id']];
					$takenCourse['numChapter'] = $maxChapter;

					if ($takenCourse['chapter_progress'] >= $maxChapter)
					{
						$completedCourses[] = $takenCourse;
					}
					else
					{
						$inprogressCourses[] = $takenCourse;
					}
				}

				// renders the view file 'protected/views/site/dashboard.php'
				// using the default layout 'protected/views/layouts/main.php'
				$this->render('dashboard', array(
						'inprogressCourses' => $inprogressCourses,
						'completedCourses' => $completedCourses,
				));	


			}
		}
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
