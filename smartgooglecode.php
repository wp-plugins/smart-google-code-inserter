<?php 
#     /* 
#     Plugin Name: Smart Google Analytics Code
#     Plugin URI: http://oturia.com/
#     Description: Smart Google Analytics, Webmaster Tools and AdWords Code
#     Author: Jason Whitaker
#     Version: 2.2 
#     Author URI: http://oturia.com/
#     */  
 ini_set( "short_open_tag", 1 ); 

if( !class_exists('SmartGoogleCode') )
{
	class SmartGoogleCode{
	
		function SmartGoogleCode() { //constructor
		
			//ACTIONS
			//Add Menu in Left Side bar
				add_action( 'admin_menu', array($this, 'my_plugin_menu') );
				
				add_action('wp_head', array($this,'smart_webmaster_head'));
				
				add_action('wp_footer', array($this,'smart_google_pcc_code'));
				
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


$ppccode = get_option( 'ppccode' );
$ppccap = get_option( 'ppccap' );
$ppcpageid = get_option( 'ppcpageid' );

if( $ppccap == "") {
	$ppccap="ex: mywplead";
}

?>

<script type="text/javascript" language="javascript">
function CheckPPC(){

	if(document.getElementById("ppccode").value != "" ) {
		
		if(document.getElementById("ppcpageid").value == "-1" ){
			alert("Please Select Page");
			return false;
		}
	}
}
</script>


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
  <form name="generalform" id="generalform" method="post" action="" onsubmit="return CheckPPC();" >
    <div class="metabox-holder" style="width: 800px;">
      <div class="postbox">
        <h3>Google Analytics Settings</h3>
        <div>
          <table class="form-table">
            <tbody>
              <tr valign="top" class="alternate">
                <th style="width:30%;" scope="row"><label style="padding: 0 0 16px 0;"><strong>Google Analytics</strong> <br />In this area, paste your Google Analytics tracking code.</label></th>
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
                <th style="width:30%;" scope="row"><label style="padding: 0 0 16px 0;"><strong>Webmaster Tools</strong> <br />In this area, paste your Google Webmaster Tools HTML tag for verifying your site. If you need help getting this code, visit <a target="_blank" href="https://support.google.com/webmasters/bin/answer.py?hl=en&answer=35659">this page</a> </label></th>
                <td style="width:90%;"><textarea rows="7" cols="90" name="sgcwebtools"><?php echo stripslashes($Varsgcwebtools); ?></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end .metabox-holder -->
    
    
    <div class="metabox-holder" style="width: 800px;">
      <div class="postbox">
        <h3>AdWords Conversion Code Settings</h3>
        <div>
		
          <table class="form-table">
            <tbody>
			<tr valign="top" class="alternate">
			<th colspan="2" scope="row">
			<label style="padding: 0 0 16px 0;"><strong>AdWords</strong> <br />This area is only for the Google AdWords conversion tracking code. It is not required. Select the page you want your conversion code to trigger on (e.g. Thank You or Order Confirmation Page).</label><br />
			</th></tr>
              <tr valign="top" class="alternate">
                <th style="width:30%;" scope="row">
                <label style="padding: 0 0 15px 0;">Caption</label><br />

                <input name="ppccap" type="text" id="ppccap" value="<?php echo stripslashes($ppccap); ?>" />
                
                <br />
				<br />
				<br />
                <label style="padding: 0 0 16px 0;">Please Select Page</label><br />

          
                                
                <select name="ppcpageid" id="ppcpageid" style="width: 150px;">
                <option value="-1">Select Page</option>
                <?php $pages = get_pages(); 
					  foreach ( $pages as $page ) {
				?> 
                <option value="<?php echo $page->ID ?>" <?php if($ppcpageid == $page->ID ) {?> selected="selected" <?php } ?> ><?php echo $page->post_title; ?></option>
                
				<?php } ?>                 
                
                </select>
                
                </th>
                <td style="width:90%;"><textarea rows="7" cols="90" id="ppccode" name="ppccode"><?php echo stripslashes($ppccode); ?></textarea></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <div class="submit">
      <input type="submit" name="button" id="button" class="button-primary" value="<?php echo _e("Save Changes"); ?>" />
    </div>
    <input name="action" value="savegooglecode" type="hidden" />
  </form>
</div>
<?php 
}

	//Save Google Code Info
		function saveGoogleCode()
		{
			update_option( 'sgcwebtools', $_POST["sgcwebtools"] );
	
			update_option( 'sgcgoogleanalytic', $_POST["sgcgoogleanalytic"] );

			update_option( 'ppccode', $_POST["ppccode"] );
			
			update_option( 'ppccap', $_POST["ppccap"] );
			
			update_option( 'ppcpageid', $_POST["ppcpageid"] );

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

	function smart_google_pcc_code()
	{
		global $post;
		$pstId = $post->ID;

		$ppccode = get_option( 'ppccode' );
		$ppcpageid = get_option( 'ppcpageid' );
		
		if($ppcpageid == $pstId ) {
			echo stripslashes($ppccode);
		}
		
	}


	function  InstallSmartDefaultValues() {

		add_option("sgcwebtools", "");
		add_option("sgcgoogleanalytic", "");
		add_option("ppccode", "");
		add_option("ppccap", "");
		add_option("ppcpageid", "");				

	}


	}
} 

if( class_exists('SmartGoogleCode') ) {
	$objSmartGoogleCode = new SmartGoogleCode();
}
?>