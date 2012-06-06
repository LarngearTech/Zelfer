#!/usr/local/bin/perl

use File::Copy;
use POSIX;
use Cwd "abs_path";

# This script takes a folder as input and then checks the health of the raw video files therein.
# The health check rules are as follows:
# 1- There must be at least one input video file.
# 2- The video files in the folder must all follow a single file extension.
# 3- This file extension must ebelong to the list of supported file types: avi, flv, mp4, mts, and wmv.
# 4- If the file extension is not MTS, there can only be a single video file.
# 5- If the file extension is MTS, there can possibly be more than one video file, but they must all belong to a single recording.
#    This can be checked by querying the properties of the video file, and then checking that each file has a start time equal to the
#    start time of the previous video file plus the duration of the previous video file.
#    For this check, the MTS files should be sorted lexicographically. We assume that the first MTS file closed is has the lowest name.

my $inputPath=shift(@ARGV);
my $duration;
my $res_x;
my $res_y;

#####################################################################################
#   Get lists of all video files in all supported extensions in the input folder    #
#####################################################################################

# AVI Files
opendir(DIR,$inputPath);
my @aviFiles = grep(/\.avi$/,readdir(DIR));
my $numAVIFiles=@aviFiles;
my $hasAVIFiles=($numAVIFiles>0)?(1):(0);
closedir(DIR);

# FLV Files
opendir(DIR,$inputPath);
my @flvFiles = grep(/\.flv$/,readdir(DIR));
my $numFLVFiles=@flvFiles;
my $hasFLVFiles=($numFLVFiles>0)?(1):(0);
closedir(DIR);

# MOV Files
opendir(DIR,$inputPath);
my @movFiles = grep(/\.mov$/,readdir(DIR));
my $numMOVFiles=@movFiles;
my $hasMOVFiles=($numMOVFiles>0)?(1):(0);
closedir(DIR);

# MP4 Files
opendir(DIR,$inputPath);
my @mp4Files = grep(/\.mp4$/,readdir(DIR));
my $numMP4Files=@mp4Files;
my $hasMP4Files=($numMP4Files>0)?(1):(0);
closedir(DIR);

# MTS Files
opendir(DIR,$inputPath);
my @mtsFiles = grep(/\.MTS$/,readdir(DIR));
@mtsFiles = sort @mtsFiles;
my $numMTSFiles=@mtsFiles;
my $hasMTSFiles=($numMTSFiles>0)?(1):(0);
closedir(DIR);

# WMV Files
opendir(DIR,$inputPath);
my @wmvFiles = grep(/\.wmv$/,readdir(DIR));
my $numWMVFiles=@wmvFiles;
my $hasWMVFiles=($numWMVFiles>0)?(1):(0);
closedir(DIR);

#####################################################################################
#                                Start health checks                                #
#####################################################################################

# If all health checks are passed, we will output a '2'.
# If a warning is raised, we will output a '1:X', where X is a human-readable warning message.
# If a warning is raised, we will output a '0:X', where X is a human-readable error message.

#                   ###########################################
#                        Check 1: At least one video file
#                   ###########################################

if(($numAVIFiles+$numFLVFiles+$numMOVFiles+$numMP4Files+$numMTSFiles+$numWMVFiles) == 0) {
	print "0:No input video files of supported extension (avi, flv, mov, mp4, MTS, or wmv) were found. Please go back to step 2 and upload exactly one (avi, flv, mp4, or wmv) files or one or more MTS files.";
	exit(0);
}

#                   ###########################################
#                           Check 2: Single extension
#                   ###########################################

if(($hasAVIFiles+$hasFLVFiles+$hasMOVFiles+$hasMP4Files+$hasMTSFiles+$hasWMVFiles) > 1) {
	print  "0:Multiple video files is only supported for MTS files, where the files all belong to the same recording. For any other file type, you must upload exactly one video file.";
	exit(0);
}

#                   ###########################################
#                        Check 3: Single file if non-MTS
#                   ###########################################

if(($hasAVIFiles+$hasFLVFiles+$hasMOVFiles+$hasMP4Files+$hasWMVFiles) > 0) {
	if(($numAVIFiles+$numFLVFiles+$numMOVFiles+$numMP4Files+$numWMVFiles) > 1) {
		print "0:Multiple video files is only supported for MTS files, where the files all belong to the same recording. For any other file type, you must upload exactly one video file.";
		exit(0);
	}
	else {
		# There is exactly one file of non-MTS extension. Get its resolution and duration.
		my $input_file;
		if($hasAVIFiles) { $input_file = $aviFiles[0]; }
		if($hasFLVFiles) { $input_file = $flvFiles[0]; }
		if($hasMOVFiles) { $input_file = $movFiles[0]; }
		if($hasMP4Files) { $input_file = $mp4Files[0]; }
		if($hasWMVFiles) { $input_file = $wmvFiles[0]; }
		
		my %file_properties = get_video_properties("$inputPath/$input_file");
		$duration=$file_properties{"duration"};
		$res_x=$file_properties{"res_h"};
		$res_y=$file_properties{"res_v"};
	}
}

