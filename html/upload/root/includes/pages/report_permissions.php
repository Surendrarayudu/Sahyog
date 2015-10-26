<?php
/*
Copyright © 2009-2014 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!isset($cmtx_path)) { die('Access Denied.'); }
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP; ?></a>
</div>

<h3><?php echo CMTX_TITLE_PERMISSIONS; ?></h3>
<hr class="title"/>

<?php echo CMTX_DESC_REPORT_PERMISSIONS; ?>

<p />

<?php
$permissions_correct = true;

if (cmtx_setting('check_db_file')) {

	echo '<b><u>Database Details</u></b>';

	echo '<p />';

	if (is_writable('../includes/db/details.php')) {
		echo '/' . cmtx_setting('commentics_folder') . '/includes/db/details.php <span class="negative">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
		$permissions_correct = false;
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/includes/db/details.php <span class="positive">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	}

	echo '<p />';

}

echo '<b><u>Database Backup</u></b>';

echo '<p />';

if (is_writable('backups/')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/backups/ <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/backups/ <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<p />';

echo '<b><u>Emails</u></b>';

echo '<p />';

if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/ <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/ <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_confirmation.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_confirmation.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_confirmation.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_basic.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_basic.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_basic.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_admin.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_admin.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_admin.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_reply.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_reply.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_reply.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br /><br />';

if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/ <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/ <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/email_test.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/email_test.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/email_test.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/email_test.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/email_test.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/email_test.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/email_test.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_ban.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_ban.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_ban.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_flag.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_flag.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_flag.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_approve.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_approve.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_approve.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_okay.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_okay.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_okay.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/reset_password.txt')) {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/reset_password.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/reset_password.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/reset_password.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/emails/' . cmtx_setting('language_frontend') . '/admin/reset_password.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/reset_password.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/reset_password.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<p />';

echo '<b><u>Words</u></b>';

echo '<p />';

if (is_writable('../includes/words/custom/')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/ <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/ <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<br />';

if (file_exists('../includes/words/custom/reserved_names.txt')) {
	if (is_writable('../includes/words/custom/reserved_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/reserved_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/reserved_emails.txt')) {
	if (is_writable('../includes/words/custom/reserved_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/reserved_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/reserved_websites.txt')) {
	if (is_writable('../includes/words/custom/reserved_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/reserved_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/reserved_towns.txt')) {
	if (is_writable('../includes/words/custom/reserved_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/reserved_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/reserved_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/reserved_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/banned_names.txt')) {
	if (is_writable('../includes/words/custom/banned_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/banned_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/banned_emails.txt')) {
	if (is_writable('../includes/words/custom/banned_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/banned_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/banned_websites.txt')) {
	if (is_writable('../includes/words/custom/banned_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/banned_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/banned_towns.txt')) {
	if (is_writable('../includes/words/custom/banned_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/banned_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/banned_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/banned_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/dummy_names.txt')) {
	if (is_writable('../includes/words/custom/dummy_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/dummy_names.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_names.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_names.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/dummy_emails.txt')) {
	if (is_writable('../includes/words/custom/dummy_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/dummy_emails.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_emails.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_emails.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/dummy_websites.txt')) {
	if (is_writable('../includes/words/custom/dummy_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/dummy_websites.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_websites.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_websites.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/dummy_towns.txt')) {
	if (is_writable('../includes/words/custom/dummy_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/dummy_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/dummy_towns.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_towns.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/dummy_towns.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/mild_swear_words.txt')) {
	if (is_writable('../includes/words/custom/mild_swear_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/mild_swear_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/mild_swear_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/mild_swear_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/mild_swear_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/mild_swear_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/strong_swear_words.txt')) {
	if (is_writable('../includes/words/custom/strong_swear_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/strong_swear_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/strong_swear_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/strong_swear_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/strong_swear_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/strong_swear_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br />';

if (file_exists('../includes/words/custom/spam_words.txt')) {
	if (is_writable('../includes/words/custom/spam_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/spam_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/custom/spam_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('../includes/words/spam_words.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/spam_words.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/words/spam_words.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<br /><br />';

if (is_writable('includes/words/custom/')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . 'includes/words/custom/ <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . 'includes/words/custom/ <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<br />';

if (file_exists('includes/words/custom/admin_notes.txt')) {
	if (is_writable('includes/words/custom/admin_notes.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/words/custom/admin_notes.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/words/custom/admin_notes.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
} else {
	if (is_writable('includes/words/admin_notes.txt')) {
		echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/words/admin_notes.txt <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
	} else {
		echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/words/admin_notes.txt <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
		$permissions_correct = false;
	}
}

echo '<p />';

echo '<b><u>Error Logs</u></b>';

echo '<p />';

if (is_writable('../includes/logs/errors.log')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/logs/errors.log <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . 'includes/logs/errors.log <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<br />';

if (is_writable('includes/logs/errors.log')) {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/logs/errors.log <span class="positive">' . CMTX_FIELD_VALUE_IS_WRITABLE . '</span>.';
} else {
	echo '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/includes/logs/errors.log <span class="negative">' . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . '</span>.';
	$permissions_correct = false;
}

echo '<p />';

if ($permissions_correct) {
	echo '<span class="positive">' . CMTX_FIELD_VALUE_PERMISSIONS_CORRECT . '</span>.';
} else {
	echo '<span class="negative">' . CMTX_FIELD_VALUE_PERMISSIONS_INCORRECT . '</span>.';
}

?>

<p />

<input type="button" class="button" name="refresh" title="<?php echo CMTX_BUTTON_REFRESH; ?>" value="<?php echo CMTX_BUTTON_REFRESH; ?>" onclick="window.location.reload()"/>