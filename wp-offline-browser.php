<?php

/*
Plugin Name: WP Offline Browser
Plugin URI: http://techysport.com
Description:This is one of the best plugin which creates offline cache  and increases loading time and speed of your wordpress website.
Version: 1.0
Author: Anop Goswami
Author URI: http://techysport.com
License: GPLv2
*/

include('includes/wpofflinebrowser.php');


//registering hooks

register_activation_hook(__FILE__, 'wpoffline_install');
register_deactivation_hook(__FILE__, 'wpoffline_remove');

function wpoffline_install(){install();}
function wpoffline_remove(){uninstall();}


add_filter('language_attributes', 'lang_add');
add_filter('mod_rewrite_rules', 'rule_add');
wp_enqueue_script('updater', plugins_url('includes/updater.js',__FILE__) );

//------ Admin Area ----------//


if (is_admin()) {
	



//Creating admin menu
	
add_action('admin_menu', 'wpoffline_admin_menu');


function wpoffline_admin_menu() 
{
	add_options_page('WP Offline Browser', 'WP Offline Browser', 'administrator',
					 'wpofflinebrowser', 'wpoffline_admin_page');
}



if(isset($_POST['submit'])){generate();}
	

function wpoffline_admin_page()
 {
		 
?>
  
<div class="wrap">
<h2>WP Offline Browser</h2>

<form method="post" action="#">

   <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Generate Cache"></p>

</form>

</div>

<?php  } 

} ?>
