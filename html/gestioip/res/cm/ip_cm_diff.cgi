#!/usr/bin/perl -w -T

# Copyright (C) 2014 Marc Uebel

# This program is distributed under the Creative Commons Attribution-NonCommercial-NoDerivatives
# 4.0 International License.
# Visit http://creativecommons.org/licenses/by-nc-nd/4.0/ for details.

use strict;
use DBI;
use lib '../../modules';
use GestioIP;
use Text::Diff;
use File::Compare;



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
my $hostname = $daten{'hostname'} || "";
my $host_id = $daten{'host_id'} || "";
my $host_id1 = $daten{'host_id1'} || "";
my $host_id2 = $daten{'host_id2'} || "";
my $job_id = $daten{'job_id'} || "";
my $job_id1 = $daten{'job_id1'} || "";
my $job_id2 = $daten{'job_id2'} || "";
my $diff_config_1 = $daten{'diff_config_1'} || "";
my $diff_config_2 = $daten{'diff_config_2'} || "";

my $error_message=$gip->check_parameters(
        vars_file=>"$vars_file",
        client_id=>"$client_id",
        hostname=>"$hostname",
        host_id=>"$host_id",
        host_id1=>"$host_id1",
        host_id2=>"$host_id2",
        diff_config_1=>"$diff_config_1",
        diff_config_2=>"$diff_config_2",
        job_id1=>"$job_id1",
        job_id2=>"$job_id2",

) || "";

$gip->print_error_with_head(title=>"$$lang_vars{gestioip_message}",headline=>"$$lang_vars{diff_configs_jo_message}",notification=>"$error_message",vars_file=>"$vars_file",client_id=>"$client_id") if $error_message;


$gip->CheckInput("$client_id",\%daten,"$$lang_vars{mal_signo_error_message}","$$lang_vars{diff_configs_jo_message} $hostname","$vars_file");

my $client_name=$gip->get_client_from_id("$client_id");
my $cm_backup_dir=$global_config[0]->[9] . "/" . $client_name;
if ( ! $cm_backup_dir ) {
	$gip->print_error("$client_id","$$lang_vars{no_cm_config_dir_message}");
}

my ($conf1,$conf2,$configs1,$configs2);
my @configs1=();
my @configs2=();
if ( $host_id ) {
	$conf1=$cm_backup_dir . "/" . $host_id . "/" . $diff_config_1;
	$conf2=$cm_backup_dir . "/" . $host_id . "/" . $diff_config_2;
	$configs1=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id}","$job_id");
	@configs1=@$configs1;
	@configs2=@configs1;
} elsif ( $host_id1 && $host_id2 ) {
	$conf1=$cm_backup_dir . "/" . $host_id1 . "/" . $diff_config_1;
	$conf2=$cm_backup_dir . "/" . $host_id2 . "/" . $diff_config_2;
	$configs1=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id1}","$job_id1");
	@configs1=@$configs1;
	$configs2=$gip->get_file_list("$client_id","${cm_backup_dir}/${host_id2}","$job_id2");
	@configs2=@$configs2;
}


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
if ( scalar @configs1 == 0 ) {
# TEST TEST TEST
	print "<p><b>$$lang_vars{no_device_configuration_message}</b><br>\n";
	$gip->print_end("$client_id");
} else {
		
	print "<form name=\"diff_config_form\" method=\"POST\" action=\"$server_proto://$base_uri/res/cm/ip_cm_diff.cgi\"><br>\n";
	#print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\"><tr><td>\n";

	print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">\n";
	print "<tr><td><b>$$lang_vars{configuratio_I_message}</b></td><td></td><td><b>$$lang_vars{configuratio_II_message}</b></td></tr>\n";


	print "<tr valign=\"top\"><td><font size=\"2\"><select name=\"diff_config_1\" size=\"1\">";
	foreach my $config_name (@configs1) {
		my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
		if ( $config_name eq $diff_config_1 ) {
			print "<option value=\"$config_name\" selected>$date_form ($serial)</option>";
		} else {
			print "<option value=\"$config_name\">$date_form ($serial)</option>";
		}
	}
	print "</select>\n";

	print "</td><td> </td><td>\n";

	print "<font size=\"2\"><select name=\"diff_config_2\" size=\"1\">";
	foreach my $config_name (@configs2) {
		my ($date_form,$serial,$hid,$jid)=$gip->get_config_name_values("$config_name");
		if ( $config_name eq $diff_config_2 ) {
			print "<option value=\"$config_name\" selected>$date_form ($serial)</option>";
		} else {
			print "<option value=\"$config_name\">$date_form ($serial)</option>";
		}
	}
	print "</select>\n";
	print "</td><td>\n";
	print "<span style=\"float: $ori\"><input type=\"hidden\" value=\"$host_id\" name=\"host_id\"><input type=\"hidden\" value=\"$host_id1\" name=\"host_id1\"><input type=\"hidden\" value=\"$host_id2\" name=\"host_id2\"><input type=\"hidden\" value=\"$hostname\" name=\"hostname\"><input type=\"hidden\" value=\"$client_id\" name=\"client_id\"><input type=\"submit\" value=\"$$lang_vars{diff_message}\" name=\"B2\" class=\"input_link_w_net\"></form></span><br><p>\n";

	print "</td></tr>\n";

	#print "<tr><td $align>$$lang_vars{description_message}</td><td $align1><input name=\"description\" type=\"text\" size=\"30\" maxlength=\"500\"></td></tr>\n";


	print "</table>\n";
}

