#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel



use strict;
use DBI;
use lib '../modules';
use GestioIP;


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
	my $required_perms="manage_user_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


my $id = $daten{'id'};

# Parameter check
my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        id=>"$id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{update_user_group_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{update_user_group_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{formato_malo_message} 1") if ! $id;
$gip->print_error("$client_id","$$lang_vars{formato_malo_message} 2") if $id !~ /^\d{1,5}$/;

my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}

my $user=$ENV{'REMOTE_USER'};

my @clients = $gip->get_clients();
my @values_locations=$gip->get_loc("$client_id");
my @values_categorias=$gip->get_cat_net("$client_id");

my %values_user_groups=$gip->get_user_group_hash("$client_id");
my %values_user_group_perms=$gip->get_user_group_perms_hash("$client_id","$id");

my $name=$values_user_groups{$id}[0];
my $description=$values_user_groups{$id}[1] || "";

my ($manage_gestioip_perm_checked, $manage_user_perm_checked, $manage_sites_and_cats_perm_checked, $manage_custom_columns_perm_checked, $read_audit_perm_checked, $clients_perm_checked, $loc_perm_checked, $cat_perm_checked, $create_net_perm_checked, $read_net_perm_checked, $update_net_perm_checked, $delete_net_perm_checked, $create_host_perm_checked, $read_host_perm_checked, $update_host_perm_checked, $delete_host_perm_checked, $create_vlan_perm_checked, $read_vlan_perm_checked, $update_vlan_perm_checked, $delete_vlan_perm_checked, $read_device_config_perm_checked, $write_device_config_perm_checked, $administrate_cm_perm_checked, $create_as_perm_checked, $read_as_perm_checked, $update_as_perm_checked, $delete_as_perm_checked, $create_line_perm_checked, $read_line_perm_checked, $update_line_perm_checked, $delete_line_perm_checked);

$manage_gestioip_perm_checked=$manage_user_perm_checked=$manage_sites_and_cats_perm_checked=$manage_custom_columns_perm_checked=$read_audit_perm_checked=$clients_perm_checked=$loc_perm_checked=$cat_perm_checked=$create_net_perm_checked=$read_net_perm_checked=$update_net_perm_checked=$delete_net_perm_checked=$create_host_perm_checked=$read_host_perm_checked=$update_host_perm_checked=$delete_host_perm_checked=$create_vlan_perm_checked=$read_vlan_perm_checked=$update_vlan_perm_checked=$delete_vlan_perm_checked=$read_device_config_perm_checked=$write_device_config_perm_checked=$administrate_cm_perm_checked=$create_as_perm_checked=$read_as_perm_checked=$update_as_perm_checked=$delete_as_perm_checked=$create_line_perm_checked=$read_line_perm_checked=$update_line_perm_checked=$delete_line_perm_checked="";

$manage_gestioip_perm_checked="checked" if $values_user_group_perms{manage_gestioip_perm};
$manage_user_perm_checked="checked" if $values_user_group_perms{manage_user_perm};
$manage_sites_and_cats_perm_checked="checked" if $values_user_group_perms{manage_sites_and_cats_perm};
$manage_custom_columns_perm_checked="checked" if $values_user_group_perms{manage_custom_columns_perm};
$read_audit_perm_checked="checked" if $values_user_group_perms{read_audit_perm};
$loc_perm_checked="checked" if $values_user_group_perms{loc_perm};
$cat_perm_checked="checked" if $values_user_group_perms{cat_perm};
$create_net_perm_checked="checked" if $values_user_group_perms{create_net_perm};
$read_net_perm_checked="checked" if $values_user_group_perms{read_net_perm};
$update_net_perm_checked="checked" if $values_user_group_perms{update_net_perm};
$delete_net_perm_checked="checked" if $values_user_group_perms{delete_net_perm};
$create_host_perm_checked="checked" if $values_user_group_perms{create_host_perm};
$read_host_perm_checked="checked" if $values_user_group_perms{read_host_perm};
$update_host_perm_checked="checked" if $values_user_group_perms{update_host_perm};
$delete_host_perm_checked="checked" if $values_user_group_perms{delete_host_perm};
$create_vlan_perm_checked="checked" if $values_user_group_perms{create_vlan_perm};
$read_vlan_perm_checked="checked" if $values_user_group_perms{read_vlan_perm};
$update_vlan_perm_checked="checked" if $values_user_group_perms{update_vlan_perm};
$delete_vlan_perm_checked="checked" if $values_user_group_perms{delete_vlan_perm};
$read_device_config_perm_checked="checked" if $values_user_group_perms{read_device_config_perm};
$write_device_config_perm_checked="checked" if $values_user_group_perms{write_device_config_perm};
$administrate_cm_perm_checked="checked" if $values_user_group_perms{administrate_cm_perm};
$create_as_perm_checked="checked" if $values_user_group_perms{create_as_perm};
$read_as_perm_checked="checked" if $values_user_group_perms{read_as_perm};
$update_as_perm_checked="checked" if $values_user_group_perms{update_as_perm};
$delete_as_perm_checked="checked" if $values_user_group_perms{delete_as_perm};
$create_line_perm_checked="checked" if $values_user_group_perms{create_line_perm};
$read_line_perm_checked="checked" if $values_user_group_perms{read_line_perm};
$update_line_perm_checked="checked" if $values_user_group_perms{update_line_perm};
$delete_line_perm_checked="checked" if $values_user_group_perms{delete_line_perm};

