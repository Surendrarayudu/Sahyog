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


# Parameter check
my $lang = $daten{'lang'} || "";
$lang="" if $lang !~ /^\w{1,3}$/;
my ($lang_vars,$vars_file)=$gip->get_lang("","$lang");
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

my $select_box_order=$daten{'select_box_order'} || "";

my $anz_hosts=$daten{'anz_hosts'} || 0;
my ($host_ip1,$host_ip2,$host_id1,$host_id2,$host_ip_int1,$host_ip_int2);

my $k;
my $mass_update_host_ids="";
for ($k=0;$k<=$anz_hosts;$k++) {
        if ( $daten{"mass_update_host_submit_${k}"} ) {
                $mass_update_host_ids.=$daten{"mass_update_host_submit_${k}"} . "_";
        }
}

$mass_update_host_ids=~s/_$//;

if ( $mass_update_host_ids ) {
	if ( $mass_update_host_ids =~ /^(.+)_(.+)_(.+)/ || $mass_update_host_ids !~ /_/) {
                $gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$$lang_vars{two_diff_hosts_message}",vars_file=>"$vars_file",client_id=>"$client_id",back_link=>"back_link");

        } elsif ( $mass_update_host_ids=~/^(.+)_(.+)$/ ) {
                $host_ip1=$1;
                $host_ip2=$2;
		if ( $host_ip1 =~ /^\d{1,3}\.\d{1,3}.\d{1,3}.\d{1,3}$/ ) {
			$host_ip_int1=$gip->ip_to_int("$client_id","$host_ip1","v4");
		} elsif ( $host_ip1 =~ /^[0-9a-f:]{1,40}$/ ) {
			$host_ip_int1=$gip->ip_to_int("$client_id","$host_ip1","v6");
		} else {
			$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$$lang_vars{formato_malo_message} $host_ip1 - $host_ip2 (1a)",vars_file=>"$vars_file",client_id=>"$client_id",back_link=>"back_link");
		}
		if ( $host_ip2 =~ /^\d{1,3}\.\d{1,3}.\d{1,3}.\d{1,3}$/ ) {
			$host_ip_int2=$gip->ip_to_int("$client_id","$host_ip2","v4");
		} elsif ( $host_ip2 =~ /^[0-9a-f:]{1,40}$/ ) {
			$host_ip_int2=$gip->ip_to_int("$client_id","$host_ip2","v6");
		} else {
			$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$$lang_vars{formato_malo_message} (1b) $host_ip2",vars_file=>"$vars_file",client_id=>"$client_id",back_link=>"back_link");
		}
                $host_id1=$gip->get_host_id_from_ip_int("$client_id","$host_ip_int1");
                $host_id2=$gip->get_host_id_from_ip_int("$client_id","$host_ip_int2");

        } else {
                $gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$$lang_vars{formato_malo_message} (mass_update_host_ids)",vars_file=>"$vars_file",client_id=>"$client_id");
	}
}



my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
	select_box_order=>"$select_box_order",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;

my $server_proto=$gip->get_server_proto();
my $base_uri = $gip->get_base_uri();

$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{diff_configs_jo_message}","$vars_file");


my $cm_xml_dir=$global_config[0]->[12] || "";
#my ($host_hash_ref,$host_sort_helper_array_ref)=$gip->get_host_hash("$client_id","","","$host_order_by","","","","CM");
my ($host_hash_ref,$host_sort_helper_array_ref)=$gip->get_host_hash("$client_id","","","IP_auf","","","","CM");
my %cm_jobs_hosts=$gip->get_cm_jobs_cm_hosts("$client_id");
my %values_device_type_groups=$gip->get_device_type_values("$client_id","$cm_xml_dir");

my $anz_host_total = keys %$host_hash_ref;
my $select_box_order_form;

my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

my $sort_order_ref;
if ( $select_box_order eq "hostname" ) {
	$sort_order_ref = sub {
		my $A=$host_hash_ref->{$a}[1];
		my $B=$host_hash_ref->{$b}[1];
		${A} cmp ${B};
	};
} else {
	$sort_order_ref = sub {
		lc ${a} cmp lc ${b};
	};
}

my $device_without_job=0;

