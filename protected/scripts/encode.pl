#!/usr/local/bin/perl

use File::Copy;
use POSIX;
use Cwd "abs_path";
use LWP::Simple;

# This script is to be used with the Courseware-ClassX API
# Subject is the equivalent of course_guid and session is the equivalent to video_presentation_guid

#####################################################
#           Parse and Check Input Arguments         #
#####################################################

my $numArgsInput = $#ARGV + 1;

if($numArgsInput==0) {
	print "\n";
	print "ClassXPublisher for ClassX-Courseware API";
	print "Usage: encode input_path encoding_path streaming_path pipeline_path format encode_video_flag sync_slides_flag encode_for_mobile_flag\n";
	print "Type encode -h, --h, -help, or --help for further help\n";
	print "\n";
	exit(0);
}
if ($numArgsInput==1) {
	my $input=shift(@ARGV);
	if(($input eq "-h")||($input eq "--h")||($input eq "-help")||($input eq "--help")) {
		print "\n";
		print "ClassXPublisher\n";
		print "Usage: encode input_path encoding_path streaming_path pipeline_path format encode_video_flag sync_slides_flag encode_for_mobile_flag\n";
		print "\n";
		exit(0);
	}
	else {
		print "Unknown command option $input.";
		print "Usage:  encode input_path encoding_path streaming_path pipeline_path format encode_video_flag sync_slides_flag encode_for_mobile_flag\n";
		exit(0);
	}
}

if ($numArgsInput!=1 && $numArgsInput!=8) {
	print "\n";
	print "Error: encode expects 8 arguments.\n";
	print "Usage: encode input_path encoding_path streaming_path pipeline_path format encode_video_flag sync_slides_flag encode_for_mobile_flag\n";
	exit(0);
}

# If this point is reached, then the command was issued to do some processing.

##############################################################################

#########################################
#         Parse Input Arguments         #
#########################################

my $inputPath=shift(@ARGV);
my $encodingPath=shift(@ARGV);
my $streamingPath=shift(@ARGV);
my $pipelinePath=shift(@ARGV);
my $format=shift(@ARGV);
my $videoEncodeFlag=shift(@ARGV);
my $slideSyncFlag=shift(@ARGV);
my $encodeForMobileFlag=shift(@ARGV);

if(!(-e "$inputPath")) {
	print "\n";
	print "Error: The first argument (input path) is not a valid path.\n";
	exit(0);
}

if(!(-e "$encodingPath")) {
	print "\n";
	print "Error: The second argument (encoding path) is not a valid path.\n";
	exit(0);
}

if(!(-e "$streamingPath")) {
	print "\n";
	print "Error: The third argument (streaming path) is not a valid path.\n";
	exit(0);
}

if(!(-e "$pipelinePath")) {
	print "\n";
	print "Error: The fourth argument (pipeline path) is not a valid path.\n";
	exit(0);
}

if(!($format eq 'classx' || $format eq 'openclassroom')) {
	print "\n";
	print "Error: The fifth argument (format) must be either classx or opencllassroom.\n";
	exit(0);
}

if(!($videoEncodeFlag eq 'n' || $videoEncodeFlag eq 'y')) {
	print "\n";
	print "Error: The sixth argument (video encoding flag) must be either y or n.\n";
	exit(0);
}

if(!($slideSyncFlag eq 'n' || $slideSyncFlag eq 'y')) {
	print "\n";
	print "Error: The seventh argument (slide synchronization flag) must be either y or n.\n";
	exit(0);
}

if(!($encodeForMobileFlag eq 'n' || $encodeForMobileFlag eq 'y')) {
	print "\n";
	print "Error: The eigth argument (encode for mobile flag) must be either y or n.\n";
	exit(0);
}

##############################################################################

#########################################################
#           Sanitize File Names in Input Path           #
#########################################################

opendir(DIR,$inputPath);

while (my $file = readdir(DIR)) {
	print "$file\n";
	if (index($file," ") >= 0) {
		$sanitized_filename = str_replace(" ","_",$file);
		`mv "$inputPath/$file" "$inputPath/$sanitized_filename"`;
	}
}

closedir(DIR);

##############################################################################

#########################################################
#   Add Status Indication Files to Streaming Directory  #
#########################################################

if($videoEncodeFlag eq 'y') {
	open (MYFILE, ">$streamingPath/video_encoding.txt");
	close(MYFILE);
	`chmod 770 "$streamingPath/video_encoding.txt"`;
}

