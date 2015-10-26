#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use lib '../../modules';
use GestioIP;
use POSIX qw(strftime);


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
	my $required_perms="administrate_cm_perm,read_device_config_perm,write_device_config_perm";
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

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        hostname=>"$hostname",
        host_id=>"$host_id",
	
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{manage_jobs_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_jobs_message} $hostname","$vars_file");


my $client_name=$gip->get_client_from_id("$client_id");
my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;

my $configs=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id}");
my @configs=@$configs;
my @backup_configs_all=();

my %values_device_config=$gip->get_device_cm_hash("$client_id","$host_id","","host_id");
my $device_type_group_id=$values_device_config{$host_id}[1] || "";
my $last_backup_log=$values_device_config{$host_id}[12] || "";
my %job_types=$gip->get_job_types_id("$client_id");
my %job_groups=$gip->get_job_groups("$client_id");

my $cm_xml_dir=$global_config[0]->[12] || "";
my %values_device_type_groups=$gip->get_device_type_values("$client_id","$cm_xml_dir");
my $jobs=$values_device_type_groups{$device_type_group_id}[2] || "";
my %jobs=();
if ( $jobs ) {
	%jobs=%$jobs;
}

my %not_defined_jobs=();

my $disabled_color='#F0EDEA';

my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

print <<EOF;
<script type="text/javascript">
<!--
function confirmation(MESSAGE) {

        answer = confirm(MESSAGE)

        if (answer){
                return true;
        }
        else{
                return false;
        }
}
//-->
</script>

<script type="text/javascript">
<!--
function mod_vals(VALUE){
   if(VALUE == 'upload' ){
    upload_config.stored_config.disabled=true;
    upload_config.stored_config.selectedIndex='0';
    upload_config.stored_config.style.backgroundColor="$disabled_color";
    upload_config.upload_config_name.disabled=false;
    upload_config.upload_config_name.style.display="none";
    upload_config.upload_config_name.style.display="inline";
    document.getElementById("no_dev_con").style.display="none";
   } else {
    upload_config.stored_config.disabled=false;
    upload_config.stored_config.style.backgroundColor="white";
    upload_config.upload_config_name.disabled=true;
    upload_config.upload_config_name.value='';
    upload_config.upload_config_name.style.display="none";
    document.getElementById("no_dev_con").style.display="inline";

   }
}
//-->
</script>

<script type="text/javascript">
function download(file) {
var url='$server_proto://$base_uri/conf/$client_name/$host_id/' + file;
alert(url)
        window.location = url;
}
</script>

<script type="text/javascript">
<!--
function mod_cm_fields(IP,LOG,ID,CLIENT_NAME) {
   document.getElementById('Hide1').innerHTML = "./fetch_config.pl --csv_hosts=" + IP + " --id=" + ID + " --name_client=" + CLIENT_NAME + " --log_file_name=" + LOG;
}

//-->
</script>



EOF

my %values_other_jobs = $gip->get_cm_jobs("$client_id","$host_id","job_id");


my $ip=$gip->get_host_value_from_host_id("$client_id","$host_id","ip") || "";
my $ip_version="v4";
$ip_version="v6" if $ip !~ /^\d{1,3}\./;
my $ip_int = $gip->ip_to_int("$client_id","$ip","$ip_version");


print "<form method=\"POST\" action=\"$server_proto://$base_uri/res/ip_modip_form.cgi\" style=\"text-align:right;\"><input name=\"red_num\" type=\"hidden\" value=\"1\"><input name=\"host_id\" type=\"hidden\" value=\"$host_id\"><input name=\"ip\" type=\"hidden\" value=\"$ip_int\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input name=\"ip_version\" type=\"hidden\" value=\"$ip_version\"><input name=\"CM_diff_form\" type=\"hidden\" value=\"1\"><input type=\"submit\" value=\"$$lang_vars{edit_jobs_message}\" name=\"B2\" class=\"input_link_w_right_align\"></form>\n";
#print "</td></tr></table>\n";

my $anz_jobs=scalar (keys %{ $values_other_jobs{$host_id}});
my @form_jobs=();
my $j=0;

my $datetime=time();
my $date_log = strftime "%Y%m%d%H%M%S", localtime($datetime);
my $logfile_name=$date_log . "_" . $client_id . "_fetch_config.log";