my $order_checkbox_by_form_message;
if ( $select_box_order eq "hostname" ) {
	$order_checkbox_by_form_message=$$lang_vars{ip_address_message};
	$select_box_order_form="IP";
} else {
	$order_checkbox_by_form_message=$$lang_vars{hostname_message};
	$select_box_order_form="hostname";
}

print "<p><br>\n";
print "<b>$$lang_vars{choose_two_jobs_message}</b><p>\n";


print "<form name=\"ip_cm_diff_devices_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_devices_form1.cgi\" style=\"display:inline\">\n";
print "<table border=\"0\" cellpadding=\"1\">\n";
print "<tr><td>\n";
if ( $host_id1 ) {
	my $ip = $host_hash_ref->{$host_ip_int1}[0];
	my $hostname=$host_hash_ref->{$host_ip_int1}[1] || "";
	my $host_id = $host_hash_ref->{$host_ip_int1}[12];
	if ( ! $cm_jobs_hosts{$host_id1} ) {
		print "<b>$$lang_vars{job_message} I</b></td><td>$ip ($hostname): <i>$$lang_vars{no_cm_jobs_device_message}</i></td></tr>\n";
		$device_without_job=1;
	} else {
		print "<b>$$lang_vars{job_message} I</b></td><td><select name=\"diff_host1\" size=\"1\">\n";
		for my $job_id ( sort keys %{ $cm_jobs_hosts{$host_id1} } ) {
			my $job_name=$cm_jobs_hosts{$host_id1}{$job_id}[2];
			$job_name=~s/_/-/g;
			my $job_group_id=$cm_jobs_hosts{$host_id1}{$job_id}[3];
			my $job_descr=$cm_jobs_hosts{$host_id1}{$job_id}[4];
			my $device_type_group_id=$cm_jobs_hosts{$host_id1}{$job_id}[5];
			my $device_type_group_name=$values_device_type_groups{$device_type_group_id}[0];
			$device_type_group_name=~s/_/-/g;

			if ( $select_box_order eq "hostname" ) {
				print "<option value=\"${host_id1}_${job_id}_${device_type_group_id}_${job_name}\">$hostname ($ip) - $device_type_group_name/$job_name</option>\n";
			} else {
				print "<option value=\"${host_id1}_${job_id}_${device_type_group_id}_${job_name}\">$ip ($hostname) - $device_type_group_name/$job_name</option>\n";
			}
		}
		print "</select>\n";
	}
} else {
	print "<b>$$lang_vars{job_message} I</b></td><td><select name=\"diff_host1\" size=\"1\">\n";
	foreach my $keys ( sort $sort_order_ref keys %{$host_hash_ref} ) {
		my $ip = $host_hash_ref->{$keys}[0];
		my $hostname=$host_hash_ref->{$keys}[1] || "";
		my $host_id = $host_hash_ref->{$keys}[12];
		for my $job_id ( sort keys %{ $cm_jobs_hosts{$host_id} } ) {
			my $job_name=$cm_jobs_hosts{$host_id}{$job_id}[2];
			$job_name=~s/_/-/g;
			my $job_group_id=$cm_jobs_hosts{$host_id}{$job_id}[3];
			my $job_descr=$cm_jobs_hosts{$host_id}{$job_id}[4];
			my $device_type_group_id=$cm_jobs_hosts{$host_id}{$job_id}[5];
			my $device_type_group_name=$values_device_type_groups{$device_type_group_id}[0] || "";
			$device_type_group_name=~s/_/-/g;

			if ( $select_box_order eq "hostname" ) {
				print "<option value=\"${host_id}_${job_id}_${device_type_group_id}_${job_name}\">$hostname ($ip) - $device_type_group_name/$job_name</option>\n";
			} else {
				print "<option value=\"${host_id}_${job_id}_${device_type_group_id}_${job_name}\">$ip ($hostname) - $device_type_group_name/$job_name</option>\n";
			}
		}
	}
	print "</select>\n";
}
print "</td></tr>\n";



