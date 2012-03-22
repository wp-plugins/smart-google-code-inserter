<?php 
#     /* 
#     Plugin Name: Smart Google Code Inserter
#     Plugin URI: http://oturia.com/
#     Description: Easily add your Google Analytics code and Webmaster Tools verification into the header with this plugin.
#     Author: Jason Whitaker
#     Version: 1.0 
#     Author URI: http://oturia.com/
#     */  


if( !class_exists('SmartGoogleCode') )
{
	class SmartGoogleCode{
	
		function SmartGoogleCode() { //constructor
		
			//ACTIONS
			//Add Menu in Left Side bar
				add_action( 'admin_menu', array($this, 'my_plugin_menu') );
				
				add_action('wp_head', array($this,'smart_webmaster_head'));
				
			# Update General Settings
				if( $_POST['action'] == 'savegooglecode' )
					add_action( 'init', array($this,'saveGoogleCode') );
									
				register_activation_hook( __FILE__, array($this, 'InstallSmartDefaultValues') );									
		}
		
		function my_plugin_menu() {

			global $objSmartGoogleCode;
		
			add_menu_page('Smart Google Code', 'Smart Google Code', 'manage_options', 'smartcode', array($objSmartGoogleCode, 'googleCodefrm'));
	
		}


	// Google Code Function
function googleCodefrm()
{


$Varsgcwebtools  = get_option( 'sgcwebtools' );

$Varsgcgoogleanalytic  = get_option( 'sgcgoogleanalytic' );

?>

<div class="wrap">
  <h2>Smart Google Code</h2>
  <?php if ( !empty($_POST ) ) { ?>
  <div id="message" class="updated fade">
    <p><strong>
      <?php _e('Settings saved.') ?>
      </strong></p>
  </div>
  <br />
  <?php } ?>
  <form name="generalform" id="generalform" method="post" action="" >
    <div class="metabox-holder" style="width: 800px;">
      <div class="postbox">
        <h3>Google Analytics Settings</h3>
        <div>
          <table class="form-table">
            <tbody>
              <tr valign="top" class="alternate">
                <th style="width:30%;" scope="row"><label>Google Analytics</label></th>
                <td style="width:70%;"><textarea rows="15" cols="90" name="sgcgoogleanalytic"><?php echo stripslashes($Varsgcgoogleanalytic); ?></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end .metabox-holder -->
    
    <div class="metabox-holder" style="width: 800px;">
      <div class="postbox">
        <h3>Webmaster Tools Settings</h3>
        <div>
          <table class="form-table">
            <tbody>
              <tr valign="top" class="alternate">
                <th style="width:30%;" scope="row"><label>Webmaster Tools</label></th>
                <td style="width:90%;"><textarea rows="7" cols="90" name="sgcwebtools"><?php echo stripslashes($Varsgcwebtools); ?></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end .metabox-holder -->
    
    <div class="submit">
      <input type="submit" name="button" id="button" class="button-primary" value="<?php echo _e("Save Changes"); ?>" />
    </div>
    <input name="action" value="savegooglecode" type="hidden" />
  </form>
</div>
<?
}

	//Save Google Code Info
		function saveGoogleCode()
		{
			update_option( 'sgcwebtools', $_POST["sgcwebtools"] );
	
			update_option( 'sgcgoogleanalytic', $_POST["sgcgoogleanalytic"] );

			$_POST['notice'] = __('Settings Saved');			
		
		}



	function smart_webmaster_head()
	{
		
		$Varsgcwebtools  = get_option( 'sgcwebtools' );
		
		$Varsgcgoogleanalytic  = get_option( 'sgcgoogleanalytic' );		
		
		echo stripslashes($Varsgcwebtools);
		echo "\n";
		echo stripslashes($Varsgcgoogleanalytic);
		
	}


	function  InstallSmartDefaultValues() {

		add_option("sgcwebtools", "");
		add_option("sgcgoogleanalytic", "");

	}


	}
} 

if( class_exists('SmartGoogleCode') )
	$objSmartGoogleCode = new SmartGoogleCode();

?>
