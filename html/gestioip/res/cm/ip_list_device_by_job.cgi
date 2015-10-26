#!/usr/bin/perl -T -w


# Copyright (C) 2014 Marc Uebel


use strict;
use DBI;
use Net::IP;
use Net::IP qw(:PROC);
use lib '../../modules';
use GestioIP;
use Math::BigInt;
use POSIX;

my $daten=<STDIN>;
my $gip = GestioIP -> new();
my %daten=$gip->preparer("$daten") if $daten;

my $server_proto=$gip->get_server_proto();
my $base_uri = $gip->get_base_uri();

# Parameter check
my $client_id = $daten{'client_id'} || $gip->get_first_client_id();;
my $ip_version=$daten{'ip_version'} || "v4";

my $lang = $daten{'lang'} || "";
$lang="en" if $lang !~ /^\w{1,3}$/;
my $entries_per_page_hosts=$daten{'entries_per_page_hosts'} || 254;
my $start_entry_hosts=$daten{'start_entry_hosts'} || 0;
my $job_group_id=$daten{'job_group'} || 0;

my ($lang_vars,$vars_file);
($lang_vars,$vars_file,$entries_per_page_hosts)=$gip->get_lang("$entries_per_page_hosts","$lang");

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        ip_version=>"$ip_version",
        start_entry_hosts=>"$start_entry_hosts",
        job_group=>"$job_group_id",
) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{redes_dispo_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


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


#Set global variables
$gip->{CM_show_hosts_by_jobs} = $job_group_id;


my $host_order_by = $daten{'host_order_by'} || "IP_auf";

$start_entry_hosts = Math::BigInt->new("$start_entry_hosts");

if ( defined($daten{'text_field_number_given'}) ) {
	$start_entry_hosts=$start_entry_hosts * $entries_per_page_hosts - $entries_per_page_hosts;
	$start_entry_hosts = 0 if $start_entry_hosts < 0;
}


my ( $first_ip_int, $last_ip_int, $last_ip_int_red, $start_entry);
$first_ip_int=$last_ip_int=$last_ip_int_red=$start_entry="";

my $align="align=\"right\"";
my $align1="";
my $ori="left";
if ( $vars_file =~ /vars_he$/ ) {
	$align="align=\"left\"";
	$align1="align=\"right\"";
	$ori="right";
}


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{cm_hosts_message}","$vars_file");

$gip->print_error("$client_id","$$lang_vars{formato_malo_message} (1)") if ! $job_group_id;

my $knownhosts = "all";

#my $host_hash_ref=$gip->get_host_hash_cm(
#	vars_file=>"$vars_file",
#	ip_version=>"$ip_version",
#	client_id=>"$client_id",
#	host_order_by=>"$host_order_by",
#) || "";

#my ($host_hash_ref,$host_sort_helper_array_ref)=$gip->get_host_hash("$client_id","","","$host_order_by","","","","CM");
my ($host_hash_ref)=$gip->get_devices_from_job_number("$client_id","$job_group_id","$host_order_by");


my $anz_host_total = keys %$host_hash_ref;


my $pages_links=$gip->get_pages_links_cm(
	vars_file=>"$vars_file",
	ip_version=>"$ip_version",
	client_id=>"$client_id",
	anz_host_total=>$anz_host_total,
	entries_per_page_hosts=>"$entries_per_page_hosts",
	start_entry_hosts=>"$start_entry_hosts",
	host_order_by=>"$host_order_by",
) || "";


$host_hash_ref=$gip->prepare_host_hash_cm(
	vars_file=>"$vars_file",
	ip_version=>"$ip_version",
	client_id=>"$client_id",
	host_hash_ref=>$host_hash_ref,
	entries_per_page_hosts=>"$entries_per_page_hosts",
	start_entry_hosts=>"$start_entry_hosts",
	host_order_by=>"$host_order_by",
);



if ( $anz_host_total > 0 ) {
	my @values_entries_per_page_hosts = ("20","50","100","254","508","1016");
	print "<table border='0'><tr><td>";
	print "<form name=\"print_cm_hosts_head_form\" method=\"POST\" action=\"$server_proto://$base_uri/ip_show_cm_hosts.cgi\" style=\"display:inline\">\n";
	print "&nbsp;&nbsp;&nbsp;$$lang_vars{entradas_por_pagina_nowrap_message} <select name=\"entries_per_page_hosts\" size=\"1\">";
	my $i = "0";
	foreach (@values_entries_per_page_hosts) {
		if ( $_ eq $entries_per_page_hosts ) {
			print "<option selected>$values_entries_per_page_hosts[$i]</option>";
			$i++;
			next;
		}
		print "<option>$values_entries_per_page_hosts[$i]</option>";
		$i++;
	}
	print "</select>\n";
	print "<input type=\"hidden\" name=\"ip_version\" value=\"$ip_version\"><input name=\"client_id\" type=\"hidden\" value=\"$client_id\"><input name=\"start_entry_hosts\" type=\"hidden\" value=\"$start_entry_hosts\"><input name=\"host_order_by\" type=\"hidden\" value=\"$host_order_by\">\n";


	print "<input type=\"submit\" value=\"\" name=\"B2\" class=\"filter_button\"></form>\n";
	print "</td>";

	print "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$pages_links</td>\n" if $pages_links ne "NO_LINKS"; 

	print "</tr></table>\n\n";


	$gip->PrintIpTab("$client_id",$host_hash_ref,"$first_ip_int","$last_ip_int","res/ip_modip_form.cgi","$knownhosts","$$lang_vars{modificar_message}","","","$vars_file","$anz_host_total","$start_entry_hosts","$entries_per_page_hosts","$host_order_by","","","$ip_version","","","");
} else {
	my %job_groups=$gip->get_job_groups("$client_id");
	my $job_group_name=$job_groups{$job_group_id}[0];
	print "<p><br><i><b>$job_group_name</b>: $$lang_vars{no_cm_devices_job_id_message}</i><br>\n";
}

$gip->print_end("$client_id","$vars_file","go_to_top");
