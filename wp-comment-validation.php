<?php
    /*
  Plugin Name: wp comment validation
  Plugin URI: http://ajaysharma3085006.wordpress.com/
  Description: comment form validation Component for WordPress
  Version: 0.2
  Author: Ajay Sharma
  Author URI: http://ajaysharma3085006.wordpress.com/
  License: GPLv2 or later
 */
 //activation
 function wp_comment_activation() { 
 add_option( wcv_enable,'1', '', yes );  
 add_option( wcv_name_enable,'1', '', yes );
 add_option( wcv_email_enable,'1', '', yes );
 add_option( wcv_website_enable,'1', '', yes );
 add_option( wcv_comment_enable,'1', '', yes );
 }
register_activation_hook(__FILE__, 'wp_comment_activation');
//deactivation
function wp_comment_deactivation() {
delete_option( 'wcv_enable' );
delete_option( 'wcv_name_txt' );
delete_option( 'wcv_email_txt' );
delete_option( 'wcv_website_txt' );
delete_option( 'wcv_comment_txt' );
delete_option( 'wcv_name_enable' );
delete_option( 'wcv_email_enable' );
delete_option( 'wcv_website_enable' );
delete_option( 'wcv_comment_enable' );
}
register_deactivation_hook(__FILE__, 'wp_comment_deactivation');
//scripts
add_action('wp_enqueue_scripts', 'wp_comments_scripts');
function wp_comments_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script('validation_js', plugins_url('js/jquery.validate.js', __FILE__), array("jquery"));
    wp_enqueue_script('validation_js');
}
add_action('wp_enqueue_scripts', 'wp_comments_styles');
function wp_comments_styles() {
    wp_register_style('validation_css', plugins_url('css/jquery.validate.css', __FILE__));
    wp_enqueue_style('validation_css');
  }
    // create custom plugin settings menu
add_action('admin_menu', 'wcv_create_menu');
function wcv_create_menu() {
	//create new top-level menu
	add_menu_page('Wordpress Comment Validation Plugin Settings', 'Wp Comment Validation', 'administrator', __FILE__, 'wcv_settings_page',plugins_url('/images/icon.png', __FILE__));
	
	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
    
}
    function register_mysettings() {
	//register our settings
	register_setting( 'wcv-settings-group', 'wcv_enable' );
	register_setting( 'wcv-settings-group', 'wcv_name_enable' );
	register_setting( 'wcv-settings-group', 'wcv_email_enable' );
	register_setting( 'wcv-settings-group', 'wcv_website_enable' );
	register_setting( 'wcv-settings-group', 'wcv_comment_enable' );
	register_setting( 'wcv-settings-group', 'wcv_name_txt' );
	register_setting( 'wcv-settings-group', 'wcv_email_txt' );
	register_setting( 'wcv-settings-group', 'wcv_website_txt' );
	register_setting( 'wcv-settings-group', 'wcv_comment_txt' );	
}

function wcv_settings_page() {?><div class="wrap">
<h2>Wp comment Validation Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wcv-settings-group' ); ?>
    <?php do_settings_sections( 'wcv_settings_page' ); ?>
    <table class="form-table">
		
		<tr valign="top">
        <th scope="row">Enable Validation</th>
        <td>
		<input type="checkbox" name="wcv_enable" value="1" <?php checked(get_option('wcv_enable'), 1); ?> />
                 Default: true</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Enable Name Validation</th>
        <td>
		<input type="checkbox" name="wcv_name_enable" value="1" <?php checked(get_option('wcv_name_enable'), 1); ?> />
                 Default: true</td>
        </tr>
	
        <tr valign="top">
        <th scope="row">Name </th>
        <td><input type="text" name="wcv_name_txt" value="<?php echo get_option('wcv_name_txt'); ?>" /> Default: Please Enter your name</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Enable Email Validation</th>
        <td>
		<input type="checkbox" name="wcv_email_enable" value="1" <?php checked(get_option('wcv_email_enable'), 1); ?> />
                 Default: true</td>
        </tr>
		
         
        <tr valign="top">
        <th scope="row">Email</th>
        <td><input type="text" name="wcv_email_txt" value="<?php echo get_option('wcv_email_txt'); ?>" /> Default: Please Enter Valid Email Address</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Enable Website  url Validation</th>
        <td>
		<input type="checkbox" name="wcv_website_enable" value="1" <?php checked(get_option('wcv_website_enable'), 1); ?> />
                 Default: true</td>
        </tr>
		
		
		<tr valign="top">
        <th scope="row">Website</th>
        <td><input type="text" name="wcv_website_txt" value="<?php echo get_option('wcv_website_txt'); ?>" /> Default: Please Enter website url</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Enable Comment Validation</th>
        <td>
		<input type="checkbox" name="wcv_comment_enable" value="1" <?php checked(get_option('wcv_comment_enable'), 1); ?> />
                 Default: true</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Comment</th>
        <td><input type="text" name="wcv_comment_txt" value="<?php echo get_option('wcv_comment_txt'); ?>" /> Default: Please Enter your Comment</td>
        </tr> 
    </table>
    
    <?php submit_button(); ?></form>
</div>
<?php } ?>
<?php 

if (get_option('wcv_enable') == 1){

//add_action('wp_head', 'wcv_js_to_head'); 
add_action('wp_footer', 'wcv_js_to_head'); 
}
function wcv_js_to_head() {//echo "data to head ajay comment plugin";?>
<?php	$wcv_name =(get_option('wcv_name_txt') == '') ? "Please Enter your name" :  get_option('wcv_name_txt'); //echo $message;
$wcv_email =(get_option('wcv_email_txt') == '') ? "Please Enter Valid Email Address" :  get_option('wcv_email_txt'); 
$wcv_website =(get_option('wcv_website_txt') == '') ? "Please Enter Valid Website Url" :  get_option('wcv_website_txt');
$wcv_message =(get_option('wcv_comment_txt') == '') ? "Please Enter your Comment" :  get_option('wcv_comment_txt'); 	?>        
        <script type="text/javascript">
		/* <![CDATA[ */
            jQuery(function(){
			<?php if (get_option('wcv_name_enable') == 1){?>
                jQuery("#author").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "<?php echo $wcv_name; ?>"
                });
				<?php }?>
               
				<?php if (get_option('wcv_email_enable') == 1){?>
                jQuery("#email").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                    message: "<?php echo $wcv_email; ?>"
                });
				<?php }?>
				
				<?php if (get_option('wcv_website_enable') == 1){?>
				jQuery("#url").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "<?php echo $wcv_website; ?>"
                });
				<?php }?>
				
				
				<?php if (get_option('wcv_comment_enable') == 1){?>
				
				jQuery("#comment").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "<?php echo $wcv_message; ?>"
                });				
				<?php }?>
						
            });
			
            /* ]]> */
        </script>
<!--validation ends-->
<?php }?>