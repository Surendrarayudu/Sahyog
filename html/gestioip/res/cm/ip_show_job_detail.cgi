#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use lib '../../modules';
use GestioIP;
use XML::Parser;
use XML::Simple;
use Data::Dumper;


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
my $device_type_group_id = $daten{'device_type_group_id'};
my $job_name = $daten{'device_job'};

my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	device_type_group_id=>"$device_type_group_id",
	device_job=>"$job_name",
	client_id=>"$client_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{job_details_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{job_details_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{select_job_message}") if ! $job_name;
$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $device_type_group_id;

my $cm_enabled_db=$global_config[0]->[8] || "";
my $cm_licence_key_db=$global_config[0]->[10] || "";
my $xml_dir=$global_config[0]->[12] || "";


#my %values_device_type_groups=$gip->get_device_type_values("$client_id","$xml_dir");

my @xml_files=$gip->read_xml_files("$client_id","$xml_dir");

my $xml_file="";

my %device_type_group_ids;
foreach my $file ( @xml_files) {
	if ( $file =~ /^${device_type_group_id}_/ ) {
		$xml_file=$file;
	}

	my $check_file=$xml_dir .  "/" . $file;

        my $parser = XML::Parser->new( ErrorContext => 2 );

	eval { $parser->parsefile( $check_file ); };

	# report any error that stopped parsing, or announce success
	if( $@ ) {
		$@ =~ s/at \/.*?$//s;               # remove module line number
		print "\n<p><span class='RedBold'>$$lang_vars{error_message} in '$check_file':</span><p><pre>$@</pre>\n";
		next;
	}


	my $xml = new XML::Simple;
	my $data = $xml->XMLin("$check_file");
	my $device_group_id_check=$data->{deviceGroupID} || "";

	$device_group_id_check="" if (ref $device_group_id_check eq 'HASH');

        if ( exists($device_type_group_ids{$device_group_id_check}) ) {
                print "<span class='RedBold'>$$lang_vars{duplicated_device_groupe_id_message} $file: $device_group_id_check. $$lang_vars{id_also_used_message} $device_type_group_ids{$device_group_id_check}</span><br>\n";
                next;
        }
        $device_type_group_ids{$device_group_id_check}=$check_file;

}


$xml_file=~ /^(\d+)_/;
my $xml_file_serial=$1 || "";

$xml_file=$xml_dir .  "/" . $xml_file;

# initialize parser object and parse the string
my $parser = XML::Parser->new( ErrorContext => 2 );
#eval { $parser->parsefile( $xml_file ); };
#
## report any error that stopped parsing, or announce success
#if( $@ ) {
#    $@ =~ s/at \/.*?$//s;               # remove module line number
#    print "\n<p>$$lang_vars{error_message} in '$xml_file':<p><pre>$@</pre>\n";
#}


# create object
my $xml = new XML::Simple;

# read XML file
my $data = $xml->XMLin("$xml_file");

# access XML data


if ( $device_type_group_id ne $xml_file_serial ) {
	print "<p><span class='RedBold'>$$lang_vars{xml_serial_incorrect_message} $xml_file<br>$$lang_vars{device_group_values_bad_display_message}</span><p><br>\n";
}

print "<p><b>$$lang_vars{device_group_values_message}</b><p>\n";
print "<table border='0'>\n";
print "<tr><td>\n";

my $xml_file_invalid=0;
my $device_group_name = $data->{deviceGroupName} || "";
if (ref $device_group_name eq 'HASH') {
	print "deviceGroupName</td><td><span class='RedBold'>$$lang_vars{error_message}: deviceGroupName: $$lang_vars{no_value_message}</span>\n";
	$xml_file_invalid=1;
	next;
} else {
	print "deviceGroupName:</td><td>$device_group_name\n";
}

print "</td></tr><tr><td>\n";

my $device_group_id = $data->{deviceGroupID} || "";
if (ref $device_group_name eq 'HASH') {
	print "deviceGroupID</td><td><span class='RedBold'>$$lang_vars{error_message}: deviceGroupID: $$lang_vars{no_value_message}\n";
	$xml_file_invalid=1;
	next;
} else {
	print "deviceGroupId:</td><td> $device_group_id\n";
}

print "</td></tr><tr><td>\n";

my $models = $data->{models} || "";
if (ref $models eq 'HASH') {
	print "models</td><td>\n";
} else {
	print "models:</td><td>$models\n";
}

print "</td></tr><tr><td>\n";

