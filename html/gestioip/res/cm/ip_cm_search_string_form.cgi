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
my $error_message=$gip->check_parameters(
	vars_file=>"$vars_file",
	client_id=>"$client_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{search_string_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{search_string_message}","$vars_file");


my $cm_enabled_db=$global_config[0]->[8] || "";
my $cm_licence_key_db=$global_config[0]->[10] || "";
my $cm_xml_dir=$global_config[0]->[12] || "";

my %values_device_type_groups=$gip->get_device_type_values("$client_id","$cm_xml_dir");


my %job_groups=$gip->get_job_groups("$client_id");


my $disabled_color='#F0EDEA';

print <<EOF;

<script type="text/javascript">
<!--
function changerows(ID) {
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

var DJ='device_job'
if ( value != '' ) {
  document.getElementById(DJ).disabled=false
  document.getElementById(DJ).style.backgroundColor='white';
  for(i=0;i<values_job_names.length;i++){
    document.getElementById(DJ).options[i].text=values_job_descr[i]
    document.getElementById(DJ).options[i].value=values_job_names[i]
  }
} else {
  document.getElementById(DJ).disabled=true
  document.getElementById(DJ).style.backgroundColor='$disabled_color';
}
document.getElementById(DJ).options[0].selected=true

}
-->
</script>

EOF




print "<p><br>\n";
print "<form name=\"show_job_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_search_string.cgi\">\n";
print "<table border=\"0\" cellpadding=\"1\">\n";

print "<tr><td>$$lang_vars{device_type_group_message}</td><td>";
if ( scalar keys %values_device_type_groups >= 1 ) {
	print "<select name=\"device_type_group_id\" id=\"device_type_group_id\" size=\"1\" onchange=\"changerows(this);\">";
	print "<option></option>\n";
	for my $key ( sort { $values_device_type_groups{$a}[0] cmp $values_device_type_groups{$b}[0] } keys %values_device_type_groups ) {
		my $device_type_group_name=$values_device_type_groups{$key}[0];
		print "<option value=\"$key\">$device_type_group_name</option>\n";
	}
	print "</select>\n";
} else {
	print "&nbsp;<font color=\"gray\"><input name=\"device_type_group_id\" type=\"hidden\" value=\"\"><i>$$lang_vars{no_device_type_group_message}</i></font>\n";
	}

print "</td></tr><tr><td>\n";
print "$$lang_vars{job_message}\n";
print "</td><td>\n";

print "<select name=\"device_job\" id=\"device_job\" size=\"1\" style=\"background-color:$disabled_color; width: 230px;\" disabled>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "<option></option>\n";
print "</select>\n";
print "</td></tr>\n";


print "<tr><td>$$lang_vars{job_group_message}</td><td>";
#print "<select name=\"job_group\" id=\"job_group\" size=\"1\" style=\"background-color:$enable_cm_bg_color;\" $enable_cm_disabled>";
print "<select name=\"job_group\" id=\"job_group\" size=\"1\">";
print "<option></option>\n";
for my $job_group_all_id ( sort keys %job_groups ) {
	my $job_group_name=$job_groups{$job_group_all_id}[0];
	print "<option value=\"$job_group_all_id\">$job_group_name</option>\n";
}
print "</select>\n";


print "</td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";

print "<tr><td>$$lang_vars{search_string_message}</td><td><input type=\"text\" value=\"\" name=\"search_string\"></td></tr>\n";
print "<tr><td><br></td><td></td></tr>\n";
print "<tr><td>$$lang_vars{only_last_configs_message}</td><td><input type=\"checkbox\" value=\"1\" name=\"only_last_configs\" checked></td></tr>\n";

print "<tr><td><br><input name=\"config\" type=\"hidden\" value=\"all\"><input type=\"submit\" value=\"$$lang_vars{submit_message}\" name=\"B2\" class=\"input_link_w_net\"></td></tr>\n";
print "</td></tr></table>\n";

print "</form>\n";

$gip->print_end("$client_id","$vars_file");

