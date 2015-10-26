#!/usr/bin/perl -w

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use lib '../../modules';
use GestioIP;
use POSIX qw(strftime);
use CGI;
use CGI qw/:standard/;
use CGI::Carp qw ( fatalsToBrowser );
use File::Copy;


my $gip = GestioIP -> new();
#my $daten=<STDIN>;
#my %daten=$gip->preparer($daten);
my %daten=();

my $query = new CGI;

my $base_uri = $gip->get_base_uri();
my $server_proto=$gip->get_server_proto();

# Parameter check
my $lang = $query->param("lang") || "";
$lang="" if $lang !~ /^\w{1,3}$/;
my ($lang_vars,$vars_file)=$gip->get_lang("","$lang");
my $client_id = $query->param("client_id");


# check Permissions
my @global_config = $gip->get_global_config("$client_id");
my $user_management_enabled=$global_config[0]->[13] || "";
if ( $user_management_enabled eq "yes" ) {
	my $required_perms="administrate_cm_perm,write_device_config_perm,read_device_config_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


my $ip_version = $query->param("ip_version") || "";
my $host_id = $query->param("host_id") || "";
my $upload_config_name=$query->param("upload_config_name") || "";
my $stored_config=$query->param("stored_config") || "";
my $job_name=$query->param("job_name") || "";
my $job_id=$query->param("job_id") || "888888";
my $do_job=$query->param("do_job");
my $job_name_descr=$query->param("job_name_descr") || "";
#my $job_type_id=$query->param("job_type_id") || "";
my $log_mode=$query->param("log_mode") || "";

my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	ip_version=>"$ip_version",
	host_id=>"$host_id",
	cm_config_name=>"$stored_config",
	secure_filename_characters=>"$upload_config_name",
	cm_job=>"$job_name",
	job_id=>"$job_id",
	do_job=>"$do_job",
	job_name_descr=>"$job_name_descr",
	log_mode=>"$log_mode",
#	id=>"$job_type_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{job_message}: $job_name_descr",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{job_message}: $job_name_descr","$vars_file");

$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if $do_job !~ /^(upload_config|run_job|run_defined_job)$/;

if ( $do_job eq "upload_config" || $do_job eq "run_job" ) {
	$gip->print_error("$client_id","$$lang_vars{select_job_message}") if ! $job_name;
}

my %values_device_config=$gip->get_device_cm_hash("$client_id","$host_id","","host_id");
my $device_type_group_id=$values_device_config{$host_id}[1] || "";
my $cm_server_id=$values_device_config{$host_id}[8] || "";

my %values_cm_server=$gip->get_cm_server_hash("$client_id");
my $cm_server_root=$values_cm_server{$cm_server_id}[3];
my $client_name=$gip->get_client_from_id("$client_id");
my $cm_xml_dir=$global_config[0]->[12] || "";
my %values_device_type_groups=$gip->get_device_type_values("$client_id","$cm_xml_dir");
my %job_types=$gip->get_job_types_id("$client_id");

my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;

my $config_file;

if ( $do_job eq "upload_config" ) {
	if ( $upload_config_name ) {
		$CGI::POST_MAX = 1024 * 10000;
		my $safe_filename_characters = "a-zA-Z0-9_.-";


		my $filename = $upload_config_name;

	#	my ( $name, $path, $extension ) = fileparse ( $filename, '\..*' );
		my ($name,$extension);
		$filename =~ /^(.*)\.(.*)$/;
		$name=$1;
		$extension=$2;
		$filename = $name . "." . $extension;
		$filename =~ tr/ /_/;
		$filename =~ s/[^$safe_filename_characters]//g;

		if ( $filename =~ /^([$safe_filename_characters]+)$/ ) {
			$filename = $1;
		} else {
			$gip->print_error("$client_id","$$lang_vars{formato_malo_message}");
		}

		my $upload_filehandle = $query->upload("upload_config_name");

		$cm_server_root =~ s/\/$//;

		$config_file=$cm_server_root . "/" . $filename;

		open ( UPLOADFILE, ">$config_file" ) or $gip->print_error("$client_id","Can not open $cm_server_root/$filename: $!");
		binmode UPLOADFILE;

		while ( <$upload_filehandle> ) {
			print UPLOADFILE;
		}

		close UPLOADFILE;
	} elsif ( $stored_config ) {
		my $cm_config=$cm_backup_dir . "/" . $host_id . "/" . $stored_config;
		my $new_file=$cm_server_root . "/" . $stored_config;

		my $return_value=copy("$cm_config","$new_file") or $gip->print_error("$client_id","Can not copy config to upload dir: cp $cm_config $new_file: $!\n");
	} else {
		$gip->print_error("$client_id","$$lang_vars{specify_upload_config_message}");
	}
} elsif ( $do_job eq "backup_config" ) {
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

my $ip=$gip->get_host_value_from_host_id("$client_id","$host_id","ip") || "";
my $hostname=$gip->get_host_value_from_host_id("$client_id","$host_id","hostname") || "";

my $jobs=$values_device_type_groups{$device_type_group_id}[2] || "";
my %jobs=%$jobs;
my $job_type=$jobs{$device_type_group_id}{$job_name}[1] || "";
my $job_type_id=$job_types{$job_type} || "";

$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (2)") if ! $job_type_id;

my $cm_log_dir=$global_config[0]->[11];


my $datetime=time();
my $date_log = strftime "%Y%m%d%H%M%S", localtime($datetime);
my $date_file = strftime "%Y%m%d%H%M", localtime($datetime);

my $backup_file_serial=$gip->get_file_serial("$client_id","$date_file","$cm_backup_dir","$host_id","$job_id");
my $ext="";
if ( $job_type_id == 1 ) {
	$ext=".conf";
} elsif ( $job_type_id == 2 ) {
	$ext=".txt";
}

my $backup_file_name=$date_file . "_" . $backup_file_serial . "_" . $host_id . "_" . $job_id . "$ext";
my $backup_file_name_orig=$backup_file_name;
my $last_config_serial=$backup_file_serial-1;
my $last_config_name=$date_file . "_" . $last_config_serial . "_" . $host_id . "_" . $job_id . "$ext";

my $logfile_name=$date_log . "_" . $client_id . "_fetch_config.log";
my $logfile_name_stdout=$date_log . "_" . $client_id . "_fetch_config.log_stdout";

my $server_name_licence=$gip->get_cm_licence_server_name("$client_id","$vars_file");

my $command_path="/usr/share/gestioip/bin";
my $command_option="";
my $user=$ENV{'REMOTE_USER'} || "N/A";
my $log_mode_param="";
if ( $log_mode eq "verbose" ) {
	$log_mode_param="--verbose";
} elsif ( $log_mode eq "debug" ) {
        $log_mode_param="--debug=3";
}

if ( $do_job eq "upload_config" ) {
	if ( $upload_config_name ) {
		$command_option="--csv_hosts=$ip --log_file_name=$logfile_name --upload_config_file=$upload_config_name --jobname=$job_name --run_unassociated_job --server_name_licence=$server_name_licence --audit_user=$user --name_client=$client_name $log_mode_param";
	} elsif ( $stored_config ) {
		$command_option="--csv_hosts=$ip --log_file_name=$logfile_name --upload_config_file=$stored_config --jobname=$job_name --run_unassociated_job --server_name_licence=$server_name_licence --audit_user=$user --name_client=$client_name $log_mode_param";
	}
} elsif ( $do_job eq "run_job" ) {
	$command_option="--csv_hosts=$ip --log_file_name=$logfile_name --backup_file_name=$backup_file_name --jobname=$job_name --run_unassociated_job --server_name_licence=$server_name_licence --audit_user=$user --name_client=$client_name $log_mode_param";
} elsif ( $do_job eq "run_defined_job" ) {
	$command_option="--csv_hosts=$ip --log_file_name=$logfile_name --id=$job_id --server_name_licence=$server_name_licence --audit_user=$user --name_client=$client_name $log_mode_param";
}


my $result=$gip->fetch_config("$command_path","$command_option","$logfile_name");


my $configs=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id}");
my @configs=@$configs;

#find real name
foreach my $config_name (@configs) {
        if ( $config_name =~ /^$backup_file_name/ ) {
                $backup_file_name=$config_name;
                last;
        }
}


my $logfile=$cm_log_dir . "/" . $logfile_name;

my $backup_file=$cm_backup_dir . "/" . $host_id . "/" . $backup_file_name;

my ($successful_fetched_message,$conf_stored_in_message,$not_changed_message,$show_file_message);
if ( $job_type_id == 1 ) {
	$error_message=$$lang_vars{error_fetching_config_message};
	$successful_fetched_message=$$lang_vars{conf_successful_fetched_message};
	$conf_stored_in_message=$$lang_vars{conf_stored_in_message};
	$not_changed_message=$$lang_vars{conf_not_changed_message};
	if ( -B "$backup_file" ) {
		$show_file_message=$$lang_vars{download_configuration_message};
	} else {
		$show_file_message=$$lang_vars{show_configuration_message};
	}
} elsif ( $job_type_id == 2 ) {
	$error_message=$$lang_vars{error_executing_commmand_message};
	$successful_fetched_message=$$lang_vars{output_successful_fetched_message};
	$conf_stored_in_message=$$lang_vars{output_stored_in_message};
	$not_changed_message=$$lang_vars{no_changes_message};
	$show_file_message=$$lang_vars{show_command_output_message};
} elsif ( $job_type_id == 3 ) {
	if ($do_job eq "upload_config") {
		$error_message=$$lang_vars{error_copying_config_to_device_message};
		$successful_fetched_message=$$lang_vars{config_successfully_copied_to_device_message};
		$show_file_message=$$lang_vars{show_command_output_message};
	} else {
		$error_message=$$lang_vars{error_executing_commmand_message};
		$successful_fetched_message=$$lang_vars{command_execution_successful_message};
	}
} elsif ( $job_type_id == 4 ) {
	$error_message=$$lang_vars{error_fetching_config_message};
	$successful_fetched_message=$$lang_vars{local_configuration_found_message};
	$conf_stored_in_message=$$lang_vars{conf_stored_in_message};
	$not_changed_message=$$lang_vars{conf_not_changed_message};
}

if ( $result == 1 ) {
	print "<p><br><b>$error_message</b><br><p>\n";
	open(LOG,"<$logfile") or $gip->print_error("$client_id","$$lang_vars{can_not_open_log_message} $logfile: $!");
	while (<LOG>) {
		print "$_<br>" if $_ =~ /error/i;
	}
	close LOG;
	print "<br><p>$$lang_vars{see_log_message}\n";

} elsif ( $result == 10 ) {
	print "<p><br><p><b>$not_changed_message</b><br>\n";

} elsif ( $result =~ /^1[0-5]\d$/ ) {
	# result between 100 and 159
	print "<p><br><b>$$lang_vars{command_not_correctly_executed_message} ($result)</b><br><p>$$lang_vars{see_log_message}<p>command: $command_path/fetch_config.pl $command_option\n";
} elsif ( $result != 0 ) {
	$gip->print_error("$client_id","<p><br><b>$$lang_vars{internal_problem_executing_command_message} ($result)</b><br><p>$$lang_vars{report_problem_message}<p>command: $command_path/fetch_config.pl $command_option");

} else {
	if ( $job_type_id < 3  ) {
		print "<p><br><p><b>$successful_fetched_message</b><p>\n";

		if ( $backup_file_name eq $backup_file_name_orig ) {
			print "<form name=\"show_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_show.cgi\" style=\"display:inline;\"><br>\n";
			print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$backup_file_name\" name=\"config\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$show_file_message\" name=\"B2\" class=\"input_link_w_net\"></span></form><br><p>\n";
		}
	} else {
		print "<p><br><p><b>$successful_fetched_message</b><p>$$lang_vars{log_stored_in_message}: $logfile\n";
	}
}


print "<p>";

print "<form name=\"show_cm_log_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi\" style=\"display:inline;\">\n";
print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$logfile_name\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{show_cm_config_fetch_log_message}\" name=\"B2\" class=\"input_link_w_net\"></span>\n";
print "</form><br><p>\n";

if ( $log_mode eq "verbose" ) {
	print "<form name=\"show_cm_log_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi\" style=\"display:inline;\">\n";
	print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$logfile_name_stdout\" name=\"cm_log_file_stdout\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{show_cm_config_fetch_log_stdout_message}\" name=\"B2\" class=\"input_link_w_net\"></span>\n";
	print "</form><br><p>\n";
}


$gip->print_end("$client_id","$vars_file");
