<?php
class CourseTest extends CDbTestCase
{
	public $fixtures = array(
		'courses' => 'Course',
		'users' => 'User',
		'instructor_courses' => ':Instructor_course',
	);

	public function testGetThumbnailUrl()
	{
		$retrievedCourse = $this->courses('course1');
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/thumbnail/'.$courseId, $retrievedCourse->thumbnailUrl);
	}

	public function testGetInstructorCareer()
	{
		/*$retrievedCourse = $this->courses('course1');
		foreach ($retrievedCourse->instructors as $instructor)
		{
			echo $instructor->fullname;
		}
		foreach ($retrievedCourse->instructor_courses as $instructor_course)
		{
			echo $instructor_course->instructor_career;
		}*/
	}

	public function testGetInstructorDescription()
	{

	}
}