if ( $anz_jobs == 0 ) {
	print "<p><i>$$lang_vars{no_jobs_for_device_definde_message}</i><br><p><br>\n";
} else {

	print "<table border=\"0\" cellpadding=\"4\" cellspacing=\"13\">\n";
	print "<tr><td colspan=\"5\"></td></tr>\n";
	print "<tr valign=\"top\"><td>\n";

	for my $job_id ( keys %{ $values_other_jobs{$host_id} } ) {
		my $job_name=$values_other_jobs{$host_id}{$job_id}[0];
		my $job_group_id=$values_other_jobs{$host_id}{$job_id}[1] || "";
		my $job_descr=$values_other_jobs{$host_id}{$job_id}[2] || "N/A";
		my $job_type=$jobs{$device_type_group_id}{$job_name}[1] || "";
		my $job_type_id=$job_types{$job_type} || "";
		my $job_name_descr=$jobs{$device_type_group_id}{$job_name}[0] || "";
		my $last_execution_date=$values_other_jobs{$host_id}{$job_id}[3] || "$$lang_vars{never_message}";
		$last_execution_date="<br>" . $last_execution_date if $last_execution_date ne "$$lang_vars{never_message}";
		my $last_execution_status=$values_other_jobs{$host_id}{$job_id}[4] || 0;
		my $last_execution_log=$values_other_jobs{$host_id}{$job_id}[5] || "";
		my $job_group_name=$job_groups{$job_group_id}[0] || "";

		next if ! $job_type_id;

		push @form_jobs,"$job_name";

		my $cm_style="cm_never_checked_button";

		if ( $last_execution_status == -1 ) {
		# never checked
			$cm_style="job_never_checked_button";
		} elsif ( $last_execution_status == 0 ) {
		# ok, new configuration stored
			$cm_style="job_ok_button";
		} elsif ( $last_execution_status == 1 ) {
		# ok, unchanged
			$cm_style="job_ok_button";
		} elsif ( $last_execution_status == 2 ) {
		# ok, warning
			$cm_style="job_warning_button";
		} elsif ( $last_execution_status == 3 ) {
		# error
			$cm_style="job_error_button";
		}


		my $status_link;
		if ( $last_execution_log ) {
			$status_link="<form name=\"show_cm_log_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi#$ip\" style=\"display:inline;\"><input type=\"hidden\" value=\"$last_execution_log\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$ip\" name=\"ip\"><input type=\"hidden\" value=\"$ip_version\" name=\"ip_version\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"\" title=\"$$lang_vars{show_last_cm_log_job_message}\" class=\"$cm_style\"></form>\n";
		} else {
			$status_link="<img src=\"$server_proto://$base_uri/imagenes/ping_gray.png\" title=\"$$lang_vars{never_executed_message}\" style=\"padding:3px;\">";
		}


		my $binary_config=0;
		if ( $job_type_id == 1 || $job_type_id == 2 || $job_type_id == 4 ) {
			my @new_configs=();
			foreach my $config_name (@configs) {
				push (@backup_configs_all,"$config_name") if $job_type_id == 1;
				if ( $config_name =~ /_${job_id}\..+/ ) {
					if ( -B "${cm_backup_dir}/${host_id}/${config_name}" ) {
						$binary_config=1;
					}
				}
				if ( $config_name =~ /^(\d{12})_(\d{2})_(\d+)_${job_id}\./ ) {
					push (@new_configs,"$config_name");
				}
			}

			my ($show_output_message,$diff_output_message);
			if ( $job_type_id == 1 ) {
				$show_output_message=$$lang_vars{show_configuration_message};
				$diff_output_message=$$lang_vars{diff_configurations_message};
			} else {
				$show_output_message=$$lang_vars{show_command_output_message};
				$diff_output_message=$$lang_vars{diff_command_outputs_message};
			}

			print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"5\">\n";
			print "<tr valign=\"top\"><td width=\"200px\">\n";
			print "$status_link <span title=\"$$lang_vars{job_short_name_message}: $job_name\n$$lang_vars{job_id_message}: $job_id\"><b>$job_name_descr</b></span><br>\n";
			print "$$lang_vars{job_descr_message}: $job_descr<br>\n";
			print "$$lang_vars{job_type_message}: $job_type<br>\n";
			my $job_group_id_show="";
			$job_group_id_show="(" . $job_group_id . ")" if $job_group_name;
			print "$$lang_vars{job_group_message}: $job_group_name $job_group_id_show<br>\n";
#			print "$$lang_vars{job_group_message}: $job_group_name<br>\n";
			print "$$lang_vars{last_execution_message}: $last_execution_date<br>\n";

			print "<span onClick=\"submit_form('ip_show_job_detail_form_$j')\" class=\"input_link_w\" title=\"$$lang_vars{show_job_details_massage}\" style=\"cursor:pointer\">$$lang_vars{show_job_details_massage}</span><span title=\"$$lang_vars{show_fetch_config_command_message}\" onclick=\"mod_cm_fields('$ip','$logfile_name','$job_id','$client_name');\" class=\"input_link_w\">*</span><br>\n";

			print "</td></tr>\n";
			print "</table>\n";

			print "</td><td>\n";

			#SHOW CONFIG

			if ( scalar @new_configs == 0 ) {
				if ( $job_type_id == 1 ) {
					print "<p><i>$$lang_vars{no_device_configuration_message}</i><br>\n";
				} else {
					print "<p><i>$$lang_vars{no_device_job_output_message}</i><br>\n";
				}
			} elsif ( $binary_config == 1 ) {
				print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
				print "<tr valign=\"top\"><td>\n";
				print "$$lang_vars{binary_config_no_show_message}\n";
				print "</td></tr>\n";
				print "</table>\n";

				print "</td><td>\n";

				print "<form name=\"show_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_show.cgi\" style=\"display:inline;\">\n";
				print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
#				print "</td></tr><tr valign=\"top\"><td>\n";
				print "<tr valign=\"top\"><td>\n";
				print "$$lang_vars{mdownload_message} $$lang_vars{file_message}\n";
				print "</td></tr><tr valign=\"top\"><td>\n";
				print "<select name=\"config\" id=\"config\" size=\"1\">";

				foreach my $config_name (@new_configs) {
					my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
					print "<option value=\"$config_name\">$date_form ($serial)</option>";
				}
				print "</select>\n";

				print "</td></tr><tr><td>\n";
				print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><span class=\"input_link_w_net\" onclick=\"download(document.getElementById('config').value)\">$$lang_vars{download_message}</span></span>\n";

				print "</td></tr>\n";
				print "</table>\n";
				print "</form>\n";
			} else {
				print "<form name=\"show_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_show.cgi\" style=\"display:inline;\">\n";
				print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
				print "<tr valign=\"top\"><td>\n";
				print "$show_output_message\n";
				print "</td></tr><tr valign=\"top\"><td>\n";
				print "<select name=\"config\" size=\"1\">";

				foreach my $config_name (@new_configs) {
					my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
					print "<option value=\"$config_name\">$date_form ($serial)</option>";
				}
				print "</select>\n";

				print "</td></tr><tr><td>\n";
				print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{show_message}\" name=\"B2\" class=\"input_link_w_net\"></span>\n";

				print "</td></tr>\n";
				print "</table>\n";
				print "</form>\n";


				print "</td><td>\n";


				#DIFF FORM

				print "<form name=\"diff_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff.cgi\" style=\"display:inline;\">\n";
				print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
				print "<tr valign=\"top\"><td>\n";
				print "$diff_output_message\n";
				print "</td></tr><tr valign=\"top\"><td>\n";

				if ( scalar(@new_configs) == 1 ) {
					if ( $job_type_id == 1 ) {
						print "<p><i>$$lang_vars{only_one_config_stored_message}</i><br>\n";
					} else {
						print "<p><i>$$lang_vars{only_one_job_output_stored_message}</i><br>\n";
					}
				} else {

					print "<select name=\"diff_config_1\" size=\"1\">";
					foreach my $config_name (@new_configs) {
						my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
						print "<option value=\"$config_name\">$date_form ($serial)</option>";
					}
					print "</select>\n";

					print "</td></tr><tr><td>\n";

					print "<select name=\"diff_config_2\" size=\"1\">";
					foreach my $config_name (@new_configs) {
						my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
						print "<option value=\"$config_name\">$date_form ($serial)</option>";
					}
					print "</select>\n";
					print "</td></tr><tr><td>\n";
					print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$job_id\" name=\"job_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{diff_message}\" name=\"B2\" class=\"input_link_w_net\"></span>\n";
				}

				print "</td></tr>\n";
				print "</table>\n";
				print "</form>\n";


				print "</td><td>\n";


				# SEARCH FORM
				print "<form name=\"search_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_search_string.cgi\" style=\"display:inline;\">\n";
				print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
				print "<tr valign=\"top\"><td>\n";
				print "$$lang_vars{find_string_message}\n";
				print "</td></tr><tr valign=\"top\"><td>\n";

				print "<select name=\"config\" size=\"1\">";
				print "<option value=\"all\">$$lang_vars{all_files_message}</option>";
				foreach my $config_name (@new_configs) {
					my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
					print "<option value=\"$config_name\">$date_form ($serial)</option>";
				}
				print "</select>\n";
				print "</td></tr><tr><td>\n";
				print "<span style=\"float: $ori\"><input type=\"text\" value=\"\" name=\"search_string\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$job_id\" name=\"job_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"></span>\n";
				print "</td></tr><tr><td>\n";
				print "<input type=\"submit\" value=\"$$lang_vars{buscar_message}\" name=\"B2\" class=\"input_link_w_net\"><br>\n";
				print "</td></tr>\n";
				print "</table>\n";
				print "</form>\n";
			}

			print "</td><td>\n";


			# RUN JOB
			print "<form id=\"run_defined_job\" name=\"run_defined_job\" action=\"$server_proto://$base_uri/res/cm/ip_do_job.cgi\" method=\"post\" style=\"display:inline;\">\n";
			print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
			print "<tr valign=\"top\"><td>\n";
			print "$$lang_vars{execute_job_now_message}<br>\n";
			print "<input type=\"hidden\" name=\"client_id\" value=\"$client_id\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" name=\"job_type_id\" value=\"$job_type_id\"><input type=\"hidden\" name=\"do_job\" value=\"run_defined_job\"><input type=\"hidden\" name=\"job_id\" value=\"$job_id\"><input type=\"hidden\" name=\"job_name_descr\" value=\"$job_name_descr\"><input type=\"hidden\" name=\"job_name\" value=\"$job_name\">\n";
			print "<input type=\"submit\" name=\"Submit\" value=\"$$lang_vars{run_job_messge}\" class=\"input_link_w\" onclick=\"return confirm('$job_name: $$lang_vars{confirm_run_job_message}')\"><p>\n";
			print "<i>$$lang_vars{log_mode_message}</i><br>\n";
			print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\"><tr><td  nowrap>\n";
			print "$$lang_vars{default_message} <input type=\"radio\" name=\"log_mode\" value=\"default\" checked>\n";
			print "$$lang_vars{verbose_message} <input type=\"radio\" name=\"log_mode\" value=\"verbose\">\n";
			print "$$lang_vars{debug_message} <input type=\"radio\" name=\"log_mode\" value=\"debug\">\n";
			print "</td></tr></table>\n";

			print "</td></tr>\n";
			print "</table>\n";
			print "</form>\n";

			print "</td></tr><tr><td colspan=\"5\"><span id='Hide1'></span><hr></td></tr><tr valign=\"top\"><td>\n";
		} else {

			# RUN JOB
			print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"5\">\n";
			print "<tr valign=\"top\"><td>\n";
			print "$status_link <b>$job_name_descr</b><br>\n";
			print "$$lang_vars{job_descr_message}: $job_descr<br>\n";
			print "$$lang_vars{job_type_message}: $job_type<br>\n";
			print "$$lang_vars{job_group_message}: $job_group_name<br>\n";
			print "$$lang_vars{last_execution_message}: $last_execution_date<br>\n";
			print "<span onClick=\"submit_form('ip_show_job_detail_form_$j')\" class=\"input_link_w\" title=\"$$lang_vars{show_job_details_massage}\" style=\"cursor:pointer\">$$lang_vars{show_job_details_massage}</span><span title=\"$$lang_vars{show_fetch_config_command_message}\" onclick=\"mod_cm_fields('$ip','$logfile_name','$job_id','$client_name');\" class=\"input_link_w\">*</span>\n";
			print "</td></tr>\n";
			print "</table>\n";

			print "</td><td>\n";

			print "<form id=\"run_defined_job\" name=\"run_defined_job\" action=\"$server_proto://$base_uri/res/cm/ip_do_job.cgi\" method=\"post\" style=\"display:inline;\">\n";
			print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
			print "<tr valign=\"top\"><td>\n";
			print "$$lang_vars{execute_job_now_message}<br>\n";
			print "<input type=\"hidden\" name=\"client_id\" value=\"$client_id\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" name=\"job_type_id\" value=\"$job_type_id\"><input type=\"hidden\" name=\"do_job\" value=\"run_defined_job\"><input type=\"hidden\" name=\"job_id\" value=\"$job_id\"><input type=\"hidden\" name=\"job_name_descr\" value=\"$job_name_descr\"><input type=\"hidden\" name=\"job_name\" value=\"$job_name\">\n";
			print "<input type=\"submit\" name=\"Submit\" value=\"$$lang_vars{run_job_messge}\" class=\"input_link_w\"><p>\n";
			print "<i>$$lang_vars{log_mode_message}</i><br>\n";
			print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\"><tr><td  nowrap>\n";
			print "$$lang_vars{default_message} <input type=\"radio\" name=\"log_mode\" value=\"default\" checked>\n";
			print "$$lang_vars{verbose_message} <input type=\"radio\" name=\"log_mode\" value=\"verbose\">\n";
			print "$$lang_vars{debug_message} <input type=\"radio\" name=\"log_mode\" value=\"debug\">\n";
			print "</td></tr></table>\n";

			print "</td></tr>\n";
			print "</table>\n";
			print "</form>\n";

			print "</td></tr><tr><td colspan=\"5\"><span id='Hide1'></span><hr></td></tr><tr valign=\"top\"><td>\n";
		}
	$j++;
	}

	print "</td></tr>\n";
	print "</table>\n\n\n";
}

