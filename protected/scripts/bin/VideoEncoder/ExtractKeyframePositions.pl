#!/usr/bin/perl

use IPC::Open3;
use strict;

my $numArgs = $#ARGV + 1;

if($numArgs != 1)
{
	print "Usage: <input directory (absolute) containing slice files> \n";
	exit(0);
}

my $input_directory = shift(@ARGV);

my $cmdStr;
my @slice_files;

opendir(DIR, "$input_directory") or die "Can't open directory $input_directory \n";	
@slice_files = grep(/\.mp4$/,readdir(DIR));
@slice_files = sort @slice_files;
closedir(DIR);

# extract keyframe positions
#my $ErrMsg;
#$ErrMsg=`rm $input_directory/keyframes.log`;
open(FILE, ">$input_directory/keyframes.log") or die "Can't open $input_directory/keyframes.log for writing...\n";
my $last_output = "";
foreach my $slice_file (@slice_files)
{
	print FILE "$slice_file\t";
	$last_output = `$input_directory/extract-keyframe-positions $input_directory/$slice_file 29.97`;
	print FILE "$last_output\n";
}
close(FILE);

