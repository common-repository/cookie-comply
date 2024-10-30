<?php
/* 
Plugin Name: Cookie Comply
Plugin URI:  http://angelicanose.weebly.com
Description: Adds a message to your blog that says your visitors must to comply with the uk law and enable the cookies.
Author: Angelica Defos
Version: 1.01
Author URI: http://angelicanose.weebly.com
*/

/*  Copyright 2012 Angelica Defos  (angelicanose@mail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function CMCLC_enqueueScripts()  
{  
    wp_enqueue_script('jquery');  
} 
add_action('wp_enqueue_scripts', 'CMCLC_enqueueScripts'); 


function CMCLC_cookieMessage()
{
  global $defaultMessage, $defaultTitle;
?>
<script type="text/javascript">
jQuery(function(){ 
  if (navigator.cookieEnabled === true)
  {
    if (document.cookie.indexOf("visited") == -1)
	{
	  jQuery('body').prepend('<div id="cookie" style="display:none;position:absolute;left:0;top:0;width:100%;background:black;background:rgba(0,0,0,0.8);z-index:9999"><div style="width:800px;margin-left:auto;margin-right:auto;padding:10px 0"><h2 style="margin:0;padding:0;color:white;display: block;float: left;height: 40px;line-height: 20px;text-align: right;width: 140px;font: normal normal normal 18px Arial,verdana,sans-serif"><?php echo addslashes(get_option('notificationTitle', $defaultTitle)); ?></h2><p style="color:#BEBEBE;display: block;float: left;font: normal normal normal 13px Arial,verdana,sans-serif;height: 64px;line-height: 16px;margin:0 0 0 30px;padding:0;width:450px;"><?php echo addslashes(get_option('notificationMessage', $defaultMessage)); ?></p><div style="float:left;margin-left:10px"><a href="#" id="closecookie" style="color:white;font:12px Arial;text-decoration:none">Close</a></div><div style="clear:both"></div></div></div>');
	  jQuery('#cookie').show("fast");
	  jQuery('#closecookie').click(function() {jQuery('#cookie').hide("fast");});
	  document.cookie="visited=yes; expires=Thu, 31 Dec 2020 23:59:59 UTC; path=/";
	}
  }
})
</script>
<?php
}
add_action('wp_footer', 'CMCLC_cookieMessage'); 




function CMCLC_createMenu() 
{
	add_submenu_page('options-general.php', 'Cookie Comply', 'Cookie Comply', 'administrator', 'CMCLC_settingsPage', 'CMCLC_settingsPage'); 
	add_action('admin_init', 'CMCLC_registerSettings');
}
add_action('admin_menu', 'CMCLC_createMenu');



function CMCLC_registerSettings() 
{
	register_setting('CMCLC', 'notificationTitle');
	register_setting('CMCLC', 'notificationMessage');
}


function CMCLC_settingsPage() 
{
  global $defaultMessage, $defaultTitle;
?>
<div class="wrap">
<h2>Cookie Comply Message</h2>
<form method="post" action="options.php">
    <?php settings_fields('CMCLC'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Message Title</th>
        <td><input name="notificationTitle" class="regular-text" type="text" value="<?php echo get_option('notificationTitle', $defaultTitle); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Message Text</th>
        <td><textarea name="notificationMessage" class="large-text code"><?php echo get_option('notificationMessage', $defaultMessage); ?></textarea></td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>
</div>
<?php } 


  $defaultTitle = 'Enable Cookies For This Site';
  $defaultMessage = 'We use cookies to remember what parts of the website you have navigated and to improve your browsing experience. Parts of the website may not work as expected with out them. By closing this message you are consenting to our use of cookies.'

?>