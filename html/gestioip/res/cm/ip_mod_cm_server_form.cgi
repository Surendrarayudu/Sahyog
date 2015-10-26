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
        my $required_perms="administrate_cm_perm,read_device_config_perm,write_device_config_perm";
        $gip->check_perms (
                client_id=>"$client_id",
                vars_file=>"$vars_file",
                daten=>\%daten,
                required_perms=>"$required_perms",
        );
}

delete @ENV{'PATH', 'IFS', 'CDPATH', 'ENV', 'BASH_ENV'};

# Parameter check
my $id=$daten{'id'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        id=>"$id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{edit_cm_server_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{edit_cm_server_message}","$vars_file");

my $align="align='right'";
my $align1="";
my $ori="left";
my $rtl_helper="<font color='white'>x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align='left'";
	$align1="align='right'";
	$ori="right";
}

my $disabled_color='#F0EDEA';

my $hide1="$$lang_vars{username_message}";
my $hide2="<input name=\\\"cm_server_user\\\" type=\\\"text\\\" size=\\\"15\\\" maxlength=\\\"50\\\" value=\\\"\\\">";
my $hide3="$$lang_vars{password_message}";
my $hide4="<input name=\\\"cm_server_pass\\\" type=\\\"password\\\" size=\\\"15\\\" maxlength=\\\"50\\\" value=\\\"\\\">";

print <<EOF;
<script type="text/javascript">
<!--
function mod_cm_fields(VALUE){
	if ( VALUE == "ftp" || VALUE == "scp" || VALUE == "rcp" ) {
		document.getElementById('Hide1').innerHTML = "$hide1";
		document.getElementById('Hide2').innerHTML = "$hide2";
		document.getElementById('Hide3').innerHTML = "$hide3";
		document.getElementById('Hide4').innerHTML = "$hide4";
	} else if ( VALUE == "scp rsa" ) {
		document.getElementById('Hide1').innerHTML = "$hide1";
		document.getElementById('Hide2').innerHTML = "$hide2";
		document.getElementById('Hide3').innerHTML = "<span id='Hide1'></span>";
		document.getElementById('Hide4').innerHTML = "<span id='Hide2'></span>";
	} else {
		document.getElementById('Hide1').innerHTML = "";
		document.getElementById('Hide2').innerHTML = "";
		document.getElementById('Hide3').innerHTML = "";
		document.getElementById('Hide4').innerHTML = "";
	}
}

//-->
</script>

<script type="text/javascript">
<!--
function mod_gip_server_ip(VALUE){
        if ( VALUE == "gip_server" ) {
                document.getElementById('ip').disabled = false;
                document.getElementById('ip').style.backgroundColor = "white";
                document.getElementById('ip').style.color = "black";
                document.getElementById('ip_man').disabled = true;
        } else {
                document.getElementById('ip').disabled = true;
                document.getElementById('ip').style.backgroundColor = "$disabled_color";
                document.getElementById('ip').style.color = "$disabled_color";
                document.getElementById('ip_man').disabled = false;
        }
}

//-->
</script>

EOF


$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $id;

my %values_cm_server=$gip->get_cm_server_hash("$client_id");
my $name=$values_cm_server{$id}[0];
my $ip=$values_cm_server{$id}[1];
my $type=$values_cm_server{$id}[2];
my $cm_server_root=$values_cm_server{$id}[3];
my $description=$values_cm_server{$id}[4];
my $cm_server_user=$values_cm_server{$id}[6];
my $cm_server_pass=$values_cm_server{$id}[7];

my %ips=$gip->exec_ip_open();

print "<p>\n";
print "<form name=\"mod_cm_server_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_mod_cm_server.cgi\"><br>\n";
print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";

print "<tr><td $align>$$lang_vars{name_message}</td><td $align1><input name=\"name\" type=\"text\" size=\"15\" maxlength=\"50\" value=\"$name\"></td></tr>\n";

