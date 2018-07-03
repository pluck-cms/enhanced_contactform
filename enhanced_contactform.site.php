<?php
/*
 * This file is part of pluck, the easy content management system
 * Copyright (c) pluck team
 * http://www.pluck-cms.org

 * Pluck is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * See docs/COPYING for the complete license.
*/

//Make sure the file isn't accessed directly.
defined('IN_PLUCK') or exit('Access denied!');

function enhanced_contactform_theme_main() {
	global $lang;

	//Define some variables.
	if (isset($_POST['contactform_to']))
		$to = $_POST['contactform_to'];
	if (isset($_POST['contactform_name']))
		$name = $_POST['contactform_name'];
	if (isset($_POST['contactform_sender']))
		$sender = $_POST['contactform_sender'];
	if (isset($_POST['contactform_message']))
		$message = $_POST['contactform_message'];
	if (isset($_POST['contactform_captcha']))
		$captcha = $_POST['contactform_captcha'];

	//If the the contactform was submitted.
	if (isset($_POST['submit'])) {
		//Check if all fields were filled.
		if ($to && $name && $sender && $message && $captcha) {
			//Sanitize the fields and set extra headers.
			//N.B. strstr would be neater, but needs PHP >= 5.3 for $before_needle param
			if (strtolower(	$_SESSION['captcha']['code']) == strtolower($captcha)){
				if(strpos($name, "\r\n"))
					$name = substr($name, 0, strpos($name, "\r\n"));
				if(strpos($sender, "\r\n"))
					$sender = substr($sender, 0, strpos($sender, "\r\n"));
				//Set email headers.
				$extra_headers = 'From: =?utf-8?B?'.base64_encode($name).'?= <'.$sender.'>'."\r\n";
				$extra_headers .= "X-Originating-IP: [".$_SERVER['REMOTE_ADDR']."]\r\n";
				$extra_headers .= "MIME-Version: 1.0\r\n";
				$extra_headers .= "Content-type: text/plain; charset=utf-8\r\n";
				$extra_headers .= "Content-Transfer-Encoding: 8bit\r\n";
				//Check if we can set envelope sender.
				if(isset($_SERVER['SERVER_ADMIN'])) {
					$mail_user = $_SERVER['SERVER_ADMIN'];
					$extra_headers .= "Sender: $mail_user\r\n";
					$sendmail_params = "-f$mail_user";
				}
				else
					$sendmail_params = NULL;

				//Now we're going to send our email.
				if (mail($to, '=?utf-8?B?'.base64_encode($lang['enhanced_contactform']['email_title'].' '.$name).'?=', $message, $extra_headers, $sendmail_params)){
					echo '<p class="success">'.$lang['enhanced_contactform']['been_send'].'</p>';
					$to ="";
					$sender = "";
					$name = "";
					$message = "";
				}				
				//If email couldn't be sent.
				else
					echo '<p class="error">'.$lang['enhanced_contactform']['not_send'].'</p>';
			} else {
				echo '<p class="error">'.$lang['enhanced_contactform']['notvalid'].'</p>';
			}

		}
		//If not all fields were filled.
		else
			echo '<p class="error">'.$lang['enhanced_contactform']['fields'].'</p>';
	}

	//Then show the contactform.
	?>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="enhanced_contactform">
			<div>
			<label for="contactform_to"><?php echo $lang['enhanced_contactform']['name']; ?></label>
				<br />
				<select name="contactform_to" id="contactform_to">
				<?php 
				    $dir = scandir('data/settings/modules/enhanced_contactform');
					foreach ($dir as $file) {
						if(($file !== ".") and ($file !== "..")) {
							include ('data/settings/modules/enhanced_contactform/'.$file);
							echo '<option value='.$email.'>'.$emailname.'</option>';
						}
			    } ?>
				</select> 
				<br />
				<label for="contactform_name"><?php echo $lang['general']['name']; ?></label>
				<br />
				<input name="contactform_name" id="contactform_name" type="text"  value="<?php echo $name;?>"/>
				<br />
				<label for="contactform_sender"><?php echo $lang['general']['email']; ?></label>
				<br />
				<input name="contactform_sender" id="contactform_sender" type="text" value="<?php echo $sender; ?>" />
				<br />
				<label for="contactform_message"><?php echo $lang['general']['message']; ?></label>
				<br />
				<textarea name="contactform_message" id="contactform_message" rows="7" cols="45"><?php echo $message; ?></textarea>
				<br />

				<?php	
					//include_once 'simple-php-captcha/simple-php-captcha.php';

					session_start();
					include("simple-php-captcha/simple-php-captcha.php");
					$_SESSION['captcha'] = simple_php_captcha();
					echo "<img src='".$_SESSION['captcha']['image_src']."' />";
?>	
				<label for="contactform_captcha"><?php echo $lang['enhanced_contactform']['captcha']; ?></label>
				<br />
				<input name="contactform_captcha" id="contactform_captcha" type="text" />
				<br />

				<input type="submit" name="submit" value="<?php echo $lang['general']['send']; ?>" />
			</div>
		</form>
	<?php
}
?>