if ( $host_id2 ) {
	my $ip = $host_hash_ref->{$host_ip_int2}[0];
	my $hostname=$host_hash_ref->{$host_ip_int2}[1] || "";
	my $host_id = $host_hash_ref->{$host_ip_int2}[12];
	if ( ! $cm_jobs_hosts{$host_id2} ) {
		print "<tr><td><b>$$lang_vars{job_message} II</b></td><td>$ip ($hostname): <i>$$lang_vars{no_cm_jobs_device_message}</i></td></tr>\n";
		$device_without_job=1;
	} else {
		print "<tr><td><b>$$lang_vars{job_message} II</b></td><td><select name=\"diff_host2\" size=\"1\">\n";
		for my $job_id ( sort keys %{ $cm_jobs_hosts{$host_id2} } ) {
			my $host_id=$cm_jobs_hosts{$host_id2}{$job_id}[1];
			my $job_name=$cm_jobs_hosts{$host_id2}{$job_id}[2];
			$job_name=~s/_/-/g;
			my $job_group_id=$cm_jobs_hosts{$host_id2}{$job_id}[3];
			my $job_descr=$cm_jobs_hosts{$host_id2}{$job_id}[4];
			my $device_type_group_id=$cm_jobs_hosts{$host_id2}{$job_id}[5];
			my $device_type_group_name=$values_device_type_groups{$device_type_group_id}[0];
			$device_type_group_name=~s/_/-/g;

			if ( $select_box_order eq "hostname" ) {
				print "<option value=\"${host_id2}_${job_id}_${device_type_group_id}_${job_name}\">$hostname ($ip) - $device_type_group_name/$job_name</option>\n";
			} else {
				print "<option value=\"${host_id2}_${job_id}_${device_type_group_id}_${job_name}\">$ip ($hostname) - $device_type_group_name/$job_name</option>\n";
			}
		}
print "</select>\n";
	}
} else {
	print "<tr><td><b>$$lang_vars{job_message} II</b></td><td><select name=\"diff_host2\" size=\"1\">\n";
	foreach my $keys ( sort $sort_order_ref keys %{$host_hash_ref} ) {
		my $ip = $host_hash_ref->{$keys}[0];
		my $hostname=$host_hash_ref->{$keys}[1] || "";
		my $host_id = $host_hash_ref->{$keys}[12];
		for my $job_id ( sort keys %{ $cm_jobs_hosts{$host_id} } ) {
			my $host_id=$cm_jobs_hosts{$host_id}{$job_id}[1];
			my $job_name=$cm_jobs_hosts{$host_id}{$job_id}[2];
			$job_name=~s/_/-/g;
			my $job_group_id=$cm_jobs_hosts{$host_id}{$job_id}[3];
			my $job_descr=$cm_jobs_hosts{$host_id}{$job_id}[4];
			my $device_type_group_id=$cm_jobs_hosts{$host_id}{$job_id}[5];
			my $device_type_group_name=$values_device_type_groups{$device_type_group_id}[0];
			$device_type_group_name=~s/_/-/g;

			if ( $select_box_order eq "hostname" ) {
				print "<option value=\"${host_id}_${job_id}_${device_type_group_id}_${job_name}\">$hostname ($ip) - $device_type_group_name/$job_name</option>\n";
			} else {
				print "<option value=\"${host_id}_${job_id}_${device_type_group_id}_${job_name}\">$ip ($hostname) - $device_type_group_name/$job_name</option>\n";
			}
		}
	}
	print "</select>\n";
}

print "</td></tr><tr><td colspan=\"2\">\n";
if ( $device_without_job == 0 ) {
	print "<input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><p><input type=\"submit\" value=\"$$lang_vars{submit_message}\" name=\"B2\" class=\"input_link_w_net\"></form>";


if ( ! $mass_update_host_ids ) {
	print "<form name=\"ip_cm_diff_devices_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff_devices_form.cgi\" style=\"display:inline; float:right\">\n";
	print "<input type=\"hidden\" value=\"$select_box_order_form\" name=\"select_box_order\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{order_checkbox_by_message} $order_checkbox_by_form_message\" name=\"B2\" class=\"input_link_w_net\">\n";
	print "</form>\n";
}
}
print "</td></tr>\n";
print "</table>\n";

if ( $device_without_job == 1 ) {
	print "<p><br><p><FORM><INPUT TYPE=\"BUTTON\" VALUE=\"$$lang_vars{atras_message}\" ONCLICK=\"history.go(-1)\" class=\"error_back_link\"></FORM>\n";
}

print "<br><p>\n";

$gip->print_end("$client_id");
