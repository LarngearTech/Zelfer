<?php

class LectureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Script to do the real encode task
	 * @param EncodeVideoOptionForm Designate encode video options.
	 */
	private function dispatchEncode($model, $encodeOption)
	{
		// Start: Get subject information

		// Path information
		$inputPath	=	$model->encodingPath;
		$streamingPath	=	$model->streamingPath;
		if (!is_dir($streamingPath))
		{
			if (!mkdir($streamingPath, 0777, true))
			{
				throw new CHttpException(500, "Failed to create $streamingPath folder."); 
			}
		}
		
		// Option information
		$encode_video	=	$encodeOption->encode_video;
		$sync_slides	=	$encodeOption->sync_slides;
		$format		=	$encodeOption->format;
		$scene_annotation_data =$encodeOption->scene_annotation_data; 

		$encode_for_mobile = 'n';

		// Clear unwanted files from previous encodings
		if($encode_video=='y') {
			if(file_exists("$streamingPath/Snapshots")) { system("rm -rf \"$streamingPath/Snapshots\""); }
			// Delete all mp4 files
			if($dir=opendir($streamingPath)) {
				while (false !== ($file = readdir($dir))) {
					if(substr($file,-3)=='mp4') {
					system("rm \"$streamingPath/$file\"");
				}
			}
		}

		if(file_exists("$streamingPath/Duration.txt"))	{ system("rm -rf \"$streamingPath/Duration.txt\""); }
		if(file_exists("$streamingPath/MSM.txt"))	{ system("rm -rf \"$streamingPath/MSM.txt\""); 			}
		if(file_exists("$streamingPath/PVManifest.txt")){ system("rm -rf \"$streamingPath/PVManifest.txt\""); 		}
		if(file_exists("$streamingPath/TrackManifest.txt")){ system("rm -rf \"$streamingPath/TrackManifest.txt\""); 	}
		if(file_exists("$streamingPath/tracked.log"))	{ system("rm -rf \"$streamingPath/tracked.log\""); 		}
		if(file_exists("$streamingPath/TrackingParameters.txt")){ system("rm -rf \"$streamingPath/TrackingParameters.txt\""); 	}
		if(file_exists("$streamingPath/video_encoding.txt"))	{ system("rm -rf \"$streamingPath/video_encoding.txt\""); 	}
		if(file_exists("$streamingPath/video_complete.txt"))	{ system("rm -rf \"$streamingPath/video_complete.txt\""); 	}
}

		if($sync_slides=='y') 
		{
			if(file_exists("$streamingPath/SlideDeck"))		{ system("rm -rf \"$streamingPath/SlideDeck\""); 		}
			if(file_exists("$streamingPath/SlideManifest.txt"))	{ system("rm -rf \"$streamingPath/SlideManifest.txt\""); 	}
			if(file_exists("$streamingPath/slide_complete.txt"))	{ system("rm -rf \"$streamingPath/slide_complete.txt\""); 	}
			if(file_exists("$streamingPath/slide_encoding.txt"))	{ system("rm -rf \"$streamingPath/slide_encoding.txt\""); 	}
		}

		// Generate Preset Views Manifests if format is ClassX
		if($format=='classx') 
		{

			// Parse the data String
			$regions=explode('-',$scene_annotation_data);

			$trackFID=fopen("$streamingPath/TrackingParameters.txt",'w');
			$presetFID=fopen("$streamingPath/PVManifest.txt",'w');

			fwrite($trackFID,strval(sizeof($regions))."\n");

			for($i=0;$i<sizeof($regions);$i++)
			{
				$regionElements=explode('_', $regions[$i]);
		
				$x=$regionElements[1];					$y=$regionElements[2];
				$w=$regionElements[3];					$h=$regionElements[4];
				$xMax=strval(intval($x)+intval($w));			$yMax=strval(intval($y)+intval($h));
	
				fwrite($trackFID,$x."\t".$xMax."\t".$y."\t".$yMax);	fwrite($presetFID,$x."\t".$y."\t".$w."\t".$h);
		
				if($i!=sizeof($regions)-1)
				{
					fwrite($trackFID,"\n");				fwrite($presetFID,"\n");
				}
			}

			fclose($trackFID);	
			fclose($presetFID);

			system("chmod -R 700 \"$streamingPath\"");
		}
		
		if($encode_video=='n' || $format=="openclassroom" || file_exists("$streamingPath/TrackingParameters.txt"))
		{
			// Create the video_encoding.txt and/or slide_encoding.txt files in the streaming folder.
	
			if($encode_video=='y') 
			{
				if(file_exists("$streamingPath/video_complete.txt")) 
				{
					system("rm -rf \"$streamingPath/video_complete.txt\"");
				}
				$FID=fopen("$streamingPath/video_encoding.txt",'w');	fclose($FID);
			}

			if($sync_slides=='y') 
			{
				if(file_exists("$streamingPath/slide_complete.txt")) 
				{
					system("rm -rf \"$streamingPath/slide_complete.txt\"");
				}

				$FID=fopen("$streamingPath/slide_encoding.txt",'w');	fclose($FID);
			}
	
			if($format == 'classx' && $encode_video == 'y') 
			{
				// Need to be fixed, just disable mobile encoding for the time being
				$encode_for_mobile = 'n';
			} 
			else 
			{
				$encode_for_mobile = 'n';
			}

			system("chmod 700 \"$streamingPath\"");

			$scriptPath = Yii::app()->basePath."/scripts";
			$pipelinePath = "$scriptPath/bin";
	
			$rand = rand();
			$encodingPath = $inputPath."/.encoding_{$rand}";
			system("mkdir \"$encodingPath\""); system("chmod 700 \"$encodingPath\"");
	
			// -----------------------------------------------------------------------------------
			// It all comes down to this!!!
			
			system("perl $scriptPath/encode.pl \"$inputPath\" \"$encodingPath\" \"$streamingPath\" \"$pipelinePath\" $format $encode_video $sync_slides $encode_for_mobile >/dev/null 2>/dev/null &");

			$fid=fopen(Yii::app()->basePath.'/../CX_Log.txt','w'); fwrite($fid,"perl $scriptPath/encode.pl \"$inputPath\" \"$encodingPath\" \"$streamingPath\" \"$pipelinePath\" $format $encode_video $sync_slides $encode_for_mobile >/dev/null 2>/dev/null &\n"); 
			fclose($fid);	

			// We are redirecting STDOUT and STDERR to /dev/null and marking the process as background so that the process would be decoupled from its www-data trigger.
	        	// This accomplishes two things:
			//     1. It allows us to redirect the publisher's browser without having to wait for the encoding to complete.
			//     2. It allows the publisher to navigate away without the closed PHP session terminating the encoding process.

			// -----------------------------------------------------------------------------------
	
			$this->redirect(array('showEncodeResult', 'lectureId'=>$model->id));
		}
		else 
		{
			throw new CHttpException(500, "Cannot dispatch this request to available encoder.");
		}
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
			'chapterId'=>$chapterId,
			'courseId'=>$courseId,
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
			throw new CHttpException(500, "Lecture with lecture id=$lectureId does not exist.");
		}
		else
		{
			if (isset($_POST['uploadDone']))
			{
				$this->redirect(array('create', 
						'lectureId'=>$model->id,
						'chapterId'=>$model->chapter_id,
						'courseId' =>$model->chapter->course->id));	
			}

			$uploaderUrl = Yii::app()->baseUrl.'/protected/scripts/upload/upload_widgets.php?'.
							'encodingPath='.$model->encodingPath.'&'.
							'streamingPath='.$model->streamingPath;
			$fileSummaryUrl = Yii::app()->baseUrl.'/protected/scripts/file_summary.php';
			$this->render('uploadVideo',array(
				'model'=>$model,
				'uploaderUrl'=>$uploaderUrl,
				'fileSummaryUrl'=>$fileSummaryUrl,
				'encodingPath'=>$model->encodingPath,
				'streamingPath'=>$model->streamingPath));
		}
	}

	/**
	 * Encode video file according to encoding option.
	 * @param integer $lectureId the ID of the model whose vdo file need to be encoded.
	 */
	public function actionEncode($lectureId)
	{
		$model = $this->loadModel($lectureId);
		$encodeOption = new EncodeVideoOptionForm;
		if ($model === null)
		{
			throw new CHttpException(500, "Lecture with lecture id=$lectureId does not exist.");
		}
		else
		{

			if (isset($_POST['EncodeVideoOptionForm']))
			{
				$encodeOption->attributes = $_POST['EncodeVideoOptionForm'];
				$this->dispatchEncode($model, $encodeOption);
			}
			$this->render('encode',array(
				'model'=>$model,
				'encodeOption'=>$encodeOption,
				'encodingPath'=>$model->encodingPath,
				'streamingPath'=>$model->streamingPath));
		}
	}

	public function actionShowEncodeResult($lectureId)
	{
		$model = $this->loadModel($lectureId);
		echo "<img src=$model->thumbnailUrl />";
		echo $model->getVideoObject("flash");
		//echo "Complete for lecture $model->name";
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $lectureId the ID of the model to be updated
	 */
	public function actionUpdate($lectureId)
	{
		$model = $this->loadModel($lectureId);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Lecture']))
		{
			$model->attributes = $_POST['Lecture'];
			if ($model->save())
			{
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model' => $model,
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
		$dataProvider = new CActiveDataProvider('Lecture');
		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Lecture('search');
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
		$model = Lecture::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='lecture-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