print "<p>\n";

if ( $diff_config_1 eq $diff_config_2) {
	print "$$lang_vars{same_config_files_message}<br><p>\n";
	$gip->print_end("$client_id");
	exit 0;
}

my $return_value=compare("$conf1","$conf2");
if ( $return_value == 0 ) {
	print "<p><br><b>$conf1</b> and <b>$conf2</b> $$lang_vars{not_differ_message}</b>";
	$gip->print_end("$client_id");
	exit 0;
}


#$diff_config_1 =~ /^(\d{12})_(\d{2})_(\d+)\.(.+)(\..+)*$/;
$diff_config_1 =~ /^(\d{12})_(\d{2,3})_(\d+)_(\d+)\./;
my $date1=$1;
my $serial1=$2;
#$diff_config_2 =~ /^(\d{12})_(\d{2})_(\d+)\.(.+)(\..+)*$/;
$diff_config_2 =~ /^(\d{12})_(\d{2,3})_(\d+)_(\d+)\./;
my $date2=$1;
my $serial2=$2;
my $conf1_show=$conf1;
my $conf2_show=$conf2;
if ( $date1 > $date2 ) {
	$conf1_show.=" (" . $$lang_vars{newer_message} . ")";
	$conf2_show.=" (" . $$lang_vars{older_message} . ")";
} elsif ( $date1 > $date2 ) {
	$conf1_show.=" (" . $$lang_vars{older_message} . ")";
	$conf2_show.=" (" . $$lang_vars{newer_message} . ")";
} elsif ( $date2 > $date1 ) {
	if ( $serial1 > $serial2 ) {
		$conf1_show.=" (" . $$lang_vars{newer_message} . ")";
		$conf2_show.=" (" . $$lang_vars{older_message} . ")";
	} else {
		$conf1_show.=" (" . $$lang_vars{older_message} . ")";
		$conf2_show.=" (" . $$lang_vars{newer_message} . ")";
	}
}


#"Unified", "Context", "OldStyle"
my $diff = diff "$conf1", "$conf2", { STYLE => "Context", CONTEXT=>"10000" };
#my $diff = diff "$conf1", "$conf2", { STYLE => "Context" };
my $diff_oldstyle = diff "$conf1", "$conf2", { STYLE => "OldStyle" };
#my $diff = diff "$conf1", "$conf2", { STYLE => "Unified" };

my @diff_oldstyle = split('\n',$diff_oldstyle);

print "<table border=\"1\" cellpadding=\"5\" cellspacing=\"2\">\n";
print "<tr><td><b><span style=\"color: green;\">&lt;$conf1_show<span><br><span style=\"color: brown;\">&gt;$conf2_show</span></b><p>";
foreach my $ele( @diff_oldstyle ) {
	if ( $ele =~ /^</ ) {
		print "<span style=\"color: green;\">$ele</span><br>\n";
	} elsif ( $ele =~ /^>/ ) {
		print "<span style=\"color: brown;\">$ele</span><br>\n";
	} else {
		print "$ele<br>\n";
	}
}
print "</td></tr>\n";
print "</table><p>\n";

