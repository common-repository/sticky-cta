<?php

/**
 * Main plugin class
 */
class scta_main {

	/**
	 * @var object $ui
	 */
	public $ui;


	/**
	 * Dump everything for this plugin here :p
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Migration
		add_action('init', array($this, 'scta_icons_migration'));

		// User interfaces object
		$this->ui = new scta_ui;

		// Pull stored data
		$this->settings = get_option( 'scta_settings' );

		// Plugin text domain
		add_action( 'init', array( $this, 'scta_textdomain' ) );

		// Register settings
		add_action( 'admin_init', array( $this, 'scta_register_settings' ) );

		// Admin menu
		add_action( 'admin_menu', array( $this, 'scta_admin_menu' ) );

		// Admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'scta_admin_assets' ) );

		// Admin notices
		add_action( 'admin_notices', array( $this, 'scta_admin_notices' ) );

		// Icons UI
		add_action( 'wp_footer', array( $this->ui, 'icons' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'scta_ui_assets' ) );



	}



	/**
	 * Load text domain
	 *
	 * @since 1.0
	 */
	public function scta_textdomain() {

		load_plugin_textdomain( 'sticky-cta', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	}


	/**
	 * Register settings
	 *
	 * @since 1.0
	 */
	public function scta_register_settings() {

		register_setting( 'scta_storage', 'scta_settings' );
		register_setting( 'scta_storage', 'scta_buttons' );
		register_setting('scta_storage', 'scta_showoncpt');

	}


	/**
	 * Admin menu
	 *
	 * @since 1.0
	 */
	public function scta_admin_menu() {

		add_menu_page(
			__( 'Sticky CTA', 'stcky-cta' ),
			__( 'Sticky CTA', 'stcky-cta' ),
			'manage_options',
			'scta',
			array(
				$this->ui,
				'admin_page'
			),
			'dashicons-list-view'
		);

	}


	/**
	 * Admin style
	 *
	 * @since 1.0
	 */
	public function scta_admin_assets() {

		// CSS
		wp_enqueue_style( 'scta-admin-style', plugins_url( 'assets/css/scta-admin-style.css', __FILE__ ) );
		wp_enqueue_style( 'scta-fontawesome', plugins_url( 'assets/css/font-awesome.css', __FILE__ ) );
		wp_enqueue_style( 'scta-iconpicker', plugins_url( 'assets/css/fontawesome-iconpicker.css', __FILE__ ) );
		wp_enqueue_style( 'wp-color-picker' );

		// JS
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'scta-iconpicker-js', plugins_url( 'assets/js/fontawesome-iconpicker.js', __FILE__ ) );
		wp_enqueue_script( 'scta-admin-js', plugins_url( 'assets/js/scta-admin-js.js', __FILE__ ) );

	}


	/**
	 * Admin notices
	 *
	 * @since 1.0
	 */
	public function scta_admin_notices() {

		// Get current screen
		$screen = get_current_screen();

		/**
		 * If settings updated successfully
		 */
		if ( isset( $_GET['settings-updated'] ) && $screen->id == 'toplevel_page_scta' ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p>Changes has been saved successfully!</p>
			</div>
			<?php
		}

	}


	/**
	 * UI Assets
	 *
	 * @since 1.0
	 */
	public function scta_ui_assets() {

		// CSS
		wp_enqueue_style( 'scta-ui-style', plugins_url( 'assets/css/scta-ui-style.css', __FILE__ ) );
		wp_enqueue_style( 'scta-fontawesome', plugins_url( 'assets/css/font-awesome.css', __FILE__ ) );

		$dynamic_css = null;

		if (!empty($this->ui->buttons['btns']) && $this->ui->buttons['btns']) {

			foreach ( $this->ui->btns_order AS $btn_key => $btn_id ) {

				// Hex to RGB
				$hex = str_replace('#', '', $this->ui->buttons['btns'][$btn_id]['btn_color']);
				$R = hexdec(substr($hex, 0, 2));
				$G = hexdec(substr($hex, 2, 2));
				$B = hexdec(substr($hex, 4, 2));

				$dynamic_css .= '#scta-btn-' . $btn_id . '{background: ' . $this->ui->buttons['btns'][$btn_id]['btn_color'] . ';}' . PHP_EOL;
				$dynamic_css .= '#scta-btn-' . $btn_id . ':hover{background:rgba(' . $R . ',' . $G . ',' . $B . ',0.9);}' . PHP_EOL;
				$dynamic_css .= '#scta-btn-' . $btn_id . ' a{color: ' . $this->ui->buttons['btns'][$btn_id]['btn_font_color'] . ';}' . PHP_EOL;

				// Share button color
				if ($btn_key == 0) {
					$dynamic_css .= '.scta-share-btn,.scta-share-btn .scta-social-popup{background:' . $this->ui->buttons['btns'][$btn_id]['btn_color']  . ';color:' . $this->ui->buttons['btns'][$btn_id]['btn_font_color'] . '}';
					$dynamic_css .= '.scta-share-btn:hover{background:rgba(' . $R . ',' . $G . ',' . $B . ',0.9);}';
					$dynamic_css .= '.scta-share-btn a{color:' . $this->ui->buttons['btns'][$btn_id]['btn_font_color']  . ' !important;}';
				}

			}

		}

		// Inline CSS
		wp_add_inline_style('scta-ui-style', $dynamic_css);


		// JS
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-effects-shake');
		wp_enqueue_script('scta-ui-js', plugins_url('assets/js/scta-ui-js.js', __FILE__));

		$btn_z_index = isset( $this->settings['btn_z_index'] ) ? $this->settings['btn_z_index'] : 1;
		wp_localize_script( 'scta-ui-js', 'scta_ui_data', array(
			'z_index' => intval( $btn_z_index )
		));
	}


	/**
     * Icons migration to newer version 
     * 
     * @since 1.0.8
     */
	public function scta_icons_migration() {

	    // Get old buttons
	    $buttons = get_option('scta_buttons');

	    // Count them
	    if(!empty($buttons['btns']))
	    if(count($buttons['btns'])>1)
	    {
		    $btns_count = count($buttons['btns']);

		    // Replace them
		    for ($i = 0; $i < $btns_count; $i++) {
		        if (strpos($buttons['btns'][$i]['btn_icon'], 'fas') === false && strpos($buttons['btns'][$i]['btn_icon'], 'far') === false && strpos($buttons['btns'][$i]['btn_icon'], 'fab') === false) {
			        $buttons['btns'][$i]['btn_icon'] = 'fas ' .$buttons['btns'][$i]['btn_icon'];
	            }
	        }
    	}

        // Update buttons
		update_option('scta_buttons', $buttons);


    }


}
