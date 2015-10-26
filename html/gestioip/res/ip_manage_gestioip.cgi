#!/usr/bin/perl -T -w

# Copyright (C) 2011 Marc Uebel

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.


use strict;
use lib '../modules';
use GestioIP;
use File::Path qw(make_path);
use File::Copy;

my $daten=<STDIN>;
my $gip = GestioIP -> new();
my %daten=$gip->preparer($daten);

my $base_uri = $gip->get_base_uri();
my $server_proto=$gip->get_server_proto();

my $lang = $daten{'lang'} || "";
my ($lang_vars,$vars_file)=$gip->get_lang("","$lang");
my $client_id = $daten{'client_id'} || $gip->get_first_client_id();


# check Permissions
my @global_config = $gip->get_global_config("$client_id");
my $user_management_enabled_db=$global_config[0]->[13];
if ( $user_management_enabled_db eq "yes" ) {
	my $required_perms="manage_gestioip_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


my $management_type=$daten{manage_type} || "";
my $ignore_networks_audit=$daten{ignore_networks_audit} || "yes";

my $ipv4_only_db=$global_config[0]->[5] || "";
my $ipv4_only=$daten{'ipv4_only'} || "$ipv4_only_db";
my $user_management_enabled=$daten{'user_management_enabled'} || $user_management_enabled_db;
my $as_enabled_db=$global_config[0]->[6] || "";
my $as_enabled=$daten{'as_enabled'} || "$as_enabled_db";
my $ll_enabled_db=$global_config[0]->[7] || "";
my $ll_enabled=$daten{'ll_enabled'} || "$ll_enabled_db";
## CONFIGURATION MANAGEMENT
my $cm_dir_exists=0;
my $cm_dir = "./cm";
if ( -e $cm_dir ) {
	$cm_dir_exists=1;
}
my $cm_enabled_db=$global_config[0]->[8] || "";
my $cm_enabled=$daten{'cm_enabled'} || "$cm_enabled_db";
my $cm_backup_dir_db=$global_config[0]->[9];
my $cm_backup_dir=$daten{'cm_backup_dir'} || "$cm_backup_dir_db";
my $cm_licence_key_db=$global_config[0]->[10] || "";
my $cm_licence_key=$daten{'cm_licence_key'} || "$cm_licence_key_db";
my $cm_log_dir_db=$global_config[0]->[11];
my $cm_log_dir=$daten{'cm_log_dir'} || "$cm_log_dir_db";
my $cm_xml_dir_db=$global_config[0]->[12];
my $cm_xml_dir=$daten{'cm_xml_dir'} || "$cm_xml_dir_db";


# cookie must be set before calling CheckInput
if ( $ipv4_only eq "yes" && $ipv4_only ne $ipv4_only_db ) {
	$gip->set_ip_version_ele("v4");
}

my $which_clients;
$which_clients = $daten{which_clients} || "9999";
if ( $which_clients !~ /^\d{1,4}/ ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}: $$lang_vars{manage_manage_message} ","$vars_file");
	$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)");
}

my $client_name=$gip->get_client_from_id("$client_id");

if ( $management_type eq "clear_audit_auto" ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}: $$lang_vars{auto_audit_deleted_message} ","$vars_file");
} elsif ( $management_type eq "clear_audit_man" ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}: $$lang_vars{man_audit_deleted_message}","$vars_file");
} elsif ( $management_type eq "edit_config" || $management_type eq "edit_global_config" ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}: $$lang_vars{parameter_changed_message}","$vars_file");
} elsif ( $management_type eq "reset_database" ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}: $$lang_vars{database_reseted_message} ($$lang_vars{client_message} <i>$client_name</i>)","$vars_file");
} else {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{manage_manage_message}","$vars_file");
}

my $reset_database_ipv4=$daten{reset_database_ipv4} || "";
my $reset_database_ipv6=$daten{reset_database_ipv6} || "";


