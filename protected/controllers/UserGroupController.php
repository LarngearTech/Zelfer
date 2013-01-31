<?php

class UserGroupController extends Controller
{
	/**
	 * @var string the default layout for the views.
	 */
	public $layout='//layouts/main';

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin@zelfer.com', 'system@zelfer.com'),
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
	 */
	public function actionCreate()
	{
		$model = new UserGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['UserGroup']))
		{
			$model->attributes = $_POST['UserGroup'];

			if ($model->save())
			{
				if (Yii::app()->request->isAjaxRequest)
				{				
					$userGroups = UserGroup::model()->findAll();
					$txtUserGroupName = "txtUserGroupName";
					$addHandler = "addUserGroup();";
					$this->renderPartial('_addUserGroup', 
						array('userGroups'=>$userGroups,
							'txtUserGroupName'=>$txtUserGroupName,
							'addHandler'=>$addHandler
						)
					);
				}
				else
				{
					$this->redirect(array('view','id' => $model->id));
				}
			}
		}
		else
		{
			$this->render('create',array(
				'model'=>$model,
			));	
		}	
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$userGroupModel = $this->loadModel($id);
		//$subgroupModel = UserSubgroup::model()->with('groups')->findAll();
		//print_r($subgroupModel); exit();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserGroup']))
		{
			$userGroupModel->attributes=$_POST['UserGroup'];
			if($userGroupModel->save())
			{
				//$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'userGroupModel'=>$userGroupModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			{
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
			{
				// Ajax return UserGroup list to display
				$userGroups = UserGroup::model()->findAll();
				$this->renderPartial('_addUserGroup', 
					array(
						'userGroups'=>$userGroups,
					)
				);				
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UserGroup');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroup']))
			$model->attributes=$_GET['UserGroup'];

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
		$model=UserGroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
