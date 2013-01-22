<div class="container">
<div id="course-header-in-class">
<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->courseInstructorsShortString);?></h3>
</div><!-- /course-header -->
<div id="course-tabs">
	<div class="tabbable tabs-top">
	<?php
	$minOrder=100000;
	$firstLecture;
	foreach($model->contents as $content)
	{
		if ($content->type != 0 && $content->order < $minOrder)
		{
			$minOrder=$content->order;
			$firstLecture = $content;
		}
	}

	$lecturesTabContent = '
		<div class="row">
			<div class="lecture-stack-wrapper span3">';
	$lecturesTabContent .= $this->widget('ContentList', 
					array(
						'mode'=>'inclass',
						'course'=>$model,
					),
					true
				);
	$lecturesTabContent .= '
			</div><!-- /lecture-stack-wrapper /span3 -->';
	$lecturesTabContent .= '<div class="lecture-content-wrapper span9">';
	$lecturesTabContent .= $this->widget('ContentDisplay', 
					array('content'=>$firstLecture),
					true);
	$lecturesTabContent .= '</div><!-- end lecture-content-wrapper -->';
	$lecturesTabContent .= '</div><!-- end row -->';

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
		/*$this->beginWidget('EBootstrapTabContent', array(
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
		$this->endWidget(); // end EbootstrapTabConent*/
		$this->beginWidget('EBootstrapTabContent', array(
			'id' => 'discussion',
		));
			echo 'This feature is coming soon...';
		$this->endWidget();
	$this->endWidget();
?>
	</div><!-- /tabbable -->
</div><!-- end course-tabs -->
</div><!-- /container -->
