<?php
class CourseTest extends CDbTestCase
{
	public $fixtures = array(
		'courses' => 'Course',
	);

	public function testGetThumbnailUrl()
	{
		$retrievedCourse = $this->courses('course1');
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/thumbnail/'.$courseId, $retrievedCourse->thumbnailUrl);
	}
}
