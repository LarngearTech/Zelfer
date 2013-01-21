<?php
$questions = $content->childContents;

$i=0;
$items;
foreach ($questions as $question)
{
	$item['id'] = 'test-'.$question->order;
	$item['itemPath'] = ResourcePath::getContentBasePath().$question->id."/data.xml";

	$items[$i]=$item;
	$i++;
}

$this->widget('ZAssessment', array(
				'lectureId' => $content->id,
				'userId' => Yii::app()->user->id,
				'headline' => $content->name,
				'description' => 'กรุณาเลือกคำตอบที่ดีที่สุด',
				'items' => $items));
?>