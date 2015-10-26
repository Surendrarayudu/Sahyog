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
my $id=$daten{'id'} || "";
my $device_user_group_name=$daten{'device_user_group_name'} || "";
my $description=$daten{'description'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        device_user_group_id=>"$id",
        device_user_group_name=>"$device_user_group_name",
        description=>"$description",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{device_user_group_delete_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;



if ( $id !~ /^\d{1,10}/ ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{device_user_group_delete_message}","$vars_file");
	$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)")
}

$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{device_user_group_delete_message}: \"$device_user_group_name\"","$vars_file");


my $in_use = $gip->check_device_user_group_in_use("$client_id","$id") || "";
my @in_use=@$in_use;
if ( $in_use[0]->[0] ) {
        my $j=0;
        my $in_use_group_hosts="";
        foreach (@in_use) {
                $in_use_group_hosts.="<br>$in_use[$j]->[0]" if $in_use[$j]->[0];
                $j++;
        }
        $in_use_group_hosts=~s/^, //;
        $gip->print_error("$client_id","$$lang_vars{device_user_group_in_use_message}:<p>$in_use_group_hosts")
}


$gip->delete_device_user_group("$client_id","$id");


my $audit_type="103";
my $audit_class="20";
my $update_type_audit="1";
my $event="$device_user_group_name";
$event=$event . "," . $description if $description;
$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");

print "<p><b>$$lang_vars{device_user_group_deleted_message}: $device_user_group_name</b><p>\n";

$gip->PrintDeviceUserGroupTab("$client_id","$vars_file");

$gip->print_end("$client_id");