my $clients_perm=$values_user_group_perms{clients_perm} || "9999";


print <<EOF;

<script type="text/javascript">
<!--
function mod_vals(VALUE){
   var num_values
   if( document.getElementById("client_perm_all").checked == true ){
    document.getElementById("client_perm_all").disabled=false;
    document.getElementById("client_perm").disabled=true;
    document.getElementById("client_perm").style.color="#F0EDEA";
    document.getElementById("client_perm").style.backgroundColor="#F0EDEA";
    num_values=document.getElementById("client_perm").options.length
    for(i=0;i<num_values;i++){
         document.getElementById("client_perm").options[i].selected=false;
         document.getElementById("client_perm").options[i].style.color="#F0EDEA";
    }
   } else {
    document.getElementById("client_perm_all").checked=false;
    document.getElementById("client_perm").disabled=false;
    document.getElementById("client_perm").style.backgroundColor="white";
    document.getElementById("client_perm").style.color="black";
    num_values=document.getElementById("client_perm").options.length
    for(i=0;i<num_values;i++){
         document.getElementById("client_perm").options[i].style.color="black";
    }
   }
}
//-->
</script>

EOF




print "<p>\n";
print "<form name=\"insert_user_group_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/ip_mod_user_group.cgi\"><br>\n";

print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";

print "<tr><td $align>$$lang_vars{name_message}</td><td $align1><input name=\"name\" value=\"$name\" type=\"text\" size=\"15\" maxlength=\"50\"></td></tr>\n";

print "<tr><td $align>$$lang_vars{description_message}</td><td $align1><input name=\"description\" value=\"$description\" type=\"text\" size=\"15\" maxlength=\"200\"></td></tr>\n";
print "</table>\n";

print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><b>$$lang_vars{global_permissions_message}</b></td><td></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";

print "<tr><td>$$lang_vars{manage_gestioip_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"manage_gestioip_perm\" $manage_gestioip_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{manage_user_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"manage_user_perm\" $manage_user_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{manage_sites_and_cats_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"manage_sites_and_cats_perm\" $manage_sites_and_cats_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{manage_custom_columns_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"manage_custom_columns_perm\" $manage_custom_columns_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_audit_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_audit_perm\" $read_audit_perm_checked></td></tr>\n";

if ( scalar(@clients) > 0 ) {
	my $size=1;
	$size=2 if scalar(@clients) == 2;
	$size=3 if scalar(@clients) >= 3;

	my ($all_clients_checked,$all_clients_disabled,$some_clients_disabled);
	$all_clients_checked="";
	$some_clients_disabled="";
	my $bg_color="";	
	my $color="black";	

	$clients_perm=~s/_/\|/;
	if ( $clients_perm =~ /^9999$/ ) {
		$all_clients_checked="checked";
		$some_clients_disabled="disabled";
		$bg_color="#F0EDEA";	
		$color="#F0EDEA";	
	}
	print "<tr><td>$$lang_vars{clients_message}</td>";
	print "<td><input type=\"checkbox\" value=\"9999\" name=\"clients_perm\" id=\"client_perm_all\" onchange=\"mod_vals(this.value);\" $all_clients_checked> $$lang_vars{all_clients_message}\n";

	print "<select name=\"clients_perm\" id=\"client_perm\" size=\"$size\" style=\"background-color:$bg_color; color:$color;\"  multiple $some_clients_disabled>";
	my $j=0;
	foreach (@clients) {
                if ( $clients[$j]->[0] =~ /^($clients_perm)$/ ) {
			print "<option value=\"$clients[$j]->[0]\" selected>$clients[$j]->[1]</option>";
		} else {
			print "<option value=\"$clients[$j]->[0]\">$clients[$j]->[1]</option>";
		}
		$j++;
	}
	print "</select>\n";
	print "</td></tr>";
}


