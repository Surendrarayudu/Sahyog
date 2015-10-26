#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use lib '../modules';
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
	my $required_perms="manage_user_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


# Parameter check
my $name=$daten{'name'} || "";
my $group_id=$daten{'group_id'} || "";
my $phone=$daten{'phone'} || "";
my $email=$daten{'email'} || "";
my $comment=$daten{'comment'} || "";


my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        name=>"$name",
        id=>"$group_id",
        email=>"$email",
        phone=>"$phone",
        comment=>"$comment",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{user_added_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{user_added_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{insert_user_message}") if ! $name;
$gip->print_error("$client_id","$$lang_vars{select_user_group_message}") if ! $group_id;

$name=$gip->remove_whitespace_se("$name");
$group_id=$gip->remove_whitespace_se("$group_id");
$phone=$gip->remove_whitespace_se("$phone");
$email=$gip->remove_whitespace_se("$email");
$comment=$gip->remove_whitespace_se("$comment");

# Check if this user servername for this client exists

my %values_users=$gip->get_user_hash("$client_id");

while ( my ($key, @value) = each(%values_users) ) {
        $gip->print_error("$client_id","$$lang_vars{user_name_exists_message}") if $value[0]->[0] eq $name;
}


##### user in datenbank einstellen

$gip->insert_user("$client_id","$name","$group_id","$phone","$email","$comment");


my $audit_type="116";
my $audit_class="1";
my $update_type_audit="21";
my $event="$name,$group_id,$phone,$email,$comment";
$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");

$gip->PrintUserTab("$client_id","$vars_file");


$gip->print_end("$client_id","$vars_file");

