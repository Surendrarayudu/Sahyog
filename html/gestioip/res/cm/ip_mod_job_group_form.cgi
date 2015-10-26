#!/usr/bin/perl -w -T

# Copyright (C) 2013 Marc Uebel

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
my $id=$daten{'id'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        id=>"$id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{edit_job_group_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{edit_job_group_message}","$vars_file");

my $align="align='right'";
my $align1="";
my $ori="left";
my $rtl_helper="<font color='white'>x</font>";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align='left'";
	$align1="align='right'";
	$ori="right";
}


$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $id;

my %job_groups=$gip->get_job_groups("$client_id");
my $name=$job_groups{$id}[0];
my $description=$job_groups{$id}[1];

print "<p>\n";
print "<form name=\"mod_job_group_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_mod_job_group.cgi\"><br>\n";
print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";

print "<tr><td $align>$$lang_vars{name_message}</td><td $align1><input name=\"name\" type=\"text\" size=\"15\" maxlength=\"50\" value=\"$name\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{description_message}</td><td $align1><input name=\"description\" type=\"text\" size=\"15\" maxlength=\"100\" value=\"$description\"></td></tr>\n";

print "</table>\n";

print "<p>\n";

print "<script type=\"text/javascript\">\n";
	print "document.mod_job_group_form.name.focus();\n";
print "</script>\n";

print "<span style=\"float: $ori\"><br><p><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

$gip->print_end("$client_id");