my @diff = split('\n',$diff);

#foreach my $ele1( @diff ) {
#	print "TEST: $ele1<br>\n";
#}

my $conf1_diff=shift @diff;
my $conf2_diff=shift @diff;
my $star_line=shift @diff;
my $first_lines_line=shift @diff;
my $first_lines="";
if ($first_lines_line =~ /^\*\*\* (\d+,\d+) \*\*\*\*$/ ) {
	$first_lines_line =~ /^\*\*\* (\d+,\d+) \*\*\*\*$/;
	$first_lines=$1;
} elsif ($first_lines_line =~ /^\*\*\* (\d+) \*\*\*\*$/ ) {
	$first_lines_line =~ /^\*\*\* (\d+) \*\*\*\*$/;
	$first_lines=$1;
}

my $ele;
my $i=0;
my $table_helper=0;

print "<table border=\"1\" cellpadding=\"5\" cellspacing=\"2\"  style=\"width:100%; table-layout:fixed; word-wrap:break-word;\">\n";
#print "<tr><td><span style=\"word-wrap:break-word;\"><b>$conf1_show</b></span></td><td><b>$conf2_show</b></td></tr>\n";
print "<tr><td><b>$conf1_show</b></td><td><b>$conf2_show</b></td></tr>\n";
print "<tr><td valign=\"top\">\n";

my $firstrun=0;
my $line_count_1=0;
my $line_count_2=0;
my $actual_file=1;
foreach $ele( @diff ) {
        if ( $ele eq "***************" ) {
		$i++;
		next;
	}
        if ( ( $ele =~ /^\*\*\* \d+,\d+ \*\*\*\*$/ && $diff[$i-1] eq "***************" ) || ( $ele =~ /^\*\*\* \d+ \*\*\*\*$/ && $diff[$i-1] eq "***************" ) ) {
		my $lines="";
		if ( $ele =~ /^\*\*\* (\d+,\d+) \*\*\*\*$/ ) {
			$ele =~ /^\*\*\* (\d+,\d+) \*\*\*\*$/;
			$lines=$1;
		} elsif ( $ele =~ /^\*\*\* (\d+) \*\*\*\*$/ ) {
			$ele =~ /^\*\*\* (\d+) \*\*\*\*$/;
			$lines=$1;
		}
		print "</td></tr><tr><td valign=\"top\">\n";
		print"<i>$lines</i><br>\n";
		$actual_file=1;
		$i++;
		next;
        } elsif ( $ele =~ /^--- \d+,\d+ ----$/ || $ele =~ /^--- \d+ ----$/ ) {
		my $lines="";
		if ( $ele =~ /^--- (\d+,\d+) ----$/ ) {
			$ele =~ /^--- (\d+,\d+) ----$/;
			$lines=$1;
		} elsif ( $ele =~ /^--- (\d+) ----$/ ) {
			$ele =~ /^--- (\d+) ----$/;
			$lines=$1;
		}
		print "</td><td valign=\"top\">\n";
		print"$lines<br>\n";
		$actual_file=2;
		$i++;
		next;

        }
	if ( $firstrun == 0 ) {
		print"$first_lines</i><br>\n";
		$firstrun=1;
	}

	if ( $actual_file == 1 ) {
		$line_count_1++;
		print "<font color=\"gray\"><i>$line_count_1 </i></font> ";
	} else {
		$line_count_2++;
		print "<font color=\"gray\"><i>$line_count_2 </i></font> ";
	}

	if ( $ele =~ /^\+/ ) {
		print "<span style=\"color: green; background: lightgreen;\">$ele</span><br>";
	} elsif ( $ele =~ /^-/ ) {
		print "<span style=\"color: red; background: pink;\">$ele</span><br>";
	} elsif ( $ele =~ /^!/ ) {
		print "<span style=\"color: brown; background: khaki;\">$ele</span><br>";
	} else {
		print "$ele<br>";
	}
	$i++;
}

print "</td></tr>\n";
print "</table>\n";

#print <<EOF;
#<pre>
#TEST: DIFF: $conf1 - $conf2
#
#$diff_oldstyle

#$diff;
#</pre>
#EOF

$gip->print_end("$client_id");
