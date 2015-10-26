#!/usr/bin/perl -w -T

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
my $name=$daten{'name'} || "";
my $description=$daten{'description'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        name=>"$name",
        description=>"$description",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{job_group_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{job_group_added_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{insert_job_group_name_message}") if ! $name;

$name=$gip->remove_whitespace_se("$name");
$description=$gip->remove_whitespace_se("$description");

# Check if this user servername for this client exists

my %job_groups=$gip->get_job_groups("$client_id");

while ( my ($key, @value) = each(%job_groups) ) {
        $gip->print_error("$client_id","$$lang_vars{job_group_name_exists_message}") if $value[0]->[0] eq $name;
}


##### job group in datenbank einstellen

$gip->insert_job_group("$client_id","$name","$description");


my $audit_type="113";
my $audit_class="13";
my $update_type_audit="1";
my $event="$name - $description";
$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");

$gip->PrintJobGroupTab("$client_id","$vars_file");


$gip->print_end("$client_id","$vars_file");