my $i=0;
foreach my $job_name (@form_jobs ) {
print <<EOF;

<form id="ip_show_job_detail_form_$i" method="post" action="$server_proto://$base_uri/res/cm/ip_show_job_detail.cgi">
<input type="hidden" name="device_job" value="$job_name" />
<input type="hidden" name="device_type_group_id" value="$device_type_group_id" />
</form>

EOF

$i++;
}

print <<EOF;
<script language="JavaScript" type="text/javascript" charset="utf-8">
<!--
function submit_form(FORMNAME)
{
document.getElementById(FORMNAME).submit();
}
-->
</script>


<script language="JavaScript" type="text/javascript" charset="utf-8">
<!--
function submit_form_upload()
{
var JOB_NAME
JOB_NAME=document.upload_config.job_name.value;
document.ip_show_job_detail_form_upload.device_job.value=JOB_NAME;
document.getElementById("ip_show_job_detail_form_upload").submit();
}
-->
</script>

EOF

print <<EOF;

<form id="ip_show_job_detail_form_upload" name="ip_show_job_detail_form_upload" method="post" action="$server_proto://$base_uri/res/cm/ip_show_job_detail.cgi">
<input type="hidden" name="device_job" value="" />
<input type="hidden" name="device_type_group_id" value="$device_type_group_id" />
</form>