if($slideSyncFlag eq 'y') {
	open (MYFILE, ">$streamingPath/slide_encoding.txt");
	close(MYFILE);
	`chmod 770 "$streamingPath/slide_encoding.txt"`;
}

##############################################################################

#########################################
#        Compose Encoding Directory     #
#########################################

# 1- Input Video
# Check the video files in the session input directory. Supported formats are avi, flv, mov, mp4, mts, and wmv.
# A video health check will be performed. This makes sure that there are just enough video files.
# There can only be files from one video extension. If there are files in more than one video extension, we exit in error.
# Furthermore, if the video extension is anything else but MTS, there should be exactly one file of that extension.
# For the MTS extension, there can be more than one file, but they should all be part of the same stream (must all have the same duration).

opendir(DIR,$inputPath);
my @aviFiles = grep(/\.avi$/,readdir(DIR));
my $numAVIFiles=@aviFiles;
my $hasAVIFiles=($numAVIFiles>0)?(1):(0);
closedir(DIR);

opendir(DIR,$inputPath);
my @flvFiles = grep(/\.flv$/,readdir(DIR));
my $numFLVFiles=@flvFiles;
my $hasFLVFiles=($numFLVFiles>0)?(1):(0);
closedir(DIR);

opendir(DIR,$inputPath);
my @movFiles = grep(/\.mov$/,readdir(DIR));
my $numMOVFiles=@movFiles;
my $hasMOVFiles=($numMOVFiles>0)?(1):(0);
closedir(DIR);

opendir(DIR,$inputPath);
my @mp4Files = grep(/\.mp4$/,readdir(DIR));
my $numMP4Files=@mp4Files;
my $hasMP4Files=($numMP4Files>0)?(1):(0);
closedir(DIR);

opendir(DIR,$inputPath);
my @mtsFiles = grep(/\.MTS$/,readdir(DIR));
@mtsFiles = sort @mtsFiles;
my $numMTSFiles=@mtsFiles;
my $hasMTSFiles=($numMTSFiles>0)?(1):(0);
closedir(DIR);

opendir(DIR,$inputPath);
my @wmvFiles = grep(/\.wmv$/,readdir(DIR));
my $numWMVFiles=@wmvFiles;
my $hasWMVFiles=($numWMVFiles>0)?(1):(0);
print $numWMVFiles;
closedir(DIR);

# Video file health check

if(($numAVIFiles+$numFLVFiles+$numMOVFiles+$numMP4Files+$numMTSFiles+$numWMVFiles) == 0) {
	print "Error: No input video files found in the session directory.\n";
	exit(0);
}

if(($hasAVIFiles+$hasFLVFiles+$hasMOVFiles+$hasMP4Files+$hasMTSFiles+$hasWMVFiles) > 1) {
	print "Error: Video files of mixed extensions found. Please check uploaded video files.\n";
	exit(0);
}

if(($hasAVIFiles+$hasFLVFiles+$hasMOVFiles+$hasMP4Files+$hasWMVFiles) > 0) {
	if(($numAVIFiles+$numFLVFiles+$numMP4Files+$numWMVFiles) > 1) {
		print "Error: For AVI, FLV, MP4, or WMV files, there can only be one input video file per presentation.\n";
		exit(0);
	}
}

if($hasMTSFiles == 1) {
	
}

my $inputFileName;
if($numMTSFiles>0) {
	# Create the concatenated MTS in the encodingPath
	my $cmd="cat ";
	foreach my $file (@mtsFiles) {
		$cmd=$cmd."\"$inputPath/$file\" ";
	}
	$cmd=$cmd.">\"$encodingPath/inputMTS.MTS\"";
	`$cmd`;
	$inputFileName="inputMTS.MTS";
}
elsif($numAVIFiles>0) {
	$inputFileName=$aviFiles[0];
	`cp "$inputPath/$inputFileName" "$encodingPath/$inputFileName"`;
}
elsif($numFLVFiles>0) {
	$inputFileName=$flvFiles[0];
	`cp "$inputPath/$inputFileName" "$encodingPath/$inputFileName"`;
}
elsif($numMOVFiles>0) {
	$inputFileName=$movFiles[0];
	`cp "$inputPath/$inputFileName" "$encodingPath/$inputFileName"`;
}
elsif($numMP4Files>0) {
	$inputFileName=$mp4Files[0];
	`cp "$inputPath/$inputFileName" "$encodingPath/$inputFileName"`;
}
elsif($numWMVFiles>0) {
	$inputFileName=$wmvFiles[0];
	`cp "$inputPath/$inputFileName" "$encodingPath/$inputFileName"`;
}

