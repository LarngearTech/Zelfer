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
			array('allow',  // allow all users to perform 'index', 'view', and 'explore' actions
				'actions' => array('index', 'view', 'explore'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'inclass', 'changeCourseInfo', 'instructorList', 'editInstructor', 'changeContent', 'changeIntroVideo', 'myCourse', 'changeThumbnail', 'publish', 'unpublish', 'delete', 'addInstructor', 'deleteInstructor', 'addLecture', 'addQuiz', 'addChapter', 'changeContentOrder', 'commitContent', 'editContent', 'cancelEditContent', 'deleteContent', 'contentTypeSelected', 'uploadContentVideo', 'deleteContentVideo', 'deleteQuestion', and 'addMultiple' actions
				'actions' => array('create', 'update', 'inclass', 'changeCourseInfo', 'instructorList', 'editInstructor', 'changeContent', 'changeIntroVideo', 'myCourse', 'changeThumbnail', 'publish', 'unpublish', 'delete', 'addInstructor', 'deleteInstructor', 'addLecture', 'addQuiz', 'addChapter', 'changeContentOrder', 'commitContent', 'editContent', 'cancelEditContent', 'deleteContent', 'contentTypeSelected', 'uploadContentVideo', 'deleteContentVideo', 'deleteQuestion', 'addMultiple'),
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
		$this->render('view',array(
			'model' => $this->loadModel($id),
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
		//$chapters = Chapter::model()->with('lectures')->findAll('course_id=:courseID', array(':courseID'=>$id));
		Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
		Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'jPaginator.css');
		Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jPaginator.js', CClientScript::POS_END);
		$contents=Content::model()->findAll('course_id=:courseID', array(':courseID'=>$id));
		$this->render('in_class',array(
			'model' => $this->loadModel($id),
			'contents' => $contents,
		));		
	}
	
	/*
	 * Change lecture video
	 */
	public function actionChangeContent()
	{
		$content = $this->getContent($_POST['contentId']);
		$this->widget('ContentDisplay',
			array('content'=>$content));
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
		$course = $this->loadModel($courseId);
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
			$course->deleteIntroVideo();
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
		$course = $this->loadModel($courseId);

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
			$course->deleteThumbnail();
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
	 * Explore all courses.
	 */
	public function actionExplore()
	{
		// load all categories
		$categories = Category::model()->findAll();

		// load all courses of each catgegory to display
		$courses_in_categories = array();
		foreach ($categories as $category) {
			$courses_in_categories[$category->id] = Course::model()->category($category->id)->status('publish')->findAll();
		}

 		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('explore', array(
				'categories' => $categories,
				'courses_in_categories' => $courses_in_categories,
		));
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
	 */
	public function actionDelete($courseId)
	{
		$course = $this->loadModel($courseId);
		$course->deleteIntroVideo();
		$course->deleteThumbnail();
		$contents = $course->contents;
		foreach ($contents as $content)
		{
			$content->delete();
		}
		$course->delete();
		$this->redirect($this->createUrl(
			'course/myCourse',
			array('uid'=>Yii::app()->user->id)
		));
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
		$course = $this->loadModel($courseId);
		$this->renderPartial('_editableInstructorList', array(
			'course' => $course,
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

			$course = $this->loadModel($courseId);
			$this->renderPartial('_editableInstructorList', array(
				'course' => $course,
			));
		}
	}

	public function actionAddQuiz()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$course  = $this->loadModel($_POST['courseId']);

			$lastChapterId=-1;
			$maxOrder=-1;
			foreach($course->contents as $content)
			{
				if($content->order > $maxOrder && $content->isChapter())
				{
					$maxOrder = $content->order;
					$lastChapterId = $content->id;
				}	
			}

			$quiz = new Content();
			$quiz->course_id = $course->id;
			$quiz->name = "Untitled Quiz";
			$quiz->parent_id = $lastChapterId;
			$quiz->order=sizeof($course->contents);
			$quiz->type=3;
			$quiz->save();

			$course  = $this->loadModel($_POST['courseId']);
			$this->widget('EditableContentList',
				array(
					'course'=>$course,
				)
			);
		}
	}

	public function actionAddLecture()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$course  = $this->loadModel($_POST['courseId']);

			$lastChapterId=-1;
			$maxOrder=-1;
			foreach($course->contents as $content)
			{
				if($content->order > $maxOrder && $content->isChapter())
				{
					$maxOrder = $content->order;
					$lastChapterId = $content->id;
				}	
			}

			$lecture = new Content();
			$lecture->course_id = $course->id;
			$lecture->name = "Untitled Lecture";
			$lecture->parent_id = $lastChapterId;
			$lecture->order=sizeof($course->contents);
			$lecture->type=1;
			$lecture->save();

			mkdir(ResourcePath::getContentBasePath().$lecture->id, 0755);

			$course  = $this->loadModel($_POST['courseId']);
			$this->widget('EditableContentList',
				array(
					'course'=>$course,
				)
			);
		}
	}

	public function actionAddChapter()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$course  = $this->loadModel($_POST['courseId']);

			$chapter = new Content();
			$chapter->course_id = $_POST['courseId'];
			$chapter->name = "Untitled Chapter";
			$chapter->parent_id = -1;
			$chapter->order=sizeof($course->contents);
			$chapter->type=0;
			$chapter->save();

			$course=$this->loadModel($_POST['courseId']);	

			$this->widget('EditableContentList',
				array(
					'course'=>$course,
				)
			);
		}
	}

	private function findNewOrder($contentId, $newOrderList)
	{
		foreach($newOrderList as $key=>$value)
		{
			if($value==$contentId)
			{
				return $key;
			}
		}
	}

	public function actionChangeContentOrder($courseId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$course  = $this->loadModel($courseId);
			$contents = $course->contents; 
			$newOrderList=$_POST['content'];

			foreach($contents as $content)
			{
				$content->order = $this->findNewOrder($content->id, $newOrderList);
			}

			usort($contents, array('ProjectUtil', 'contentComparator'));
			$currentChapter=-1;
			foreach($contents as $content)
			{
                                // Update parentId
                                if ($content->isChapter())
                                {
                                        $currentChapter=$content->id;
                                }
                                else
                                {
                                        $content->parent_id=$currentChapter;
                                }
				$content->save();
			}

			$this->widget('EditableContentList',
				array(
					'course'=>$course,
				)
			);
		}
	}

	public function actionEditContent()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$content=Content::model()->findByPk($_POST['contentId']);
			$this->widget('EditableContentListItem',
				array(
					'content'=>$content,
					'contentPrefix'=>$_POST['contentPrefix'],
					'mode'=>'edit'
				)
			);
		}
	}

	public function actionCommitContent()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$content=$this->getContent($_POST['contentId']);
			$content->name=$_POST['contentName'];
			$content->save();

			$content=$this->getContent($_POST['contentId']);
			$this->widget('EditableContentListItem',
				array(
					'content'=>$content,
					'contentPrefix'=>$_POST['contentPrefix'],
				)
			);
		}
	}

	public function actionCancelEditContent()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			// Remove temp dir
			$content=$this->getContent($_POST['contentId']);
			$contentDir=ResourcePath::getContentBasePath().$_POST['contentId'].'/tmp';
			if(is_dir($contentDir))
			{
				rmdir($contentDir);
			}

			$this->widget('EditableContentListItem',
				array(
					'content'=>$content,
					'contentPrefix'=>$_POST['contentPrefix'],
					//'mode'=>'edit',
				)
			);
		}
	}

	/**
	 * Delete a content from course
	 */
	public function actionDeleteContent()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$course=$this->loadModel($_POST['courseId']);
			if ($course)
			{
				$prevChapter=-1;
				$contents = $course->contents;
				usort($contents, array('ProjectUtil', 'contentComparator'));
				foreach($contents as $content)
				{
					if ($content->isChapter())
					{
						if ($content->id!=$_POST['contentId'])
						{
							$prevChapter=$content->id;
						}
						else
						{
							//echo "delete content ".$_POST['contentId']." from course ".$_POST['courseId']." prevChapter ".$prevChapter;
							$childContents=$content->childContents;
							foreach ($childContents as $childContent)
							{
								$childContent->parent_id=$prevChapter;
								$childContent->save();
							}
							$content->delete();
							
						}
					}
					else if($content->id==$_POST['contentId'])
					{
						//echo "delete content ".$_POST['contentId']." from course ".$_POST['courseId'];
						$content->delete();
					}
				}

				// Remove content directory
				$contentDir = ResourcePath::getContentBasePath().$_POST['contentId'];
				if (is_dir($contentDir))
				{
					rmdir($contentDir);
				}
			}

			$course=$this->loadModel($_POST['courseId']);
			$this->widget('EditableContentList', 
				array('course'=>$course)
			);
		}
	}

	public function actionContentTypeSelected()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$widget=new ContentList();
			if ($_POST['contentType'] == 'video')
			{
				$widget->render('addVideoContent', 
					array('contentId'=>$_POST['contentId']));
			}
			else if($_POST['contentType'] == 'multipleChoices')
			{
				$quiz = $this->getContent($_POST['contentId']);

				if ($quiz)
				{
					$question = new Content();
					$question->course_id = $quiz->course_id;
					$question->parent_id = $quiz->id;
					$question->name = "Untitled Question";
					$question->order = sizeof($quiz->childContents);
					$question->type = 4;
					$question->save();

					mkdir(ResourcePath::getContentBasePath().$question->id, 0755);
					$widget->render('addMultipleChoices',
						array('content'=>$question));

				}
			}
		}
	}

	public function actionUploadContentVideo($contentId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$content = $this->getContent($contentId);
			$content->type=2;
			$content->save();

			$contentDir=ResourcePath::getContentBasePath().$contentId;
			$tmpDir = $contentDir.'/tmp';
			if (is_dir($tmpDir))
			{
				//PHPHelper::rrmdir($contentDir);
				shell_exec('rm -rf '.$tmpDir);
			}
			mkdir($tmpDir, 0755, true);

			$target='video.'.PHPHelper::getFileExtension($_FILES['uploadedFile']['name']);
			if((!is_uploaded_file($_FILES['uploadedFile']['tmp_name'])) or !copy($_FILES['uploadedFile']['tmp_name'], $tmpDir.'/'.$target))
			{
				echo "Error copy files";	
			}
			else
			{
				VideoUtil::encode($tmpDir.'/'.$target, $contentDir.'/');
			}
		}
	}

	public function actionDeleteContentVideo($contentId)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$content=$this->getContent($contentId);
			$content->type=1;
			$content->save();

			$contentDir = ResourcePath::getContentBasePath().$contentId;
			if (is_dir($contentDir.'/video'))
			{
				shell_exec('rm -rf '.$contentDir.'/video');
			}
		}
	}

	public function actionDeleteQuestion()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$question = $this->getContent($_POST['contentId']);
			if ($question)
			{
				$quiz=Content::model()->findByPk($question->parent_id);
				shell_exec('rm -rf '.ResourcePath::getContentBasePath().$question->id);
				$question->delete();

				$this->widget('EditableContentListItem',
					array(
						'content'=>$quiz,
						'contentPrefix'=>Yii::t('site', 'Quiz'),
						'mode'=>'edit'
					)
				);
			}

		}
	}

	public function actionAddMultiple()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			//print_r($_POST['data']);
			$contentId = $_POST['contentId'];

			$question = $this->getContent($contentId);
			if ($question)
			{
				Yii::import('ext.qtiprocessor.*');
				require_once('QtiProcessor.php');
				
				$item = array();
				$item['title'] = $_POST['data']['question'];
				$item['type'] = 'choice';
				$item['choices'] = $_POST['data']['txt-choice'];

				$item['answers'] = $item['choices'][$_POST['data']['answer']];
				$item['shuffle'] = 'false';
				$item['maxChoices'] = 1;
				$item['prompt'] = $_POST['data']['question'];
		
				$qt = new QtiProcessor();
				$xml = $qt->createQtiXmlItem($item);
				$file = fopen(ResourcePath::getContentBasePath().$contentId."/data.xml", "w");
				fwrite($file, $xml);
				fclose($file);

				$question->name = $item['title'];
				$question->save();

				$quiz = Content::model()->findByPk($question->parent_id);
				$this->widget('EditableContentListItem',
					array(
						'content'=>$quiz,
						'contentPrefix'=>Yii::t('site', 'Quiz'),
						'mode'=>'edit'
					)
				);
			}
		}
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


	private function getContent($contentId)
	{
		$content=Content::model()->findByPk($contentId);
		if($content===null)
			throw new CHttpException(404, 'The requested content does not exist.');
		return $content;
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
