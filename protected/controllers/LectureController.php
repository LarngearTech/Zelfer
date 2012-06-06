<?php

class LectureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param integer $lectureId the ID of the model to be updated.
	 * @param integer $chapterId the chapter id.
	 * @param integer $courseId the course id.
	 */
	public function actionCreate($lectureId, $chapterId, $courseId)
	{
		// Wheter this is a newly created session or just a redirect from editInfo 
		// Newly created session
		if ($lectureId == "")
		{
			$model = new Lecture;	
		}
		// Was redirected from editInfo
		else
		{
			$model = $this->loadModel($lectureId);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lecture']))
		{
			$model->attributes=$_POST['Lecture'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'chapterId'=>$chapterId,
			'courseId'=>$courseId,
		));
	}

	/**
	 * Edit lecture's information.
	 * If creation is successful, the browser will be redirected to create page to proceed to next step.
	 * @param integer $lectureId the ID of the model to be updated.
	 * @param integer $chapterId the chapter id.
	 * @param integer $courseId the course id.
	 * @param string $returnAction can be either 'create' or 'update' depends on which page it was redirect from.
	 */
	public function actionEditInfo($lectureId, $chapterId, $courseId, $returnAction)
	{
		if ($lectureId != "")
		{
			$model = $this->loadModel($lectureId);
		}
		else
		{
			$model = new Lecture();
		}

		if (isset($_POST['Lecture']))
		{
			$model->attributes = $_POST['Lecture'];
			$model->chapter_id = $chapterId;
			if($model->save())
			{
				if ($returnAction == 'create')
				{
					$this->redirect(array('create', 
										'lectureId'=>$model->getPrimaryKey(),
										'chapterId'=>$model->chapter_id,
										'courseId' =>$model->chapter->course->id));		
				}
				else if ($returnAction == 'update')
				{
					$this->redirect(array('update', 
										'lectureId'=>$model->getPrimaryKey(),));		
				}
			}
		}

		$this->render('editInfo',array(
			'model'=>$model,
			'returnAction'=>$returnAction
		));
	}

	/**
	 * Upload video to server.
	 * If creation is successful, the browser will be redirected to create page to proceed to next step.
	 * @param integer $lectureId the ID of the model to be updated
	 */
	public function actionUploadVideo($lectureId)
	{
		$model = $this->loadModel($lectureId);
		if ($model === null)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
		else
		{
			$uploader_url = Yii::app()->baseUrl.'/protected/scripts/upload/upload_widgets.php?'.
							'encodingPath='.$model->encodingPath.'&'.
							'streamingPath='.$model->streamingPath;
			$this->render('uploadVideo',array(
				'model'=>$model,
				'uploader_url'=>$uploader_url));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $lectureId the ID of the model to be updated
	 */
	public function actionUpdate($lectureId)
	{
		$model=$this->loadModel($lectureId);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lecture']))
		{
			$model->attributes=$_POST['Lecture'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
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
		$dataProvider=new CActiveDataProvider('Lecture');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Lecture('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lecture']))
			$model->attributes=$_GET['Lecture'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Lecture::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lecture-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
