#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.


use strict;
use DBI;
use POSIX qw(strftime);
use lib '../../modules';
use GestioIP;

my $daten=<STDIN>;
my $gip = GestioIP -> new();
my %daten=$gip->preparer($daten) if $daten;

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
my $date_param = $daten{'date'} || "";
my $host_id = $daten{'host_id'} || "";
my $job_id_param = $daten{'job_id'} || "";
my $group_id_param = $daten{'group_id'} || "";
my $show_days = $daten{'show_days'} || 0;


my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	digest8=>"$date_param",
	id=>"$job_id_param",
	id1=>"$group_id_param",
	digest6=>"$show_days",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{dashboard_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{dashboard_message}","$vars_file");


my $client_name=$gip->get_client_from_id("$client_id");
my $log_dir=$global_config[0]->[11];


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

#$show_days=5;

my $date;
my $datetime = time();
if ( $date_param =~ /^\d{8}$/ ) {
	$date=$date_param;
} else {
	$date = strftime "%Y%m%d", localtime($datetime);
}

my $range_sec = $datetime;
my @days;
my $day_second=86400;
my $datetime_form;
my ( $show_date_start,$show_date_end,$show_date_end_seconds);
if ( $show_days ) {
	$show_date_start=$date;
	$show_date_end_seconds=$datetime-$show_days*$day_second;
	$show_date_end=strftime "%Y%m%d", localtime($show_date_end_seconds);
}


my $display_date;
if ( $show_days ) {
	$show_date_end=~/^(\d{4})(\d{2})(\d{2})$/;
	my $y=$1;
	my $m=$2;
	my $d=$3;
	$display_date="$d/$m/$y";
	$date=~/^(\d{4})(\d{2})(\d{2})$/;
	$y=$1;
	$m=$2;
	$d=$3;
	$display_date.=" - $d/$m/$y";
} else {
	$date=~/^(\d{4})(\d{2})(\d{2})$/;
	my $y=$1;
	my $m=$2;
	my $d=$3;
	$display_date="$d/$m/$y";
}
print "<b>$display_date</b>\n";

print "<span style=\"float:right\">\n";
print "<i>$$lang_vars{date_message}</i> ";
print "<form name=\"send_date\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/cm_dashboard.cgi\" style=\"display:inline\">";
print "<select name=\"date\">\n";
print "<option selected></option>\n";
my $datetime_count=$datetime;
for (my $i=1;$i<32;$i++) {
	my $datetime_form = strftime "%d/%m/%Y", localtime($datetime_count);
	my $datetime_form_value = strftime "%Y%m%d", localtime($datetime_count);
	if ( $date == $datetime_form_value && ! $show_days) {
		print "<option value=\"$datetime_form_value\" selected>$datetime_form</option>\n";
	} else {
		print "<option value=\"$datetime_form_value\">$datetime_form</option>\n";
	}
	$datetime_count = $datetime_count-86400;
}
print "</select>\n";
print "<input type=\"submit\" class=\"input_link_w\" value=\"$$lang_vars{show_message}\" name=\"B1\">\n";
print "</form>\n";

print "<i>$$lang_vars{last_message}</i> ";
print "<form name=\"days\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/cm_dashboard.cgi\" style=\"display:inline;\">";
print "<select name=\"show_days\">\n";
print "<option></option>\n";
for (my $i=1;$i<31;$i++) {
	if ( $show_days == $i ) {
		print "<option value=\"$i\" selected>$i</option>\n";
	} else {
		print "<option value=\"$i\">$i</option>\n";
	}
}
print "</select>\n";
print "<i>$$lang_vars{days_message}</i> ";
print "<input type=\"submit\" class=\"input_link_w\" value=\"$$lang_vars{show_message}\" name=\"B1\">\n";
print "</form>\n";

print "</span>\n";


print "<br>\n";

my $ip_hash = $gip->get_host_hash_id_key("$client_id","","ip");

my $xml_dir=$global_config[0]->[12] || "";
my %values_device_type_groups=$gip->get_device_type_values("$client_id","$xml_dir");
#my %values_other_jobs = $gip->get_cm_jobs("$client_id","","id","$job_group_id","$device_type_group_id","id");
my $device_type_groupe_id_jobs=();
my %job_groups=$gip->get_job_groups("$client_id");
my %jobs=$gip->get_cm_jobs_all("$client_id");
#push @{$values{$id}},"$name","$description","$client_id";


my (@changed_group,@unchanged_group,@failed_group,@changed_job,@unchanged_job,@failed_job);
my (@changed_tmp,@unchanged_tmp,@failed_tmp);

my @logs = glob($log_dir . '/' . '*');
#my @device_type_group_ids_found=();
#my @job_group_ids_found=();
#my @job_ids_found=();
my %job_group_ids_found;
my %job_ids_found;



#get an association of all device_type_groups per job_group
#my %device_type_group_ids_jobs=$gip->get_device_type_group_ids_job_group_id("$client_id");

# get device_type_ids which are used in the device_job_groups of used log files
#while ( my ($group_id, $device_type_ids) = each(%device_type_group_ids_jobs) ) {
#	for my $dtid (@$device_type_ids) {
#		print "TEST DIDI: $group_id - $dtid<br>\n" if $job_group_ids_found{$group_id};
#	}
#}


print "<br>\n";

my %vals_by_group;
my %vals_by_job;
my $group_found=0;
my $job_found=0;
my @show_log_days=();
my $next=0;

foreach my $log ( @logs ) {
	$next=0;
	my $gid="";
	my $jid="";
	@changed_tmp=();
	@unchanged_tmp=();
	@failed_tmp=();
	my @changed_tmp_new=();
	my @unchanged_tmp_new=();
	my @failed_tmp_new=();

	next if $log =~ /_stdout$/i;

	my $show_days_expr="";
	if ( $show_date_start ) {
		#20141019
		my $show_days_expr_pre;
		my $show_days_expr_seconds=$datetime;
		for (my $i=0;$i<$show_days;$i++) {
			$show_days_expr_pre=strftime "%Y%m%d", localtime($show_days_expr_seconds);
			$show_days_expr=$show_days_expr . "|" . $show_days_expr_pre;
			$show_days_expr_seconds=$show_days_expr_seconds-$day_second;
		}
		$show_days_expr =~ s/^\|//;
		next if $log !~ /\/($show_days_expr)/;
	} elsif ( $date ) {
		next if $log !~ /\/$date/;
	}

	open (LOG,"$log");
	while (<LOG>) {

		if ( $_ =~ /Configuration changed/ ) {
			if ( $_ !~ /-/ ) {
				$_ =~ s/Configuration changed: //;
				@changed_tmp=split(",",$_) if $_;
				my $i=0;
				foreach my $ip ( @changed_tmp ) {
					$ip=~s/\s//g;
					my $ip_int=$ip_hash->{$ip}[1] || "";
					if ( $ip_int ) {
						my $csv="$ip_int,$ip,$log";
						$changed_tmp_new[$i++]=$csv;;
					}
				}
				@changed_tmp=@changed_tmp_new;

			}
		} elsif ( $_ =~ /Configuration unchanged/ ) {
			if ( $_ !~ /-/ ) {
				$_ =~ s/Configuration unchanged: //;
				@unchanged_tmp=split(",",$_) if $_;
				my $i=0;
				foreach my $ip ( @unchanged_tmp ) {
					$ip=~s/\s//g;
					my $ip_int=$ip_hash->{$ip}[1] || "";
					if ( $ip_int ) {
						my $csv="$ip_int,$ip,$log";
						$unchanged_tmp_new[$i++]=$csv;;
					}
				}
				@unchanged_tmp=@unchanged_tmp_new;
			}
		} elsif ( $_ =~ /Backup failed/ ) {
			if ( $_ !~ /-/ ) {
				$_ =~ s/Backup failed: //;
				@failed_tmp=split(",",$_) if $_;
				my $i=0;
				foreach my $ip ( @failed_tmp ) {
					$ip=~s/\s//g;
					my $ip_int=$ip_hash->{$ip}[1] || "";
					if ( $ip_int ) {
						my $csv="$ip_int,$ip,$log";
						$failed_tmp_new[$i++]=$csv;;
					}
				}
				@failed_tmp=@failed_tmp_new;

			}
		}

                if ( $_ =~ /executing fetch_config.pl/ ) {
                        #get job group or job id
                        if ( $_ =~ /(-g|--group_id)/ ) {
                                $_ =~ /(-g|--group_id) (\d+)/;
                                $gid=$2 || "";
				if ( ! $job_groups{$gid}[0] ) {
					$next=1;
					next;
				}
				$group_found=1;

                        } elsif ( $_ =~ /(-i|--id)/ ) {
                                $_ =~ /(-i|--id) (\d+)/;
                                $jid=$2 || "";
				if ( ! $jobs{$jid}[0] ) {
					$next=1;
					next;
				}
				$job_found=1;
                        }
			last;
                }
	}
	close LOG;

	if ( $group_id_param && $gid && $gid != $group_id_param ) {
		$next=1;
	}
	if ( $job_id_param && $jid && $jid != $job_id_param ) {
		$next=1;
	}


	next if $next == 1;


	if ( $gid ) {
                $job_group_ids_found{"$gid"}++;
		if ( $show_date_start ) {
			$log =~ /\/($show_days_expr)/;
			my $logdate=$1;
			push @{$vals_by_group{$logdate}{$gid}{"changed"}},@changed_tmp;
			push @{$vals_by_group{$logdate}{$gid}{"unchanged"}},@unchanged_tmp;
			push @{$vals_by_group{$logdate}{$gid}{"failed"}},@failed_tmp;
		} else {
			push @{$vals_by_group{$gid}{"changed"}},@changed_tmp;
			push @{$vals_by_group{$gid}{"unchanged"}},@unchanged_tmp;
			push @{$vals_by_group{$gid}{"failed"}},@failed_tmp;
		}
		@changed_group = (@changed_group,@changed_tmp);
		@unchanged_group = (@unchanged_group,@unchanged_tmp);
		@failed_group = (@failed_group,@failed_tmp);
	} elsif ( $jid ) {
                $job_ids_found{"$jid"}++;
		if ( $show_date_start ) {
			$log =~ /\/($show_days_expr)/;
			my $logdate=$1;
			push @{$vals_by_job{$logdate}{$jid}{"changed"}},@changed_tmp;
			push @{$vals_by_job{$logdate}{$jid}{"unchanged"}},@unchanged_tmp;
			push @{$vals_by_job{$logdate}{$jid}{"failed"}},@failed_tmp;
		} else {
			push @{$vals_by_job{$jid}{"changed"}},@changed_tmp;
			push @{$vals_by_job{$jid}{"unchanged"}},@unchanged_tmp;
			push @{$vals_by_job{$jid}{"failed"}},@failed_tmp;
		}
		@changed_job = (@changed_job,@changed_tmp);
		@unchanged_job = (@unchanged_job,@unchanged_tmp);
		@failed_job = (@failed_job,@failed_tmp);
	}
}


my ($anz_failed_group,$anz_changed_group,$anz_unchanged_group,$anz_failed_job,$anz_changed_job,$anz_unchanged_job);
$anz_failed_group=$anz_changed_group=$anz_unchanged_group=$anz_failed_job=$anz_changed_job=$anz_unchanged_job=0;

my @results_group=();

$anz_failed_group=scalar(@failed_group);
$anz_changed_group=scalar(@changed_group);
$anz_unchanged_group=scalar(@unchanged_group);
my @failed_group_orig=@failed_group;
my @changed_group_orig=@changed_group;
my @unchanged_group_orig=@unchanged_group;

$anz_failed_job=scalar(@failed_job);
$anz_changed_job=scalar(@changed_job);
$anz_unchanged_job=scalar(@unchanged_job);
my @failed_job_orig=@failed_job;
my @changed_job_orig=@changed_job;
my @unchanged_job_orig=@unchanged_job;


sub sort_by_number {
    $a =~ /(\d+)/;
    my $numa = $1;
    $b =~ /(\d+)/;
    my $numb = $1;

    return $numa <=> $numb;
}

@failed_group = sort sort_by_number @failed_group;
foreach ( @failed_group_orig) {
	push (@results_group,"failed"); 
}
@changed_group = sort sort_by_number @changed_group;
foreach (@changed_group_orig) {
	push (@results_group,"changed");
}
@unchanged_group = sort sort_by_number @unchanged_group;
foreach  (@unchanged_group_orig) {
	push (@results_group,"unchanged");
}

if ( $show_days ) {
	#eleminate duplicated entries
	my %counts1 = ();
	my %counts1_helper = ();

	if ( $group_found == 1 ) {
		%counts1 = ();
		%counts1_helper = ();
		my @changed_group_tmp=();
		for (@changed_group) {
			$_ =~ /^(\d+),(.+),(.+)$/;
			my $ip_int=$1;
			$counts1_helper{$ip_int}++;
			$counts1{$ip_int}="$_,$counts1_helper{$ip_int}";
		}
		foreach my $key ( sort sort_by_number keys %counts1 ) {
			push @changed_group_tmp,"$counts1{$key}";
		}
		@changed_group=@changed_group_tmp;

		%counts1 = ();
		%counts1_helper = ();
		my @failed_group_tmp=();
		for (@failed_group) {
			$_ =~ /^(\d+),(.+),(.+)$/;
			my $ip_int=$1;
			$counts1_helper{$ip_int}++;
			$counts1{$ip_int}="$_,$counts1_helper{$ip_int}";
		}
		foreach my $key ( sort sort_by_number keys %counts1 ) {
			push @failed_group_tmp,"$counts1{$key}";
		}
		@failed_group=@failed_group_tmp;
	}

	if ( $job_found == 1 ) {
		%counts1 = ();
		%counts1_helper = ();
		my @failed_job_tmp=();
		for (@failed_job) {
			$_ =~ /^(\d+),(.+),(.+)$/;
			my $ip_int=$2;
			$counts1_helper{$ip_int}++;
			$counts1{$ip_int}="$_,$counts1_helper{$ip_int}";
		}
		foreach my $key ( sort sort_by_number keys %counts1 ) {
			push @failed_job_tmp,"$counts1{$key}";
		}
		@failed_job=@failed_job_tmp;

		%counts1 = ();
		%counts1_helper = ();
		my @changed_job_tmp=();
		for (@changed_job) {
			$_ =~ /^(\d+),(.+),(.+)$/;
			my $ip_int=$1;
			$counts1_helper{$ip_int}++;
			$counts1{$ip_int}="$_,$counts1_helper{$ip_int}";
		}
		foreach my $key ( sort sort_by_number keys %counts1 ) {
			push @changed_job_tmp,"$counts1{$key}";
		}
		@changed_job=@changed_job_tmp;
	}
}



print "<table border='0' width='100%' cellpadding='10'>\n";
print "<tr><td valign='top'>\n";
print "<span class=\"headline_administrate_text\">$$lang_vars{job_groups_message}</span><p>\n" if ! $job_id_param;

if ( $group_found == 1 && ! $job_id_param) {
	print "<i>$$lang_vars{failed_message}:</i><br>\n";
	if ( @failed_group ) {
		my $count_hosts=0;
		foreach ( @failed_group ) {
			if ( $count_hosts == 500 ) {
				print "<i><b>$$lang_vars{resultado_limitado_message} 500 $$lang_vars{entradas_message}</i></b><br>\n";
				last;
			}

			my ($ip,$ip_int,$log);
			my $count=1;
			if ( $show_days ) {
				$_ =~ /^(\d+),(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
				$count=$4 if $4;
			} else {
				$_ =~ /^(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
			}
			my $ip_version="v4";
			$ip_version="v6" if $ip =~ /:/;
			$log =~ s/.*\///;
			my $style;
			my $style_span;
			my $hostname=$ip_hash->{$ip}[2];
			my $host_id=$ip_hash->{$ip}[0];
			if ( $show_days ) {
				if ( $count >= $show_days ) {
					$style="RedLink";
					$style_span="RedSpan";
				} elsif ( $count >= $show_days/2 ) {
					$style="OrangeLink";
					$style_span="OrangeSpan";
				} elsif ( $count == 1 ) {
					$style="Blue1Link";
				} else {
					$style="Blue2Link";
					$style_span="Blue2Span";
				}
			} else {
				$style="Blue1Link";
			}
			
			if ( $show_days && $count > 1 ) {
				print "<form style=\"display:inline;\"></form>\n";
				print "<span class=\"$style_span\" style=\"display:inline;\" title=\"$count x $$lang_vars{failed_message}\">$ip ($hostname)</span>";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			} else {
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi#$ip\" style=\"display:inline;\"><input type=\"hidden\" value=\"$log\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$ip\" name=\"ip\"><input type=\"hidden\" value=\"$ip_version\" name=\"ip_version\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"$style\" value=\"$ip ($hostname)\" name=\"B1\" title=\"$$lang_vars{show_cm_config_fetch_log_message}\"></form>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			}
			$count_hosts++;
		}
	} else {
		print "-<br>\n";
	}


	print "<p>\n";
	print "<i>$$lang_vars{changed_message}:</i><br>\n";
	if ( @changed_group ) {
		my $count_hosts=0;
		foreach ( @changed_group ) {
			if ( $count_hosts == 500 ) {
				print "<i><b>$$lang_vars{resultado_limitado_message} 500 $$lang_vars{entradas_message}</i></b><br>\n";
				last;
			}

			my ($ip,$ip_int,$log);
			my $count=1;
			if ( $show_days ) {
				$_ =~ /^(\d+),(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
				$count=$4 if $4;
			} else {
				$_ =~ /^(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
			}
			my $ip_version="v4";
			$ip_version="v6" if $ip =~ /:/;
			$log =~ s/.*\///;
			my $style;
			my $style_span;
			my $hostname=$ip_hash->{$ip}[2];
			my $host_id=$ip_hash->{$ip}[0];
			if ( $show_days ) {
				if ( $count >= $show_days ) {
					$style="Blue3Link";
					$style_span="Blue3Span";
				} elsif ( $count == 1 ) {
					$style="Blue1Link";
				} else {
					$style="Blue2Link";
					$style_span="Blue2Span";
				}
			} else {
				$style="Blue1Link";
			}
			
			if ( $show_days && $count > 1 ) {
				print "<form style=\"display:inline;\"></form>\n";
				print "<span class=\"$style_span\" style=\"display:inline;\" title=\"$count x $$lang_vars{changed_message}\">$ip ($hostname)</span>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			} else {
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi#$ip\" style=\"display:inline;\"><input type=\"hidden\" value=\"$log\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$ip\" name=\"ip\"><input type=\"hidden\" value=\"$ip_version\" name=\"ip_version\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"$style\" value=\"$ip ($hostname)\" name=\"B1\" title=\"$$lang_vars{show_cm_config_fetch_log_message}\"></form>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			}
			$count_hosts++;
		}
	} else {
		print "-<br>\n";
	}


	print "</td><td valign='top'>\n";


	if ( scalar(keys %job_group_ids_found) > 1 || $show_days ) {
		my $i=0;
		my %counts = ();
		for (@results_group) {
			$counts{$results_group[$i++]}++;
		}
		$gip->create_stat_pie_chart(\%counts,"cm_stat","results_group","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");

		print "<p>\n";
		print "<b><i>$$lang_vars{all_job_groups_message}</i></b><br>\n";
		print "$$lang_vars{failed_message}: $anz_failed_group - $$lang_vars{changed_message}: $anz_changed_group - $$lang_vars{unchanged_message}: $anz_unchanged_group<br>\n";

		print "<img src=\"../../imagenes/dyn/results_group.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\">";
	}

	print "<br><p>\n";

	if ( $show_date_start ) {
		foreach my $logdate ( reverse sort keys %vals_by_group) {
			$logdate=~/^(\d{4})(\d{2})(\d{2})$/;
			my $y=$1;
			my $m=$2;
			my $d=$3;
			
			print "<b><i>$d/$m/$y</i></b><br>\n";
			foreach my $gid (keys %{$vals_by_group{$logdate}}) {
				my $job_group_name=$job_groups{$gid}[0];
				print "<b><i>$job_group_name ($gid)</i></b><br>\n";
				my ($anz_failed,$anz_changed,$anz_unchanged);
				$anz_failed=$anz_changed=$anz_unchanged=0;
				my %counts = ();
				while ( my ($type, $changed_devs) = each %{$vals_by_group{$logdate}{$gid}} ) {
					for my $dev (@$changed_devs) {
						my @results_group=();
						if ( $type eq "unchanged" ) {
							push (@results_group,"unchanged");
							$anz_unchanged++;
						} elsif ( $type eq "changed" ) {
							push (@results_group,"changed");
							$anz_changed++;
						} elsif ( $type eq "failed" ) {
							push (@results_group,"failed");
							$anz_failed++;
						}

						my $i=0;
						for (@results_group) {
							$counts{$results_group[$i++]}++;
						}
					}
				}

				print "$$lang_vars{failed_message}: $anz_failed - $$lang_vars{changed_message}: $anz_changed - $$lang_vars{unchanged_message}: $anz_unchanged<br>\n";
				$gip->create_stat_pie_chart(\%counts,"cm_stat","results_${logdate}_${gid}","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");

print <<EOF;
<form name="submit_${logdate}_${gid}" action="$server_proto://$base_uri/res/cm/cm_dashboard.cgi" method="post">
<input type="hidden" name="date" value="$y$m$d"/>
<input type="hidden" name="group_id" value="$gid"/>
</form>
EOF
				print "<span onclick=\"document.forms['submit_${logdate}_${gid}'].submit();\" style=\"cursor: pointer\"><img src=\"../../imagenes/dyn/results_${logdate}_${gid}.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\"></span>";
				print "<p>\n";
			}
		}

	} else {

		foreach my $gid (keys %vals_by_group) {
			my ($anz_failed,$anz_changed,$anz_unchanged);
			$anz_failed=$anz_changed=$anz_unchanged=0;
			my $job_group_name=$job_groups{$gid}[0];
			print "<b><i>$job_group_name ($gid)</i></b><br>\n";
			my %counts = ();
			while ( my ($type, $changed_devs) = each %{$vals_by_group{$gid}} ) {
				for my $dev (@$changed_devs) {
					my @results_group=();
					if ( $type eq "unchanged" ) {
						push (@results_group,"unchanged");
						$anz_unchanged++;
					} elsif ( $type eq "changed" ) {
						push (@results_group,"changed");
						$anz_changed++;
					} elsif ( $type eq "failed" ) {
						push (@results_group,"failed");
						$anz_failed++;
					}

					my $i=0;
					for (@results_group) {
						$counts{$results_group[$i++]}++;
					}
				}
			}
			print "$$lang_vars{failed_message}: $anz_failed - $$lang_vars{changed_message}: $anz_changed - $$lang_vars{unchanged_message}: $anz_unchanged<br>\n";
			$gip->create_stat_pie_chart(\%counts,"cm_stat","results_${gid}","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");
#			print "<img src=\"../../imagenes/dyn/results_${gid}.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\">";

print <<EOF;
<form name="submit_${gid}" action="$server_proto://$base_uri/res/cm/cm_dashboard.cgi" method="post">
<input type="hidden" name="date" value="$date_param"/>
<input type="hidden" name="group_id" value="$gid"/>
</form>
EOF
			print "<span onclick=\"document.forms['submit_${gid}'].submit();\" style=\"cursor: pointer\"><img src=\"../../imagenes/dyn/results_${gid}.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\"></span>";
			print "<p>\n";
		}
	}
} else {
	$date=~/^(\d{4})(\d{2})(\d{2})$/;
	my $y=$1;
	my $m=$2;
	my $d=$3;
	print "<b>$d/$m/$y</b>: $$lang_vars{no_job_groups_date_message}<p>\n" if ! $job_id_param;
}




print "</td><td valign='top'>\n";
print "<span class=\"headline_administrate_text\">$$lang_vars{single_jobs_messsage}</span><p>\n" if ! $group_id_param;

if ( $job_found == 1 && ! $group_id_param ) {
	my @results_job=();

	@failed_job = sort sort_by_number @failed_job;
	foreach my $failed (@failed_job_orig) {
		push (@results_job,"failed");
	}
	@changed_job = sort sort_by_number @changed_job;
	foreach my $changed (@changed_job_orig) {
		push (@results_job,"changed");
	}
	@unchanged_job = sort sort_by_number @unchanged_job;
	foreach my $unchanged (@unchanged_job_orig) {
		push (@results_job,"unchanged");
	}

	print "<i>$$lang_vars{failed_message}:</i><br>\n";
	if ( @failed_job ) {
		my $count_hosts=0;
		foreach ( @failed_job ) {
			if ( $count_hosts == 500 ) {
				print "<i><b>$$lang_vars{resultado_limitado_message} 500 $$lang_vars{entradas_message}</i></b><br>\n";
				last;
			}

			my ($ip,$ip_int,$log);
			my $count=1;
			if ( $show_days ) {
				$_ =~ /^(\d+),(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
				$count=$4 if $4;
			} else {
				$_ =~ /^(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
			}
			my $ip_version="v4";
			$ip_version="v6" if $ip =~ /:/;
			$log =~ s/.*\///;
			my $style;
			my $style_span;
			my $hostname=$ip_hash->{$ip}[2];
			my $host_id=$ip_hash->{$ip}[0];
			if ( $show_days ) {
				if ( $count >= $show_days ) {
					$style="RedLink";
					$style_span="RedSpan";
				} elsif ( $count >= $show_days/2 ) {
					$style="OrangeLink";
					$style_span="OrangeSpan";
				} elsif ( $count == 1 ) {
					$style="Blue1Link";
				} else {
					$style="Blue2Link";
					$style_span="Blue2Span";
				}
			} else {
				$style="Blue1Link";
			}

			if ( $show_days && $count > 1 ) {
				print "<form style=\"display:inline;\"></form>\n";
				print "<span class=\"$style_span\" style=\"display:inline;\" title=\"$count x $$lang_vars{failed_message}\">$ip ($hostname)</span>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			} else {
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi#$ip\" style=\"display:inline;\"><input type=\"hidden\" value=\"$log\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$ip\" name=\"ip\"><input type=\"hidden\" value=\"$ip_version\" name=\"ip_version\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"$style\" value=\"$ip ($hostname)\" name=\"B1\" title=\"$$lang_vars{show_cm_config_fetch_log_message}\"></form>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			}
			$count_hosts++;
		}
	} else {
		print "-<br>\n";
	}

	print "<p>\n";
	print "<i>$$lang_vars{changed_message}:</i><br>\n";
	if ( @changed_job ) {
		my $count_hosts=0;
		foreach ( @changed_job ) {
			if ( $count_hosts == 500 ) {
				print "<i><b>$$lang_vars{resultado_limitado_message} 500 $$lang_vars{entradas_message}</i></b><br>\n";
				last;
			}

			my ($ip,$ip_int,$log);
			my $count=1;
			if ( $show_days ) {
				$_ =~ /^(\d+),(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
				$count=$4 if $4;
			} else {
				$_ =~ /^(.+),(.+),(.+)$/;
				$ip_int=$1;
				$ip=$2;
				$log=$3;
			}
			my $ip_version="v4";
			$ip_version="v6" if $ip =~ /:/;
			$log =~ s/.*\///;
			my $style;
			my $style_span;
			my $hostname=$ip_hash->{$ip}[2];
			my $host_id=$ip_hash->{$ip}[0];
			if ( $show_days ) {
				if ( $count >= $show_days ) {
					$style="Blue3Link";
					$style_span="Blue3Span";
				} elsif ( $count == 1 ) {
					$style="Blue1Link";
				} else {
					$style="Blue2Link";
					$style_span="Blue2Span";
				}
			} else {
				$style="Blue1Link";
			}
			
			if ( $show_days && $count > 1 ) {
				print "<form style=\"display:inline;\"></form>\n";
				print "<span class=\"$style_span\" style=\"display:inline;\" title=\"$count x $$lang_vars{changed_message}\">$ip ($hostname)</span>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			} else {
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_show_cm_log.cgi#$ip\" style=\"display:inline;\"><input type=\"hidden\" value=\"$log\" name=\"cm_log_file\"><input type=\"hidden\" value=\"$ip\" name=\"ip\"><input type=\"hidden\" value=\"$ip_version\" name=\"ip_version\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"$style\" value=\"$ip ($hostname)\" name=\"B1\" title=\"$$lang_vars{show_cm_config_fetch_log_message}\"></form>\n";
				print "<form name=\"show_cm_log_form_${ip}\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_form.cgi\" style=\"display:inline;\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" class=\"show_jobs_button\" value=\"\" name=\"B1\" title=\"$$lang_vars{job_management_short_expl_message}\"></form><br>\n";
			}
			$count_hosts++;
		}	
	} else {
		print "-<br>\n";
	}


	print "</td><td valign='top'>\n";


	if ( scalar(keys %job_ids_found) > 1 || $show_days ) {
		my $i=0;
		my %counts = ();
		for (@results_job) {
			$counts{$results_job[$i++]}++;
		}
		$gip->create_stat_pie_chart(\%counts,"cm_stat","results_job","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");

		print "<p>\n";
		print "<b><i>$$lang_vars{all_jobs_message}</i></b><br>\n";
		print "$$lang_vars{failed_message}: $anz_failed_job - $$lang_vars{changed_message}: $anz_changed_job - $$lang_vars{unchanged_message}: $anz_unchanged_job<br>\n";
		print "<img src=\"../../imagenes/dyn/results_job.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\">";
	}


	print "<br><p>\n";

	if ( $show_date_start ) {
		foreach my $logdate ( reverse sort keys %vals_by_job) {
			$logdate=~/^(\d{4})(\d{2})(\d{2})$/;
			my $y=$1;
			my $m=$2;
			my $d=$3;
			
			print "<b><i>$d/$m/$y</i></b><br>\n";
			foreach my $jid (keys %{$vals_by_job{$logdate}}) {
				my ($anz_failed,$anz_changed,$anz_unchanged);
				$anz_failed=$anz_changed=$anz_unchanged=0;
				my $job_name=$jobs{$jid}[1];
				print "<b><i>$job_name ($jid)</i></b><br>\n";
				my %counts = ();
				while ( my ($type, $changed_devs) = each %{$vals_by_job{$logdate}{$jid}} ) {
					for my $dev (@$changed_devs) {
						my @results_job=();
						if ( $type eq "unchanged" ) {
							push (@results_job,"unchanged");
							$anz_unchanged++;
						} elsif ( $type eq "changed" ) {
							push (@results_job,"changed");
							$anz_changed++;
						} elsif ( $type eq "failed" ) {
							push (@results_job,"failed");
							$anz_failed++;
						}

						my $i=0;
						for (@results_job) {
							$counts{$results_job[$i++]}++;
						}
					}
				}

				print "$$lang_vars{failed_message}: $anz_failed - $$lang_vars{changed_message}: $anz_changed - $$lang_vars{unchanged_message}: $anz_unchanged<br>\n";
				$gip->create_stat_pie_chart(\%counts,"cm_stat","results_${logdate}_${jid}","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");

print <<EOF;
<form name="submit_${logdate}_${jid}" action="$server_proto://$base_uri/res/cm/cm_dashboard.cgi" method="post">
<input type="hidden" name="date" value="$y$m$d"/>
<input type="hidden" name="job_id" value="$jid"/>
</form>
EOF
				print "<span onclick=\"document.forms['submit_${logdate}_${jid}'].submit();\" style=\"cursor: pointer\"><img src=\"../../imagenes/dyn/results_${logdate}_${jid}.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\"></span>";
				print "<p>\n";
			}
		}
	} else {

		foreach my $jid (keys %vals_by_job) {
			my ($anz_failed,$anz_changed,$anz_unchanged);
			$anz_failed=$anz_changed=$anz_unchanged=0;
			my $job_name=$jobs{$jid}[1];
			print "<b><i>$job_name ($jid)</i></b><br>\n";
			my %counts = ();
			while ( my ($type, $changed_devs) = each %{$vals_by_job{$jid}} ) {
				for my $dev (@$changed_devs) {
					my @results_job=();
					if ( $type eq "unchanged" ) {
						push (@results_job,"unchanged");
						$anz_unchanged++;
					} elsif ( $type eq "changed" ) {
						push (@results_job,"changed");
						$anz_changed++;
					} elsif ( $type eq "failed" ) {
						push (@results_job,"failed");
						$anz_failed++;
					}

					my $i=0;
					for (@results_job) {
						$counts{$results_job[$i++]}++;
					}
				}
			}

			print "$$lang_vars{failed_message}: $anz_failed - $$lang_vars{changed_message}: $anz_changed - $$lang_vars{unchanged_message}: $anz_unchanged<br>\n";
			$gip->create_stat_pie_chart(\%counts,"cm_stat","results_${jid}","v6","$client_id","$vars_file","$$lang_vars{networks6_by_cat_message}","cm_stat");

print <<EOF;
<form name="submit_${jid}" action="$server_proto://$base_uri/res/cm/cm_dashboard.cgi" method="post">
<input type="hidden" name="date" value="$date_param"/>
<input type="hidden" name="job_id" value="$jid"/>
</form>
EOF
			print "<span onclick=\"document.forms['submit_${jid}'].submit();\" style=\"cursor: pointer\"><img src=\"../../imagenes/dyn/results_${jid}.png\" alt=\"$$lang_vars{networks6_by_cat_message} chart\"></span>";
			print "<p>\n";
		}
	}
} else {
	$date=~/^(\d{4})(\d{2})(\d{2})$/;
	my $y=$1;
	my $m=$2;
	my $d=$3;
	print "<b>$d/$m/$y</b>: $$lang_vars{no_job_date_message}<p>\n" if ! $group_id_param;
}

print "</td></tr></table>\n";


print "<p><br>\n";

$gip->print_end("$client_id");


