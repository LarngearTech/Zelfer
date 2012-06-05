<?php
class LectureTest extends CDbTestCase
{
	public $fixtures = array(
		'lectures' => 'Lecture',
	);

	public function testGetEncodingPath()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals('/asset/encoding/'.$lectureId, $retrievedLecture->encodingPath);
	}

	public function testGetStreamingPath()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		//$this->assertEquals('/asset/streaming/'.$lectureId, $retrievedLecture->streamingPath);
		$this->assertEquals(Lecture::STREAMING_PATH_PREFIX.$lectureId, $retrievedLecture->streamingPath);
	}

	public function testGetSlideUrl()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals(Lecture::SLIDE_URL_PREFIX.$lectureId, $retrievedLecture->slideUrl);
	}
}
