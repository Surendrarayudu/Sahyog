#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use lib '../../modules';
use GestioIP;


my $gip = GestioIP -> new();
my $daten=<STDIN>;
my %daten=$gip->preparer($daten);

my ($lang_vars,$vars_file)=$gip->get_lang();
my $client_id = $daten{'client_id'} || $gip->get_first_client_id();


# check Permissions
my @global_config = $gip->get_global_config("$client_id");
my $user_management_enabled=$global_config[0]->[13] || "";
if ( $user_management_enabled eq "yes" ) {
	my $required_perms="administrate_cm_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


# Parameter check
my $cm_log_file = $daten{'cm_log_file'} || "";
my $cm_log_file_stdout = $daten{'cm_log_file_stdout'} || "";
my $ip = $daten{'ip'} || "";
my $ip_version = $daten{'ip_version'} || "";
$cm_log_file=$cm_log_file_stdout if ! $cm_log_file && $cm_log_file_stdout;

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{show_log_message}",notification=>"$$lang_vars{select_log_file_message}",vars_file=>"$vars_file",client_id=>"$client_id") if ! $cm_log_file;

my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	cm_log_file=>"$cm_log_file",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{show_log_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;

if ( $ip ) {
	$error_message=$gip->check_parameters(
		vars_file=>"$vars_file",
		client_id=>"$client_id",
		ip=>"$ip",
		ip_version=>"$ip_version",
	) || "";

	$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{show_log_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;
}

my $server_proto=$gip->get_server_proto();
my $base_uri = $gip->get_base_uri();


$cm_log_file =~ /^(\d{14})_(\d{1,3})_.*$/;
my $date=$1;
$date =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/;
my $year=$1;
my $month=$2;
my $day=$3;
my $hour=$4;
my $minute=$5;
my $sec=$6;
my $date_cm_file=$day . "/" . $month . "/" . $year . " - " . $hour . ":" . $minute . ":" . $sec;

$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{log_from_message} $date_cm_file","$vars_file");


my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

my $cm_log_dir=$global_config[0]->[11];

print "<p><br>\n";

open(LOG,"<${cm_log_dir}/${cm_log_file}") or $gip->print_error("$client_id","$cm_log_file: $!");

my $match_ip=$ip;
$match_ip="XXXXX" if ! $ip;
while (<LOG>) {
        $_ =~ s//<br>/;
	if ( $_ =~ /^$/ ) {
		print "<p>\n";
	} elsif ( $_ =~ /^############## $match_ip/ ) {
		$_=~/############## (.+) \(/;
		my $ip=$1;
		print "<span id=\"$match_ip\"><b>$_</b></span>\n";
#	} elsif ( $_ =~ /^############## / ) {
#		$_=~/############## (.+) \(/;
#		my $ip=$1;
#		print "<span id=\"$ip\">$_</span>\n";
	} elsif ( $_ =~ /^ERROR/ ) {
		print "<span class=\"RedBold\">$_</span>\n";
	} elsif ( $_ =~ /^Job execution Summary/ ) {
		print "<b>$_</b>";
	} elsif ( $_ =~ /^Configuration changed/ ) {
		$_ =~ s/Configuration changed:/\<b\>Configuration changed:\<\/b\>/;
		print "$_";
	} elsif ( $_ =~ /^Configuration unchanged:/ ) {
		$_ =~ s/Configuration unchanged:/\<b\>Configuration unchanged:\<\/b\>/;
		print "$_";
	} elsif ( $_ =~ /^Backup failed:/ ) {
		$_ =~ s/Backup failed:/\<b\>Backup failed:\<\/b\>/;
		print "$_";
	} else {
		print "$_";
	}
}

print "<br><p>\n";


$gip->print_end("$client_id");
