#!/usr/bin/perl -T -w

# Copyright (C) 2014 Marc Uebel

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
use Net::IP;
use Net::IP qw(:PROC);
use lib '../modules';
use GestioIP;


my $daten=<STDIN>;
my $gip = GestioIP -> new();
my %daten=$gip->preparer($daten);

my $base_uri = $gip->get_base_uri();
my $server_proto=$gip->get_server_proto();

my $lang = $daten{'lang'} || "";
my ($lang_vars,$vars_file,$entries_per_page_hosts);
($lang_vars,$vars_file)=$gip->get_lang("","$lang");
if ( $daten{'entries_per_page_hosts'} && $daten{'entries_per_page_hosts'} =~ /^\d{1,3}$/ ) {
        $entries_per_page_hosts=$daten{'entries_per_page_hosts'};
} else {
        $entries_per_page_hosts = "254";
}

my $client_id = $daten{'client_id'} || $gip->get_first_client_id();
my $host_order_by = $daten{'host_order_by'} || "IP_auf";
my $ip_version = $daten{'ip_version'} || "";

my $search_index=$daten{'search_index'} || "";
my $search_hostname=$daten{'search_hostname'} || "";

my $ip_int=$daten{'ip'};
if ( $ip_int !~ /^\d{1,50}$/ ) {
	$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{cambiar_host_message}","$vars_file");
	$gip->print_error("$client_id","$$lang_vars{formato_malo_message}");
}

my @host=$gip->get_host("$client_id","$ip_int","$ip_int");
my $required_perms;
if (@host) {
	$required_perms="update_host_perm";
} else {
	$required_perms="create_host_perm";
}

