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


# Parameter check
my $id = $daten{'id'};

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        id=>"$id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{update_user_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{update_user_message}","$vars_file");

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
my %values_user_groups=$gip->get_user_group_hash("$client_id");
my %values_users=$gip->get_user_hash("$client_id");

if ( ! %values_user_groups ) {
	print "<p><br>$$lang_vars{no_user_group_define_message}<br>";
	print "<p><br><p><FORM><INPUT TYPE=\"BUTTON\" VALUE=\"$$lang_vars{atras_message}\" ONCLICK=\"history.go(-1)\" class=\"error_back_link\"></FORM><p><br>\n";
	$gip->print_end("$client_id");
}

my $name=$values_users{$id}[0];
my $group_id=$values_users{$id}[1] || "";
my $phone=$values_users{$id}[2] || "";
my $email=$values_users{$id}[3] || "";
my $comment=$values_users{$id}[4] || "";


print "<p>\n";
print "<form name=\"insert_user_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/ip_mod_user.cgi\"><br>\n";
print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";

print "<tr><td $align>$$lang_vars{name_message}</td><td $align1><input name=\"name\" value=\"$name\" type=\"text\" size=\"15\" maxlength=\"50\"></td></tr>\n";

print "<tr><td>$$lang_vars{user_group_message}</td><td><font size=\"2\"><select name=\"group_id\" size=\"1\">";
print "<option></option>";
while ( my ($key, @value) = each(%values_user_groups) ) {
                my $name=$value[0]->[0];
                my $group_id_select=$key;
		if ( $group_id == $group_id_select ) { 
			print "<option value=\"$group_id_select\" selected>$name</option>";
		} else {
			print "<option value=\"$group_id_select\">$name</option>";
		}
}
print "</select>";
print "</td></tr>";


print "<tr><td $align>$$lang_vars{mail_message}</td><td $align1><input name=\"email\" value=\"$email\" type=\"text\" size=\"15\" maxlength=\"200\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{phone_message}</td><td $align1><input name=\"phone\" value=\"$phone\" type=\"text\" size=\"15\" maxlength=\"200\"></td></tr>\n";
print "<tr><td $align>$$lang_vars{comentario_message}</td><td $align1><input name=\"comment\" value=\"$comment\" type=\"text\" size=\"15\" maxlength=\"200\"></td></tr>\n";

print "</table>\n";

print "<p>\n";

print "<script type=\"text/javascript\">\n";
	print "document.insert_user_form.name.focus();\n";
print "</script>\n";

print "<span style=\"float: $ori\"><br><p><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"submit\" value=\"$$lang_vars{cambiar_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

$gip->print_end("$client_id");