print <<EOF;
<script type="text/javascript">
<!--
function confirmation(MESSAGE) {
//        var answer = confirm("$$lang_vars{client_message} ${client_name}: $$lang_vars{database_reset_confirmation_message}")
        var answer = confirm("$$lang_vars{client_message} ${client_name}: " +  MESSAGE)
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
function show_cm_dir_text_field(value){
  if( value == "yes" ) {
    config_form.cm_licence_key.disabled=false;
    config_form.cm_backup_dir.disabled=false;
    config_form.cm_log_dir.disabled=false;
    config_form.cm_xml_dir.disabled=false;
   }else{
    config_form.cm_licence_key.disabled=true;
    config_form.cm_backup_dir.disabled=true;
    config_form.cm_log_dir.disabled=true;
    config_form.cm_xml_dir.disabled=true;
   }
}
//-->
</script>

EOF



my @config = $gip->get_config("$client_id");
my @clients = $gip->get_clients();
my @client_entries=$gip->get_client_entries("$client_id");


my $default_resolver_db;
if ( ! $client_entries[0] ) {
	$default_resolver_db="yes";
} else {
	$default_resolver_db=$client_entries[0]->[20] || "";
}
my $default_resolver;
if ( $daten{default_resolver} ) {
	$default_resolver=$daten{default_resolver};
	if ( $default_resolver eq "no" && ! $daten{'dns1'} && ! $daten{'dns2'} && ! $daten{'dns3'} ) {
		$gip->print_error("$client_id","$$lang_vars{no_dns_server_message}");
	}
} else {
	$default_resolver=$default_resolver_db;
}
if ( $default_resolver !~ /(yes|no)/ ) {
	$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (2)");
}

my $size_db = $gip->get_size_db("$client_id") || " N/A";
my $size_table_audit = $gip->get_size_table_audit("$client_id") || " N/A";
my $size_table_audit_auto = $gip->get_size_table_audit_auto("$client_id") || "N/A";
$size_db.="MB" if $size_db !~ /N\/A/;
$size_table_audit.="MB" if $size_table_audit !~ /N\/A/;
$size_table_audit_auto.="MB" if $size_table_audit_auto !~ /N\/A/;

my $smallest_bm_db = $config[0]->[0] || "22";
#my $smallest_bm6_db = $config[0]->[7] || "116";
my $max_procs_db = $config[0]->[1] || "254";
my $ignorar_db = $config[0]->[2] || "";
my $ignore_generic_auto_db = $config[0]->[3] || "yes";
my $generic_dyn_host_name_db = $config[0]->[4] || "";
my $dyn_ranges_only_db = $config[0]->[5] || "n";
my $ping_timeout_db = $config[0]->[6] || "2";
#my $confirmation_db = $config[0]->[7] || "no";
my $confirmation_db = $gip->get_config_confirmation("$client_id") || "yes";
my $default_client_id_db=$gip->get_default_client_id("$client_id") || "";
my $mib_dir_db=$global_config[0]->[3] || "";
my $vendor_mib_dirs_db=$global_config[0]->[4] || "";
my $ocs_enabled_db=$config[0]->[8] || "no";
my $ocs_database_user_db=$config[0]->[9] || "";
my $ocs_database_name_db=$config[0]->[10] || "";
my $ocs_database_pass_db=$config[0]->[11] || "";
my $ocs_database_ip_db=$config[0]->[12] || "";
my $ocs_database_port_db=$config[0]->[13] || "";

my $dns1_db="";
my $dns2_db="";
my $dns3_db="";
if ( $client_entries[0] ) {
	$dns1_db=$client_entries[0]->[21] || "";
	$dns2_db=$client_entries[0]->[22] || "";
	$dns3_db=$client_entries[0]->[23] || "";
}


my $smallest_bm=$daten{smallest_bm} || "$smallest_bm_db";
#my $smallest_bm6=$daten{smallest_bm6} || "$smallest_bm_db";
my $max_procs=$daten{max_procs} || "$max_procs_db";
my $ignorar=$daten{ignorar} || "";
my $ignore_generic_auto=$daten{ignore_generic_auto} || "$ignore_generic_auto_db";
my $generic_dyn_host_name=$daten{generic_dyn_host_name} || "";
my $dyn_ranges_only=$daten{dyn_ranges_only} || "n";
my $ping_timeout=$daten{ping_timeout} || "2";
my $confirmation=$daten{confirmation} || "$confirmation_db";
my $default_client_id = $daten{'default_client_id'} || "$default_client_id_db";
my $ocs_enabled=$daten{ocs_enabled} || "$ocs_enabled_db";
my $ocs_database_user=$daten{ocs_database_user} || "$ocs_database_user_db";
my $ocs_database_name=$daten{ocs_database_name} || "$ocs_database_name_db";
my $ocs_database_pass=$daten{ocs_database_pass} || "$ocs_database_pass_db";
my $ocs_database_ip=$daten{ocs_database_ip} || "$ocs_database_ip_db";
my $ocs_database_port=$daten{ocs_database_port} || "$ocs_database_port_db";
my $mib_dir=$daten{'mib_dir'} || "$mib_dir_db";
if ( $mib_dir ) {
	$gip->print_error("$client_id","$$lang_vars{mib_dir_slash_message}") if $mib_dir !~ /^\//;
}

my $vendor_mib_dirs=$daten{'vendor_mib_dirs'} || $vendor_mib_dirs_db;
$vendor_mib_dirs =~ s/\s+//g;
$vendor_mib_dirs =~ s/\t+//g;

$mib_dir =~ s/^\s*//;
$mib_dir =~ s/[\t\s]$//;
my $mibdir_warning="";
my $vendor_mibdir_warning="";
if ( ! -e $mib_dir ) {
	$mibdir_warning="<tr><td colspan=\"2\"><span style=\"color:red;\">$$lang_vars{aviso_message}: $$lang_vars{mib_dir_no_exist_message}</span></td></tr>\n";
} else {
	my @vendor_mib_dirs = split(",",$vendor_mib_dirs);
	foreach ( @vendor_mib_dirs ) {
		my $mib_vendor_dir = $mib_dir . "/" . $_;
		if ( ! -e $mib_vendor_dir ) {
			$vendor_mibdir_warning="<tr><td colspan=\"2\"><span style=\"color:red;\">$$lang_vars{aviso_message}: $$lang_vars{mib_dir_no_exist_message}: $mib_vendor_dir</span></td></tr>\n";
			last;
		} elsif ( ! -r $mib_vendor_dir ) {
			$vendor_mibdir_warning="<tr><td colspan=\"2\"><span style=\"color:red;\">$$lang_vars{aviso_message}: $$lang_vars{mib_dir_not_readable}: $mib_vendor_dir</span></td></tr>\n";
		}
	}
}


my ($dns1,$dns2,$dns3);
if ( $ENV{'SCRIPT_NAME'} =~ /manage_gestioip.cgi/ ) {
	$dns1 = $daten{'dns1'} || "";
	$dns2 = $daten{'dns2'} || "";
	$dns3 = $daten{'dns3'} || "";
	$gip->print_error("$client_id","$$lang_vars{insert_ip_dns_server_message}") if ( $dns1 && $dns1 !~ /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/ ) || ( $dns2 && $dns2 !~ /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/ ) || ( $dns3 && $dns3 !~ /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/ );
} else {
	$dns1 = $dns1_db || "";
	$dns2 = $dns2_db || "";
	$dns3 = $dns3_db || "";
}

if ( $default_resolver eq "no" && $ENV{'SCRIPT_NAME'} !~ /manage_gestioip.cgi/ ) {
	if ( ! $dns1 && ! $dns2 && ! $dns3 ) {
		$gip->print_error("$client_id","$$lang_vars{no_dns_server_message}");
	}
}

my $event="";
my $event_new="";
my $hay_cambio="0";
my $hay_default_client_cambio="0";
my $hay_confirmation_cambio="0";
my $hay_mib_dir_cambio="0";
my $hay_vendor_mib_dirs_cambio="0";
my $hay_ipv4_only_cambio="0";
my $hay_user_management_enabled_cambio="0";
my $hay_as_enabled_cambio="0";
my $hay_ll_enabled_cambio="0";
my $hay_cm_enabled_cambio="0";
my $hay_cm_backup_dir_cambio="0";
my $hay_cm_licence_key_cambio="0";
my $hay_cm_log_dir_cambio="0";
my $hay_cm_xml_dir_cambio="0";
my $hay_dns_cambio="0";
my $smallest_bm_show=$smallest_bm_db;
#my $smallest_bm6_show=$smallest_bm6_db;
my $smallest_bm6_show=64;
my $max_procs_show=$max_procs_db;
my $ignorar_show=$ignorar_db;
my $ignore_generic_auto_show=$ignore_generic_auto_db;
my $generic_dyn_host_name_show=$generic_dyn_host_name_db;
my $dyn_ranges_only_show=$dyn_ranges_only;
my $ping_timeout_show=$ping_timeout;
my $confirmation_show=$confirmation;
my $default_client_id_show=$default_client_id_db;
my $default_resolver_show=$default_resolver_db;
my $mib_dir_show=$mib_dir_db;
my $vendor_mib_dirs_show=$vendor_mib_dirs_db;
my $ipv4_only_show=$ipv4_only_db;
my $user_management_enabled_show=$user_management_enabled_db;
my $as_enabled_show=$as_enabled_db;
my $ll_enabled_show=$ll_enabled_db;
my $cm_enabled_show=$cm_enabled_db;
my $cm_backup_dir_show=$cm_backup_dir_db;
my $cm_licence_key_show=$cm_licence_key_db;
my $cm_log_dir_show=$cm_log_dir_db;
my $cm_xml_dir_show=$cm_xml_dir_db;
my $cm_licence_key_note="";
my $dns1_show=$dns1_db;
my $dns2_show=$dns2_db;
my $dns3_show=$dns3_db;
my $ocs_enabled_show=$ocs_enabled_db;
my $ocs_database_user_show=$ocs_database_user_db;
my $ocs_database_name_show=$ocs_database_name_db;
my $ocs_database_pass_show=$ocs_database_pass_db;
my $ocs_database_ip_show=$ocs_database_ip_db;
my $ocs_database_port_show=$ocs_database_port_db;

if ( $management_type eq "edit_config" ) {

	if ( $smallest_bm ne $smallest_bm_db ) {
		$event_new = "smallest BM: $smallest_bm_db -> $smallest_bm";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$smallest_bm_show=$smallest_bm;
	}
#	if ( $smallest_bm6 ne $smallest_bm6_db ) {
#		$event_new = "smallest BM6: $smallest_bm6_db -> $smallest_bm6";
#		$event = $event . ", " . $event_new if $event_new;
#		$event_new = "";
#		$hay_cambio="1";
#		$smallest_bm6_show=$smallest_bm6;
#	}
	if ( $max_procs ne $max_procs_db ) {
		$event_new = "max procs: $max_procs_db -> $max_procs";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$max_procs_show=$max_procs;
	}
	if ( $ignorar ne $ignorar_db ) {
		$event_new="ignore: $ignorar_db -> $ignorar";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ignorar_show=$ignorar;
	}
	if ( $ignore_generic_auto_db ne $ignore_generic_auto ) {
		$event_new="ignorie generic auto: $ignore_generic_auto_db -> $ignore_generic_auto";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ignore_generic_auto_show=$ignore_generic_auto;
	}
	if ( $generic_dyn_host_name_db ne $generic_dyn_host_name ) {
		$event_new="generic dyn name: $generic_dyn_host_name_db -> $generic_dyn_host_name";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$generic_dyn_host_name_show=$generic_dyn_host_name;
	}
	if ( $dyn_ranges_only_db ne $dyn_ranges_only ) {
		$event_new="dyn_ranges only: $dyn_ranges_only_db -> $dyn_ranges_only";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$dyn_ranges_only_show=$dyn_ranges_only;
	}
	if ( $ping_timeout_db ne $ping_timeout ) {
		$event_new="ping timeout: $ping_timeout_db -> $ping_timeout";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ping_timeout_show=$ping_timeout;
	}
	if ( $default_resolver_db ne $default_resolver ) {
		$event_new="$$lang_vars{use_default_resolver_message}: $default_resolver_db -> $default_resolver";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$hay_dns_cambio="1";
		$default_resolver_show=$default_resolver;
	}
	if ( $dns1_db ne $dns1 ) {
		$event_new="DNS1: $dns1_db -> $dns1" if $default_resolver eq "no";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$hay_dns_cambio="1";
		$dns1_show=$dns1;
	}
	if ( $dns2_db ne $dns2 ) {
		$event_new="DNS2: $dns2_db -> $dns2" if $default_resolver eq "no";;
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$hay_dns_cambio="1";
		$dns2_show=$dns2;
	}
	if ( $dns3_db ne $dns3 ) {
		$event_new="DNS1: $dns3_db -> $dns3" if $default_resolver eq "no";;
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$hay_dns_cambio="1";
		$dns3_show=$dns3;
	}
	if ( $ocs_enabled ne $ocs_enabled_db ) {
		$event_new = "enable OCS: $ocs_enabled_db -> $ocs_enabled";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_enabled_show=$ocs_enabled;
	}
	if ( $ocs_database_user ne $ocs_database_user_db ) {
		$event_new = "OCS user: $ocs_database_user_db -> $ocs_database_user";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_database_user_show=$ocs_database_user;
	}
	if ( $ocs_database_name ne $ocs_database_name_db ) {
		$event_new = "OCS DB name: $ocs_database_name_db -> $ocs_database_name";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_database_name_show=$ocs_database_name;
	}
	if ( $ocs_database_pass ne $ocs_database_pass_db ) {
		$event_new = "OCS DB pass changed";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_database_pass_show=$ocs_database_pass;
	}
	if ( $ocs_database_ip ne $ocs_database_ip_db ) {
		$event_new = "OCS DB IP: $ocs_database_ip_db -> $ocs_database_ip";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_database_ip_show=$ocs_database_ip;
	}
	if ( $ocs_database_port ne $ocs_database_port_db ) {
		$event_new = "OCS DB port: $ocs_database_port_db -> $ocs_database_port";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cambio="1";
		$ocs_database_port_show=$ocs_database_port;
	}

	if ( $hay_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_config("$client_id","$smallest_bm_show","$max_procs_show","$ignorar_show","$ignore_generic_auto_show","$generic_dyn_host_name_show","$dyn_ranges_only_show","$ping_timeout_show","$smallest_bm6_show","$ocs_enabled_show","$ocs_database_user_show","$ocs_database_name_show","$ocs_database_pass_show","$ocs_database_ip","$ocs_database_port_show");
	}
	if ( $hay_dns_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->update_dns_server("$client_id","$default_resolver","$dns1","$dns2","$dns3");
	}

} elsif ( $management_type eq "edit_global_config" ) {
	if ( $default_client_id ne $default_client_id_db ) {
		my $old_default_client_name=$gip->get_client_from_id("$default_client_id_db") || "";
		my $new_default_client_name=$gip->get_client_from_id("$default_client_id");
		$event_new = "default_client: $old_default_client_name -> $new_default_client_name";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_default_client_cambio="1";
		$default_client_id_show=$default_client_id;
	}
	if ( $confirmation ne $confirmation_db ) {
		$event_new = "confirmation: $confirmation_db -> $confirmation";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_confirmation_cambio="1";
		$confirmation_show=$confirmation;
	}
	if ( $mib_dir ne $mib_dir_db ) {
		$event_new = "mib_dir: $mib_dir_db -> $mib_dir";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_mib_dir_cambio="1";
		$mib_dir_show=$mib_dir;
	}
	if ( $vendor_mib_dirs ne $vendor_mib_dirs_db ) {
		$event_new = "vendor_mib_dirs: $vendor_mib_dirs_db -> $vendor_mib_dirs";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_vendor_mib_dirs_cambio="1";
		$vendor_mib_dirs_show=$vendor_mib_dirs;
	}
	if ( $ipv4_only ne $ipv4_only_db ) {
		$event_new = "ipv4_only: $ipv4_only_db -> $ipv4_only";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_ipv4_only_cambio="1";
		$ipv4_only_show=$ipv4_only;
	}
	if ( $user_management_enabled ne $user_management_enabled_db ) {
		$event_new = "user_management_enabled: $user_management_enabled_db -> $user_management_enabled";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_user_management_enabled_cambio="1";
		$user_management_enabled_show=$user_management_enabled;
	}
	if ( $as_enabled ne $as_enabled_db ) {
		$event_new = "as_enabled: $as_enabled_db -> $as_enabled";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_as_enabled_cambio="1";
		$as_enabled_show=$as_enabled;
	}
	if ( $ll_enabled ne $ll_enabled_db ) {
		$event_new = "ll_enabled: $ll_enabled_db -> $ll_enabled";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_ll_enabled_cambio="1";
		$ll_enabled_show=$ll_enabled;
	}
	if ( $cm_enabled ne $cm_enabled_db ) {
		$event_new = "cm_enabled: $cm_enabled_db -> $cm_enabled";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cm_enabled_cambio="1";
		$cm_enabled_show=$cm_enabled;
	}
	if ( $cm_backup_dir ne $cm_backup_dir_db ) {
		$event_new = "cm_backup_dir: $cm_backup_dir_db -> $cm_backup_dir";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cm_backup_dir_cambio="1";
		$cm_backup_dir_show=$cm_backup_dir;
	}
	if ( $cm_licence_key ne $cm_licence_key_db ) {

		$event_new = "cm_licence_key: $cm_licence_key_db -> $cm_licence_key";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cm_licence_key_cambio="1";
		$cm_licence_key_show=$cm_licence_key;
	}
	if ( $cm_log_dir ne $cm_log_dir_db ) {
		$event_new = "cm_log_dir: $cm_log_dir_db -> $cm_log_dir";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cm_log_dir_cambio="1";
		$cm_log_dir_show=$cm_log_dir;
	}
	if ( $cm_xml_dir ne $cm_xml_dir_db ) {
		$event_new = "cm_xml_dir: $cm_xml_dir_db -> $cm_xml_dir";
		$event = $event . ", " . $event_new if $event_new;
		$event_new = "";
		$hay_cm_xml_dir_cambio="1";
		$cm_xml_dir_show=$cm_xml_dir;
	}


	if ( $hay_default_client_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->update_default_client("$client_id","$default_client_id");
	}
	if ( $hay_confirmation_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_confirmation_config("$client_id","$confirmation_show");
	}
	if ( $hay_mib_dir_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_mib_dir_config("$client_id","$mib_dir_show");
	}
	if ( $hay_vendor_mib_dirs_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_vendor_mib_dirs_config("$client_id","$vendor_mib_dirs_show");
	}
	if ( $hay_ipv4_only_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_ipv4_only_config("$client_id","$ipv4_only_show");
	}
	if ( $hay_user_management_enabled_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_user_management_enabled_config("$client_id","$user_management_enabled_show");

		if ( $user_management_enabled eq "yes" ) {
			my $user=$ENV{'REMOTE_USER'};
			my %values_users=$gip->get_user_hash("$client_id","$user");
			if ( ! %values_users ) {
				# Create user if not exists
				my $group_id;
				$gip->insert_user("$client_id","$user","1","","","user automatically created");
			} else {
				# Set user's group to default group to make him a GestioIP Admin user
				my $user_id=(keys %values_users)[0];
				my @value=$values_users{$user_id};

				my $phone=$value[0]->[2] || "";
				my $email=$value[0]->[3] || "";
				my $comment=$value[0]->[4] || "";
				$gip->update_user("$client_id","$user_id","$user","1","$phone","$email","$comment");

			}
		}
	}
	if ( $hay_as_enabled_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_as_enabled_config("$client_id","$as_enabled_show");
	}
	if ( $hay_ll_enabled_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_ll_enabled_config("$client_id","$ll_enabled_show");
	}
	if ( $hay_cm_enabled_cambio == "1" ) {

		if ( ! $cm_backup_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_config_dir_message}");
		}

		if ( ! $cm_log_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_cm_log_dir_message}");
		}

		if ( ! $cm_xml_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_cm_xml_dir_message}");
		}

		$event =~ s/^, // if $event;
		$gip->change_cm_enabled_config("$client_id","$cm_enabled_show");


		# create configuration backup directory base dir if not exists
		unless ( -d "$cm_backup_dir" ) {
			make_path("$cm_backup_dir") or $gip->print_error("$client_id","$$lang_vars{can_not_create_backup_dir_message}: $cm_backup_dir: $!");
		}
		unless ( -w "$cm_backup_dir" ) {
			$gip->print_error("$client_id","$$lang_vars{backup_dir_not_writable_message}: $cm_backup_dir: $!");
		}

		# create configuration backup directory for all existing clients if not exists
		my $j=0;
		foreach (@clients) {
			my $client_name=$clients[$j]->[1];
			unless ( -d "$cm_backup_dir/$client_name" ) {
				mkdir "$cm_backup_dir/$client_name" or $gip->print_error("$client_id","$$lang_vars{can_not_create_backup_dir_message}: $cm_backup_dir/$client_name: $!");
			}
			unless ( -w "$cm_backup_dir/$client_name" ) {
				$gip->print_error("$client_id","$$lang_vars{backup_dir_not_writable_message}: $cm_backup_dir/$client_name: $!");
			}
			$j++;
		}

		$gip->change_cm_backup_dir_config("$client_id","$cm_backup_dir_show");
		$gip->change_cm_log_dir_config("$client_id","$cm_log_dir_show");
		$gip->change_cm_xml_dir_config("$client_id","$cm_xml_dir_show");

	}
	if ( $hay_cm_backup_dir_cambio == "1" ) {

		if ( ! $cm_backup_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_config_dir_message}");
		} elsif ( $cm_backup_dir eq "/" ) {
			$gip->print_error("$client_id","$$lang_vars{cm_dir_not_root_message}");
		}

		$event =~ s/^, // if $event;


