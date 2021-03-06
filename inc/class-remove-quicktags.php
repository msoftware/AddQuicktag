<?php
/**
 * AddQuicktag - Settings
 * 
 * @license    GPLv3
 * @package    AddQuicktag
 * @subpackage AddQuicktag Settings
 * @author     Frank Bueltge <frank@bueltge.de>
 */

if ( ! function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a part of plugin, not much I can do when called directly.";
	exit;
}

class Add_Quicktag_Remove_Quicktags extends Add_Quicktag_Settings {
	
	protected static $classobj = NULL;
	// post types for the settings
	private static $post_types_for_js;
	// default buttons from WP Core
	private static $core_quicktags = 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,fullscreen';
	// Transient string
	private static $addquicktag_core_quicktags = 'addquicktag_core_quicktags';
	
	/**
	 * Handler for the action 'init'. Instantiates this class.
	 * 
	 * @access  public
	 * @since   2.0.0
	 * @return  $classobj
	 */
	public static function get_object() {
		
		if ( NULL === self :: $classobj ) {
			self :: $classobj = new self;
		}
		
		return self :: $classobj;
	}
	
	/**
	 * Constructor, init on defined hooks of WP and include second class
	 * 
	 * @access  public
	 * @since   0.0.2
	 * @uses    register_activation_hook, register_uninstall_hook, add_action
	 * @return  void
	 */
	public function __construct() {
		
		add_action( 'addquicktag_settings_form_page', array( $this, 'get_remove_quicktag_area' ) );
	}
	
	public function get_remove_quicktag_area( $options ) {
		
		if ( ! isset( $options['core_buttons'] ) )
			$options['core_buttons'] = array();
		?>
		<h3><?php _e('Remove Core Quicktag buttons', parent::get_textdomain() ); ?></h3>
		<table class="widefat">
			<tr>
				<th class="row-title" style="width:3%;">&#x2714;</th>
				<th class="row-title"><?php _e( 'Button', parent::get_textdomain() ); ?></th>
			</tr>
			
			<?php
				// Convert string to array
				$core_buttons = explode( ',', self::$core_quicktags );
				// Loop over items to remove and unset them from the buttons
				foreach( $core_buttons as $key => $value ) {
					
					if ( array_key_exists( $value, $options['core_buttons'] ) )
						$checked = ' checked="checked"';
					else
						$checked = '';
					
					// same style as in editor
					if ( 'strong' === $value ) {
						$text = 'b';
						$style = ' style="font-weight: bold;"';
					} else if ( 'em' === $value ) {
						$text  = 'i';
						$style = ' style="font-style: italic;"';
					} else if ( 'link' === $value ) {
						$text  = $value;
						$style = ' style="text-decoration: underline;"';
					} else if ( 'del' === $value ) {
						$text  = $value;
						$style = ' style="text-decoration: line-through;"';
					} else if ( 'block' === $value ) {
						$text  = 'b-quote';
						$style = '';
					} else {
						$text  = $value;
						$style = '';
					}
					
					echo '<tr><td><input type="checkbox" name="' . parent :: get_option_string() 
						. '[core_buttons][' . $value . ']" value="1" ' 
						. $checked . ' /></td><td>';
					echo '<input type="button" class="ed_button" title="" value="' . $text . '"' . $style . '> <code>' . $value . '</code></td></tr>';
				}
				
				// Convert new buttons array back into a comma-separated string
				$core_qt = implode( ',', $core_buttons );
			?>
		</table>
		<?php
	}
	
} // end class

$add_quicktag_remove_quicktags = Add_Quicktag_Remove_Quicktags::get_object();