# 2- trackingParameters.txt
if($format eq "classx") {
	if(!(-e "$streamingPath/TrackingParameters.txt")) {
		print "Error: The tracking parameters file was not found. Please annotate the session scene to create it.\n";
		exit(0);
	}
`cp "$streamingPath/TrackingParameters.txt" "$encodingPath"`;
}

# 3- SlideDeck Directory
if($slideSyncFlag eq "y") {

	if(-e "$streamingPath/SlideDeck") {
		# Delete the slide deck directory and recreate it
		`rm -rf "$streamingPath/SlideDeck"`;
	}
	`mkdir "$streamingPath/SlideDeck"`;
	`chmod 770 "$streamingPath/SlideDeck"`;
	
	# Parse all PDFs in presentation folder to images inside SlideDeck
	opendir(DIR,$inputPath);
	my @pdfFiles = grep(/\.pdf$/,readdir(DIR));
	@pdfFiles = sort @pdfFiles;
	my $numPDFFiles=@pdfFiles;
	
	foreach my $file (@pdfFiles) {
		my $fileName=substr($file,0,-4);
		
		$cmd="convert \"$inputPath/$file\" -resize 776x582 \"$streamingPath/SlideDeck/\"".$fileName."S%03d.jpg";
		`$cmd`;
	}
	`chmod -R 770 "$streamingPath/SlideDeck"`;
	if(!(-e "$streamingPath/SlideDeck")) {
		print "Error: SlideDeck directory was not found in session's streaming folder.\n";
		exit(0);
	}
	`cp -r "$streamingPath/SlideDeck" "$encodingPath"`;
}

`chmod -R 770 "$encodingPath"`;
################################################################################

#########################################
#        Video Encoding Section         #
#########################################

if($videoEncodeFlag eq "y") {
	if($format eq 'classx') {
		

		if($encodeForMobileFlag eq 'y') {
			# Get courseID and lectureID from streaming path
			my @path_parts = split('/', $streamingPath); 
			my $num_parts = @path_parts;
			$courseID  = $path_parts[$num_parts-2];
			$lectureID = $path_parts[$num_parts-1];

			$trackingFilename = "TrackingParameters.txt";
			`chmod 770 -R "$encodingPath"`;
			`chmod 770 -R "$streamingPath"`;	
			my $transcodeFileName = "$inputFileName.mp4";
			`ffmpeg -i ${encodingPath}/$inputFileName -ac 1 -ab 128k -y -vcodec libx264 -vpre ultrafast -g 30 -r 30 -crf 22 $encodingPath/$transcodeFileName`;
			`chmod 770 -R "$encodingPath"`;
			# publish video content to ClassX Mobile
			# Path to tracking parameters: "\"$streamingPath/TrackingParameters.txt\""
			my $cxmPublishingURL = "http://mars3.stanford.edu/cxm/publish/publish.php?path=${encodingPath}/&filename=${transcodeFileName}&tpath=${encodingPath}&tracking=${trackingFilename}&courseID=${courseID}&lectureID=${lectureID}";
			use LWP::Simple;
			my $tempcontent = get($cxmPublishingURL);

			#wait for file transofer to be finished
			sleep(500);

		}
		#encode classX video
		EncodeVideo_ClassX($inputFileName,$encodingPath,$pipelinePath,$streamingPath);

	}
	elsif($format eq 'openclassroom') {
		EncodeVideo_OpenClassroom($inputFileName,$encodingPath,$pipelinePath,$streamingPath);
	}
	GenerateVideoSnapshots($format,$encodingPath,$streamingPath);
}

################################################################################

#########################################
#    Slide Synchronization Section      #
#########################################

if($slideSyncFlag eq "y") {
	SyncSlides($inputFileName,$encodingPath,$pipelinePath);
}

################################################################################

##################################
#  Cleanup and Transfer Section  #
##################################


`rm -rf "$encodingPath/$inputFileName"`;

# Copy all files in encoding directory to streaming folder
chdir $encodingPath;
`cp -r * "$streamingPath"`;

