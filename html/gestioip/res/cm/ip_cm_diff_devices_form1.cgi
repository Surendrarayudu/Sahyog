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


# Parameter check
my $lang = $daten{'lang'} || "";
$lang="" if $lang !~ /^\w{1,3}$/;
my ($lang_vars,$vars_file)=$gip->get_lang("","$lang");
my $client_id = $daten{'client_id'} || $gip->get_first_client_id();


# check Permissions
my @global_config = $gip->get_global_config("$client_id");
my $user_management_enabled=$global_config[0]->[13] || "";
if ( $user_management_enabled eq "yes" ) {
	my $required_perms="administrate_cm_perm,read_device_config_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}

my $diff_host1 = $daten{'diff_host1'} || "";
my $diff_host2 = $daten{'diff_host2'} || "";

my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	diff_host1=>"$diff_host1",
	diff_host2=>"$diff_host2",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;

##Set global variable
#$gip->{CM_show_hosts} = 1;

my $server_proto=$gip->get_server_proto();
my $base_uri = $gip->get_base_uri();

$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{diff_configs_jo_message}","$vars_file");


my $client_name=$gip->get_client_from_id("$client_id");
my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;

#${host_id}_${job_id}_${device_type_group_id}
$diff_host1=~/^(\d+)_(\d+)_(.+)_(.+)$/;
my $host_id1=$1;
my $job_id1=$2;
my $device_type_group_id1=$3;
my $job_name1=$4;
$diff_host2=~/^(\d+)_(\d+)_(.+)_(.+)$/;
my $host_id2=$1;
my $job_id2=$2;
my $device_type_group_id2=$3;
my $job_name2=$4;
$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $host_id1 || ! $host_id2 || ! $job_id1 || ! $job_id2 || ! $device_type_group_id1 || ! $device_type_group_id2;


my $configs1=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id1}");
my @configs1=@$configs1;
my $configs2=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id2}");
my @configs2=@$configs2;

my $job_without_output=0;

my $binary_config=0;
my @new_configs1=();
foreach my $config_name (@configs1) {
	if ( $config_name =~ /_${job_id1}\.(conf|txt)\..+/ ) {
		$binary_config=1;
		last;
	}
	if ( $config_name =~ /^(\d{12})_(\d{2})_(\d+)_${job_id1}\./ ) {
		push (@new_configs1,"$config_name");
	}
}

my @new_configs2=();
foreach my $config_name (@configs2) {
	if ( $config_name =~ /_${job_id2}\.(conf|txt)\..+/ ) {
		$binary_config=1;
		last;
	}
	if ( $config_name =~ /^(\d{12})_(\d{2})_(\d+)_${job_id2}\./ ) {
		push (@new_configs2,"$config_name");
	}
}



my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}


my $hostname1=$gip->get_host_value_from_host_id("$client_id","$host_id1","hostname") || "";
my $hostname2=$gip->get_host_value_from_host_id("$client_id","$host_id2","hostname") || "";
print "<p><br>\n";
print "<b>$$lang_vars{choose_diffs_message}</b><p>\n";
print "<form name=\"ip_cm_diff_devices_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff.cgi\"><br>\n";

print "<table border=\"0\" cellpadding=\"1\">\n";
if ( scalar(@new_configs1) == 0 ) {
	print "<tr><td><b>$hostname1</b>($job_name1)</td><td><i>$$lang_vars{no_job_files_message}</i></td></tr>\n";
	$job_without_output=1;
} else {
	print "<tr><td><b>$hostname1</b> ($job_name1)</td><td>\n";
	print "<select name=\"diff_config_1\" size=\"1\">\n";
	foreach my $config_name (@new_configs1) {
		my ($date_form,$serial)=$gip->get_config_name_values("$config_name");
		print "<option value=\"$config_name\">$date_form ($serial)</option>\n";
	}
	print "</select>\n";
}

print "</td></tr></td></tr>\n";

if ( scalar(@new_configs2) == 0 ) {
	print "<tr><td><b>$hostname2</b>($job_name2)</td><td><i>$$lang_vars{no_job_files_message}</i></td></tr>\n";
	$job_without_output=1;
} else {
	print "<tr><td><b>$hostname2</b>($job_name2)</td><td>\n";
	print "<select name=\"diff_config_2\" size=\"1\">\n";
	foreach my $config_name (@new_configs2) {
		my ($date_form,$serial)=$gip->get_config_name_values("$config_name");
		print "<option value=\"$config_name\">$date_form ($serial)</option>\n";
	}
	print "</select>\n";
}

print "</td></tr>\n";
print "</td></tr><tr><td>\n";
print "<input type=\"hidden\" value=\"$host_id1\" name=\"host_id1\"><input type=\"hidden\" value=\"$host_id2\" name=\"host_id2\">\n";
print "<input type=\"hidden\" value=\"$job_id1\" name=\"job_id1\"><input type=\"hidden\" value=\"$job_id2\" name=\"job_id2\">\n";

if ( $job_without_output == 0 ) {
	print "<input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><p><input type=\"submit\" value=\"$$lang_vars{diff_message}\" name=\"B2\" class=\"input_link_w_net\">\n";
}
print "</td></tr>\n";
print "</table>\n";
print "</form>\n";

if ( $job_without_output == 1 ) {
        print "<p><br><p><FORM><INPUT TYPE=\"BUTTON\" VALUE=\"$$lang_vars{atras_message}\" ONCLICK=\"history.go(-1)\" class=\"error_back_link\"></FORM>\n";
}


print "<br><p>\n";

$gip->print_end("$client_id");
