<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @var string location of thumbnail of this course.
	 */
	protected $_thumbnailUrl;
	/**
	 * @var string location of introduction of this course.
	 */
	protected $_introUrl;

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
				'actions' => array('create', 'update', 'instructorList', 'editInstructor'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin','delete'),
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
		$chapters = Chapter::model()->with('lectures')->findAll('course_id=:courseID', array(':courseID'=>$id));
		$this->render('view',array(
			'model' => $this->loadModel($id),
			'chapters' => $chapters,
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
			if($model->save())
			{
				$thumbnails = CUploadedFile::getInstancesByName('thumbnails');
				
				// Each course can has one and only one thumbnail and intro video.
				// We use CMultipleFileUploader only to allow user to remove incorrect file before submitting.
				if (isset($thumbnails) && count($thumbnails)===1)
				{
					foreach ($thumbnails as $key=>$thumbnail)
					{
						$this->saveThumbnail($thumbnail, $model->id);
					}
				}

				$intros = CUploadedFile::getInstancesByName('introductions');
				if (isset($intros) && count($intros)===1)
				{
					foreach ($intros as $key=>$intro)
					{
						$this->saveIntro($intro, $model->id);
					}
				}
				
				$this->redirect(array('update','courseId'=>$model->id));
			}
		}

		// Query all category
		$categoryList = array();
		$data = Category::model()->findAll();
		foreach ($data as $category)
		{
			$categoryList[$category->id] = $category->name;
		}
	
		$this->render('create',array(
			'model'=>$model,
			'categoryList'=>$categoryList,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($courseId)
	{
		$model=$this->loadModel($courseId);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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

		
	private function saveThumbnail($thumbnail, $courseId)
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
				system("rm thumbnail*");
			}

			if ($thumbnail)
			{
				$ext = end(explode('.', $thumbnail->name));
				$thumbnail->saveAs("$path/thumbnail.$ext");

				// save thumbnail's file name
				$file = fopen("$path/thumbnail", 'w');
				fputs($file, "$path/thumbnail.$ext");
				fclose($file);
			}
		}	
		else
		{
			throw new CHttpException(500, "couseId was invalid");
		}	
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