# Copy MSM.txt to the streaming directory
if($format eq 'classx') {
	if(-e "$streamingPath/slice1.mp4") {
		`cp "$pipelinePath/MSM_slice.txt" "$streamingPath/MSM.txt"`;
	}
	elsif(-e "$streamingPath/tile1.mp4") {
		`cp "$pipelinePath/MSM_tile.txt" "$streamingPath/MSM.txt"`;
	}
	elsif(-e "$streamingPath/stream1.mp4") {
		`cp "$pipelinePath/MSM_stream.txt" "$streamingPath/MSM.txt"`;
	}
}
elsif($format eq 'openclassroom') {
	`cp "$pipelinePath/MSM_openclassroom.txt" "$streamingPath/MSM.txt"`;
}

# Update the status indication files in the streaming directory.
if($videoEncodeFlag eq 'y') {
	`rm -rf "$streamingPath/video_encoding.txt"`;
	open (MYFILE, ">$streamingPath/video_complete.txt");
	close(MYFILE);
	`chmod 770 "$streamingPath/video_complete.txt"`;
}
if($slideSyncFlag eq 'y') {
	`rm -rf "$streamingPath/slide_encoding.txt"`;
	open (MYFILE, ">$streamingPath/slide_complete.txt");
	close(MYFILE);
	`chmod 770 "$streamingPath/slide_complete.txt"`;
}

`rm -rf "$encodingPath"`;

################################################################################

#########################################
#       User-defined Functions          #
#########################################

sub EncodeVideo_ClassX
{
	my $inputFileName=$_[0]; my $encodingPath=$_[1]; my $pipelinePath=$_[2]; my $streamingPath=$_[3];

	# Get the video duration and write it to Duration.txt
	`ffmpeg -i "$encodingPath/$inputFileName" > "$encodingPath/inputVideoInfo.txt" 2>&1`;
	open(inputVideoInfoFID,"<$encodingPath/inputVideoInfo.txt");
	my @lines=<inputVideoInfoFID>;
	`rm "$encodingPath/inputVideoInfo.txt"`;
	
	my $line; my $hours; my $minutes; my $seconds;
	foreach $line (@lines)
	{
		chomp($line);
		my $durationStringIndex=index($line,"Duration:");
		if($durationStringIndex>0)
		{
			my $firstCommaIndex=index($line,",");
			$hours=substr($line,$durationStringIndex+10,2);
			$minutes=substr($line,$durationStringIndex+13,2);
			$seconds=substr($line,$durationStringIndex+16,$firstCommaIndex-($durationStringIndex+16));
			
		}
	}
	my $duration=floor(3600*$hours+60*$minutes+$seconds);
	open (MYFILE, ">$encodingPath/Duration.txt");
	print MYFILE $duration;
	close (MYFILE);
	
	my $numFrames=floor(29.97*$duration);
	`$pipelinePath/VideoEncoder/ClassXEncoder -i "$encodingPath/$inputFileName" -o "$encodingPath" -p "$encodingPath/TrackingParameters.txt" -f $numFrames -q 30 -g 60 --overlap 1 -r 1 -q 30 -g 60`;
	`chmod -R 770 "$encodingPath"`;
	
	# Add audio to slice0.mp4
	my $thumbnailName;
	if(-e "$encodingPath/slice0.mp4") {
		$thumbnailName="slice0.mp4";
	}
	elsif(-e "$encodingPath/tile0.mp4") {
		$thumbnailName="tile0.mp4";
	}
	elsif(-e "$encodingPath/stream0.mp4") {
		$thumbnailName="stream0.mp4";
	}
	`mv "$encodingPath/$thumbnailName" "$encodingPath/thumbnail_noSound.mp4"`;
	`ffmpeg -i "$encodingPath/$inputFileName" -i "$encodingPath/thumbnail_noSound.mp4" -map 1:0 -map 0:1 -vcodec copy -ac 1 "$encodingPath/$thumbnailName"`;
	if(-e "$encodingPath/$thumbnailName") {
		`rm "$encodingPath/thumbnail_noSound.mp4"`;
	}
	`chmod -R 770 "$encodingPath"`;
	
	# Create TrackManifest.txt
	open(ipTrackFID,"<$encodingPath/tracked.log");
	my @trackLines=<ipTrackFID>;
	close(ipTrackFID);
	open(opTrackFID,">$encodingPath/TrackManifest.txt");
	print opTrackFID "8 29.97";
	foreach $line(@trackLines) {
		chomp($line);
		print opTrackFID "\n$line";
	}
	close(opTrackFID);
	`chmod -R 770 "$encodingPath"`;
}