my $login_prompt = $data->{loginPrompt} || "";
if (ref $login_prompt eq 'HASH') {
	print "loginPrompt:</td><td> \n";
} else {
	print "loginPrompt:</td><td>$login_prompt\n";
}

print "</td></tr><tr><td>\n";

my $enable_prompt = $data->{enablePrompt} || "";
if (ref $enable_prompt eq 'HASH') {
	print "enablePrompt</td><td><span class='RedBold'>$$lang_vars{error_message}: enablePrompt: $$lang_vars{no_value_message}</span>\n";
	$xml_file_invalid=1;
	next;
} else {
	print "enablePrompt:</td><td>$enable_prompt\n";
}

print "</td></tr><tr><td>\n";

my $enable_command = $data->{enableCommand} || "";
if (ref $enable_command eq 'HASH') {
	print "enableCommand:</td><td> \n";
} else {
	print "enableCommand:</td><td>$enable_command\n";
}

print "</td></tr><tr><td>\n";

my $username_expr = $data->{usernameExpr} || "";
if (ref $username_expr eq 'HASH') {
	print "usernameExpr:</td><td> \n";
} else {
	print "usernameExpr:</td><td>$username_expr\n";
}

print "</td></tr><tr><td>\n";

my $password_expr = $data->{passwordExpr} || "";
if (ref $username_expr eq 'HASH') {
	print "passwordExpr:</td><td> \n";
} else {
	print "passwordExpr:</td><td>$password_expr\n";
}

print "</td></tr><tr><td>\n";

my $logout_command = $data->{logoutCommand} || "";
if (ref $logout_command eq 'HASH') {
	print "logoutCommand:</td><td>$$lang_vars{error_message} logoutCommand: $$lang_vars{no_value_message}\n";
	next;
} else {
	print "logoutCommand:</td><td>$logout_command\n";
}

print "</td></tr><tr><td>\n";

my $pager_expr = $data->{pagerExpr} || "";
if (ref $pager_expr eq 'HASH') {
	print "pagerExpr:</td><td>\n";
} else {
	print "pagerExpr:</td><td>$pager_expr\n";
}

print "</td></tr><tr><td>\n";

my $pager_disable_command = $data->{pagerDisableCmd} || "";
if (ref $pager_disable_command eq 'HASH') {
	print "pagerDisableCmd:</td><td> \n";
} else {
	print "pagerDisableCmd:</td><td>$pager_disable_command\n";
}

print "</td></tr></table>\n";

print "<p><span class='RedBold'>$$lang_vars{invalid_XML_file_message}</span><p>\n" if $xml_file_invalid != 0;



my %commands;
my %prompt;
my %login_atts;
my %enable_commands;
my $exit_command="exit";

push @{$prompt{$device_group_id}},"$login_prompt","$enable_prompt";
       push @{$enable_commands{$device_group_id}},"$enable_command";

if ( $username_expr eq '[[GENERIC_USERNAME_EXPR]]' ) {
	$username_expr="[Ll]ogin|[Uu]sername|[Uu]ser name|[Uu]ser";
}
if ( $password_expr eq '[[GENERIC_PASSWORD_EXPR]]' ) {
	$password_expr="[Pp]assword|passwd";
}

push @{$login_atts{$device_group_id}},"$username_expr","$password_expr";

my @jobs=();
while ( my ($key, $value) = each(%{$data->{jobs}}) ) {
	push @jobs,"$key";
}

my ($commands,$comment,$returns,$diffConfigIgnore,$configName,$commandTimeout,$localSourceFile,$destConfigName,$configExtension,$dateFormat,$jobType);
#my $valid_job_parameter="diffConfigIgnore|configName|commandTimeout|jobType|localSourceFile";
$diffConfigIgnore=$data->{jobs}{$job_name}{diffConfigIgnore} || "";
$diffConfigIgnore="" if ref $diffConfigIgnore eq "HASH";
$configName=$data->{jobs}{$job_name}{configName} || "";
$configName="" if ref $configName eq "HASH" || $configName eq "ARRAY";
$commandTimeout=$data->{jobs}{$job_name}{commandTimeout} || "";
$commandTimeout="" if ref $commandTimeout eq "HASH" || $commandTimeout eq "ARRAY";
$localSourceFile=$data->{jobs}{$job_name}{localSourceFile} || "";
$localSourceFile="" if ref $localSourceFile eq "HASH" || $localSourceFile eq "ARRAY";
$comment=$data->{jobs}{$job_name}{comment} || "";
$comment="" if ref $comment eq "HASH" || $comment eq "ARRAY";
$destConfigName=$data->{jobs}{$job_name}{destConfigName} || "";
$destConfigName="" if ref $destConfigName eq "HASH" || $destConfigName eq "ARRAY";
$configExtension=$data->{jobs}{$job_name}{configExtension} || "";
$configExtension="" if ref $configExtension eq "HASH" || $configExtension eq "ARRAY";
$dateFormat=$data->{jobs}{$job_name}{dateFormat} || "";
$dateFormat="" if ref $dateFormat eq "HASH" || $dateFormat eq "ARRAY";
$jobType=$data->{jobs}{$job_name}{jobType} || "";
$jobType="" if ref $jobType eq "HASH" || $jobType eq "ARRAY";


