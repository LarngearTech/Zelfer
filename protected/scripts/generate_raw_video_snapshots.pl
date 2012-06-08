#!/usr/local/bin/perl

use POSIX;

#####################################################
#           Parse and Check Input Arguments         #
#####################################################

my $numArgsInput = $#ARGV + 1;

if ($numArgsInput!=1) {
	print "\n";
	print "Error: Expecting 1 argument.\n";
	print "Usage: generate_raw_video_snapshots.pl session_encoding_directory\n";
	exit(0);
}

my $inputPath=shift(@ARGV);

if(!(-e "$inputPath")) {
	# print "\n";
	# print "Error: Incorrect input path\n".$inputPath;
	exit(0);
}

# 1- Delete any snapshot for which there is no corresponding video file
opendir(DIR,$inputPath);
my @snapshotFiles = grep(/\.jpg$/,readdir(DIR));
closedir(DIR);

foreach my $snapshot (@snapshotFiles) {
	my $base_name=substr($snapshot,0,-3);
	if(length($base_name)>0 && !((-e "$inputPath/$base_name.avi") || (-e "$inputPath/$base_name.flv") || (-e "$inputPath/$base_name.mp4") || (-e "$inputPath/$base_name.MTS") || (-e "$inputPath/$base_name.wmv"))) {
		`rm $inputPath/$snapshot`;
	}
}


opendir(DIR,$inputPath);
my @videoFiles = grep(/\.(avi|flv|mov|mp4|MTS|wmv)$/,readdir(DIR));
closedir(DIR);

foreach my $video_file (@videoFiles) {
	my $snapshot_file = substr($video_file,0,-4).".jpg";
	if(!(-e "$inputPath/$snapshot_file")) { 
		`ffmpeg -i \"$inputPath/$video_file\" > \"$inputPath/inputVideoInfo.txt\" 2>&1`;
		open(inputVideoInfoFID,"<$inputPath/inputVideoInfo.txt");
		my @lines=<inputVideoInfoFID>;
		`rm \"$inputPath/inputVideoInfo.txt\"`;

		my $snapshot_size='213x160';
		foreach $line (@lines) {
			chomp($line);		
			if(index($line,'DAR 16:9')>0) {
				$snapshot_size='213x120'; break;
			}
		}

		`ffmpeg -i \"$inputPath/$video_file\" -y -ss 0.1 -s $snapshot_size \"$inputPath/$snapshot_file\"`;
		`chmod 777 \"$inputPath/$snapshot_file\"`;
	}
	
}