sub EncodeVideo_OpenClassroom
{
	my $inputFileName=$_[0]; my $encodingPath=$_[1]; my $pipelinePath=$_[2]; my $streamingPath=$_[3];

	# Get the video duration and write it to Duration.txt
	`ffmpeg -i "$encodingPath/$inputFileName" > "$encodingPath/inputVideoInfo.txt" 2>&1`;
	open(inputVideoInfoFID,"<$encodingPath/inputVideoInfo.txt");
	my @lines=<inputVideoInfoFID>;
	`rm "$encodingPath/inputVideoInfo.txt"`;
	
	my $line; my $hours; my $minutes; my $seconds;
	foreach $line (@lines)
	{
		chomp($line);
		my $durationStringIndex=index($line,"Duration:");
		if($durationStringIndex>0)
		{
			my $firstCommaIndex=index($line,",");
			$hours=substr($line,$durationStringIndex+10,2);
			$minutes=substr($line,$durationStringIndex+13,2);
			$seconds=substr($line,$durationStringIndex+16,$firstCommaIndex-($durationStringIndex+16));
			
		}
	}
	my $duration=floor(3600*$hours+60*$minutes+$seconds);
	open (MYFILE, ">$encodingPath/Duration.txt");
	print MYFILE $duration;
	close (MYFILE);
	print "\n\nffmpeg -i \"$encodingPath/$inputFileName\" -vcodec libx264 -vpre normal -cqp 30 -s 960x540 -g 60 -ac 1 \"$encodingPath/encodedVideo.mp4\"\n\n";
	`ffmpeg -i "$encodingPath/$inputFileName" -vcodec libx264 -vpre normal -cqp 30 -s 960x540 -g 60 -ac 1 "$encodingPath/encodedVideo.mp4"`;
	`chmod -R 770 "$encodingPath"`;
}

sub GenerateVideoSnapshots
{
	my $format=$_[0]; my $encodingPath=$_[1]; my $streamingPath=$_[2];
	my $inputFileName;
	if($format eq 'classx') {
		if(-e "$encodingPath/tile0.mp4") {
			$inputFileName="tile0.mp4";
		}
		elsif(-e "$encodingPath/slice0.mp4") {
			$inputFileName="slice0.mp4";
		}
		elsif(-e "$encodingPath/stream0.mp4") {
			$inputFileName="stream0.mp4";
		}
	}
	elsif($format eq 'openclassroom') {
		$inputFileName="encodedVideo.mp4";
	}

	# Get the video duration
	`ffmpeg -i "$encodingPath/$inputFileName" > "$encodingPath/inputVideoInfo.txt" 2>&1`;
	open(inputVideoInfoFID,"<$encodingPath/inputVideoInfo.txt");
	my @lines=<inputVideoInfoFID>;
	`rm "$encodingPath/inputVideoInfo.txt"`;
	
	# Get video duration and aspect ratio	
	my $line; my $hours; my $minutes; my $seconds;
	my $snapshot_size='106x60';
	foreach $line (@lines)
	{
		chomp($line);
		my $durationStringIndex=index($line,"Duration:");
		if($durationStringIndex>0)
		{
			my $firstCommaIndex=index($line,",");
			$hours=substr($line,$durationStringIndex+10,2);
			$minutes=substr($line,$durationStringIndex+13,2);
			$seconds=substr($line,$durationStringIndex+16,$firstCommaIndex-($durationStringIndex+16));
			
		}
		if(index($line,'DAR 16:9')>0) {
			$snapshot_size='106x60'; break;
		}
	}
	my $duration=floor(3600*$hours+60*$minutes+$seconds);
	if(-e "$streamingPath/Snapshots") {
		`rm -rf "$streamingPath/Snapshots"`;
	}

	`mkdir "$streamingPath/Snapshots"`;
	`chmod 770 "$streamingPath/Snapshots"`;
	
	for(my $i=1;$i<$duration-2;$i+=300) {
		$snapshot_name=$i-1;
		while(length($snapshot_name)<5) {
			$snapshot_name='0'.$snapshot_name;
		}
		if(!(-e "$streaming/Snapshots/$snapshot_name")) {
			`ffmpeg -i "$encodingPath/$inputFileName" -s $snapshot_size -ss $i -y "$streamingPath/Snapshots/$snapshot_name.jpg"`;
		}
	}

	`chmod -R 770 "$streamingPath/Snapshots"`;
}

