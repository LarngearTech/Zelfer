<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->courseInstructorsShortString);?></h3>

<div id="course-tabs"">
	<?php
	// create contents for the lecture tab 
	$chapIdx = 0;
	$lecturesTabContent = '
	<div class="row">
		<div class="accordion span3" id="chapter-accordion">';
	foreach ($chapters as $chapter)
	{
		$chapIdx++;
		$lecturesTabContent .= '
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter'.$chapIdx.'-collapse">
						'.$chapIdx.'. '.CHtml::encode($chapter->name).'
					</a>
				</div>
				<div id="chapter'.$chapIdx.'-collapse" class="accordion-body collapse">
					<div class="accordion-inner">
						<ul>';
		// create a lecture list
		foreach ($chapter->lectures as $lecture)
		{
			$lecturesTabContent .= 
				'<li class="lecture">
					<div class="lecture-name">
						'.CHtml::encode($lecture->name).'
					</div>
					<div class="lecture-items">
						<a href="'.$lecture->streamingUrl.'"><img src="'.Yii::app()->baseUrl.'/images/play.png" class="icon"></a> 
						<a href="'.$lecture->slideUrl.'"><img src="'.Yii::app()->baseUrl.'/images/slide.png" class="icon material"></a>
						<a href="'.$lecture->videoUrl.'"><img src="'.Yii::app()->baseUrl.'/images/video.png" class="icon material"></a>
					</div>	
				</li>';
		}
		$lecturesTabContent .= '</ul>
					</div><!-- end accordion-inner -->
				</div><!-- end chapter -->
			</div><!-- end accorion-group -->
		';
	}
	$lecturesTabContent .= '</div><!-- end accordion -->';
	$lecturesTabContent .= '<div id="lecture-content-wrapper" class="span9">
		'.$lecture->getVideoObject('flash').'
		</div><!-- end lecture-content-wrapper -->
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
		echo 'Problem set';
		$this->endWidget();
		$this->beginWidget('EBootstrapTabContent', array(
			'id' => 'discussion',
		));
		echo 'Discussion';
		$this->endWidget();
	$this->endWidget();
?>
</div><!-- end course-tabs -->
