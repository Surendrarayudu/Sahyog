#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use lib '../../modules';
use GestioIP;
use Text::Diff;


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
	my $required_perms="administrate_cm_perm,read_device_config_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


# Parameter check
my $host_id = $daten{'host_id'} || "";
my $hostname = $daten{'hostname'} || "";
my $search_string = $daten{'search_string'} || "";
my $config_name = $daten{'config'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        host_id=>"$host_id",
        hostname=>"$hostname",
        search_string=>"$search_string",
        cm_config_name=>"$config_name",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{show_cm_config_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{show_cm_config_message} $hostname","$vars_file");


my $client_name=$gip->get_client_from_id("$client_id");
my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;
if ( ! $cm_backup_dir ) {
	$gip->print_error("$client_id","$$lang_vars{no_cm_config_dir_message}");
}

my $configs=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id}");
my @configs=@$configs;

foreach my $cmn (@configs) {
	if ( $cmn =~ /^$config_name/ ) {
		$config_name=$cmn;
		last;
	}
}

my $conf=$cm_backup_dir . "/" . $host_id . "/" . $config_name;

my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

#$config_name =~ /^(\d{12})_(\d{2})_(\d+).(\d+)\.(txt|conf)$/;
$config_name =~ /^(\d{12})_(\d{2})_(\d+).(\d+)\.(txt|conf)/;
my $date=$1;
my $serial=$2;
my $host_id_config_file=$3;
$date =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})$/;
my $year=$1;
my $month=$2;
my $day=$3;
my $hour=$4;
my $minute=$5;
my $date_form=$day . "/" . $month . "/" . $year . " " . $hour . ":" . $minute . " ($serial)";
 

print "<p><br>\n";
print "<b>$date_form</b> ($config_name) <a href=\"$server_proto://$base_uri/conf/$client_name/$host_id/$config_name\" class=\"input_link_w\">$$lang_vars{download_message}</a><p>\n";
print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\"><tr><td>\n";

open(CONF,"$conf") or $gip->print_error("$client_id","$$lang_vars{can_not_open_cm_config_message}: $!");
print "<pre>\n";
while (<CONF>) {
	if ( $_ =~ /$search_string/ ) {
		print "<font color=\"green\">$_</font>";
	} else {
		print "$_";
	}
}
print "</pre>\n";
print "</td></tr></table>\n";
close CONF;

$gip->print_end("$client_id");