sub SyncSlides
{
	
	my $inputFileName=$_[0]; my $encodingPath=$_[1]; my $pipelinePath=$_[2];
	
	mkdir "$encodingPath/SlideSyncWorkDir",0700;
	`cp -r "$encodingPath/SlideDeck" "$encodingPath/SlideSyncWorkDir"`;

	##############################################################################
	# Step 1: Rename the slide images in SlideDeck to a monolithic naming scheme #
	##############################################################################

	opendir(DIR,"$encodingPath/SlideDeck");
	my @originalJpgFileNames = grep(/\.jpg$/,readdir(DIR));
	@originalJpgFileNames = sort @originalJpgFileNames;
	closedir(DIR);

	my $currentJpgFileIndex=0;
	foreach my $jpgFile(@originalJpgFileNames) {
		my $indexString=$currentJPGFileIndex;
		while(length($indexString)<3) {
			$indexString="0".$indexString;
		}
		`mv "$encodingPath/SlideSyncWorkDir/SlideDeck/$jpgFile" "$encodingPath/SlideSyncWorkDir/SlideDeck/$indexString.jpg"`;
		$currentJPGFileIndex++;
	}
	my $numSlides=@originalJpgFileNames;
	
	##################################################
	# Step 2: Run the slide synchronization function #
	##################################################

	# Create the Param File
	open (MYFILE, ">$encodingPath/SlideSyncWorkDir/SlideSyncParamFile.txt");
	print MYFILE "1920\n1080\n";
	print MYFILE "$pipelinePath/SlideSynchronizer/sift\n";
	print MYFILE "$pipelinePath/SlideSynchronizer/image_matching\n";
	print MYFILE "$encodingPath/SlideSyncWorkDir/SlideDeck/\n";
	print MYFILE "$numSlides\n";
	print MYFILE "50\n776\n582\n";
	print MYFILE "$pipelinePath/SlideSynchronizer/slideMatch\n";
	print MYFILE "$encodingPath/$inputFileName\n";
	print MYFILE "12\n"; # This parameter may need to be tuned
	print MYFILE "$encodingPath/SlideSyncWorkDir/";
	close(MYFILE);
	`cp "$encodingPath/SlideSyncWorkDir/SlideSyncParamFile.txt" "$streamingPath/SlideSyncParamFile.txt"`;
	`chmod 770 "$encodingPath/SlideSyncWorkDir/SlideSyncParamFile.txt"`;

	# Perform the Slide Sync
	`$pipelinePath/SlideSynchronizer/processExt_extract_sift_fr_jpg "$encodingPath/SlideSyncWorkDir/SlideDeck/" "$pipelinePath"`;
	`$pipelinePath/SlideSynchronizer/changeDetect "$encodingPath/SlideSyncWorkDir/SlideSyncParamFile.txt"`;
	`$pipelinePath/SlideSynchronizer/slideMatch "$encodingPath/SlideSyncWorkDir/SlideSyncParamFile.txt"`;

	`cp "$encodingPath/SlideSyncWorkDir/resultsOut.txt" "$encodingPath/SlideMatchingResults.txt"`;
	`cp "$encodingPath/SlideSyncWorkDir/resultsOut_model.txt" "$encodingPath/TransformationModels.txt"`;
	`chmod 770 "$encodingPath/SlideMatchingResults.txt"`;

	######################################
	# Step 3: Generate SlideManifest.txt #
	######################################
	
	my $i=0;
	
	# Filter down the Results File
	#------------------------------
	# Read the results file
	open(matchingFileLines,"$encodingPath/SlideMatchingResults.txt");
	open(modelsFileLines,"$encodingPath/TransformationModels.txt");
	my @matchingLines=<matchingFileLines>;
	my @modelLines=<modelsFileLines>;
	chomp @matchingLines;
	chomp @modelLines;
	my $numMatchingLines=@matchingLines;
	my $numModelLines=@modelLines;

	while($numMatchingLines > 0 && length($matchingLines[$numMatchingLines-1]) == 0) {
		pop(@matchingLines); $numMatchingLines=@matchingLines;
	}

	exit(0) if $numMatchingLines<1;
	
	# Add dummy line at end of matchingLines very distant into the future
	push(@matchingLines,"30000000\t999");
	
	my $slideManifestString=$originalJpgFileNames[0];
	for($i=1;$i<$numSlides;$i++) {
		$slideManifestString.=",".$originalJpgFileNames[$i];
	}

	$i=0;
	while($i<$numMatchingLines)
	{
		print $i."\n";
		# Event elements: 0-frame number   1-slide number
		# Model elements: 0-a   1-b   2-c   3-d   4-e   5-f
		my $showtimeStart=(split(/\t/,$matchingLines[$i]))[0]/29.97; $i++;
		while((split(/\t/,$matchingLines[$i]))[1] == (split(/\t/,$matchingLines[$i-1]))[1]) {
			$i++;
		}
		my $showtimeEnd=(split(/\t/,$matchingLines[$i]))[0]/29.97;
		
		$slideManifestString.="\n".$originalJpgFileNames[(split(/\t/,$matchingLines[$i-1]))[1]]." ".floor($showtimeStart)." ".floor($showtimeEnd)." ".(split(/\t/,$modelLines[$i-1]))[0].",".(split(/\t/,$modelLines[$i-1]))[1].",".(split(/\t/,$modelLines[$i-1]))[2].",".(split(/\t/,$modelLines[$i-1]))[3].",".(split(/\t/,$modelLines[$i-1]))[4].",".(split(/\t/,$modelLines[$i-1]))[5];
	}

	open (MYFILE, ">$encodingPath/SlideManifest.txt");
	print MYFILE $slideManifestString;
	close (MYFILE);
	
	`rm "$encodingPath/SlideMatchingResults.txt"`;
	`rm "$encodingPath/TransformationModels.txt"`;
	`rm -rf "$encodingPath/SlideDeck"`;
	`rm -rf "$encodingPath/SlideSyncWorkDir"`;
	`chmod -R 770 "$encodingPath"`;

}