#                   ###########################################
#                      Check 4: Continuous Stream if MTS Set
#
                   ###########################################
my $warning_string=" Warning issue(s): ";
my $has_warnings=0;

if($hasMTSFiles == 1) {
	
	my %last_file_properties=get_video_properties("$inputPath/".$mtsFiles[0]);
	my %current_file_properties;

	$duration=$last_file_properties{"duration"};
	$res_x=$last_file_properties{"res_h"};
	$res_y=$last_file_properties{"res_v"};

	if($numMTSFiles > 1) {
		# Check the continuity of the MTS files

		for(my $i=1;$i<$numMTSFiles;$i++) {
			my $short_last_file_name=substr($mtsFiles[$i-1],rindex($mtsFiles[$i-1],"/")+1);
			my $short_current_file_name=substr($mtsFiles[$i],rindex($mtsFiles[$i],"/")+1);
			%current_file_properties=get_video_properties("$inputPath/".$mtsFiles[$i]);
			
			$duration=$duration+$current_file_properties{"duration"};
			print "Current file: ".$mtsFiles[$i].", start: ".$current_file_properties{"start"}.", last file start: ".$last_file_properties{"start"}.", last file duration: ".$last_file_properties{"duration"}."\n";
			if($current_file_properties{"start"} > ($last_file_properties{"start"}+$last_file_properties{"duration"}+5)) {
				if($last_file_properties{"duration"}==0) {
					# This is due a very wierd case where a ffmpeg would report a duration of 0 seconds for the video. We ignore the apparent file discontinuity and cross our fingers!
					# The reported duration will not be correct. Issue a wanring for that.
					$has_warnings=1;
					$warning_string=$warning_string."Cannot determine duration of file ".$short_last_file_name." due to header corruption. The total video duration may be inaccurate. ";
				}
				else {	
					print "0:MTS file ".$short_current_file_name." does not seem to be a continuation of the video in MTS file ".$short_last_file_name.". Please revise the uploaded video files.";
					exit(0);
				}
			}
			%last_file_properties=%current_file_properties;
		}
	}

	# Issue a warning if the first MTS has a start time much greater than 0.	
	my $short_first_file_name=substr($mtsFiles[0],rindex($mtsFiles[0],"/")+1);
	my %first_file_properties=get_video_properties("$inputPath/".$mtsFiles[0]);
	if($first_file_properties{"start"}>5) {
		$has_warnings=1;
		$warning_string = $warning_string."There seems to be a missing MTS file in the video recording before ".$short_first_file_name.". However, you may still encode the presentation.";
	}
}

# Reaching this point implies that all health checks have been passed. Get additional information (video duration and resolution) and send it along with the health flag.

my $duration_hours=floor($duration/3600);
my $temp=$duration-3600*$duration_hours;
my $duration_minutes=floor($temp/60);
my $duration_seconds=floor($temp-60*$duration_minutes);

if(length($duration_minutes) == 1) {
	$duration_minutes = "0".$duration_minutes;
}
if(length($duration_seconds) == 1) {
	$duration_seconds = "0".$duration_seconds;
}

my $output_string="1:$duration_hours:$duration_minutes:$duration_seconds#".$res_x."x".$res_y;
if($has_warnings==1) {
	$output_string=$output_string."#$warning_string";
}
print $output_string;


###############################################################################
#                                 Subroutines                                 #
###############################################################################

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
	my @data_str_lines = split("\n",$data_str);
	my $h_resolution; my $v_resolution;
	foreach my $line (@data_str_lines) {
		if((index($line,"Stream") >= 0) && (index($line,"Video") >= 0)) {
			my $offset = 0;
			for(my $i=0;$i<2;$i++) {
				$offset=index($line,",",$offset)+2;
			}
			my $end_index_comma=index($line,",",$offset);
			my $end_index_space=index($line," ",$offset);
			my $end_index=($end_index_comma<$end_index_space)?($end_index_comma):($end_index_space);
			my $cross_index=index($line,"x",$offset);
			$h_resolution=substr($line,$offset,$cross_index-$offset);
			$v_resolution=substr($line,$cross_index+1,$end_index-$cross_index-1);
			break;
		}
	}
	
	my %output=("duration",$duration,"start",$start,"bitrate",$bitrate,"res_h",$h_resolution,"res_v",$v_resolution);
	return %output;

}
