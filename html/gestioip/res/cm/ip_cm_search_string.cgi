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
my $hostname = $daten{'hostname'} || "";
my $host_id = $daten{'host_id'} || "";
my $job_id = $daten{'job_id'} || "";
my $search_type = $daten{'search_type'} || "host";
my $config_name = $daten{'config'} || "";
my $job_group_id = $daten{'job_group'} || "";
my $device_job = $daten{'device_job'} || "";
my $device_type_group_id = $daten{'device_type_group_id'} || "";
my $search_string = $daten{'search_string'} || "";
my $only_last_configs = $daten{'only_last_configs'} || "";


my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	hostname=>"$hostname",
	id=>"$job_id",
	search_type=>"$search_type",
	cm_config_name=>"$config_name",
	job_group=>"$job_group_id",
	device_job=>"$device_job",
	device_type_group_id=>"$device_type_group_id",
	search_string=>"$search_string",
	one_or_cero=>"$only_last_configs",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{find_in_config_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{find_in_config_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{no_search_string_message}") if ! $search_string;
$gip->print_error("$client_id","$$lang_vars{dos_signos_message}") if $search_string !~ /^../;


my $client_name=$gip->get_client_from_id("$client_id");
my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;
if ( ! $cm_backup_dir ) {
	$gip->print_error("$client_id","$$lang_vars{no_cm_config_dir_message}");
}

my $conf_dir=$cm_backup_dir . "/" . $host_id;
my $conf=$conf_dir . "/" . $config_name;



my @job_id_search=();


my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

 
my @configs=();
my @configs_host_ids=();
my $found=0;
my $number_entries=0;
my $string_found=0;

print "<br>\n";

my $ip_hash = $gip->get_host_hash_id_key("$client_id","");

if ( ! $job_id ) {

	my $xml_dir=$global_config[0]->[12] || "";
	my %values_device_type_groups=$gip->get_device_type_values("$client_id","$xml_dir");
	my %values_other_jobs = $gip->get_cm_jobs("$client_id","$host_id","job_id","$job_group_id","$device_type_group_id");
	my $jobs=$values_device_type_groups{$device_type_group_id}[2] || "";
	my %jobs=();
	my $device_type_groupe_id_jobs=();

	for my $host_id_jobs ( sort keys %values_other_jobs ) {
		for my $job_id_jobs ( sort keys %{ $values_other_jobs{$host_id_jobs} } ) {
			my $job_name=$values_other_jobs{$host_id_jobs}{$job_id_jobs}[0];
			if ( $device_job ) {
				push(@job_id_search,"$job_id_jobs") if $device_job eq $job_name;
			} else {
				push(@job_id_search,"$job_id_jobs");
			}
		}
	} 

	my $job_id_search_expr=join('|',@job_id_search);
	$job_id_search_expr="(" . $job_id_search_expr . ")";

	@configs_host_ids = glob($cm_backup_dir . '/' . '*');
	foreach $conf_dir ( @configs_host_ids ) {
		last if $number_entries > 500;
		if ( $conf_dir =~ /\/\d+$/ ) {
			$conf_dir =~ /.*\/(\d+)$/;
			my $host_id=$1;
			my $ip=$ip_hash->{$host_id}[0] || "";
			my $hostname=$ip_hash->{$host_id}[1] || "";
			next if ! $hostname;

			@configs = glob($conf_dir . '/' . '*');

			my @new_configs=();
			if ( $only_last_configs ) {
				opendir my $dh, $conf_dir or die "Error opening $conf_dir: $!";
				my @files = sort { $b->[10] <=> $a->[10] }
				map {[ $_, CORE::stat "$conf_dir/$_" ]}
				grep !m/^\.\.?$/, readdir $dh;
				closedir $dh;

				next if ! exists $files[0]; # directory empty
				my ($name, @stat) = @{$files[0]};
#				push(@new_configs,"$conf_dir/$name") if $name =~ /_$job_id_search_expr\./ && -b $conf_dir/$name;
				push(@new_configs,"$conf_dir/$name") if $name =~ /_$job_id_search_expr\./;

			} else {
				foreach my $conf (@configs) {
					push(@new_configs,"$conf") if $conf =~ /_$job_id_search_expr\.(conf|txt)$/;
#					push(@new_configs,"$conf") if $conf =~ /_$job_id_search_expr\./ && -b $conf;
				}
			}

			@configs=@new_configs;

			($found,$number_entries)=print_found_string(\@configs,"$host_id","$ip","$hostname","$found","$number_entries");
			$string_found=1 if $found == 1;
		}
	}
} elsif ( $job_id ) {
	if ( $config_name eq "all" ) {
		@configs = glob($conf_dir . '/' . '*' . '_' . ${job_id} . '.*');
	} else {
		$configs[0]=$conf;
	}

	my $ip="";
	my $hostname="";
	if ( $host_id ) {
		$ip=$ip_hash->{$host_id}[0] || "";
		$hostname=$ip_hash->{$host_id}[1] || "" if ! $hostname;
		($found,$number_entries)=print_found_string(\@configs,"$host_id","$ip","$hostname","","$number_entries");
	} else {
		($found,$number_entries)=print_found_string(\@configs,"","$ip","$hostname","","$number_entries");
	}

	$string_found=1 if $found == 1;
}

print "<br>\n";

print "<b>$$lang_vars{no_match_message}</b>" if $string_found == 0;

print "<p><br>\n";

$gip->print_end("$client_id");




sub print_found_string {
	my @configs = @{$_[0]};
	my $host_id = $_[1];
	my $ip = $_[2];
	my $hostname = $_[3];
	my $found = $_[4] || 0;
	my $number_entries = $_[5] || 0;

	my $found_print_filename=0;
	foreach my $file (@configs) {
		last if $number_entries > 500;
		my $first_found=0;
		open(FILE,"$file") or $gip->print_error("$client_id","$$lang_vars{can_not_open_cm_config_message} $file: $!");
		while(<FILE>) {
			if ( $_ =~ /$search_string/i ) {
				$file =~ /.*(\d{12}_\d{2}_\d+_\d+\.(conf|txt))$/;
				my $file_name=$1;
				$found_print_filename=1;
				if ( $first_found == 0 ) {
					print "<table border='0'><tr valign=\"top\"><td>\n";
					print "<b><i>$hostname ($ip)</i></b> $file_name\n";
					print "</td><td>\n";
					print "<form name=\"show_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_show.cgi\" style='display:inline;'><input type=\"hidden\" value=\"$search_string\" name=\"search_string\"><input type=\"hidden\" value=\"$file_name\" name=\"config\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{show_message}\" name=\"B2\" class=\"input_link_w_net\"></form>\n" if $first_found == 0;
					print "</td></tr></table>\n";
				}
				print "$_<br>\n";
				$first_found=1;
				$found=1;
				if ( $number_entries > 500 ) {
					print "<i><b>$$lang_vars{resultado_limitado_message} 500 $$lang_vars{entradas_message}</i></b><br>\n";
					last;
				}
				$number_entries++;
			}
		}
		close FILE;

#		print "<br>\n";
		print "<p><br>\n" if $first_found==1;
	}

	return ($found,$number_entries);
}
