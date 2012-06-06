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
		$this->assertEquals(Lecture::ENCODING_PATH_PREFIX.$lectureId, $retrievedLecture->encodingPath);
	}

	public function testGetStreamingPath()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals(Lecture::STREAMING_PATH_PREFIX.$lectureId, $retrievedLecture->streamingPath);
	}

	public function testGetSlideUrl()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals(Lecture::SLIDE_URL_PREFIX.$lectureId, $retrievedLecture->slideUrl);
	}

	public function testGetVideoUrl()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals(Lecture::VIDEO_URL_PREFIX.$lectureId, $retrievedLecture->videoUrl);
	}
}
