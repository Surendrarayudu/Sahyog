<?php
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: '.(isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*'));
header('Access-Control-Allow-Headers: *');

define('_EMAIL_TO', 'harpreetk@del.amarujala.com');
define('_EMAIL_FROM', 'no-reply@amarujala.com');
define('_EMAIL_SUBJECT', 'Contact Form');

$fields = array(
	array('name' => 'name', 'valid' => array('require'), 'title' => 'Name'),
	array('name' => 'email', 'valid' => array('require'), 'title' => 'Email'),
	array('name' => 'query-type', 'valid' => array('require'), 'title' => 'Query Type'),
	array('name' => 'message', 'title' => 'Message', 'valid' => array('require')),
);

$info = pathinfo($_SERVER['REQUEST_URI']);
$path = '//'.$_SERVER['HTTP_HOST'].$info['dirname'].'/';

if (!empty($_POST)){
	$error_fields = array();
	$email_content = array();
	foreach ($fields AS $field){
		$value = isset($_POST[$field['name']])?$_POST[$field['name']]:'';
		$title = empty($field['title'])?$field['name']:$field['title'];
		if (is_array($value)){
			$value = implode('/ ', $value);
		}
		$email_content[] = $title.': '.$value;
		$is_valid = true;
		$err_message = '';
		if (!empty($field['valid'])){
			foreach ($field['valid'] AS $valid) {
				switch ($valid) {
					case 'require':
						$is_valid = $is_valid && strlen($value) > 0;
						$err_message = 'Field required';
						break;
					case 'email':
						$is_valid = $is_valid && preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $value);
						$err_message = 'Email required';
						break;
					default:				
						break;
				}
			}
		}
		if (!$is_valid){
			if (!empty($field['err_message'])){
				$err_message = $field['err_message'];
			}
			$error_fields[] = array('name' => $field['name'], 'message' => $err_message);
		}
	}

	if (empty($error_fields)){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		// Send email
		mail (_EMAIL_TO, _EMAIL_SUBJECT, implode('<hr>', $email_content), $headers);	
		echo (json_encode(array('code' => 'success')));
	}else{
		echo json_encode(array('code' => 'failed', 'fields' => $error_fields));
	}
	die();
}

?>
<div class="wrap-embed-contact-form">
	<form class="embed-contact-form">
		<div class="form-heading">Contact Us</div>
		<div class="form-sub-heading">Please, fill in the form to get in touch!</div>
		<hr>
		<div class="form-message hide">
			Your message has been sent successfully!
		</div>
		<div class="form-content">
			<div class="group">
				<label for="name" class="empty"></label>
				<div><input id="name" name="name" placeholder="Your Name" class="form-control"></div>
			</div>
			<div class="group">
				<label for="email" class="empty"></label>
				<div><input type="email" name="email" placeholder="Your Email" class="form-control"></div>
			</div>
			<div class="group">
				<label for="query-type">Query type</label>
				<div>
					<select id="query-type" name="query-type" class="form-control">
						<option value="General Query">General Query</option>
						<option value="Presale">Presale</option>
						<option value="Technical">Technical</option>
						<option value="Others">Others</option>
					</select>
				</div>
			</div>
			<div class="group">
				<label for="message" class="empty"></label>
				<div><textarea id="message" name="message" placeholder="Your Message" class="form-control" rows="5"></textarea></div>
			</div>
			<div class="group">
				<label class="empty"></label>
				<div><button class="btn-submit" type="submit">Send Message</button></div>
			</div>
		</div>
		<a class="btn-show-contact" href="#contact"><img src="<?php echo $path; ?>images/btn_contact.png"></a>
	</form>
</div>