# check if new dir exists -> check if new dir is empty -> not empty warning ; if empty rename dir ; if not exists create dir > rename old dir to new
		if  ( ! -d $cm_backup_dir_show ) {
			make_path("$cm_backup_dir_show",{error => \my $make_path_err});
			if (@$make_path_err) {
				for my $diag (@$make_path_err) {
					my ($file, $message) = %$diag;
					$gip->print_error("$client_id","$$lang_vars{can_not_create_backup_dir_message}: $cm_backup_dir: $message");
				}
			}
		
			if ( -d $cm_backup_dir_db ) {
				move("$cm_backup_dir_db/*","$cm_backup_dir_show") or $gip->print_error("$client_id","$$lang_vars{can_not_move_backup_directory_content_message}: mv $cm_backup_dir_db/* $cm_backup_dir_show: $!")
			}
		} else {
			if ( -d $cm_backup_dir_db ) {
				move("$cm_backup_dir_db/*","$cm_backup_dir_show/") or $gip->print_error("$client_id","$$lang_vars{can_not_move_backup_directory_content_message}: mv $cm_backup_dir_db/* $cm_backup_dir_show: $!")
			}
		}

		$gip->change_cm_backup_dir_config("$client_id","$cm_backup_dir_show");

	}

	if ( $hay_cm_log_dir_cambio == "1" ) {

		if ( ! $cm_log_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_cm_log_dir_message}");
		}
		if  ( ! -d "$cm_log_dir_show" ) {
			$gip->print_error("$client_id","$$lang_vars{cm_log_dir_not_exists_message}");
		}
		$gip->change_cm_log_dir_config("$client_id","$cm_log_dir_show");
	}

	if ( $hay_cm_xml_dir_cambio == "1" ) {

		if ( ! $cm_xml_dir ) {
			$gip->print_error("$client_id","$$lang_vars{insert_cm_xml_dir_message}");
		}
		if  ( ! -d "$cm_xml_dir_show" ) {
			$gip->print_error("$client_id","$$lang_vars{cm_xml_dir_not_exists_message}");
		}
		$gip->change_cm_xml_dir_config("$client_id","$cm_xml_dir_show");
	}

	if ( $hay_cm_licence_key_cambio == "1" ) {
		$event =~ s/^, // if $event;
		$gip->change_cm_licence_key_config("$client_id","$cm_licence_key_show");
	}
}