if ( $ips{error} ) {
	print STDERR "ERROR executing \"ip addr\" - $ips{error}\n";
	print "<tr><td $align>$$lang_vars{ip_address_message}</td><td $align1><input name=\"ip\" type=\"text\"  size=\"15\" maxlength=\"50\"></td></tr>\n";
} else {
	my $ip_select_disabled="disabled";
	my $ip_select_backgroundcolor="$disabled_color";
	my $ip_man_disabled="";
	my $gip_server_ip_select_checked="";
	my $gip_server_ip_man_checked="checked";
	my $gip_server_ip_man_value="$ip";
	for my $key(keys %ips ) {
		if ( $ip eq $key ) {
			$ip_select_disabled="";
			$ip_select_backgroundcolor="white";
			$ip_man_disabled="disabled";
			$gip_server_ip_select_checked="checked";
			$gip_server_ip_man_checked="";
			$gip_server_ip_man_value="";
			last;
		}
	}

	print "<tr><td colspan=\"2\">$$lang_vars{use_gip_server_ip_message} <input name=\"gip_server_ip\" type=\"radio\" value=\"gip_server\" onclick=\"mod_gip_server_ip(this.value);\" $gip_server_ip_select_checked> $$lang_vars{use_other_ip_message} <input name=\"gip_server_ip\" type=\"radio\" value=\"other_ip\" onclick=\"mod_gip_server_ip(this.value);\" $gip_server_ip_man_checked> $$lang_vars{only_for_natted_address_message}</td></tr>\n";


	print "<tr><td $align>$$lang_vars{ip_address_message}</td><td $align1><select name=\"ip\" id=\"ip\" size=\"1\" style=\"background-color:$ip_select_backgroundcolor\" $ip_select_disabled>\n";
	print "<option></option>";
	for my $key(keys %ips ) {
		next if $key eq "error";
		if ( $ip eq $key ) {
			print "<option selected>$key</option>";
		} else {
			print "<option>$key</option>";
		}
	}
	print "</select>";
	print "</td></tr>";
	print "<tr><td $align>$$lang_vars{ip_address_message}</td><td $align1><input name=\"ip\" id=\"ip_man\" type=\"text\" size=\"15\" maxlength=\"50\" value=\"$gip_server_ip_man_value\" $ip_man_disabled></td></tr>\n";
}


my @cm_cm_server_type_values=("tftp","scp","ftp");
print "<tr><td $align>$$lang_vars{cm_server_type_message}</td><td><font size=\"2\"><select name=\"cm_server_type\" size=\"1\" onchange=\"mod_cm_fields(this.value);\">";
print "<option></option>";
foreach (@cm_cm_server_type_values) {
	if ( $_ eq $type ) {
		print "<option selected>$_</option>";
	} else {
		print "<option>$_</option>";
	}
}
print "</select>";
print "</td></tr>";

if ( $type eq "ftp" || $type eq "scp" || $type eq "rcp" ) {
	print "<tr><td $align><span id='Hide1'>$$lang_vars{username_message}</span></td><td $align1><span id='Hide2'><input name=\"cm_server_user\" type=\"text\" size=\"15\" maxlength=\"30\" value=\"$cm_server_user\"></span></td></tr>\n";
	print "<tr><td $align><span id='Hide3'>$$lang_vars{password_message}</span></td><td $align1><span id='Hide4'><input name=\"cm_server_pass\" type=\"password\" size=\"15\" maxlength=\"30\" value=\"$cm_server_pass\"></span></td></tr>\n";
} elsif ( $type eq "scp rsa" ) {
	print "<tr><td $align><span id='Hide1'>$$lang_vars{username_message}</span></td><td $align1><span id='Hide2'><input name=\"cm_server_user\" type=\"text\" size=\"15\" maxlength=\"30\" value=\"$cm_server_user\"></span></td></tr>\n";
	print "<tr><td $align><span id='Hide3'></span></td><td $align1><span id='Hide4'></span></td></tr>\n";
} else {
	print "<tr><td $align><span id='Hide1'></span></td><td $align1><span id='Hide2'></span></td></tr>\n";
	print "<tr><td $align><span id='Hide3'></span></td><td $align1><span id='Hide4'></span></td></tr>\n";
}

print "<tr><td $align>$$lang_vars{tftp_root_message}</td><td $align1><input name=\"cm_server_root\" type=\"text\" size=\"15\" maxlength=\"200\" value=\"$cm_server_root\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{description_message}</td><td $align1><input name=\"cm_server_description\" type=\"text\" size=\"15\" maxlength=\"200\" value=\"$description\"></td></tr>\n";

print "</table>\n";

print "<p>\n";

print "<script type=\"text/javascript\">\n";
	print "document.mod_cm_server_form.name.focus();\n";
print "</script>\n";

print "<span style=\"float: $ori\"><br><p><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

$gip->print_end("$client_id");

