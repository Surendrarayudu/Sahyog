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
my $device_user_group_name=$daten{'device_user_group_name'} || "";
my $device_user_name=$daten{'device_user_name'} || "";
my $login_pass=$daten{'login_pass'} || "";
my $retype_login_pass=$daten{'retype_login_pass'} || "";
my $priv_pass=$daten{'priv_pass'} || "";
my $retype_priv_pass=$daten{'retype_priv_pass'} || "";
my $description=$daten{'description'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
	device_user_group_name=>"$device_user_group_name",
	device_user_name=>"$device_user_name",
	login_pass=>"$login_pass",
	retype_login_pass=>"$retype_login_pass",
	user_group_priv_pass=>"$priv_pass",
	retype_priv_pass=>"$retype_priv_pass",
	user_group_description=>"$description",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{device_user_group_add_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{device_user_group_added_message}","$vars_file");


$gip->print_error("$client_id","$$lang_vars{login_pass_no_match_message}") if $login_pass ne $retype_login_pass;
$gip->print_error("$client_id","$$lang_vars{priv_pass_no_match_message}") if $priv_pass ne $retype_priv_pass;
$gip->print_error("$client_id","$$lang_vars{insert_device_user_group_name}") if ! $device_user_group_name;
#$gip->print_error("$client_id","$$lang_vars{insert_device_user_name}") if ! $device_user_name;

# Check if this user group name/username for this client exists

my %values_device_user_groups=$gip->get_device_user_groups_hash("$client_id");

while ( my ($key, @value) = each(%values_device_user_groups) ) {
	$gip->print_error("$client_id","$$lang_vars{device_user_group_name_exists_message}") if $value[0]->[0] eq $device_user_group_name;
#	print "$key => $value[0]->[0]\n" if $value[0]->[5]==$client_id;
}

##### user group in datenbank einstellen

$gip->insert_device_user_group("$client_id","$device_user_group_name","$device_user_name","$login_pass","$priv_pass","$description");


my $audit_type="101";
my $audit_class="20";
my $update_type_audit="1";
my $event="$device_user_group_name";
$event=$event . "," .  $description if $description;
$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");


$gip->PrintDeviceUserGroupTab("$client_id","$vars_file");

$gip->print_end("$client_id","$vars_file");

