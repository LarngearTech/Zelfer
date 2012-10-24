<div class="container">
<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->courseInstructorsShortString);?></h3>

<div id="course-tabs">
	<?php
	$lecturesTabContent = '
		<div class="row">
			<div class="lecture-stack-wrapper span3">';
	/*$lecturesTabContent .= $this->widget('ZLectureStack', array(
								'contents' => $contents,
							), true);*/
	$lecturesTabContent .= $this->widget('ContentList', 
					array(
						'mode'=>'inclass',
						'course'=>$model,
					),
					true
				);
	$lecturesTabContent .= '
			</div><!-- /lecture-stack-wrapperspan3 -->';
	$lecturesTabContent .= '<div class="span9"><form><legend id="lecture-name">First Lecture</legend>';
	$lecturesTabContent .= '<div id="lecture-content-wrapper" class="videoWrapper">';
	$lecturesTabContent .= $this->widget('application.extensions.videojs.EVideoJS', array(
						'options' => array(
							// Unique identifier, is autogenerated by default, useful for jQuery integrations.
							'id' => false,
							// Video and poster width in pixels
							//'width' => 320,
							// Video and poster height in pixels
							//'height' => 240,
							// Poster image absolute URL
							'poster' => false,
							// Absolute URL of the video in MP4 format
							'video_mp4' => "/zelfer/content/1/video.mp4",
							// Absolute URL of the video in OGV format
							//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.ogv',
							//'video_ogv' => $model->intro_url.".ogv",
							// Absolute URL of the video in WebM format
							//'video_webm' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.webm',
							// Use Flash fallback player ?
							'flash_fallback' => true,
							//'flash_fallback' => false,
							// Address of custom Flash player to use as fallback
							//'flash_player' => 'swf/ClassXPlayer_v2.swf',
							//'flash_player' => false,
							'flash_player' => 'http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf',
							// Show controls ?
							'controls' => true,
							// Preload video content ?
							'preload' => true,
							// Autostart the playback ?
							'autoplay' => false,
							// Show VideoJS support link ?
							'support' => false,
							// Show video download links ?
							'download' => false,
						),
					), true);
	$lecturesTabContent .= '</div><!-- end lecture-content-wrappero span9 -->';
	$lecturesTabContent .= '</form></div>
			</div><!-- end row -->';

	// create course tabs including lecture and problem set tabs.
	$this->widget('EBootstrapTabNavigation', array(
		'items' => array(
			array('label' => Yii::t('site', 'Lecture'), 'url' => '#lecture', 'active' => true),
			array('label' => Yii::t('site', 'Problem Set'), 'url' => '#problemset'),
			array('label' => Yii::t('site', 'Discussion'), 'url' => '#discussion'),
		),
)	);

	$this->beginWidget('EBootstrapTabContentWrapper');
		$this->beginWidget('EBootstrapTabContent', array(
			'active' => true,
			'id' => 'lecture',
		));
			echo $lecturesTabContent;
		$this->endWidget();
		$this->beginWidget('EBootstrapTabContent', array(
			'id' => 'problemset',
		));
			$this->widget('ZAssessment', array(
				'lectureId' => 5,
				'userId' => Yii::app()->user->id,
				'headline' => 'Problem Set 1',
				'description' => 'กรุณาเลือกคำตอบที่ดีที่สุด',
				'items' => array(
					array(
						'id' => 'test-1',
						'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'1.xml',
					),
					array(
                        'id' => 'test-2',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'2.xml',
                    ),
					array(
                        'id' => 'test-3',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'3.xml',
                    ),  
					array(
                        'id' => 'test-4',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'4.xml',
                    ),
					array(
                        'id' => 'test-5',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'5.xml',
                    ),
					array(
                        'id' => 'test-6',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'6.xml',
                    ),
					array(
                        'id' => 'test-7',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'7.xml',
                    ),
					array(
                        'id' => 'test-8',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'8.xml',
                    ),
					array(
                        'id' => 'test-9',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'9.xml',
                    ),
					array(
                        'id' => 'test-10',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'10.xml',
                    ),
					array(
                        'id' => 'test-11',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'11.xml',
                    ),
					array(
                        'id' => 'test-12',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'12.xml',
                    ),
					array(
                        'id' => 'test-13',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'13.xml',
                    ),
					array(
                        'id' => 'test-14',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'14.xml',
                    ),
					array(
                        'id' => 'test-15',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'15.xml',
                    ),
					array(
                        'id' => 'test-16',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'16.xml',
                    ),
					array(
                        'id' => 'test-17',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'17.xml',
                    ),
					array(
                        'id' => 'test-18',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'18.xml',
                    ),
					array(
                        'id' => 'test-19',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'19.xml',
                    ),
					array(
                        'id' => 'test-20',
                        'itemPath' => Yii::app()->basePath.DIRECTORY_SEPARATOR.'assessments'.DIRECTORY_SEPARATOR.'5'.DIRECTORY_SEPARATOR.'20.xml',
                    ),
				)
			));
		$this->endWidget(); // end EbootstrapTabConent
		$this->beginWidget('EBootstrapTabContent', array(
			'id' => 'discussion',
		));
			echo 'This feature is coming soon...';
		$this->endWidget();
	$this->endWidget();
?>
</div><!-- end course-tabs -->
</div><!-- /container -->