sub get_video_properties
{
	my $name=$_[0];
	my $ffmpeg_output=`ffmpeg -i "$name" 2>&1`;

	# Get the string part that holds the properties (starts by "Duration:")
	my $data_str_start_index=index($ffmpeg_output,"Duration:");
	my $data_str=substr($ffmpeg_output,$data_str_start_index);

	# Get the duration in seconds
	my $comma_index=index($data_str,",");
	my $hours=substr($data_str,10,2);
	my $mins=substr($data_str,13,2);
	my $secs=substr($data_str,16,$comma_index-16);
	my $duration=3600*$hours+60*$mins+$secs;
	$data_str=substr($data_str,$comma_index+2);

	# Get the start time in seconds
	$comma_index=index($data_str,",");
	my $start=substr($data_str,7,$comma_index-7);
	$data_str=substr($data_str,$comma_index+2);

	# Get bitrate in kb/s
	$kbps_index=index($data_str,"kb/s");
	my $bitrate=substr($data_str,9,$kbps_index-9);
	
	# Get resolution
	my $offset=index($data_str,"Stream #0.0");
	for(my $i=0;$i<2;$i++) {
		$offset=index($data_str,",",$offset)+2;
	}
	my $end_index_comma=index($data_str,",",$offset);
	my $end_index_space=index($data_str," ",$offset);
	my $end_index=($end_index_comma<$end_index_space)?($end_index_comma):($end_index_space);
	my $cross_index=index($data_str,"x",$offset);
	my $h_resolution=substr($data_str,$offset,$cross_index-$offset);
	my $v_resolution=substr($data_str,$cross_index+1,$end_index-$cross_index-1);

	my %output=("duration",$duration,"start",$start,"bitrate",$bitrate,"res_h",$h_resolution,"res_v",$v_resolution);
	return %output;

}

################################################################################

#########################################
#           Utility Functions           #
#########################################

sub str_replace {
	my $replace_this = shift;
	my $with_this  = shift; 
	my $string   = shift;
	
	my $length = length($string);
	my $target = length($replace_this);
	
	for(my $i=0; $i<$length - $target + 1; $i++) {
		if(substr($string,$i,$target) eq $replace_this) {
			$string = substr($string,0,$i) . $with_this . substr($string,$i+$target);
			#return $string; #Comment this if you what a global replace
		}
	}
	return $string;
}

################################################################################