EOF




#### UPLOAD CONFIG

print "<br><p>\n";
print "<b>$$lang_vars{upload_cm_config_message}</b>\n";
print "<p>";
print "<form id=\"upload_config\" name=\"upload_config\" action=\"$server_proto://$base_uri/res/cm/ip_do_job.cgi\" method=\"post\" enctype=\"multipart/form-data\">\n";

print "$$lang_vars{job_message}\n";

if ( scalar keys %jobs >= 1 ) {
	print "<select name=\"job_name\" size=\"1\" width=\"230px;\">";
	print "<option></option>\n";
	for my $job_name ( keys %{ $jobs{$device_type_group_id} } ) {
		my $job_description=$jobs{$device_type_group_id}{$job_name}[0] || "";
		print "<option value=\"$job_name\">$job_description</option>\n";
	}
	print "</select>\n";
#	print "<i>$$lang_vars{select_upload_job_message}</i><p>\n";
	print "<i>$$lang_vars{select_upload_job_message}</i>\n";
	print "<span onClick=\"submit_form_upload('ip_show_job_detail_form_upload')\" class=\"input_link_w\" title=\"$$lang_vars{show_job_details_massage}\" style=\"cursor:pointer\">$$lang_vars{show_job_details_massage}</span><p>\n";
} else {
	print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_cm_jobs_message}</i></font><p>\n";
}

