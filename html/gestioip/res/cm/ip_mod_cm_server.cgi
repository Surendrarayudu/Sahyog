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
my $name=$daten{'name'} || "";
my $ip=$daten{'ip'} || "";
my $cm_server_type=$daten{'cm_server_type'} || "";
my $cm_server_root=$daten{'cm_server_root'} || "";
my $description=$daten{'cm_server_description'} || "";
my $cm_server_user=$daten{'cm_server_user'} || "";
my $cm_server_pass=$daten{'cm_server_pass'} || "";

my $ip_version="v4";
if ( $ip !~ /^\d{1,3}\./ ) {
        $ip_version="v6";
}

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        cm_server_name=>"$name",
        cm_server_id=>"$id",
        cm_server_ip=>"$ip",
        ip_version=>"$ip_version",
        cm_server_type=>"$cm_server_type",
        cm_server_root=>"$cm_server_root",
        cm_server_description=>"$description",
        cm_server_user=>"$cm_server_user",
        cm_server_pass=>"$cm_server_pass",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{edit_cm_server_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


my %values_cm_server=$gip->get_cm_server_hash("$client_id");
my $old_name=$values_cm_server{$id}[0];
my $old_ip=$values_cm_server{$id}[1];
my $old_type=$values_cm_server{$id}[2];
my $old_cm_server_root=$values_cm_server{$id}[3];
my $old_description=$values_cm_server{$id}[4];
my $old_cm_server_user=$values_cm_server{$id}[6] || "";
my $old_cm_server_pass=$values_cm_server{$id}[7] || "";


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{cm_server_changed_message}","$vars_file");


$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $id;
$gip->print_error("$client_id","$$lang_vars{insert_cm_server_name_message}") if ! $name;
$gip->print_error("$client_id","$$lang_vars{insert_cm_server_ip_message}") if ! $ip;
$gip->print_error("$client_id","$$lang_vars{insert_cm_server_type_message}") if ! $cm_server_type;
$gip->print_error("$client_id","$$lang_vars{insert_cm_server_root_message}") if ! $cm_server_root;
if ( $ip_version eq "v6" ) {
	$gip->print_error("$client_id","$$lang_vars{ip_zone_identifier_message}") if $ip !~ /^.+\s.+/;
}

# TEST
#$gip->print_error("$client_id","$$lang_vars{localhost_no_valid_message}") if $ip eq "localhost" || $ip eq "127.0.0.1"; 
if ( $cm_server_type eq "ftp" || $cm_server_type eq "scp" || $cm_server_type eq "rcp" ) {
	$gip->print_error("$client_id","$$lang_vars{insert_cm_server_user_message}") if ! $cm_server_user;
	$gip->print_error("$client_id","$$lang_vars{insert_cm_server_pass_message}") if ! $cm_server_pass;
} elsif (  $cm_server_type eq "scp rsa" ) {
	$gip->print_error("$client_id","$$lang_vars{insert_cm_server_user_message}") if ! $cm_server_user;
}

$ip=$gip->remove_whitespace_se("$ip");
$name=$gip->remove_whitespace_se("$name");
$cm_server_root=$gip->remove_whitespace_se("$cm_server_root");

##### cm server in datenbank updaten

$gip->update_cm_server("$client_id","$id","$name","$ip","$cm_server_type","$cm_server_root","$description","$cm_server_user","$cm_server_pass");

my $audit_type="111";
my $audit_class="13";
my $update_type_audit="1";
my $event="$old_name,$old_ip,$old_type,$old_cm_server_root,$old_description,$old_cm_server_user -> $name,$ip,$cm_server_type,$cm_server_root,$description,$cm_server_user";
$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");


$gip->PrintCMServerTab("$client_id","$vars_file");

$gip->print_end("$client_id","$vars_file");