#print "<tr><td>$$lang_vars{location_message}</td><td><select name=\"loc\" size=\"1\" $loc_perm_checked>";
#my $j=0;
#print "<option></option>";
#foreach (@values_locations) {
#	my $loc=$values_locations[$j]->[0];
#	if ( $loc eq "NULL" ) {
#		$j++;
#		next;
#	}
#        print "<option>$loc</option>";
#        $j++;
#}
#print "</select>\n";
#print "</td></tr>";
#
#print "<tr><td>$$lang_vars{cats_message}</td><td><select name=\"cat\" size=\"1\" $cat_perm_checked>";
#my $j=0;
#print "<option></option>";
#foreach (@values_categorias) {
#	my $cat=$values_categorias[$j]->[0];
#	if ( $cat eq "NULL" ) {
#		$j++;
#		next;
#	}
#        print "<option>$cat</option>";
#        $j++;
#}
#print "</select>\n";
#print "</td></tr>";
#


print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><b>$$lang_vars{client_permissions_message}</b></td><td></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><i><b>$$lang_vars{networks_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{create_net_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"create_net_perm\" $create_net_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_net_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_net_perm\" $read_net_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{update_net_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"update_net_perm\" $update_net_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{delete_net_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"delete_net_perm\" $delete_net_perm_checked></td></tr>\n";

print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><i><b>$$lang_vars{hosts1_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{create_host_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"create_host_perm\" $create_host_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_host_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_host_perm\" $read_host_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{update_host_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"update_host_perm\" $update_host_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{delete_host_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"delete_host_perm\" $delete_host_perm_checked></td></tr>\n";

print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><i><b>$$lang_vars{vlans_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{create_vlan_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"create_vlan_perm\" $create_vlan_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_vlan_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_vlan_perm\" $read_vlan_perm_checked ></td></tr>\n";
print "<tr><td>$$lang_vars{update_vlan_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"update_vlan_perm\" $update_vlan_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{delete_vlan_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"delete_vlan_perm\" $delete_vlan_perm_checked></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";

print "<tr><td><i><b>$$lang_vars{cm_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{read_device_config_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_device_config_perm\" $read_device_config_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{write_device_config_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"write_device_config_perm\" $write_device_config_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{administrate_cm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"administrate_cm_perm\" $administrate_cm_perm_checked></td></tr>\n";


print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><i><b>$$lang_vars{autonomous_systems_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{create_as_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"create_as_perm\" $create_as_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_as_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_as_perm\" $read_as_perm_checked ></td></tr>\n";
print "<tr><td>$$lang_vars{update_as_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"update_as_perm\" $update_as_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{delete_as_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"delete_as_perm\" $delete_as_perm_checked></td></tr>\n";

print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td><i><b>$$lang_vars{leased_lines_message}</b></i></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{create_line_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"create_line_perm\" $create_line_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{read_line_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"read_line_perm\" $read_line_perm_checked ></td></tr>\n";
print "<tr><td>$$lang_vars{update_line_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"update_line_perm\" $update_line_perm_checked></td></tr>\n";
print "<tr><td>$$lang_vars{delete_line_perm_message}</td><td> <input type=\"checkbox\" value=\"1\" name=\"delete_line_perm\" $delete_line_perm_checked></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";

print "</table>\n";

print "<p><br>\n";

print "<span style=\"float: $ori\"><br><p><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

print "<script type=\"text/javascript\">\n";
	print "document.insert_user_group_form.name.focus();\n";
print "</script>\n";


$gip->print_end("$client_id");
