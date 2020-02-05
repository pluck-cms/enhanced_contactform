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

function enhanced_contactform_pages_admin() {
	global $lang;

	$module_page_admin[] = array(
		'func'  => 'Main',
		'title' => $lang['enhanced_contactform']['main']
	);
	$module_page_admin[] = array(
		'func'  => 'activate',
		'title' => $lang['enhanced_contactform']['adminpage']
	);
		
	return $module_page_admin;
}

function enhanced_contactform_page_admin_main() {
	global $lang;
	if (!file_exists('data/settings/modules/enhanced_contactform')) {
		mkdir('data/settings/modules/enhanced_contactform', 0775, true);
}

	//Define some variables.
	if (isset($_POST['contactform_name']))
		$name = $_POST['contactform_name'];
	if (isset($_POST['contactform_email']))
		$email = $_POST['contactform_email'];

	//If the the contactform was submitted.
	if (isset($_POST['submit'])) {
		//Check if all fields were filled.
		if ($name && $sender) {
			//Sanitize the fields and set extra haders.
			//N.B. strstr would be neater, but needs PHP >= 5.3 for $before_needle param
			if(strpos($name, "\r\n"))
				$name = substr($name, 0, strpos($name, "\r\n"));
			if(strpos($email, "\r\n"))
				$email = substr($email, 0, strpos($sender, "\r\n"));
			//Set email headers.
		}
		//If not all fields were filled.
		else
			echo '<p class="error">'.$lang['enhanced_contactform']['fields'].'</p>';
	}

	//Then show the contactform.
	?>

	<?php
	showmenudiv($lang['enhanced_contactform']['adminpage'],$lang['enhanced_contactform']['adminpage'],'data/image/note.png','admin.php?module=enhanced_contactform&amp;page=activate',false);


    if (isset($_GET['delete'])) {
        unlink ('data/settings/modules/enhanced_contactform/'.$_GET['delete']);
        echo $_GET['delete'] . $lang['enhanced_contactform']['deleted'];
        redirect ('?module=enhanced_contactform','0');
    }

    $dir = opendir('data/settings/modules/enhanced_contactform/');
    while (false !== ($file = readdir($dir))) {
        if(($file !== ".") and ($file !== "..") and ($file != "new")) {
        include ('data/settings/modules/enhanced_contactform/'.$file);
        echo '
        <div class="menudiv" style="margin: 10px;">
            <table width="100%">
                <tr>
                    <td width="20"><img src="data/image/website_small.png"></td>
                    <td>
                        <span>'.$emailname.'</a></span><br/>
                        <p>'.$email.'</p>
                    </td>
                    <td align="right">
                        <a href="?module=enhanced_contactform&delete='.$file.'"><img src="data/image/trash_small.png" border="0" title="'.$lang['enhanced_contactform']['delete'].'" alt="'.$lang['enhanced_contactform']['delete'].'"></a>
                    </td>
                </tr>
            </table>
        </div>';

        }
    }

}

function enhanced_contactform_page_admin_activate(){
	global $lang;
    	showmenudiv($lang['enhanced_contactform']['backlink'],false,'data/image/restore.png','?module=enhanced_contactform',false);

           ?>
            <div class="menudiv" style="margin: 10px;">
 
	        <form method="post" action="" style="margin-top: 5px; margin-bottom: 15px;">
    	        <?php echo $lang['enhanced_contactform']['name']; ?> <br /><input name="name" type="text" value="" /><br />
        	    <?php echo $lang['enhanced_contactform']['email']; ?> <br /><input name="email" type="text" value="" /><br />
            	<input type="submit" name="Submit" value="<?php echo $lang['enhanced_contactform']['send']; ?>" />
	        </form>
 
            </div> <?php 
           
    
    if (isset($_POST['Submit'])) {

		       //Check if everything has been filled in
			   if((!isset($_POST['name'])) || (!isset($_POST['email']))) { ?>
				<span style="color: red;"><?php echo $lang['enhanced_contactform']['fillall']; ?></span>
			<?php
				// exit;
			}
			else {
				//Then fetch our posted variables
				$name = $_POST['name'];
				$email = $_POST['email'];

				//Check for HTML, and eventually block it
				if ((preg_match('/</', $name)) || (preg_match('/>/', $name)) || (preg_match('/</', $email)) || (preg_match('/>/', $email))) { ?>
					<span style="color: red;"><?php echo $lang['enhanced_contactform']['nohtml']; ?></span>
				<?php } else {
		
				$file=str_replace(" ", "_", $name);
				$file=date ("dmY"). '-' . $file;
				
				$fp = fopen ('data/settings/modules/enhanced_contactform/' . $file . '.php',"w");
				fputs ($fp, '<?php'."\n"
					.'$emailname = "'.$name.'";'."\n"
					.'$email = "'.$email.'";'."\n"
					.'');
				fclose ($fp);
				
			
				}
			}
	

		redirect('?module=enhanced_contactform','0');
    }
    
}

?>