# check Permissions
my @global_config = $gip->get_global_config("$client_id");
my $user_management_enabled=$global_config[0]->[13] || "";
if ( $user_management_enabled eq "yes" ) {
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


my $ip_ad=$gip->int_to_ip("$client_id","$ip_int","$ip_version");

my $red_num=$daten{'red_num'} || "";
my $loc=$daten{'loc'} || "";
$loc = "" if $loc eq "---";
my $cm_val=$daten{'cm_val'} || "";

#Detect call from ip_show_cm_hosts.cgi and ip_list_device_by_job.cgi
my $CM_show_hosts=$daten{'CM_show_hosts'} || "";
my $CM_show_hosts_by_jobs=$daten{'CM_show_hosts_by_jobs'} || "";
my $CM_diff_form=$daten{'CM_diff_form'} || "";

my $text_field_number_given_form = "";
if ( defined($daten{'text_field_number_given'}) ) {
	$text_field_number_given_form="<input name=\"text_field_number_given\" type=\"hidden\" value=\"text_field_number_given\">";
}


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{cambiar_host_message} $ip_ad","$vars_file");


my $utype = $daten{'update_type'};
$gip->print_error("$client_id","$$lang_vars{formato_malo_message}") if $daten{'anz_values_hosts'} && $daten{'anz_values_hosts'} !~ /^\d{2,4}||no_value$/;
$gip->print_error("$client_id","$$lang_vars{formato_malo_message}") if $daten{'knownhosts'} && $daten{'knownhosts'} !~ /^all|hosts|libre$/;
$gip->print_error("$client_id","$$lang_vars{formato_malo_message}") if $daten{'start_entry_hosts'} && $daten{'start_entry_hosts'} !~ /^\d{1,20}$/;
#$gip->print_error("$client_id","$$lang_vars{formato_malo_message}") if ! $daten{'host_id'};
my $anz_values_hosts = $daten{'anz_values_hosts'} || "no_value";

my $start_entry_hosts=$daten{'start_entry_hosts'} || '0';
my $knownhosts=$daten{'knownhosts'} || 'all';
my $host_id=$daten{'host_id'} || "";

print "<p>\n";

$daten{'ip'} || $gip->print_error("$client_id","$$lang_vars{una_ip_message}<br>");
my $linked_ip=$daten{'linked_ip'} || "";

if ( $ip_version eq "v4" ) {
	$gip->CheckInIP("$client_id","$ip_ad","$$lang_vars{formato_ip_malo_message} - $$lang_vars{comprueba_ip_message}: <b><i>$ip_ad</i></b><br>");
} else {
	my $valid_v6=$gip->check_valid_ipv6("$ip_ad") || "0";
	$gip->print_error("$client_id","$$lang_vars{formato_ip_malo_message}") if $valid_v6 ne "1";
}

my @values_redes=();
my $red="";
my $BM="";
if ( ! $CM_show_hosts && ! $CM_show_hosts_by_jobs ) {
	@values_redes = $gip->get_red("$client_id","$red_num");
	$red = "$values_redes[0]->[0]" || "";
	$BM = "$values_redes[0]->[1]" || "";
}

my @values_locations=$gip->get_loc("$client_id");
my @values_categorias=$gip->get_cat("$client_id");
my @values_utype=$gip->get_utype();

my $hostname = $host[0]->[1] || "";
if (( ! $hostname || $hostname eq "unknown" ) && $search_hostname ) {
	$hostname = $search_hostname;
}
$hostname = "" if $hostname eq "NULL";
my $host_descr = $host[0]->[2] || "NULL";
my $loc_val = $host[0]->[3] || "$loc";
my $cat_val = $host[0]->[4] || "NULL";
my $int_ad_val = $host[0]->[5] || "n";
my $update_type = $host[0]->[7] || "";
my $comentario = $host[0]->[6] || "";

$host_descr = "" if (  $host_descr eq "NULL" );
$comentario = "" if (  $comentario eq "NULL" ); 
$loc_val = "" if (  $loc_val eq "NULL" ); 
$cat_val = "" if (  $cat_val eq "NULL" );
$update_type = "" if (  $update_type eq "NULL" ); 

my $disabled_color='#F0EDEA';


print <<EOF;
<script language="JavaScript" type="text/javascript" charset="utf-8">
<!--
function checkhost(IP,HOSTNAME,CLIENT_ID,IP_VERSION)
{
var opciones="toolbar=no,right=100,top=100,width=500,height=300", i=0;
var URL="$server_proto://$base_uri/ip_checkhost.cgi?ip=" + IP + "&hostname=" + HOSTNAME + "&client_id=" + CLIENT_ID  + "&ip_version=" + IP_VERSION;
host_info=window.open(URL,"",opciones);
}
-->
</script>

<script type="text/javascript">
<!--
function mod_cm_fields(ANZ_OTHER_JOBS){
//ANZ_OTHER_JOBS++
  if(ip_mod_form.enable_cm.checked == true){
    ip_mod_form.connection_proto.disabled=false;
    ip_mod_form.connection_proto_port.disabled=false;
    ip_mod_form.connection_proto.style.backgroundColor="white";
    ip_mod_form.connection_proto_port.style.backgroundColor="white";
    ip_mod_form.device_type_group_id.disabled=false;
    ip_mod_form.device_type_group_id.style.backgroundColor="white";
    ip_mod_form.save_config_changes.disabled=false;
    ip_mod_form.save_config_changes.style.backgroundColor="white";
    ip_mod_form.cm_server_id.disabled=false;
    ip_mod_form.cm_server_id.style.backgroundColor="white";
    document.getElementById('delete_cm_checkbox').checked=false;
    document.getElementById('delete_cm_checkbox').style.display='none';
    document.getElementById('delete_cm_checkbox_span').style.display='none';

    for (var i = 0, length = ip_mod_form.ele_auth.length; i < length; i++) {
      if (ip_mod_form.ele_auth[i].checked) {
        ele_auth_value=ip_mod_form.ele_auth[i].value;
        break;
      }
    }
    for (var i = 0, length = ip_mod_form.ele_auth.length; i < length; i++) {
      ip_mod_form.ele_auth[i].disabled=false;
    }
    if ( ele_auth_value == "group" ) {
      ip_mod_form.user_name.disabled=true;
      ip_mod_form.login_pass.disabled=true;
      ip_mod_form.retype_login_pass.disabled=true;
      ip_mod_form.enable_pass.disabled=true;
      ip_mod_form.retype_enable_pass.disabled=true;
      ip_mod_form.device_user_group_id.disabled=false;
      ip_mod_form.device_user_group_id.style.backgroundColor='white';
    } else {
      ip_mod_form.user_name.disabled=false;
      ip_mod_form.login_pass.disabled=false;
      ip_mod_form.retype_login_pass.disabled=false;
      ip_mod_form.enable_pass.disabled=false;
      ip_mod_form.retype_enable_pass.disabled=false;
      ip_mod_form.device_user_group_id.disabled=true;
      ip_mod_form.device_user_group_id.style.backgroundColor='$disabled_color';
    }

        for(j=0;j<30;j++){
            OTHER_JOB_ENABLED='job_enabled_' + j
            OTHER_JOB_ID='device_other_job_' + j
            OTHER_JOB_GROUP_ID='other_job_group_' + j
            OTHER_JOB_DESCR='other_job_descr_' + j

            document.getElementById(OTHER_JOB_ENABLED).disabled=false;

            if ( document.getElementById(OTHER_JOB_ENABLED).checked == true ) {
              document.getElementById(OTHER_JOB_ID).disabled=false;
              document.getElementById(OTHER_JOB_ID).style.backgroundColor="white";
              document.getElementById(OTHER_JOB_GROUP_ID).disabled=false;
              document.getElementById(OTHER_JOB_GROUP_ID).style.backgroundColor="white";
              document.getElementById(OTHER_JOB_DESCR).disabled=false;
              document.getElementById(OTHER_JOB_DESCR).style.backgroundColor="white";
            }
        }


   }else{

    ip_mod_form.connection_proto.disabled=true;
    ip_mod_form.connection_proto_port.disabled=true;
    ip_mod_form.connection_proto.style.backgroundColor='$disabled_color';
    ip_mod_form.connection_proto_port.style.backgroundColor='$disabled_color';
    ip_mod_form.device_type_group_id.disabled=true;
    ip_mod_form.device_type_group_id.style.backgroundColor="$disabled_color";
    ip_mod_form.save_config_changes.disabled=true;
    ip_mod_form.save_config_changes.style.backgroundColor="$disabled_color";
    ip_mod_form.cm_server_id.disabled=true;
    ip_mod_form.cm_server_id.style.backgroundColor="$disabled_color";
    document.getElementById('delete_cm_checkbox').checked=false;
    document.getElementById('delete_cm_checkbox').style.display='inline';
    document.getElementById('delete_cm_checkbox_span').style.display='inline';

    for (var i = 0, length = ip_mod_form.ele_auth.length; i < length; i++) {
      ip_mod_form.ele_auth[i].disabled=true;
    }

    ip_mod_form.device_user_group_id.disabled=true;
    ip_mod_form.device_user_group_id.style.backgroundColor="$disabled_color";
    ip_mod_form.user_name.disabled=true;
    ip_mod_form.login_pass.disabled=true;
    ip_mod_form.retype_login_pass.disabled=true;
    ip_mod_form.enable_pass.disabled=true;
    ip_mod_form.retype_enable_pass.disabled=true;

        for(j=0;j<30;j++){
            OTHER_JOB_ENABLED='job_enabled_' + j
            OTHER_JOB_ID='device_other_job_' + j
            OTHER_JOB_GROUP_ID='other_job_group_' + j
            OTHER_JOB_DESCR='other_job_descr_' + j
            document.getElementById(OTHER_JOB_ENABLED).disabled=true;
            document.getElementById(OTHER_JOB_ID).disabled=true;
            document.getElementById(OTHER_JOB_ID).style.backgroundColor="$disabled_color";
            document.getElementById(OTHER_JOB_GROUP_ID).disabled=true;
            document.getElementById(OTHER_JOB_GROUP_ID).style.backgroundColor="$disabled_color";
            document.getElementById(OTHER_JOB_DESCR).disabled=true;
            document.getElementById(OTHER_JOB_DESCR).style.backgroundColor="$disabled_color";
        }
   }
}
//-->
</script>


<script type="text/javascript">
<!--
function mod_user_info(VALUE){
   if(VALUE == 'group' ){
    ip_mod_form.user_name.disabled=true;
    ip_mod_form.login_pass.disabled=true;
    ip_mod_form.retype_login_pass.disabled=true;
    ip_mod_form.enable_pass.disabled=true;
    ip_mod_form.retype_enable_pass.disabled=true;
    ip_mod_form.device_user_group_id.disabled=false;
    ip_mod_form.device_user_group_id.style.backgroundColor='white';
    ip_mod_form.user_name.value='';
    ip_mod_form.login_pass.value='';
    ip_mod_form.retype_login_pass.value='';
    ip_mod_form.enable_pass.value='';
    ip_mod_form.retype_enable_pass.value='';

    document.getElementById('cm_individual_user').style.display='none';
    document.getElementById('cm_device_user_group').style.display='inline';
    document.getElementById('cm_device_user_group1').style.display='inline';

   } else {

    ip_mod_form.user_name.disabled=false;
    ip_mod_form.login_pass.disabled=false;
    ip_mod_form.retype_login_pass.disabled=false;
    ip_mod_form.enable_pass.disabled=false;
    ip_mod_form.retype_enable_pass.disabled=false;
    ip_mod_form.device_user_group_id.selectedIndex='0';
    ip_mod_form.device_user_group_id.disabled=true;
    ip_mod_form.device_user_group_id.style.backgroundColor='#F0EDEA';

    document.getElementById('cm_individual_user').style.display='inline';
    document.getElementById('cm_device_user_group').style.display='none';
    document.getElementById('cm_device_user_group1').style.display='none';

   }

}
//-->
</script>

<script type="text/javascript">
<!--
function disable_job(K){
  OTHER_JOB_ENABLED='job_enabled_' + K;
  OTHER_JOB_ID='device_other_job_' + K;
  OTHER_JOB_GROUP_ID='other_job_group_' + K;
  OTHER_JOB_DESCR='other_job_descr_' + K;
  JOB_ENABLED=document.getElementById(OTHER_JOB_ENABLED).checked;
  if ( JOB_ENABLED == true ) {
    document.getElementById(OTHER_JOB_ID).disabled=false;
    document.getElementById(OTHER_JOB_ID).style.backgroundColor="white";
    document.getElementById(OTHER_JOB_GROUP_ID).disabled=false;
    document.getElementById(OTHER_JOB_GROUP_ID).style.backgroundColor="white";
    document.getElementById(OTHER_JOB_DESCR).disabled=false;
    document.getElementById(OTHER_JOB_DESCR).readOnly=false;
    document.getElementById(OTHER_JOB_DESCR).style.backgroundColor="white";
    for (i=0; i<document.getElementById(OTHER_JOB_ID).options.length; i++) {
      document.getElementById(OTHER_JOB_ID).options[i].disabled=false;
    }
    for (i=0; i<document.getElementById(OTHER_JOB_GROUP_ID).options.length; i++) {
        document.getElementById(OTHER_JOB_GROUP_ID).options[i].disabled=false ;
    }
  } else {
    document.getElementById(OTHER_JOB_ID).style.backgroundColor="$disabled_color";
    document.getElementById(OTHER_JOB_GROUP_ID).style.backgroundColor="$disabled_color";
    document.getElementById(OTHER_JOB_DESCR).readOnly=true;
    document.getElementById(OTHER_JOB_DESCR).style.backgroundColor="$disabled_color";
    for (i=0; i<document.getElementById(OTHER_JOB_ID).options.length; i++) {
      if ( i != document.getElementById(OTHER_JOB_ID).selectedIndex ) {
        document.getElementById(OTHER_JOB_ID).options[i].disabled=true;
      }
    }
    for (i=0; i<document.getElementById(OTHER_JOB_GROUP_ID).options.length; i++) {
      if ( i != document.getElementById(OTHER_JOB_GROUP_ID).selectedIndex ) {
        document.getElementById(OTHER_JOB_GROUP_ID).options[i].disabled=true;
      }
    }
  }
}
//-->
</script>

<script type="text/javascript">
<!--
function mod_connection_proto_port(VALUE){
   if(VALUE == 'telnet' ){
    ip_mod_form.connection_proto_port.value='23';
   } else if (VALUE == 'SSH' ){
    ip_mod_form.connection_proto_port.value='22';
   }
}
//-->
</script>

EOF


print "<form name=\"ip_mod_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/ip_modip.cgi\">\n";
print "<table border=\"0\" cellpadding=\"1\">\n";
print "<tr><td><b>IP</b></td><td><b>  $$lang_vars{hostname_message}</b></td><td><b>  $$lang_vars{description_message}</b></td><td><b>  $$lang_vars{loc_message}</b></td><td><b> $$lang_vars{cat_message}</b></td><td><b>AI</b></td><td><b>$$lang_vars{comentario_message}</b></td><td><b>UT</b></td></tr>\n";
print "<tr valign=\"top\"><td class=\"hostcheck\" onClick=\"checkhost(\'$ip_ad\',\'\',\'$client_id\',\'$ip_version\')\" style=\"cursor:pointer;\" title=\"ping\"><font size=\"2\">$ip_ad<input type=\"hidden\" name=\"ip\" value=\"$ip_ad\"></font></td>\n";
print "<td><i><font size=\"2\"><input type=\"text\" size=\"15\" name=\"hostname\" value=\"$hostname\" maxlength=\"75\"></font></i></td>\n";
print "<td><i><font size=\"2\"><input type=\"text\" size=\"15\" name=\"host_descr\" value=\"$host_descr\" maxlength=\"100\"></font></i></td>\n";
print "<td><font size=\"2\"><select name=\"loc\" size=\"1\" value=\"$loc_val\">";
print "<option>$loc_val</option>";
my $j=0;
foreach (@values_locations) {
	$values_locations[$j]->[0] = "" if ($values_locations[$j]->[0] eq "NULL" && $loc_val ne "NULL" );
	print "<option>$values_locations[$j]->[0]</option>" if ( $values_locations[$j]->[0] ne "$loc_val" );
	$j++;
}
print "</select>\n";
print "</font></td><td><font size=\"2\"><select name=\"cat\" size=\"1\">";
print "<option>$cat_val</option>";
$j=0;
foreach (@values_categorias) {
	$values_categorias[$j]->[0] = "" if ($values_categorias[$j]->[0] eq "NULL" && $cat_val ne "NULL" );
        print "<option>$values_categorias[$j]->[0]</option>" if ($values_categorias[$j]->[0] ne "$cat_val" );
        $j++;
}
print "</select>\n";

if ( ! $CM_show_hosts && ! $CM_show_hosts_by_jobs ) {
	print "</font></td><input name=\"red\" type=\"hidden\" value=\"$red\"><input name=\"BM\" type=\"hidden\" value=\"$BM\">\n";
}

my $int_admin_checked;
if ( $int_ad_val eq "y" ) {
	$int_admin_checked="checked";
} else {
	$int_admin_checked="";
}

print "<td><input type=\"checkbox\" name=\"int_admin\" value=\"y\" $int_admin_checked></td>\n";


print "<td><textarea name=\"comentario\" cols=\"30\" rows=\"5\" wrap=\"physical\" maxlength=\"500\">$comentario</textarea></td>";
print "<td><select name=\"update_type\" size=\"1\">";
print "<option>$update_type</option>";
$j=0;
foreach (@values_utype) {
	$values_utype[$j]->[0] = "" if ( $values_utype[$j]->[0] =~ /NULL/ && $update_type ne "NULL" );
        print "<option>$values_utype[$j]->[0]</option>" if ( $values_utype[$j]->[0] ne "$update_type" );
        $j++;
}
print "</select>\n";
print "</td>";

print "<td><input name=\"entries_per_page_hosts\" type=\"hidden\" value=\"$entries_per_page_hosts\"><input name=\"start_entry_hosts\" type=\"hidden\" value=\"$start_entry_hosts\"><input name=\"knownhosts\" type=\"hidden\" value=\"$knownhosts\"><input name=\"anz_values_hosts\" type=\"hidden\" value=\"$anz_values_hosts\"></td></tr>\n";



my %cc_value = ();
my @custom_columns = $gip->get_custom_host_columns("$client_id");
%cc_value=$gip->get_custom_host_columns_from_net_id_hash("$client_id","$host_id") if $host_id;


print "<table border=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse\">\n";
print "<tr><td colspan='3'><p></td></tr>\n";
if ( $custom_columns[0] ) {
        print "<tr><td colspan='3'> <b>$$lang_vars{custom_host_columns_message}</b></td></tr>\n";
}
print "<tr><td colspan='3'><p></td></tr>\n";

my @vendors = $gip->get_vendor_array();

my $n=0;
foreach my $cc_ele(@custom_columns) {
	my $cc_name = $custom_columns[$n]->[0];
	my $pc_id = $custom_columns[$n]->[3];
	my $cc_id = $custom_columns[$n]->[1];
	my $cc_entry = $cc_value{$cc_id}[1] || "";
	if ( $daten{'OS'} && $cc_name eq "OS" ) {
		$cc_entry = $daten{'OS'};	
	}
	if ( $daten{'OS_version'} && $cc_name eq "OS_version" ) {
		$cc_entry = $daten{'OS_version'};	
	}
	if ( $daten{'MAC'} && $cc_name eq "MAC" ) {
		$cc_entry = $daten{'MAC'};	
	}
	if ( $cc_name ) {
		if ( $cc_name eq "vendor" ) {
			my $knownvendor="0";
			foreach (@vendors) {
				if ( $cc_entry =~ /$_/i ) {
					$knownvendor=1; 
					last;
				}
			}
			my $checked_known="";
			my $checked_unknown="";
			my $disabled_known="";
			my $disabled_unknown="";
			my $cc_entry_unknown="";
			if ( $knownvendor == 1 ) {
				$checked_known="checked";
				$disabled_unknown="disabled";
			} elsif ( ! $cc_entry  ) {
				$checked_known="checked";
				$disabled_unknown="disabled";
			} else {
				$checked_unknown="checked";
				$disabled_known="disabled";
				$cc_entry_unknown=$cc_entry;
			}
			print "<tr><td><b>$cc_name</b></td><td> <input type=\"radio\" name=\"vendor_radio\" value=\"known\" onclick=\"custom_${n}_value_known.disabled=false;custom_${n}_value_unknown.value='';custom_${n}_value_unknown.disabled=true;\" $checked_known></td><td>\n";
			print "<font size=\"2\"><select name=\"custom_${n}_value_known\" id=\"custom_${n}_value_known\" size=\"1\" $disabled_known>";
			print "<option></option>\n";
			my $j=0;
			foreach (@vendors) {
				my $vendor=$vendors[$j];
				my $vendor_img;
				if ( $vendor =~ /(lucent|alcatel)/i ) {
					$vendor_img="lucent-alcatel";
				} elsif ( $vendor =~ /(borderware)/i ) {
					$vendor_img="watchguard";
				} elsif ( $vendor =~ /(dlink|d-link)/i ) {
					$vendor_img="dlink";
				} elsif ( $vendor =~ /(cyclades)/i ) {
					$vendor_img="avocent";
				} elsif ( $vendor =~ /(eci telecom)/i ) {
					$vendor_img="eci";
				} elsif ( $vendor =~ /(^hp)/i ) {
					$vendor="hp";
					$vendor_img="hp";
				} elsif ( $vendor =~ /(minolta)/i ) {
					$vendor_img="konica";
				} elsif ( $vendor =~ /(okilan)/i ) {
					$vendor_img="oki";
				} elsif ( $vendor =~ /(phaser)/i ) {
					$vendor_img="xerox";
				} elsif ( $vendor =~ /(tally|genicom)/i ) {
					$vendor_img="tallygenicom";
				} elsif ( $vendor =~ /(seiko|infotec)/i ) {
					$vendor_img="seiko_infotec";
				} elsif ( $vendor =~ /(^palo)/i ) {
					$vendor="paloalto";
					$vendor_img="palo_alto";
				} elsif ( $vendor =~ /(silverpeak)/i ) {
					$vendor_img="silver_peak";
				} else {
					$vendor_img=$vendor;
				}
				if ( $cc_entry && $cc_entry =~ /$vendors[$j]/i ) {
					print "<option value=\"$vendor\" style=\"background: url(../imagenes/vendors/$vendor_img.png) no-repeat top left;\" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $vendor</option>";
				} else {
					print "<option value=\"$vendor\" style=\"background: url(../imagenes/vendors/$vendor_img.png) no-repeat top left;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $vendor</option>";
				}
				$j++;
			}
			print "</select><input name=\"custom_${n}_name\" type=\"hidden\" value=\"$cc_name\"><input name=\"custom_${n}_id\" type=\"hidden\" value=\"$cc_id\"><input name=\"custom_${n}_pcid\" type=\"hidden\" value=\"$pc_id\"></td></tr>\n";
			print "<tr><td></td><td><input type=\"radio\" name=\"vendor_radio\" value=\"unknown\" onclick=\"custom_${n}_value_known.disabled=true;custom_${n}_value_unknown.disabled=false;document.ip_mod_form.custom_${n}_value_known.options[0].selected = true;\" $checked_unknown></td><td><input type=\"text\" size=\"20\" name=\"custom_${n}_value_unknown\" id=\"custom_${n}_value_unknown\" value=\"$cc_entry_unknown\" maxlength=\"500\" $disabled_unknown></td></tr>\n";

		} elsif ( $cc_name eq "URL" ) {
			print "<tr><td><b>$cc_name</b><br>(service::URL)</td><td colspan='2'><input name=\"custom_${n}_name\" type=\"hidden\" value=\"$cc_name\"><input name=\"custom_${n}_id\" type=\"hidden\" value=\"$cc_id\"><input name=\"custom_${n}_pcid\" type=\"hidden\" value=\"$pc_id\"><textarea name='custom_${n}_value' cols='50' rows='5' wrap='physical' maxlength='500'>$cc_entry</textarea></td></tr>\n";

		} elsif ( $cc_name eq "linked IP" ) {
			$linked_ip=$cc_entry if ! $linked_ip;
			print "<tr><td><b>$cc_name</b></td><td></td><td><input name=\"custom_${n}_name\" type=\"hidden\" value=\"$cc_name\"><input name=\"custom_${n}_id\" type=\"hidden\" value=\"$cc_id\"><input name=\"custom_${n}_pcid\" type=\"hidden\" value=\"$pc_id\"><input type=\"text\" size=\"20\" name=\"custom_${n}_value\" value=\"$linked_ip\" maxlength=\"700\"></td></tr>\n";

		} elsif ( $cc_name eq "CM" ) {

			my %values_device_config;
			%values_device_config=$gip->get_device_cm_hash("$client_id","$host_id") if $host_id;

			my $cm_enabled_db=$global_config[0]->[8] || "";
			my $cm_licence_key_db=$global_config[0]->[10] || "";
			my $cm_xml_dir=$global_config[0]->[12] || "";
			my $enable_cm_checkbox_disabled="";
			my $cm_note="";
			my ($return_code,$cm_licence_key_message,$device_count)=$gip->check_cm_licence("$client_id","$vars_file","$cm_licence_key_db");
			my $device_count_enabled=$gip->get_cm_host_count("$client_id");

			if ( $cm_enabled_db ne "yes" ) {
				$cm_note="<font color=\"red\"><b>" . $$lang_vars{cm_management_disabled_message} . "<br>" . $$lang_vars{enable_cm_managemente_help_message} . "</b></font>";
				$enable_cm_checkbox_disabled="disabled";
			} elsif ( $device_count < $device_count_enabled && !keys %values_device_config ) {
			# license host count exceeded, only for new hosts
				$cm_note="<b><font color=\"red\">" . $$lang_vars{host_count_exceeded_message} . "</font><br>" . $$lang_vars{number_of_supported_cm_hosts_message} . ": " . $device_count . "<br>" . $$lang_vars{number_of_new_cm_hosts_message} . ": " . $device_count_enabled . "<p>";
				$enable_cm_checkbox_disabled="disabled";
			} elsif ( $return_code != 0 && $return_code != 2 ) {
				# valid or expire warn
				$cm_note="<font color=\"red\"><b>" . $$lang_vars{cm_management_disabled_message} . "<br>" . $cm_licence_key_message . "<br" .  $$lang_vars{cm_management_disabled_message} . "</b></font>";
				$enable_cm_checkbox_disabled="disabled";
			}

			$cm_val="disabled" if ! $cm_val;


			my %values_device_type_groups=$gip->get_device_type_values("$client_id","$cm_xml_dir");
			my %values_device_user_groups=$gip->get_device_user_groups_hash("$client_id");
			my %values_cm_server=$gip->get_cm_server_hash("$client_id");
			my %values_other_jobs;
			my $anz_values_other_jobs=0;
			%values_other_jobs = $gip->get_cm_jobs("$client_id","$host_id","job_id") if $host_id;
			$anz_values_other_jobs=keys(%{$values_other_jobs{$host_id}}) if $host_id;

			my ($cm_id,$device_type_group_id,$device_user_group_id,$user_name,$login_pass,$enable_pass,$description,$connection_proto,$connection_proto_port,$cm_server_id,$save_config_changes);
			$device_type_group_id=$device_user_group_id=$user_name=$login_pass=$enable_pass=$description=$connection_proto=$connection_proto_port=$cm_server_id=$save_config_changes="";

			if ( $host_id ) {
				for my $key ( sort keys %values_device_config ) {
					$cm_id=$key;
					$device_type_group_id=$values_device_config{$key}[1] || "";
					$device_user_group_id=$values_device_config{$key}[2] || "";
					if ( ! $device_user_group_id ) {
						$user_name=$values_device_config{$key}[3] || "";
						$login_pass=$values_device_config{$key}[4] || "";
						$enable_pass=$values_device_config{$key}[5] || "";
					}
					$description=$values_device_config{$key}[6] || "";
					$connection_proto=$values_device_config{$key}[7] || "";
					$connection_proto_port=$values_device_config{$key}[13] || "";
					$cm_server_id=$values_device_config{$key}[8] || "";
					$save_config_changes=$values_device_config{$key}[9] || "";
				}
			}

			my $device_type_group_id_preselected=$device_type_group_id || 1;
			my $jobs=$values_device_type_groups{$device_type_group_id_preselected}[2] || "";
			my %jobs=();
			if ( $jobs ) {
				%jobs=%$jobs;
			}


print <<EOF;

<script type="text/javascript">
<!--
function changerows(ID,ANZ_OTHER_JOBS) {
value=ID.options[ID.selectedIndex].value
EOF

my $m=0;
for my $id ( keys %values_device_type_groups ) {
        if ( $m == 0 ) {
                print "  if ( value == \"$id\" ) {\n";
        } else {
                print "  } else if ( value == \"$id\" ) {\n";
        }

        print "    var values_job_names=new Array(\"\"";
	my $jobs_j=$values_device_type_groups{$id}[2] || "";
	my %jobs_j=();
	if ( $jobs_j ) {
		%jobs_j=%$jobs_j;
	}
	

	for my $job_name ( keys %{$jobs_j{$id}} ) {
                print ",\"$job_name\"";
        }
        print ")\n";



        print "    var values_job_descr=new Array(\"\"";
	for my $job_name ( keys %{$jobs_j{$id}} ) {
		my $job_description=$jobs_j{$id}{$job_name}[0] || "";
		$job_description=~s/"/\\"/g;
                print ",\"$job_description\"";
        }
        print ")\n";

        $m++;
}
print "  }\n";

print <<EOF;
var OTHER_JOB_ID
var OTHER_JOB_GROUP_ID
var OTHER_JOB_DESCR
for(j=0;j<30;j++){
            OTHER_JOB_ID='device_other_job_' + j
            OTHER_JOB_GROUP_ID='other_job_group_' + j
            OTHER_JOB_DESCR='other_job_descr_' + j 
            document.getElementById(OTHER_JOB_ID).options.length=values_job_names.length
            document.getElementById(OTHER_JOB_ID).options[0].selected=true
            document.getElementById(OTHER_JOB_GROUP_ID).options[0].selected=true
            document.getElementById(OTHER_JOB_DESCR).value='';
}

for(i=0;i<values_job_names.length;i++){
        for(j=0;j<30;j++){
            OTHER_JOB_ID='device_other_job_' + j
            document.getElementById(OTHER_JOB_ID).options[i].text=values_job_descr[i]
            document.getElementById(OTHER_JOB_ID).options[i].value=values_job_names[i]
            document.getElementById(OTHER_JOB_ID).options[0].selected=true
        }
}

}
-->
</script>

<script type="text/javascript">
<!--

function show_host_ip_field(ID) {
var BUTTON_ID='plus_button_' + ID
document.getElementById(BUTTON_ID).value='';
document.getElementById(BUTTON_ID).style.display='none';
ID++
var OTHER_JOB_ID='other_job_group_form_' + ID
document.getElementById(OTHER_JOB_ID).style.display='inline';
}

-->
</script>


<script type="text/javascript">
<!--

function delete_job(ID) {
var OTHER_JOB_ID='device_other_job_' + ID
var OTHER_JOB_GROUP_ID='other_job_group_' + ID
var OTHER_JOB_DESCR='other_job_descr_' + ID
document.getElementById(OTHER_JOB_ID).options[0].selected=true
document.getElementById(OTHER_JOB_GROUP_ID).options[0].selected=true
document.getElementById(OTHER_JOB_DESCR).value='';
}

-->
</script>

EOF

			print "<tr><td colspan=\"3\">\n";
			print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\">\n";

			my $enable_cm_checked="";
			my $enable_cm_disabled="";
			my $enable_cm_bg_color="white";
			$enable_cm_checked="checked" if $cc_entry eq "enabled";
			$enable_cm_disabled="disabled" if $cc_entry ne "enabled" || $enable_cm_checkbox_disabled eq "disabled";
			$enable_cm_bg_color=$disabled_color if $cc_entry ne "enabled" || $enable_cm_checkbox_disabled eq "disabled";
			my $save_config_changes_checked="";
			$save_config_changes_checked="checked" if $save_config_changes;


			print "<tr><td><br><b>$$lang_vars{CM_message}</b></td><td>";
			print "<tr><td colspan=\"2\">$cm_note</td><td>" if $cm_note;

			print "<tr><td>$$lang_vars{enable_cm_host_message}</td><td><input name=\"enable_cm\" type=\"checkbox\" value=\"enable_cm\" $enable_cm_checked onchange=\"mod_cm_fields(\'$anz_values_other_jobs\');\" $enable_cm_checkbox_disabled></td></tr>\n";
			print "<tr><td><span id=\"delete_cm_checkbox_span\" style=\"display:none;\">$$lang_vars{delete_cm_configuration_message}</span></td><td> <input name=\"delete_cm_all\" id=\"delete_cm_checkbox\" type=\"checkbox\" value=\"delete_cm_all\" style=\"display:none;\">\n";
			print "</td></tr>";


			print "<tr><td>$$lang_vars{device_type_group_message}</td><td>";
			if ( scalar keys %values_device_type_groups >= 1 ) {
				print "<select name=\"device_type_group_id\" size=\"1\" style=\"background-color:$enable_cm_bg_color;\" onchange=\"changerows(this,\'$anz_values_other_jobs\');\" $enable_cm_disabled>";
				print "<option></option>\n";
				for my $key ( sort { $values_device_type_groups{$a}[0] cmp $values_device_type_groups{$b}[0] } keys %values_device_type_groups ) {

					my $device_type_group_name=$values_device_type_groups{$key}[0];
					if ( $device_type_group_id eq $key ) {
						print "<option value=\"$key\" selected>$device_type_group_name</option>\n";
					} else {
						print "<option value=\"$key\">$device_type_group_name</option>\n";
					}
				}
				print "</select></td></tr>\n";
			} else {
				print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_device_type_group_message}</i></font>\n";
			}


			print "<tr><td><br></td></tr>\n";





			my $device_user_group_disabled="";
			my $individual_user_disabled="";
			my $device_user_select_background="white";
			my $display_device_user_group="inline";
			my $display_individual_user="none";
			if ( $user_name || $login_pass || $enable_pass ) {
				$device_user_group_disabled="disabled";
				$device_user_select_background="#F0EDEA";
				$display_device_user_group="none";
				$display_individual_user="inline";

				print "<tr><td colspan=\"2\">$$lang_vars{use_device_user_group_message} <input name=\"ele_auth\" type=\"radio\" value=\"group\" onclick=\"mod_user_info(this.value);\" $enable_cm_disabled> $$lang_vars{use_device_individual_user_message}\n";
				print"<input name=\"ele_auth\" type=\"radio\" value=\"individual\" onclick=\"mod_user_info(this.value);\" $enable_cm_disabled checked></td></tr>\n";
			} else {
				$individual_user_disabled="disabled";
				$device_user_group_disabled="disabled" if $cc_entry ne "enabled" || $enable_cm_checkbox_disabled eq "disabled";
				$device_user_select_background="#F0EDEA" if $cc_entry ne "enabled" || $enable_cm_checkbox_disabled eq "disabled";
				print "<tr><td colspan=\"2\">$$lang_vars{use_device_user_group_message} <input name=\"ele_auth\" type=\"radio\" value=\"group\" onclick=\"mod_user_info(this.value);\" $enable_cm_disabled checked> $$lang_vars{use_device_individual_user_message}\n";
				print"<input name=\"ele_auth\" type=\"radio\" value=\"individual\" onclick=\"mod_user_info(this.value);\" $enable_cm_disabled></td></tr>\n";
			}


			print "<tr><td>\n";

			print "<span id=\"cm_device_user_group\" style=\"display:$display_device_user_group;\">$$lang_vars{device_user_group_message}</span></td><td><span id=\"cm_device_user_group1\" style=\"display:$display_device_user_group;\">";
			if ( scalar keys %values_device_user_groups >= "1" ) {

				print "<select name=\"device_user_group_id\" size=\"1\" style=\"background-color: $device_user_select_background;\" $device_user_group_disabled>";
				print "<option></option>\n";
				for my $key ( sort { $values_device_user_groups{$a}[0] cmp $values_device_user_groups{$b}[0] } keys %values_device_user_groups ) {
					my $device_user_group_name=$values_device_user_groups{$key}[0];
					if ( $device_user_group_id eq $key ) {
						print "<option value=\"$key\" selected>$device_user_group_name</option>";
					} else {
						print "<option value=\"$key\">$device_user_group_name</option>";
					}
				}
				print "</select>\n";
			} else {
				print "&nbsp;<font color=\"gray\"><input name=\"device_user_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_device_user_group_message}</i></font>\n";
			}


			print "</span></td></tr>\n";



			print "</td></tr>\n";
			print "<tr><td colspan=\"2\">\n";
			print "<span id=\"cm_individual_user\" style=\"display:$display_individual_user;\">\n";
			print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\">\n";


			print "<tr><td>$$lang_vars{device_user_name_message}</td><td><input name=\"user_name\" type=\"text\" size=\"15\" maxlength=\"50\" value=\"$user_name\" $individual_user_disabled>\n";

			print "</td></tr><tr><td>\n";

			print "$$lang_vars{login_pass_message}</td><td><input name=\"login_pass\" type=\"password\" size=\"12\" maxlength=\"500\" value=\"$login_pass\" $individual_user_disabled>\n";

			print "</td></tr><tr><td>\n";

			print "$$lang_vars{retype_login_pass_message}</td><td><input name=\"retype_login_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$login_pass\" $individual_user_disabled>\n";

			print "</td></tr><tr><td>\n";

			print "$$lang_vars{enable_pass_message}</td><td><input name=\"enable_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$enable_pass\" $individual_user_disabled>\n";

			print "</td></tr><tr><td>\n";

			print "$$lang_vars{retype_enable_pass_message}</td><td><input name=\"retype_enable_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$enable_pass\" $individual_user_disabled>\n";


			print "</td></tr>\n";
			print "</table>\n";
			print "</span>\n";



			print "<tr><td><br></td></tr>\n";



			print "<tr><td>\n";


			if ( ! $connection_proto_port && $connection_proto eq "telnet") {
				$connection_proto_port=23;
			} elsif ( ! $connection_proto_port && $connection_proto eq "SSH") {
				$connection_proto_port=22;
			}

			my @cm_connetion_type_values=("telnet","SSH");
			print "\n$$lang_vars{connection_proto_message}</td><td><font size=\"2\"><select name=\"connection_proto\" size=\"1\" onchange=\"mod_connection_proto_port(this.value);\" style=\"background-color:$enable_cm_bg_color;\" $enable_cm_disabled>";
			print "<option></option>";
			foreach (@cm_connetion_type_values) {
				if ( $_ eq $connection_proto ) {
					print "<option selected>$_</option>\n";
				} else {
					print "<option>$_</option>\n";
				}
			}
			print "</select>\n";
			print "$$lang_vars{port_message} <input name=\"connection_proto_port\" type=\"text\" size=\"3\" maxlength=\"5\" value=\"$connection_proto_port\" $enable_cm_disabled>\n";


			print "</td></tr><tr><td>\n";


			print "$$lang_vars{backup_server_message}</td><td>";
			if ( scalar keys %values_cm_server >= "1" ) {
				print "<select name=\"cm_server_id\" size=\"1\" style=\"background-color:$enable_cm_bg_color;\" $enable_cm_disabled>";
				print "<option></option>\n";
				for my $key ( sort { $values_cm_server{$a}[0] cmp $values_cm_server{$b}[0] } keys %values_cm_server ) {

					my $cm_server_name=$values_cm_server{$key}[0];
					if ( $cm_server_id eq $key ) {
						print "<option value=\"$key\" selected>$cm_server_name</option>\n";
					} else {
						print "<option value=\"$key\">$cm_server_name</option>\n";
					}
				}
				print "</select>\n";
			} else {
				print "&nbsp;<font color=\"gray\"><input name=\"cm_server_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_cm_server_message}</i></font>\n";
			}

			print "</td></tr><tr><td>\n";


			print "$$lang_vars{save_config_changes_message}</td><td><input type=\"checkbox\" name=\"save_config_changes\" value=\"1\" $save_config_changes_checked $enable_cm_disabled>\n";


### JOBS
			print "</td></tr><tr><td>\n";
			print "<br><b><i>$$lang_vars{other_jobs_message}</i></b>";
			print "</td></tr><tr><td>\n";

			my %job_groups=$gip->get_job_groups("$client_id");
			my $k=0;
			if ( $anz_values_other_jobs > 0 && $host_id ) {
				sub sort_sub {
					$a <=> $b;
				}
				for my $job_id ( sort sort_sub keys %{ $values_other_jobs{$host_id} } ) {
					my $job_name=$values_other_jobs{$host_id}{$job_id}[0];
					my $job_group_id=$values_other_jobs{$host_id}{$job_id}[1];
					my $job_descr=$values_other_jobs{$host_id}{$job_id}[2];
					my $job_enabled=$values_other_jobs{$host_id}{$job_id}[6] || 0;
					my $job_enabled_disabled="";
					my $job_enabled_readonly="";
					my $job_enabled_checked="";
					my $job_enabled_bg_color="white";
					$job_enabled_bg_color=$disabled_color if $job_enabled == 0 || $enable_cm_disabled eq "disabled";
					$job_enabled_readonly="readonly" if $job_enabled == 0;
					$job_enabled_disabled="disabled" if $job_enabled == 0;
					$job_enabled_checked="checked" if $job_enabled == 1;

					print "<tr><td><br></td><td></td></tr>\n";
					print "<tr><td>$$lang_vars{enable_message}</td><td>";
					print "<input type=\"checkbox\" name=\"job_enabled_${k}\" id=\"job_enabled_${k}\" style=\"background-color:$job_enabled_bg_color\" onclick=\"disable_job($k);\" $enable_cm_disabled $job_enabled_checked>";
					print "</td></tr>\n";
					print "<tr><td>\n";
					print "$$lang_vars{job_message}</td><td>";
					if ( scalar keys %jobs >= 1 ) {
						print "<select name=\"device_other_job_${k}\" id=\"device_other_job_${k}\" size=\"1\" style=\"background-color:$job_enabled_bg_color; width: 230px;\" $enable_cm_disabled>";
                                                print "<option $job_enabled_disabled></option>\n";
                                                for my $job_name1 ( keys %{ $jobs{$device_type_group_id} } ) {
                                                        my $job_description=$jobs{$device_type_group_id}{$job_name1}[0] || "";
                                                        if ( $job_name eq $job_name1 ) {
                                                                print "<option value=\"$job_name1\" selected>$job_description</option>\n";
                                                        } else {
                                                                print "<option value=\"$job_name1\" $job_enabled_disabled>$job_description</option>\n";
                                                        }
                                                }
                                                print "</select>\n";


						print "</td></tr><tr><td>\n";


						print "$$lang_vars{description_message}</td><td><input name=\"other_job_descr_${k}\" id=\"other_job_descr_${k}\" type=\"text\" size=\"30\" maxlength=\"500\" value=\"$job_descr\" style=\"background-color:$job_enabled_bg_color;\" $enable_cm_disabled  $job_enabled_readonly>\n";


						print "</td></tr><tr><td>\n";


                                                print "$$lang_vars{job_group_message}</td><td>";
                                                print "<select name=\"other_job_group_${k}\" id=\"other_job_group_${k}\" size=\"1\" style=\"background-color:$job_enabled_bg_color;\" $enable_cm_disabled>";
                                                print "<option $job_enabled_disabled></option>\n";

						for my $job_group_all_id ( sort keys %job_groups ) {
							my $job_group_name=$job_groups{$job_group_all_id}[0];
                                                        if ( $job_group_id eq $job_group_all_id ) {
                                                                print "<option value=\"$job_group_all_id\" selected>$job_group_name</option>\n";
                                                        } else {
                                                                print "<option value=\"$job_group_all_id\" $job_enabled_disabled>$job_group_name</option>\n";
                                                        }
                                                }
                                                print "</select>\n";


						print "</td></tr>\n<tr><td>\n";


						print "<span id=\"delete_button_${k}\" onClick=\"delete_job('$k')\" class=\"delete_small_button\" title=\"$$lang_vars{delete_job_message}\" style=\"cursor:pointer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>\n";
						print "<input name=\"device_other_job_id_${k}\" type=\"hidden\" value=\"$job_id\">";


					} else {
						print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_cm_jobs_message}</i></font>\n";
					}

					$k++;
				}
				print "<input name=\"device_other_jobs_anz\" type=\"hidden\" value=\"$k\">\n";
			} else {
				print "</td></tr><tr><td>\n";
				print "$$lang_vars{enable_message}</td><td>";
				print "<input type=\"checkbox\" name=\"job_enabled_0\" id=\"job_enabled_0\" style=\"background-color:$enable_cm_bg_color;\" onclick=\"disable_job($k);\" $enable_cm_disabled checked>";
				print "</td></tr><tr><td>\n";

				print "$$lang_vars{job_message}</td><td>";
				if ( scalar keys %jobs >= 1 ) {
					print "<select name=\"device_other_job_0\" id=\"device_other_job_0\" size=\"1\" style=\"background-color:$enable_cm_bg_color; width: 230px;\" $enable_cm_disabled>";
					print "<option></option>\n";
					for my $job_name ( keys %{ $jobs{$device_type_group_id} } ) {
						my $job_description=$jobs{$device_type_group_id}{$job_name}[0] || "";
						print "<option value=\"$job_name\">$job_description</option>\n";
					}
					print "</select>\n";
					print "<input name=\"device_other_jobs_anz\" type=\"hidden\" value=\"1\">\n";

					print "</td></tr><tr><td>\n";


					print "$$lang_vars{description_message}</td><td><input name=\"other_job_descr_0\" id=\"other_job_descr_0\" type=\"text\" size=\"30\" maxlength=\"500\" value=\"\" $enable_cm_disabled>\n";

					print "</td></tr><tr><td>\n";


					print "$$lang_vars{job_group_message}</td><td>";
					print "<select name=\"other_job_group_0\" id=\"other_job_group_0\" size=\"1\" style=\"background-color:$enable_cm_bg_color;\" $enable_cm_disabled>";
					print "<option></option>\n";

					for my $job_group_all_id ( sort keys %job_groups ) {
						my $job_group_name=$job_groups{$job_group_all_id}[0];
						print "<option value=\"$job_group_all_id\">$job_group_name</option>\n";
					}

					print "</select>\n";
					print "<input name=\"device_other_job_id_0\" type=\"hidden\" value=\"0\">";
					print "</td></tr><tr><td>\n";
					print "<span id=\"delete_button_${k}\" onClick=\"delete_job('$k')\" class=\"delete_small_button\" title=\"$$lang_vars{delete_job_message}\" style=\"cursor:pointer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>\n";
					$k++;

				} else {
					print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_cm_jobs_message}</i></font>\n";
				}
			}

			print "</td></tr><tr><td>\n";

			print "<span id=\"plus_button_${k}\" onClick=\"show_host_ip_field('$k')\" class=\"add_small_button\" title=\"$$lang_vars{add_job_message}\" style=\"cursor:pointer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>\n";


			print "</td></tr>\n";
			print "<tr><td><br></td></tr>\n";

			for ( ; $k<=30; $k++ ) {

				print "<tr><td colspan=\"2\">\n";
				print "<span id=\"other_job_group_form_${k}\" style='display:none;'>\n";
				print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\" width=\"100%\">\n";
				print "<tr><td>$$lang_vars{enable_message}</td><td>";
				print "<input type=\"checkbox\" name=\"job_enabled_${k}\" id=\"job_enabled_${k}\" style=\"background-color:$enable_cm_bg_color\" onclick=\"disable_job($k);\" $enable_cm_disabled checked>";
				print "</td></tr>\n";
				print "<tr><td width=\"50%\">$$lang_vars{job_message}\n";
				print "</td><td>\n";

				print "<select name=\"device_other_job_${k}\" id=\"device_other_job_${k}\" size=\"1\" style=\"background-color:$enable_cm_bg_color; width: 230px;\" $enable_cm_disabled>";
				print "<option></option>\n";
				for my $job_name ( keys %{ $jobs{$device_type_group_id} } ) {
					my $job_description=$jobs{$device_type_group_id}{$job_name}[0] || "";
					print "<option value=\"$job_name\">$job_description</option>\n";
				}
				print "</select>\n";

				print "</td></tr><tr><td>\n";

				print "$$lang_vars{description_message}</td><td><input name=\"other_job_descr_${k}\" id=\"other_job_descr_${k}\" type=\"text\" size=\"30\" maxlength=\"500\" value=\"\" $enable_cm_disabled>\n";

				print "</td></tr><tr><td>\n";


				print "$$lang_vars{job_group_message}\n";
				print "</td><td>\n";
				print "<select name=\"other_job_group_${k}\" id=\"other_job_group_${k}\" size=\"1\" style=\"background-color:$enable_cm_bg_color;\" $enable_cm_disabled>";
				print "<option></option>\n";

				for my $job_group_all_id ( sort keys %job_groups ) {
					my $job_group_name=$job_groups{$job_group_all_id}[0];
					print "<option value=\"$job_group_all_id\">$job_group_name</option>\n";
				}
				print "</select>\n";


				print "</td></tr><tr><td>\n";


				print "<span id=\"delete_button_${k}\" onClick=\"delete_job('$k')\" class=\"delete_small_button\" title=\"$$lang_vars{delete_job_message}\" style=\"cursor:pointer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>\n";
				print "</td></tr><tr><td>\n";

				print "<span id=\"plus_button_${k}\" onClick=\"show_host_ip_field('$k')\" class=\"add_small_button\" title=\"$$lang_vars{add_job_message}\" style=\"cursor:pointer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>\n";
				print "</td></tr>\n";
#				print "<tr><td><br></td><td></td></tr>\n";
				print "</table>\n";
				print "</span></td></tr>\n";
			}



			print "</table>\n";

			print "<input name=\"custom_${n}_name\" type=\"hidden\" value=\"$cc_name\"><input name=\"custom_${n}_id\" type=\"hidden\" value=\"$cc_id\"><input name=\"custom_${n}_pcid\" type=\"hidden\" value=\"$pc_id\"></td></tr>\n";
#			print "</td></tr>\n";
#			print "<p>\n";


		} else {
			print "<tr><td><b>$cc_name</b></td><td></td><td><input name=\"custom_${n}_name\" type=\"hidden\" value=\"$cc_name\"><input name=\"custom_${n}_id\" type=\"hidden\" value=\"$cc_id\"><input name=\"custom_${n}_pcid\" type=\"hidden\" value=\"$pc_id\"><input type=\"text\" size=\"20\" name=\"custom_${n}_value\" value=\"$cc_entry\" maxlength=\"500\"></td></tr>\n";
		}
	$n++;
	}
}

