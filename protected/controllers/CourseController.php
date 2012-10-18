<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index','view','inclass'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'changeCourseInfo', 'instructorList', 'editInstructor', 'changeVideo', 'changeIntroVideo', 'myCourse', 'changeThumbnail', 'publish', 'unpublish', 'delete', 'addInstructor', 'deleteInstructor', 'addLecture', 'addChapter', 'changeContentOrder'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin'),
				'users' => array('admin'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		// get all chapters of a specified course id 
		// with all corresponding lectures
		$contents = Content::model()->findAll(
				'course_id=:courseID', 
				array(
					':courseID'=>$id
				));
		$this->render('view',array(
			'model' => $this->loadModel($id),
			'contents' => $contents,
		));
	}

	/**
	 * Displays a class view if a user has already taken the course.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionInclass($id)
	{
		// get all chapters of a specified course id 
		// with all corresponding lectures
		$chapters = Chapter::model()->with('lectures')->findAll('course_id=:courseID', array(':courseID'=>$id));
		$this->render('in_class',array(
			'model' => $this->loadModel($id),
			'chapters' => $chapters,
		));
	}
	
	/*
	 * Change lecture video
	 */
	public function actionChangeVideo($videoId)
	{
		$model = Course::model()->findByPk($videoId);
		$this->widget('IntroVideoPlayer', array('course'=>$model));
	}

	
	/**
	 * Display user's learn courses and teach courses
	 * @param integer $uid user's id
	 */
	function actionMyCourse($uid)
	{
		$userModel = User::model()->findByPk($uid);

		$this->render('myCourse', 
			array(
			'userModel' => $userModel,
		));
	}


	/**
	 * Change course's intro video
	 * @param integer $courseId
	 */
	function actionChangeIntroVideo($courseId)
	{
		$course = Course::model()->findByPk($courseId);

		if ($course)
		{
			Yii::import("application.widgets.EAjaxUpload.qqFileUploader");
 
			$folder=ResourcePath::getIntroVideoBasePath();
			$sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
			$allowedExtensions = array("avi", "mpeg", "mov","mp4");
			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
			$result = $uploader->handleUpload($folder);
 
			$fileSize=filesize($folder.$result['filename']);
			$fileName=$result['filename'];

			// Replace previous intro video with the current one
			if (!empty($course->intro_url))
			{
				$introVideoPath = $folder.$course->intro_url;
				if (file_exists($introVideoPath))
				{
					shell_exec('rm -rf '.$introVideoPath);
				}
			}
			$newName = uniqid().'.'.PHPHelper::getFileExtension($fileName);
			rename($folder.$fileName, $folder.$newName);
			// Convert file to x264 using ffmpeg
			$baseName = VideoUtil::encode($folder.$newName, $folder);
				
			$course->intro_url = $baseName;
			if($course->save()){
				$result['html'] = $this->widget('IntroVideoPlayer', 
							array('course'=>$course),
							true);
				$return = json_encode($result);
				echo $return;
			}
		}
		else
		{
			throw CException('Cannot not update database');
		}
	}


	/*
	 * Change course's thumbnail
	 */
	function actionChangeThumbnail($courseId)
	{
		$course = Course::model()->findByPk($courseId);

		if ($course)
		{
			Yii::import("application.widgets.EAjaxUpload.qqFileUploader");
 
			$folder=ResourcePath::getCourseThumbnailBasePath();
			$sizeLimit = 256 * 1024;// maximum file size in bytes
			$allowedExtensions = array("jpg", "jpeg", "bmp", "gif", "png");
			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
			$result = $uploader->handleUpload($folder);
 
			$fileSize=filesize($folder.$result['filename']);
			$fileName=$result['filename'];

			// Replace previous thumbnail with the current one
			if (!empty($course->thumbnail_url))
			{
				$thumbnailPath = $folder.PHPHelper::getFileFullName($course->thumbnail_url);
				if (file_exists($thumbnailPath))
				{
					unlink($thumbnailPath);
				}
			}
			$newname = uniqid().'.'.PHPHelper::getFileExtension($fileName);
			rename($folder.$fileName, $folder.$newname);
			$course->thumbnail_url = ResourcePath::getCourseThumbnailBaseUrl().$newname;
			if($course->save()){
				$result['html'] = $this->widget('CourseThumbnail', 
							array('course'=>$course),
						true);
				$return = json_encode($result);
				echo $return;
			}
			else
			{
				throw CException('Cannot not update database');
			}
		}
 
	}


	/**
	 * Publish course.
	 */
	public function actionPublish($courseId)
	{
		$model = $this->loadModel($courseId);
		if ($model){
			$model->publish();
			$this->redirect(array('site/index'));
		}
	}


	/**
	 * Unpublish course.
	 */
	public function actionUnpublish($courseId)
	{
		$model = $this->loadModel($courseId);
		if ($model){
			$model->unpublish();
			$this->redirect(array('site/index'));
		}
	}

	/**
	 * @return list of pair of $user->id, $user->fullname for CJuiAutoComplete.
	 */
	public function actionInstructorList()
	{
		// Query all instructor
		if (Yii::app()->request->isAjaxRequest && !empty($_GET['term']))
		{
			$instructorList = array();
			$keyword = addcslashes($_GET['term'], '%_');

			$data = User::model()->findAll(array('condition' => "fullname LIKE '%$keyword%'"));

			foreach ($data as $instructor)
			{
				$instructorList[] = array('id'=>$instructor->id,
							'label'=>$instructor->fullname, 
							'value'=>$instructor->fullname);
			}
			echo CJSON::encode($instructorList);
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Course;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->owner_id=Yii::app()->user->id;
				$model->save();
				$user = User::model()->findByPk(Yii::app()->user->id);
				$user->addTeachCourse($model->id);
				$transaction->commit();

				$this->redirect(array('update','courseId'=>$model->id));
			}
			catch (Exception $e) {
				$transaction->rollback();
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'categoryList'=>$this->categoryList(),
		));
	}


	public function actionUpdate($courseId)
	{
		$model=$this->loadModel($courseId);
		$this->render('update', array(
			'model'=>$model,
			'categoryList'=>$this->categoryList(),
		)); 
	}

	
	/**
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChangeCourseInfo($courseId)
	{
		$model=$this->loadModel($courseId);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			if($model->save()){
				echo $this->widget('CourseThumbnail', array('course'=>$model), true);
			}
		}
	}

	
	/**
	 * Modify list of instructor
	 */
	public function actionEditInstructor($courseId)
	{
		$model = $this->loadModel($courseId);
		if(isset($_POST['instructorIdList']))
		{
			foreach ($_POST['instructorIdList'] as $instructorId)
			{
				// Save instructor
				$sqlStatement = 'INSERT INTO instructor_course VALUES(NULL, '.$instructorId.', '.$courseId.',"","")';				
				$command=Yii::app()->db->createCommand($sqlStatement);
				$command->execute();
			}
			$this->redirect( array('update',
					'courseId'=>$courseId,
			));
		}

		$this->render('editInstructor',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($courseId)
	{
		$this->loadModel($courseId)->delete();
		$this->redirect(array('site/index'));
	}


	/**
	 * Add instructor specified by instructorId to list of instructor
	 * specified by courseId
	 */
	public function actionAddInstructor()
	{
		$courseId = $_POST['courseId'];
		if(Yii::app()->request->isAjaxRequest)
		{
			$instructorId = $_POST['instructorId'];

			// Check that instructorId is not existed for courseId
			$sqlStatement = 'SELECT count(*) 
					 FROM instructor_course 
					 WHERE course_id='.$courseId.' AND user_id='.$instructorId;
			$rows = Yii::app()->db->createCommand($sqlStatement)->queryAll();
			if ($rows[0]['count(*)'] == 0)
			{
				// Insert new record to instructor_course table
				$instructor = new User();
				$instructor->id = $instructorId;
				$instructor->addTeachCourse($courseId);
			}
		}
		$course = Course::model()->findByPk($courseId);
		$this->widget('EditableInstructorList', 
			array(
			'course'=>$course,
			'deleteInstructorHandler'=>$this->createUrl('course/deleteInstructor'),
			'update'=>'#instructor-list-container',
		));
	}


	/**
	 * Delete instructor specified by instructorId from course specified by courseId
	 */
	public function actionDeleteInstructor()
	{
		$courseId = $_POST['courseId'];
		if(Yii::app()->request->isAjaxRequest)
		{
			$instructorId = $_POST['instructorId'];
			$instructor = new User();
			$instructor->id = $instructorId;
			$instructor->removeTeachCourse($courseId);
		}
		$course = Course::model()->findByPk($courseId);
		$this->widget('EditableInstructorList',
			array(
			'course'=>$course,
			'deleteInstructorHandler'=>$this->createUrl('course/deleteInstructor'),
			'update'=>'#instructor-list-container',
		));
	}


	public function actionAddLecture()
	{
	}

	public function actionAddChapter()
	{
	}

	public function actionChangeContentOrder()
	{
		print_r($_POST);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Course');
		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Course('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Course']))
			$model->attributes = $_GET['Course'];

		$this->render('admin',array(
			'model' => $model,
		));
	}

	/**
	 * Subscribe to course.
	 */
	public function actionSubscribe($id)
	{
		echo $id;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Course::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	 * Return Array array list of mapping between category->id and categoryName
	 */
	private function categoryList()
	{
		// Query all category
		$categoryList = array();
		$data = Category::model()->findAll();
		foreach ($data as $category)
		{
			$categoryList[$category->id] = $category->name;
		}
		return $categoryList;
	}

		
	private function saveIntro($intro, $courseId)
	{
		// Validate courseId
		$course = $this->loadModel($courseId);
		if ($course)
		{
			// make the directory to store the thumbnail
			$path = $course->getResourcePath();
			if(!is_dir($path)) 
			{
				mkdir($path, 0775, true);
			}
			else
			{	
				// remove all previous thumbnail
				system("rm intro*");
			}

			$inputPath = "$path/input"; 
			if ($intro)
			{
				// make the directory to store the intro file
				if(!is_dir($inputPath)) 
				{
					mkdir($inputPath, 0775, true);
				}
				else
				{	
					// reset all encoding state
					if(file_exists("$path/video_complete.txt")) 
					{
						system("rm -rf \"$path/video_complete.txt\"");
					}
					$FID=fopen("$path/video_encoding.txt",'w');	fclose($FID);
				}

				if ($intro)
				{
					$ext = end(explode('.', $intro->name));
					$intro->saveAs("$inputPath/intro.$ext");
					// create a directory to store temporaly encoding data
					$rand = rand();
					$encodingPath = $path."/.encoding_{$rand}";
					mkdir($encodingPath, 0775, true);
	
					$scriptPath = Yii::app()->basePath."/scripts";
					$pipelinePath = "$scriptPath/bin";
					system("perl $scriptPath/encode.pl \"$inputPath\" \"$encodingPath\" \"$path\" \"$pipelinePath\" openclassroom y n n >/dev/null 2>/dev/null &");
				}
			}
		}	
		else
		{
			throw new CHttpException(500, "couseId was invalid");
		}	
	}
}
