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
	my $required_perms="administrate_cm_perm";
	$gip->check_perms (
		client_id=>"$client_id",
		vars_file=>"$vars_file",
		daten=>\%daten,
		required_perms=>"$required_perms",
	);
}


# Parameter check
my $id = $daten{'id'};

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        device_user_group_id=>"$client_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{device_user_group_edit_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{device_user_group_edit_message}","$vars_file");


my %values_device_user_groups=$gip->get_device_user_groups_hash("$client_id");

my $device_user_group_name=$values_device_user_groups{$id}[0];
my $device_user_name=$values_device_user_groups{$id}[1];
my $login_pass=$values_device_user_groups{$id}[2] || "";
my $retype_login_pass=$values_device_user_groups{$id}[2] || "";
my $priv_pass=$values_device_user_groups{$id}[3] || "";
my $retype_priv_pass=$values_device_user_groups{$id}[3] || "";
my $description=$values_device_user_groups{$id}[4] || "";


my $align="align=\"right\"";
my $align1="";
my $ori="left";
my $rtl_helper="<font color=\"white\">x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}



print "<p>\n";
print "<form name=\"insert_user_group_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_mod_user_group.cgi\"><br>\n";
print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";

print "<tr><td $align>$$lang_vars{device_user_group_name_message}</td><td $align1><input name=\"device_user_group_name\" type=\"text\"  size=\"12\" maxlength=\"20\" value=\"$device_user_group_name\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{device_user_name_message}</td><td $align1><input name=\"device_user_name\" type=\"text\"  size=\"12\" maxlength=\"30\" value=\"$device_user_name\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{login_pass_message}</td><td $align1><input name=\"login_pass\" type=\"password\" size=\"12\" maxlength=\"500\" value=\"$login_pass\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{retype_login_pass_message}</td><td $align1><input name=\"retype_login_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$login_pass\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{priv_mode_pass_message}</td><td $align1><input name=\"priv_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$priv_pass\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{retype_priv_pass_message}</td><td $align1><input name=\"retype_priv_pass\" type=\"password\" size=\"12\" maxlength=\"30\" value=\"$priv_pass\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{description_message}</td><td $align1><input name=\"description\" type=\"text\" size=\"30\" maxlength=\"500\" value=\"$description\"></td></tr>\n";


print "</table>\n";

print "<p>\n";

print "<script type=\"text/javascript\">\n";
	print "document.insert_user_group_form.device_user_group_name.focus();\n";
print "</script>\n";

print "<span style=\"float: $ori\"><br><p><input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

$gip->print_end("$client_id");