my @diffConfigIgnore=();
if ( ref $diffConfigIgnore eq "ARRAY"  ) {
	@diffConfigIgnore=@$diffConfigIgnore;
}


my @commands=();
my @returns=();

if ( $jobType ne "copy_local" ) {
	if ( ! exists($data->{jobs}{$job_name}{command}) ) {
		print "<p><span class='RedBold'>$$lang_vars{error_message}: $$lang_vars{invalid_job_message}: $job_name $$lang_vars{no_commands_message}</span><br>\n";
	#	next;
	}
	if ( ! exists($data->{jobs}{$job_name}{return}) ) {
		print "<p><span class='RedBold'>$$lang_vars{error_message}: $$lang_vars{invalid_job_message}: $job_name $$lang_vars{no_return_prompts_message}</span><br>\n";
	#	next;
	}
}

my $commands_count=0;
my $returns_count=0;
my $command_array=0;
my $returns_array=0;
$commands=$data->{jobs}{$job_name}{command} || "";
if (ref $data->{jobs}{$job_name}{command} eq 'ARRAY') {
	@commands=@$commands;
	$commands_count=scalar @$commands;
	$command_array=1;
} elsif ( $commands ) {
	$commands[0]=$data->{jobs}{$job_name}{command};
}


$returns=$data->{jobs}{$job_name}{return} || "";
if (ref $data->{jobs}{$job_name}{return} eq 'ARRAY') {
	@returns=@$returns;
	$returns_count=scalar @$returns;
	$returns_array=1;
} elsif ( $returns ) {
	$returns[0]=$data->{jobs}{$job_name}{return};
}

if ( $command_array == 1 && $returns_array == 0 || $command_array == 0 && $returns_array == 1 ) {
	print "\n$$lang_vars{error_message}: $$lang_vars{invalid_job_message}: $$lang_vars{same_number_cmd_return_message}\n" if $commands_count ne $returns_count;
}

print "<p><br><b>$$lang_vars{job_details_message} \"$job_name\"</b><p>\n";

my $job_anz=scalar @commands;
my $j=1;

print "<table border='0'>\n";

print "<tr><td>\n";
print "jobType: $jobType</td></tr>";

print "<tr><td>\n";
print "comment: $comment</td></tr>";

if ( $diffConfigIgnore[0] ) {
	foreach (@diffConfigIgnore) {
		print "<tr><td>\n";
		print "diffConfigIgnore: $_</td></tr>";
	}
} elsif ( $diffConfigIgnore ) {
	print "<tr><td>\n";
	print "diffConfigIgnore: $diffConfigIgnore</td></tr>";
}

if ( $configName ) {
	print "<tr><td>\n";
	print "configName: $configName</td></tr>";
}

if ( $commandTimeout ) {
	print "<tr><td>\n";
	print "commandTimeout: $commandTimeout</td></tr>";
}

if ( $localSourceFile ) {
	print "<tr><td>\n";
	print "localSourceFile: $localSourceFile</td></tr>";
}

if ( $configExtension ) {
	print "<tr><td>\n";
	print "configExtension: $configExtension</td></tr>";
}

if ( $dateFormat ) {
	print "<tr><td>\n";
	print "dateFormat: $dateFormat</td></tr>";
}


print "</table>\n";
print "<table border='0'>\n";

for ( my $i=0; $i<$job_anz; $i++) {
	print "<tr><td>\n";
	print "$$lang_vars{command_message} $j:</td><td>$commands[$i]\n";
	print "</td></tr><tr><td>\n";
	print "$$lang_vars{return_message} $j:</td><td>$returns[$i]\n";
	print "</td></tr>\n";
	$j++;
}

print "</table><p>\n";


print "<br><p><br>$$lang_vars{xml_file_message}: $xml_file\n";


$gip->print_end("$client_id","$vars_file");