my @values_smallest_bm = ("8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
my @values_max_procs = ("32","64","128","254");
my @values_confirmation = ("yes","no");
my @values_ignorar_generic_auto = ("yes","no");
my @values_ocs_enabled = ("yes","no");

my $anz_clients=$gip->count_clients("$client_id");

my $align="align=\"right\"";
my $align1="";
my $ori="left";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

print "<p><br><b style=\"float:$ori;\">$$lang_vars{configuration_message}</b><br>\n";
print "<form name=\"config_form\" id=\"config_form\"  method=\"POST\" action=\"$server_proto://$base_uri/res/ip_manage_gestioip.cgi\">\n";
print "<table border=\"0\" cellpadding=\"7\"><tr>\n";
print "<td $align>$$lang_vars{default_client_message}</td>\n";
my $j=0;
if ( $anz_clients > "1" ) {
	print "<td $align1><select name=\"default_client_id\" size=\"1\">\n";
	print "<option></option>\n" if ! $default_client_id_db;
        foreach (@clients) {
                if ( $clients[$j]->[0] eq "$default_client_id_show") {
                        print "<option value=\"$clients[$j]->[0]\" selected>$clients[$j]->[1]</option>";
                        $j++;
                        next;
                }
                print "<option value=\"$clients[$j]->[0]\">$clients[$j]->[1]</option>";
                $j++;
        }
        print "</select>\n";
} else {
	my $default_client_show=$gip->get_client_from_id("$default_client_id_show") || "";
	print "<td $align1><b><i>$default_client_show</i></b>\n";
}

print "</td></tr>\n";
print "<tr><td $align>$$lang_vars{ip_v4_only_message}</td><td $align1><select name=\"ipv4_only\" size=\"1\">\n";
foreach (@values_confirmation) {
	if ( $_ eq $ipv4_only ) { 
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select></td></tr>\n";

print "</td></tr>\n";
print "<tr><td $align>$$lang_vars{user_management_message}</td><td $align1><select name=\"user_management_enabled\" size=\"1\">\n";
foreach (@values_confirmation) {
	if ( $_ eq $user_management_enabled ) { 
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select></td></tr>\n";

print "</td></tr>\n";
print "<tr><td $align>$$lang_vars{as_enabled_message}</td><td $align1><select name=\"as_enabled\" size=\"1\">\n";
foreach (@values_confirmation) {
	if ( $_ eq $as_enabled ) { 
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select></td></tr>\n";

print "</td></tr>\n";
print "<tr><td $align>$$lang_vars{ll_enabled_message}</td><td $align1><select name=\"ll_enabled\" size=\"1\">\n";
foreach (@values_confirmation) {
	if ( $_ eq $ll_enabled ) { 
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select></td></tr>\n";

print "<tr><td $align>$$lang_vars{ask_for_confirmation_message}</td><td $align1><select name=\"confirmation\" size=\"1\">\n";
foreach (@values_confirmation) {
	if ( $_ eq $confirmation ) { 
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select></td></tr>\n";

print $mibdir_warning if $mibdir_warning;
print "<tr><td $align>$$lang_vars{mib_dir_message}</td><td $align1><input type=\"text\" name=\"mib_dir\" size=\"25\" value=\"$mib_dir_show\" maxlength=\"100\"></td></tr>\n";

print $vendor_mibdir_warning if $vendor_mibdir_warning;
print "<tr><td $align>$$lang_vars{vendor_mib_dirs_message}</td><td $align1><textarea name=\"vendor_mib_dirs\" cols=\"30\" rows=\"5\" wrap=\"physical\" maxlength=\"500\">$vendor_mib_dirs</textarea> (<i>$$lang_vars{coma_separated_list}</i>)</td></tr>\n";

if ( $cm_dir_exists == 1 ) {

	print "</td></tr>\n";
	print "<tr><td><br></td></tr>\n";
	print "<tr><td $align>$$lang_vars{cm_enabled_message}</td><td $align1><select name=\"cm_enabled\" size=\"1\" onchange=\"show_cm_dir_text_field(this.value);\">\n";
	foreach (@values_confirmation) {
		if ( $_ eq $cm_enabled ) { 
			print "<option selected>$_</option>";
			next;
		}
		print "<option>$_</option>";
	}
	print "</select></td></tr>\n";
	my $server_name=$gip->get_cm_licence_server_name("$client_id","$vars_file");
	if ( $cm_enabled eq "yes" ) {

		my $cm_disabled_message="";
		my ($return_code,$cm_licence_key_message,$device_count)=$gip->check_cm_licence("$client_id","$vars_file","$cm_licence_key","$server_name");
		$device_count=$$lang_vars{unlimited_message} if $device_count == 99999;

		my $device_count_message="";
		$device_count_message="$device_count $$lang_vars{devices_message}, " if $device_count;

		## CM licences invalid or expired
		if ( $return_code == 1 ) {
			# licence invalid
			$cm_licence_key_note="<font color=\"red\"><i>" . $cm_licence_key_message . "</i></font>";
			$cm_disabled_message="<tr><td colspan=\"2\"><font color=\"red\"><b>$$lang_vars{cm_disabled_message}</b></font></td></tr>\n";
		} elsif ( $return_code == 2 ) {
			# licence expire warn
			$cm_licence_key_note="<font color=\"orange\"><i>" . $cm_licence_key_message . "</i></font>";
		} elsif ( $return_code == 0 ) {
			# licence valid
			$cm_licence_key_note="<font color=\"green\"><i>" . $cm_licence_key_message . "</i></font>";
		} elsif ( $return_code == 3 ) {
			# licence expired
			$cm_licence_key_note="<font color=\"red\"><i>" . $cm_licence_key_message . "</i></font>";
			$cm_disabled_message="<tr><td colspan=\"2\"><font color=\"red\"><b>$$lang_vars{cm_disabled_message}</b></font></td></tr>\n";
		} elsif ( $return_code == 4 ) {
			# no licence key found
			$cm_licence_key_note="<font color=\"red\"><i>" . $cm_licence_key_message . "</i></font>";
			$cm_disabled_message="<tr><td colspan=\"2\"><font color=\"red\"><b>$$lang_vars{cm_disabled_message}</b></font></td></tr>\n";
		}

		print "$cm_disabled_message\n";

		print "<tr><td $align>$$lang_vars{licence_key_message}<br>\"$server_name\"</td><td $align1><input type=\"text\" name=\"cm_licence_key\" id=\"cm_licence_key\" size=\"40\" value=\"$cm_licence_key\" maxlength=\"100\"> $device_count_message $cm_licence_key_note</td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_backup_dir_message}</td><td $align1><input type=\"text\" name=\"cm_backup_dir\" id=\"cm_backup_dir\" size=\"25\" value=\"$cm_backup_dir\" maxlength=\"100\"></td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_log_dir_message}</td><td $align1><input type=\"text\" name=\"cm_log_dir\" id=\"cm_log_dir\" size=\"25\" value=\"$cm_log_dir\" maxlength=\"100\"></td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_xml_dir_message}</td><td $align1><input type=\"text\" name=\"cm_xml_dir\" id=\"cm_xml_dir\" size=\"25\" value=\"$cm_xml_dir\" maxlength=\"100\"></td></tr>\n";


		# Activate custom host column CM if no activated
		my $cm_id=$gip->get_custom_host_column_ids_from_name("$client_id","CM") || "";
		if ( ! $cm_id ) {
			my $last_custom_host_column_id=$gip->get_last_custom_host_column_id();
			$last_custom_host_column_id++;
			my $cm_id_predef=$gip->get_predef_host_column_id("$client_id","CM");
			my $insert_ok=$gip->insert_custom_host_column("9999","$last_custom_host_column_id","CM","$cm_id_predef");

			my $audit_type="42";
			my $audit_class="5";
			my $update_type_audit="1";
			my $event="CM";
			$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");
		}


	} else {

		print "<tr><td $align>$$lang_vars{licence_key_message}<br>\"$server_name\"</td><td $align1><input type=\"text\" name=\"cm_licence_key\" id=\"cm_licence_key\" size=\"40\" value=\"$cm_licence_key\" maxlength=\"100\" disabled></td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_backup_dir_message}</td><td $align1><input type=\"text\" name=\"cm_backup_dir\" id=\"cm_backup_dir\" size=\"25\" value=\"$cm_backup_dir\" maxlength=\"100\" disabled></td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_log_dir_message}</td><td $align1><input type=\"text\" name=\"cm_log_dir\" id=\"cm_log_dir\" size=\"25\" value=\"$cm_log_dir\" maxlength=\"100\" disabled></td></tr>\n";

		print "<tr><td $align>$$lang_vars{configuration_xml_dir_message}</td><td $align1><input type=\"text\" name=\"cm_xml_dir\" id=\"cm_xml_dir\" size=\"25\" value=\"$cm_xml_dir\" maxlength=\"100\" disabled></td></tr>\n";
	}
	print "<tr><td><br></td></tr>\n";
} else {
	print "<tr><td colspan=\"2\"><p><br>$$lang_vars{no_cm_module_message}<br></td></tr>\n";
}

print "<tr><td><br><input name=\"manage_type\" type=\"hidden\" value=\"edit_global_config\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input type=\"submit\" value=\"$$lang_vars{set_message}\" name=\"B1\"></td></tr>\n";


print "</table>\n";
print "</form>\n";
print "<p><br><hr><br><p>\n";




print "<b style=\"float: $ori\">$$lang_vars{client_configuration_message} <span class=\"client_name_head_text\">$client_name</span></b><br>\n";
print "<form name=\"client_specific_config\"  method=\"POST\" action=\"$server_proto://$base_uri/res/ip_manage_gestioip.cgi\">\n";
print "<table border=\"0\" cellpadding=\"7\">\n";
print "<tr><td $align>$$lang_vars{smalles_bm_manage_message}</td><td $align1><select name=\"smallest_bm\" size=\"1\">\n";
foreach (@values_smallest_bm) {
	if ( $_ eq $smallest_bm_show ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select>\n";
print "</td></tr>\n";

#if ( $ipv4_only_show eq "no" ) {
#	print "<tr><td $align>$$lang_vars{smalles_bm6_manage_message}</td><td $align1><select name=\"smallest_bm6\" size=\"1\">\n";
#	for ( my $i=1; $i <= 128; $i++ ) {
#	if ( $i eq $smallest_bm6_show ) {
#		print "<option selected>$i</option>";
#		next;
#	}
#	print "<option>$i</option>";
#	}
#	print "</select>\n";
#	print "</td></tr>\n";
#}


print "<tr><td $align>$$lang_vars{ping_timeout_message}</td><td $align1><select name=\"ping_timeout\" size=\"1\">\n";
for (my $i = 1; $i < 11; $i++) {
        if ( $i eq $ping_timeout_show ) {
                print "<option selected>$i</option>";
                next;
        }
        print "<option>$i</option>";
}
print "</select>s\n";


print " $$lang_vars{ping_patch_message} <font color=\"white\">x</font></td></tr>\n";
print "</td></tr>\n";

print "</table>\n";
print "<p><br>\n";

print "<i style=\"float: $ori\">$$lang_vars{dns_server_message}</i><br>\n";
print "<table border=\"0\" cellpadding=\"7\">\n";
	if ( $default_resolver eq "yes" ) {
		print "<tr><td $align>$$lang_vars{default_resolver_message}</td><td $align1><input type=\"radio\" name=\"default_resolver\" value=\"yes\" onclick=\"dns1.disabled=true;dns2.disabled=true;dns3.disabled=true;\" checked></td></tr>";
		print "<tr><td $align>$$lang_vars{specify_dns_server_message}</td><td $align1><input type=\"radio\" name=\"default_resolver\" value=\"no\" onclick=\"dns1.disabled=false;dns2.disabled=false;dns3.disabled=false;\"></td></tr>";
	print "<tr><td $align>$$lang_vars{server_1_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns1\" value=\"$dns1_show\" maxlength=\"75\" disabled></td></tr>\n";
	print "<tr><td $align>$$lang_vars{server_2_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns2\" value=\"$dns2_show\" maxlength=\"75\" disabled></td></tr>\n";
	print "<tr><td $align>$$lang_vars{server_3_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns3\" value=\"$dns3_show\" maxlength=\"75\" disabled></td></tr>\n";
	} else {
		print "<tr><td $align>$$lang_vars{default_resolver_message}</td><td $align1><input type=\"radio\" name=\"default_resolver\" value=\"yes\" onclick=\"dns1.disabled=true;dns2.disabled=true;dns3.disabled=true;\"></td></tr>";
		print "<tr><td $align>$$lang_vars{specify_dns_server_message}</td><td $align1><input type=\"radio\" name=\"default_resolver\" value=\"no\" onclick=\"dns1.disabled=false;dns2.disabled=false;dns3.disabled=false;\" checked></td></tr>";
	print "<tr><td $align>$$lang_vars{server_1_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns1\" value=\"$dns1_show\" maxlength=\"75\"></td></tr>\n";
	print "<tr><td $align>$$lang_vars{server_2_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns2\" value=\"$dns2_show\" maxlength=\"75\"></td></tr>\n";
	print "<tr><td $align>$$lang_vars{server_3_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"dns3\" value=\"$dns3_show\" maxlength=\"75\"></td></tr>\n";
	}
print "</table>\n";
print "<p><br>\n";

print "<i style=\"float: $ori\">$$lang_vars{update_manage_message}</i><br>\n";

print "<table border=\"0\" cellpadding=\"7\">\n";
print "<tr><td $align>$$lang_vars{ignorar_manage_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"ignorar\" value=\"$ignorar_show\" maxlength=\"75\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{ignorar_generic_auto_manage_message}</td><td $align1><select name=\"ignore_generic_auto\" size=\"1\">\n";
foreach (@values_ignorar_generic_auto) {
	if ( $_ eq $ignore_generic_auto_show ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}

print "</select>\n";
print "</td></tr>\n";
print "<tr><td $align>$$lang_vars{generic_dyn_manage_message}</td><td $align1><input type=\"text\" size=\"25\" name=\"generic_dyn_host_name\" value=\"$generic_dyn_host_name_show\" maxlength=\"75\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{max_sinc_procs_manage_message}</td><td $align1><select name=\"max_procs\" size=\"1\">\n";
foreach (@values_max_procs) {
	if ( $_ eq $max_procs_show ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select>\n";
print "</td></tr>\n";
if ( $dyn_ranges_only eq "n" ) {
	print "<tr><td $align>$$lang_vars{dyn_ranges_only_message}</td><td $align1><input type=\"checkbox\" name=\"dyn_ranges_only\" value=\"y\"></td></tr>";
} else {
	print "<tr><td $align>$$lang_vars{dyn_ranges_only_message}</td><td $align1><input type=\"checkbox\" name=\"dyn_ranges_only\" value=\"y\" checked></td></tr>";
}
print "</table>\n";
print "<p><br>\n";

print "<i style=\"float: $ori\">$$lang_vars{ocs_message}</i><br>\n";

print "<table border=\"0\" cellpadding=\"7\">\n";
print "<tr><td $align>$$lang_vars{ocs_enabled_support_message}</td><td $align1><select name=\"ocs_enabled\" size=\"1\">\n";
foreach (@values_ocs_enabled) {
	if ( $_ eq $ocs_enabled_show ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}

if ( $ocs_enabled_show eq "yes" ) {
print <<EOF;
	<tr><td align="right">$$lang_vars{ocs_database_name_message}</td><td $align1><input type="text" name="ocs_database_name" size="25" value="$ocs_database_name_show" maxlength="100"></td></tr>
	<tr><td align="right">$$lang_vars{ocs_database_user_message}</td><td $align1><input type="text" name="ocs_database_user" size="25" value="$ocs_database_user_show" maxlength="100"></td></tr>
	<tr><td align="right">$$lang_vars{ocs_database_pass_message}</td><td $align1><input type="password" name="ocs_database_pass" size="25" value="$ocs_database_pass_show" maxlength="100"></td></tr>
	<tr><td align="right">$$lang_vars{ocs_database_ip_message}</td><td $align1><input type="text" name="ocs_database_ip" size="25" value="$ocs_database_ip_show" maxlength="100"></td></tr>
	<tr><td align="right">$$lang_vars{ocs_database_port_message}</td><td $align1><input type="text" name="ocs_database_port" size="5" value="$ocs_database_port_show" maxlength="7"></td></tr>
EOF
}


print "<tr><td><br><input name=\"manage_type\" type=\"hidden\" value=\"edit_config\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input type=\"submit\" value=\"$$lang_vars{set_message}\" name=\"B1\"></td></tr>\n";
print "</table>\n";
print "</form>\n";

if ( $hay_cambio == "1" || $hay_default_client_cambio == "1" || $hay_confirmation_cambio == "1" || $hay_mib_dir_cambio == "1" || $hay_vendor_mib_dirs_cambio == "1" || $hay_ipv4_only_cambio == "1" || $hay_as_enabled_cambio == "1" || $hay_ll_enabled_cambio == "1" || $hay_cm_enabled_cambio == "1" ) {
	my $audit_type="25";
	my $audit_class="6";
	my $update_type_audit="1";
	$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");
}

$j=0;

print "<p><br><hr><br><p>\n";
#print "<br><p>\n";


if ( $management_type eq "clear_audit_auto" || $management_type eq "clear_audit_man" ) {

	$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (3)") if $daten{which_clients_audit_delete} !~ /^(actual_client|all_clients)$/;
	my $which_clients_audit_delete=$daten{which_clients_audit_delete};

	my ($range_sec, $time_range, $time_range_start, $time_range_delete);
	if ( $management_type eq "clear_audit_auto" ) {
		$time_range =  $daten{clear_audit_auto};
	} elsif ( $management_type eq "clear_audit_man" ) {
		$time_range =  $daten{clear_audit_man};
	}
	if ( $time_range eq "1 hour" ) {
		$range_sec="3600";
	} elsif ( $time_range eq "6 hours" ) {
		$range_sec="21600";
	} elsif ( $time_range eq "1 day" ) {
		$range_sec="86400";
	} elsif ( $time_range eq "3 days" ) {
		$range_sec="259200";
	} elsif ( $time_range eq "7 days" ) {
		$range_sec="604800";
	} elsif ( $time_range eq "2 weeks" ) {
		$range_sec="1209600";
	} elsif ( $time_range eq "4 weeks" ) {
		$range_sec="2419200";
	} elsif ( $time_range eq "3 month" ) {
		$range_sec="7257600";
	} elsif ( $time_range eq "6 month" ) {
		$range_sec="14515200";
	} elsif ( $time_range eq "1 year" ) {
		$range_sec="29030400";
	} elsif ( $time_range eq "2 years" ) {
		$range_sec=58060800;
	} elsif ( $time_range eq "3 years" ) {
		$range_sec=87091200;
	} elsif ( $time_range eq "4 years" ) {
		$range_sec=116121600;
	} elsif ( $time_range eq "5 years" ) {
		$range_sec=145152000;
	}

	my $datetime = time();
	$time_range_start = $datetime - $range_sec;
	if ( $management_type eq "clear_audit_auto" ) {
		if ( $ignore_networks_audit eq "yes" ) {
			$gip->delete_audit_auto("$client_id","$time_range_start","$which_clients_audit_delete");
		} else {
			$gip->delete_audit_auto_without_networks("$client_id","$time_range_start","$which_clients_audit_delete");
		}
		my $audit_type="26";
		my $audit_class="3";
		my $update_type_audit="1";
		$event = "$$lang_vars{entries_older_than} $time_range $$lang_vars{borrado_message}";
		$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");
	} elsif ( $management_type eq "clear_audit_man" ) {
		$gip->delete_audit_man("$client_id","$time_range_start","$which_clients_audit_delete");
		my $audit_type="27";
		my $audit_class="3";
		my $update_type_audit="1";
		$event = "$$lang_vars{entries_older_than} $time_range $$lang_vars{borrado_message}";
		$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");
	}
} elsif ( $management_type eq "reset_database" ) {
	my $switch_string="";
	my @vlan_switches = $gip->get_vlan_switches_all("$client_id");
	foreach my $switch_entry(@vlan_switches) {
		$switch_string .= $switch_entry->[1] . "," if $switch_entry->[1];		
	}
	my @switch_strings=split(",",$switch_string);

	# delete duplicated entries
	my %seen = ();
	my $item;
	my @uniq;
	foreach $item(@switch_strings) {
	next if ! $item;
	push(@uniq, $item) unless $seen{$item}++;
	}
	@switch_strings = @uniq;
	

	my $ip_version_reset="";
	if ( $reset_database_ipv4 && $reset_database_ipv6 ) {
		$ip_version_reset="all";
	} elsif ( $reset_database_ipv4 && ! $reset_database_ipv6 ) {
		$ip_version_reset="v4";
	} elsif ( ! $reset_database_ipv4 && $reset_database_ipv6 ) {
		$ip_version_reset="v6";
	}
	$gip->reset_database_client("$client_id","$ip_version_reset");

	@switch_strings = $gip->check_vlan_switch_exists("$client_id",\@switch_strings);
	my @switches_new=();

	foreach $item(@switch_strings) {

		my @switches = $gip->get_vlan_switches_match("$client_id","$item");
		my $i = 0;
		foreach ( @switches ) {
			my $vlan_id = $_->[0];
			my $switches = $_->[1];
			$switches =~ s/,$item,/,/;
			$switches =~ s/^$item,//;
			$switches =~ s/,$item$//;
			$switches =~ s/^$item$//;
			$switches_new[$i]->[0]=$vlan_id;
			$switches_new[$i]->[1]=$switches;
			$i++;
		}

		foreach ( @switches_new ) {
			my $vlan_id_new = $_->[0];
			my $switches_new = $_->[1];
			$gip->update_vlan_switches("$client_id","$vlan_id_new","$switches_new");
		}

	}

	my $audit_type="47";
	my $audit_class="5";
	my $update_type_audit="1";
	$event = "$$lang_vars{database_reseted_message} $$lang_vars{client_message}: $client_name";
	$gip->insert_audit("$client_id","$audit_class","$audit_type","$event","$update_type_audit","$vars_file");
}


my $anz_man_audit=$gip->get_anz_man_audit("$client_id");
my $anz_auto_audit=$gip->get_anz_auto_audit("$client_id");
my $anz_man_audit_total=$gip->get_anz_man_audit();
my $anz_auto_audit_total=$gip->get_anz_auto_audit();


print "<p><br>\n";
print "<b style=\"float: $ori\">$$lang_vars{manage_audit_message}</b><br>\n";
my @values_time_range = ("1 hour","6 hours","1 day","3 days","7 days","2 weeks","4 weeks","3 month","6 month","1 year","2 years","3 years","4 years","5 years");
my $onclick = "";
if ( $confirmation_db eq "yes" ) {
	my $confirmation_message=$$lang_vars{database_reset_confirmation_message};
	$onclick =  "onclick=\"return confirmation('$confirmation_message');\"";
}

print "<form  method=\"POST\" action=\"$server_proto://$base_uri/res/ip_manage_gestioip.cgi\">\n";
print "<table border=\"0\" cellpadding=\"7\">\n";
print "<tr><td $align>$$lang_vars{clear_audit_auto_message}</td><td $align1><select name=\"clear_audit_auto\" size=\"1\">\n";
foreach (@values_time_range) {
	if ( $_ eq "3 month" ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select> \n";
print "</td><td> ($anz_auto_audit $$lang_vars{actual_anz_audit_auto_message} <i>$client_name</i>)</td></tr>\n";
print "<tr><td $align>$$lang_vars{actual_client_message}<br>$$lang_vars{all_clients_message}</td><td $align1><input name=\"which_clients_audit_delete\" type=\"radio\" value=\"actual_client\" checked><br><input name=\"which_clients_audit_delete\" type=\"radio\" value=\"all_clients\"></td></tr>\n";
print "<tr><td><br><input name=\"manage_type\" type=\"hidden\" value=\"clear_audit_auto\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input type=\"submit\" value=\"$$lang_vars{borrar_message}\" name=\"B1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"ignore_networks_audit\" value=\"yes\" checked> <i>$$lang_vars{keep_network_entries_audit_message}</i></td><td></td><td></td></tr>\n";
print "</form>\n";
print "<tr><td><p><br></td><td></td><td></td></tr>\n";

print "<form  method=\"POST\" action=\"$server_proto://$base_uri/res/ip_manage_gestioip.cgi\">\n";
print "<tr><td $align>$$lang_vars{clear_audit_man_message}</td><td $align1><select name=\"clear_audit_man\" size=\"1\">\n";
foreach (@values_time_range) {
	if ( $_ eq "1 year" ) {
		print "<option selected>$_</option>";
		next;
	}
	print "<option>$_</option>";
}
print "</select>\n";
print "</td><td>($anz_man_audit $$lang_vars{actual_anz_audit_man_message} <i>$client_name</i>)</td></tr>\n";
print "<tr><td $align>$$lang_vars{actual_client_message}<br>$$lang_vars{all_clients_message}</td><td $align1><input name=\"which_clients_audit_delete\" type=\"radio\" value=\"actual_client\" checked><br><input name=\"which_clients_audit_delete\" type=\"radio\" value=\"all_clients\"></td></tr>\n";
print "<tr><td><br><input name=\"manage_type\" type=\"hidden\" value=\"clear_audit_man\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input type=\"submit\" value=\"$$lang_vars{borrar_message}\" name=\"B1\"></form></td><td></td></tr>\n";
print "</table>\n";
print "<table border=\"0\" cellpadding=\"7\">\n";
print "</td><td colspan=\"4\"><p><br>$$lang_vars{db_size_total_message}: ${size_db} (AA: ${size_table_audit_auto} ($anz_auto_audit_total $$lang_vars{actual_anz_audit_auto_message} $$lang_vars{total_message}), MA: ${size_table_audit} ($anz_man_audit_total $$lang_vars{actual_anz_audit_man_message} $$lang_vars{total_message}))</td></tr>\n";
print "</table>\n";
print "<br><p>\n";

print "<table border=\"0\" cellpadding=\"7\">\n";
print "<tr><td><b>$$lang_vars{reset_database_for_client_message} <span class=\"client_name_head_text\">$client_name</span></td></tr>\n";
print "<tr><td><p></td><td></td><td></td></tr>\n";
print "<tr><td $align1><form name=\"reset_database\" method=\"POST\" action=\"$server_proto://$base_uri/res/ip_manage_gestioip.cgi\">IPv4<input type=\"checkbox\" name=\"reset_database_ipv4\" value=\"yes\" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPv6<input type=\"checkbox\" name=\"reset_database_ipv6\" value=\"yes\" checked><font color=\"white\">x</font></td><td></td><td></td></tr>\n";
print "<tr><td $align1><input name=\"manage_type\" type=\"hidden\" value=\"reset_database\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input type=\"submit\" value=\"$$lang_vars{reset_database_message}\" name=\"B1\" $onclick></form></td></tr>\n";

print "</table>\n";

$gip->print_end("$client_id","$vars_file");