my $CM_show_hosts_hidden="";
my $CM_show_hosts_by_jobs_hidden="";
my $CM_diff_form_hidden="";
if ( $CM_show_hosts ) {
	$CM_show_hosts_hidden="<input name=\"CM_show_hosts\" type=\"hidden\" value=\"$CM_show_hosts\">";
} elsif ( $CM_show_hosts_by_jobs ) {
	$CM_show_hosts_by_jobs_hidden="<input name=\"CM_show_hosts_by_jobs\" type=\"hidden\" value=\"$CM_show_hosts_by_jobs\">";
} elsif ( $CM_diff_form ) {
	$CM_diff_form_hidden="<input name=\"CM_diff_form\" type=\"hidden\" value=\"1\">";
}

print "<tr><td><br><p><input type=\"hidden\" name=\"host_id\" value=\"$host_id\"><input name=\"host_order_by\" type=\"hidden\" value=\"$host_order_by\"><input type=\"hidden\" name=\"client_id\" value=\"$client_id\"><input type=\"hidden\" name=\"ip_version\" value=\"$ip_version\"><input type=\"hidden\" name=\"search_index\" value=\"$search_index\"><input type=\"hidden\" name=\"search_hostname\" value=\"$search_hostname\"><input type=\"hidden\" name=\"red_num\" value=\"$red_num\">$text_field_number_given_form $CM_show_hosts_hidden $CM_show_hosts_by_jobs_hidden $CM_diff_form_hidden<input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B1\" class=\"input_link_w_net\"></td><td></td></tr>\n";
print "</table>\n";
print "</form>\n";


print "<script type=\"text/javascript\">\n";
print "document.ip_mod_form.hostname.focus();\n";
print "</script>\n";

$gip->print_end("$client_id","$vars_file");