print "<br>\n";

print "$$lang_vars{use_stored_configuration_message} <input name=\"file_type\" type=\"radio\" value=\"stored\" onclick=\"mod_vals(this.value);\" checked>\n";
print "$$lang_vars{upload_file_message} <input name=\"file_type\" type=\"radio\" value=\"upload\" onclick=\"mod_vals(this.value);\"><br>\n";

#print "$$lang_vars{configuration_message}\n";
if ( scalar @backup_configs_all == 0 ) {
	print "<p><span id=\"no_dev_con\"><i>$$lang_vars{no_device_configuration_message}</i></span><br>\n";
	print "<select name=\"stored_config\" size=\"1\" style=\"display:none;\">";
	print "<option></option>\n";
	print "</select>\n";
} else {
	print "<span id=\"no_dev_con\">\n";
	print "<br>\n";
	print "<select name=\"stored_config\" size=\"1\">";
	print "<option></option>\n";
	foreach my $config_name (@backup_configs_all) {
		my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
		my $job_name=$values_other_jobs{$host_id}{$jid}[0] || "";
		my $job_name_descr=$jobs{$device_type_group_id}{$job_name}[0] || "N/A";
		print "<option value=\"$config_name\">$job_name_descr: $date_form ($serial)</option>";
	}
	print "</select>\n";
	print "<p><br>\n";
	print "</span>\n";

}

