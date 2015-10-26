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

my $server_proto=$gip->get_server_proto();
my $base_uri = $gip->get_base_uri();
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
my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{show_log_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{show_log_message}","$vars_file");


my $cm_log_dir=$global_config[0]->[11];

my $log_files=$gip->get_log_file_list("$client_id","$cm_log_dir") || "";

my @log_files=@$log_files;
my @log_files_new=();
foreach (@log_files) {
	my $log_file=$_;
	if ( $log_file =~ /^(\d{14})_(\d{1,3})_fetch_config.log$/ ) {
		push (@log_files_new,"$log_file");
	}
}

@log_files=@log_files_new;

my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}


print "<p><br>\n";

if ( scalar @log_files == 0 ) {
	print "<p><i>$$lang_vars{no_cm_log_message}</i><br>\n";
} else {
	print "<b>$$lang_vars{log_from_message}</b>\n";
	print "<form name=\"show_cm_log_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi\" style=\"display:inline;\"><br>\n";
	print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\"><tr><td>\n";
	print "<tr valign=\"top\"><td><font size=\"2\">$$lang_vars{from_message}<br>:\n";
	print "<select name=\"cm_log_file\" size=\"10\">";

	foreach (@log_files) {
		my $log_file=$_;
		$log_file =~ /^(\d{14})_(\d{1,3})_.*$/;
		my $date=$1;
		$date =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/;
		my $year=$1;
		my $month=$2;
		my $day=$3;
		my $hour=$4;
		my $minute=$5;
		my $sec=$6;
		my $date_form=$day . "/" . $month . "/" . $year . " - " . $hour . ":" . $minute . ":" . $sec; 
		print "<option value=\"$log_file\">$date_form</option>";
	}
	print "</select>\n";

	print "</td><td valign=\"bottom\">\n";
	print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{show_message}\" name=\"B2\" class=\"input_link_w_net\"></span></form><br><p>\n";
}

print "</td></tr>\n";
print "</table>\n";

print "<br><p>\n";

$gip->print_end("$client_id");