print <<EOF;
<input type="file" name="upload_config_name" id="upload_config_name" style="margin: 1em;display:none;" disabled><p>

<i>$$lang_vars{log_mode_message}</i><br>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tr><td nowrap>
$$lang_vars{default_message} <input type="radio" name="log_mode" value="default" checked>
$$lang_vars{verbose_message} <input type="radio" name="log_mode" value="verbose">
$$lang_vars{debug_message} <input type="radio" name="log_mode" value="debug"><p>
</td></tr></table>

<input type="hidden" name="client_id" value="$client_id">
<input type="hidden" name="job_type_id" value="3">
<input type="hidden" name="do_job" value="upload_config">
<input type="hidden" name="host_id" value="$host_id">
<input type="submit" name="Submit" value="$$lang_vars{upload_message}" class="input_link_w" onclick="return confirm('$$lang_vars{confirm_upload_job_message}')">
</form>
EOF


print "<br><p>\n";


#### RUN JOB

print "<br><p>\n";
print "<b>$$lang_vars{run_device_job_message}</b>\n";
print "<p>";
print "<form id=\"run_job\" name=\"run_job\" action=\"$server_proto://$base_uri/res/cm/ip_do_job.cgi\" method=\"post\">\n";

print "$$lang_vars{job_message}\n";

if ( scalar keys %jobs >= 1 ) {
	print "<select name=\"job_name\" size=\"1\" width=\"230px;\">";
	print "<option></option>\n";
	for my $job_name ( keys %{ $jobs{$device_type_group_id} } ) {
		my $job_description=$jobs{$device_type_group_id}{$job_name}[0] || "";
		print "<option value=\"$job_name\">$job_description</option>\n";
	}
	print "</select><p>\n";

} else {
	print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_cm_jobs_message}</i></font><p>\n";
}

print <<EOF;

<i>$$lang_vars{log_mode_message}</i><br>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tr><td nowrap>
$$lang_vars{default_message} <input type="radio" name="log_mode" value="default" checked>
$$lang_vars{verbose_message} <input type="radio" name="log_mode" value="verbose">
$$lang_vars{debug_message} <input type="radio" name="log_mode" value="debug"><p>
</td></tr></table>

<input type="hidden" name="client_id" value="$client_id">
<input type="hidden" name="do_job" value="run_job">
<input type="hidden" name="host_id" value="$host_id">
<input type="hidden" name="job_id" value="9999">
<input type="submit" name="Submit" value="$$lang_vars{run_job_messge}" class="input_link_w" onclick="return confirm('$$lang_vars{confirm_run_job_message}')">
</form>
EOF




print "<br><p>\n";
print "<br><p>\n";




#print "<script type=\"text/javascript\">\n";
#	print "document.insert_user_group_form.device_user_group_name.focus();\n";
#print "</script>\n";

print "<p><br><p>$$lang_vars{configuration_backup_dir_2_message}: <a href=\"$server_proto://$base_uri/conf/$client_name/$host_id\">$cm_backup_dir/$host_id</a><br>\n";

$gip->print_end("$client_id");
