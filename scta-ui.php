<?php

/**
 * Sticky Side Buttons UIs
 *
 * User Interface class which will contain
 * UI for the front and admin panel
 */
class scta_ui {

	/**
	 * @var array $buttons
	 * @var array $settings
	 */
	public $buttons;
	public $settings;
	public $btns_order;
	public $cpts;
	public $showoncpt;

	/**
	 * Dump everything for this class here
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Pull stored data
		$this->buttons   = get_option( 'scta_buttons' );
		$this->settings  = get_option( 'scta_settings' );
		$this->showoncpt = get_option( 'scta_showoncpt' );

		// Buttons Sorting
		$this->btns_order = explode( '&', str_replace( 'sort=', '', $this->buttons['btns_order'] ) );

	}


	/**
	 * Admin Page UI
	 *
	 * @since 1.0
	 */
	public function admin_page() {
		?>
        <div class="wrap" id="scta-wrap">
            <h1>
				<?php echo get_admin_page_title(); ?>
            </h1>
            <form method="post" action="options.php">
				<?php

				// Button builder
				$this->button_builder();

				// General settings
				$this->general_settings();

				?>
            </form>
        </div>
		<?php
	}


	/**
	 * Button Builder UI Part
	 *
	 * @since 1.0
	 */
	public function button_builder() {
		?>
        <div class="scta-panel">
			<?php settings_fields( 'scta_storage' ); ?>
            <input type="hidden" name="scta_buttons[btns_order]" id="scta-btns-order"
                   value="<?php echo $this->buttons['btns_order'] ?>">
            <header class="scta-panel-header">
				<?php _e( 'Button Builder', 'stcky-cta' ); ?>
            </header>
            <div class="scta-panel-body">
                <p><?php _e( 'Add buttons then drag and drop to reorder them. Click the arrow on the right of each item to reveal more configuration options.', 'stcky-cta' ); ?></p>
                <p><a href="#" class="button scta-add-btn"><?php _e( 'Add Button', 'stcky-cta' ); ?></a></p>

                <ul id="scta-sortable-buttons">
					<?php

					// Buttons exists
					if ( isset( $this->buttons['btns'] ) ) {

						// Buttons loop + ordering
						foreach ( $this->btns_order AS $btn_key => $btn_id ) {

							?>
                            <li id="scta_btn_<?php echo $btn_id; ?>">
                                <header>
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
									<?php echo $this->buttons['btns'][ $btn_id ]['btn_text']; ?>
                                </header>
                                <div class="scta-btn-body">
                                    <div class="scta-body-left">
                                        <p>
                                            <label for="button-text-<?php echo $btn_id; ?>">Button Text</label>
                                            <input type="text"
                                                   id="button-text-<?php echo $btn_id; ?>"
                                                   class="widefat"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][btn_text]"
                                                   value="<?php echo $this->buttons['btns'][ $btn_id ]['btn_text']; ?>">
                                        </p>
                                        <p class="scta-iconpicker-container">
                                            <label for="button-icon-<?php echo $btn_id; ?>">Button icon</label>
                                            <input type="text"
                                                   id="button-icon-<?php echo $btn_id; ?>"
                                                   class="widefat scta-iconpicker"
                                                   data-placement="bottomRight"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][btn_icon]"
                                                   value="<?php echo $this->buttons['btns'][ $btn_id ]['btn_icon']; ?>">
                                            <span class="scta-icon-preview input-group-addon"></span>
                                        </p>
                                        <p>
                                            <label for="button-link-<?php echo $btn_id; ?>">link URL</label>
                                            <input type="text"
                                                   id="button-link-<?php echo $btn_id; ?>"
                                                   class="widefat"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][btn_link]"
                                                   value="<?php echo $this->buttons['btns'][ $btn_id ]['btn_link']; ?>">
                                        </p>
                                    </div>
                                    <div class="scta-body-right">
                                        <p>
                                            <label for="button-color-<?php echo $btn_id; ?>">Button Color</label>
                                            <input type="text"
                                                   id="button-color-<?php echo $btn_id; ?>"
                                                   class="widefat scta-colorpicker"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][btn_color]"
                                                   value="<?php echo $this->buttons['btns'][ $btn_id ]['btn_color']; ?>">
                                        </p>
                                        <p>
                                            <label for="button-font-color-<?php echo $btn_id; ?>">font color</label>
                                            <input type="text"
                                                   id="button-font-color-<?php echo $btn_id; ?>"
                                                   class="widefat scta-colorpicker"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][btn_font_color]"
                                                   value="<?php echo $this->buttons['btns'][ $btn_id ]['btn_font_color']; ?>">
                                        </p>
                                        <p>
                                            <label for="button-opening-<?php echo $btn_id; ?>"
                                                   style="text-transform: inherit">Open link in a new window</label>
                                            <input type="checkbox"
                                                   id="button-opening-<?php echo $btn_id; ?>"
                                                   class="open-new-window"
                                                   name="scta_buttons[btns][<?php echo $btn_id; ?>][open_new_window]"
                                                   value="1"
												<?php echo ( isset( $this->buttons['btns'][ $btn_id ]['open_new_window'] ) && $this->buttons['btns'][ $btn_id ]['open_new_window'] == 1 ) ? ' checked="checked"' : ''; ?>>
                                        </p>
                                    </div>
                                    <div class="scta-btn-controls">
                                        <a href="#" class="scta-remove-btn">Remove</a> |
                                        <a href="#" class="scta-close-btn">Close</a>
                                    </div>
                                </div>
                            </li>
							<?php
						}
					}
					?>
                </ul>

            </div>
            <footer class="scta-panel-footer">
                <input type="submit" class="button-primary"
                       value="<?php _e( 'Save Buttons', 'stcky-cta' ); ?>">
            </footer>
        </div>
		<?php
		return true;
	}


	/**
	 * General Settings UI Part
	 *
	 * @since 1.0
	 */
	public
	function general_settings() {
		?>
        <div class="scta-panel">
			<?php settings_fields( 'scta_storage' ); ?>
            <header class="scta-panel-header">
				<?php _e( 'General Settings', 'stcky-cta' ); ?>
            </header>
            <div class="scta-panel-body">
                <div class="scta-row">
                    <div class="scta-col">
                        <label for="scta-pos-left">
                            <strong><?php _e( 'Button Position', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-pos-left">
                            <input type="radio"
                                   name="scta_settings[btn_pos]"
                                   id="scta-pos-left"
                                   value="left"
								<?php echo ( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'left' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Left', 'stcky-cta' ); ?>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-pos-right">
                            <input type="radio"
                                   name="scta_settings[btn_pos]"
                                   id="scta-pos-right"
                                   value="right"
								<?php echo ( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'right' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Right', 'stcky-cta' ); ?>
                        </label>
                    </div>
                     
                </div>

                <div class="scta-row">
                    <div class="scta-col">
                        <label for="scta-btn-dark">
                            <strong><?php _e( 'Rollover Style', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-dark">
                            <input type="radio"
                                   name="scta_settings[btn_hover]"
                                   id="scta-btn-dark"
                                   value="dark"
								<?php echo ( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'dark' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Darken', 'stcky-cta' ); ?>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-light">
                            <input type="radio"
                                   name="scta_settings[btn_hover]"
                                   id="scta-btn-light"
                                   value="light"
								<?php echo ( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'light' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Lighten', 'stcky-cta' ); ?>
                        </label>
                    </div>
                </div>

                <div class="scta-row">
                    <div class="scta-col">
                        <label for="scta-btn-none">
                            <strong><?php _e( 'Animation', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-none">
                            <input type="radio"
                                   name="scta_settings[btn_anim]"
                                   id="scta-btn-none"
                                   value="none"
								<?php echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'none' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'None', 'stcky-cta' ); ?>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-slide">
                            <input type="radio"
                                   name="scta_settings[btn_anim]"
                                   id="scta-btn-slide"
                                   value="slide"
								<?php echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'slide' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Slide', 'stcky-cta' ); ?>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-icons">
                            <input type="radio"
                                   name="scta_settings[btn_anim]"
                                   id="scta-btn-icons"
                                   value="icons"
								<?php echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'icons' ) ? ' checked="checked"' : ''; ?>>
							<?php _e( 'Icons Only', 'stcky-cta' ); ?>
                        </label>
                    </div>
                </div>

                <div class="scta-row">
                    
                    
                    <div class="scta-col">
                        <label for="scta-btn-disable">
                            <strong><?php _e( 'Enable Social Sharing', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-share">
                            <input type="checkbox"
                                   name="scta_settings[btn_share]"
                                   id="scta-btn-share"
                                   value="1"
								<?php echo ( isset( $this->settings['btn_share'] ) && $this->settings['btn_share'] == 1 ) ? ' checked="checked"' : ''; ?>>
                        </label>
                    </div>
                </div>

                
                <div class="scta-row">
                    <div class="scta-col">
                        <label for="scta-btn-disable">
                            <strong><?php _e( 'Disable on Mobile', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <label for="scta-btn-disable">
                            <input type="checkbox"
                                   name="scta_settings[btn_disable_mobile]"
                                   id="scta-btn-disable"
                                   value="1"
								<?php echo ( isset( $this->settings['btn_disable_mobile'] ) && $this->settings['btn_disable_mobile'] == 1 ) ? ' checked="checked"' : ''; ?>>
                        </label>
                    </div>
                </div>

                <div class="scta-row">
                    <div class="scta-col">
                        <label for="scta-btn-z-index">
                            <strong><?php _e( 'Z-Index', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <input type="number"
                               name="scta_settings[btn_z_index]"
                               id="scta-btn-z-index" class="small-text"
                               value="<?php echo isset( $this->settings['btn_z_index'] ) ? intval( $this->settings['btn_z_index'] ) : 1 ?>">

                    </div>
                </div>

                <div class="scta-row">
                    <div class="scta-col">
                        <label>
                            <strong><?php _e( 'Show on', 'stcky-cta' ); ?>:</strong>
                        </label>
                    </div>
                    <div class="scta-col">
                        <p>
                            <label for="show-on-pages">
                                <input type="checkbox"
                                       name="scta_settings[show_on_pages]"
                                       id="show-on-pages"
                                       value="1"
									<?php echo ( isset( $this->settings['show_on_pages'] ) && $this->settings['show_on_pages'] == 1 ) ? ' checked="checked"' : ''; ?>>
								<?php _e( 'Pages', 'stcky-cta' ); ?>
                            </label>
                        </p>
                        <p>
                            <label for="show-on-posts">
                                <input type="checkbox"
                                       name="scta_settings[show_on_posts]"
                                       id="show-on-posts"
                                       value="1"
									<?php echo ( isset( $this->settings['show_on_posts'] ) && $this->settings['show_on_posts'] == 1 ) ? ' checked="checked"' : ''; ?>>
								<?php _e( 'Posts', 'stcky-cta' ); ?>
                            </label>
                        </p>
						<?php $this->cpts = get_post_types( array( '_builtin' => false ), 'objects' );
						if ( $this->cpts ):
							foreach ( $this->cpts as $cpt ): ?>
                                <p>
                                    <label for="show-on-<?php echo $cpt->name; ?>">
                                        <input type="checkbox"
                                               name="scta_showoncpt[]"
                                               id="show-on-<?php echo $cpt->name; ?>"
                                               value="<?php echo $cpt->name; ?>"
											<?php echo ( $this->showoncpt && in_array( $cpt->name, $this->showoncpt ) ) ? ' checked="checked"' : ''; ?>>
										<?php _e( $cpt->labels->name, 'stcky-cta' ); ?>
                                    </label>
                                </p>
							<?php endforeach; endif; ?>
                        <p>
                            <label for="show-on-frontpage">
                                <input type="checkbox"
                                       name="scta_settings[show_on_frontpage]"
                                       id="show-on-frontpage"
                                       value="1"
									<?php echo ( isset( $this->settings['show_on_frontpage'] ) && $this->settings['show_on_frontpage'] == 1 ) ? ' checked="checked"' : ''; ?>>
								<?php _e( 'Front Page', 'stcky-cta' ); ?>
                            </label>
                        </p>
                    </div>
                </div>


            </div>
            <footer class="scta-panel-footer">
                <input type="submit" class="button-primary"
                       value="<?php _e( 'Save Settings', 'stcky-cta' ); ?>">
            </footer>
        </div>
		<?php
		return true;
	}


	/**
	 * Icons UI Part
	 *
	 * @since 1.0
	 */
	public function icons() {

		// Show on
		if ( ( isset( $this->settings['show_on_pages']) && $this->settings['show_on_pages'] && get_post_type() == 'page' && ! is_front_page() ) ||
		     ( isset($this->settings['show_on_posts']) && $this->settings['show_on_posts'] && ( get_post_type() == 'post' ) ) ||
		     ( isset($this->settings['show_on_frontpage']) && $this->settings['show_on_frontpage'] && is_front_page() ) || (!empty($this->showoncpt) && in_array( get_post_type(), $this->showoncpt ) ) ) {

			// Buttons exists
			if ( isset( $this->buttons['btns'] ) ) {
				?>
                <div id="scta-container"
                     class="<?php
				     echo ( isset( $this->settings['btn_pos'] ) && $this->settings['btn_pos'] == 'left' ) ? 'scta-btns-left' : 'scta-btns-right';
				     echo ( isset( $this->settings['btn_disable_mobile'] ) ) ? ' scta-disable-on-mobile' : '';
				     echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'slide' ) ? ' scta-anim-slide' : '';
				     echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] == 'icons' ) ? ' scta-anim-icons' : '';
				     ?>">
                    <ul class="<?php echo ( isset( $this->settings['btn_hover'] ) && $this->settings['btn_hover'] == 'light' ) ? 'scta-light-hover' : 'scta-dark-hover'; ?>">
						<?php
						// Buttons loop + ordering
						foreach ( $this->btns_order AS $btn_key => $btn_id ) {
							?>
                            <li id="scta-btn-<?php echo $btn_id; ?>">
                                <p>
                                    <a href="<?php echo $this->buttons['btns'][ $btn_id ]['btn_link']; ?>" <?php echo ( !empty($this->buttons['btns'][ $btn_id ]['open_new_window']) ) ? 'target="_blank"' : ''; ?>><?php
										echo ( isset( $this->buttons['btns'][ $btn_id ]['btn_icon'] ) && $this->buttons['btns'][ $btn_id ]['btn_icon'] ) ? '<span class="' . $this->buttons['btns'][ $btn_id ]['btn_icon'] . '"></span> ' : '';
										echo ( isset( $this->buttons['btns'][ $btn_id ]['btn_text'] ) && ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] != 'icons' ) ) ? __( $this->buttons['btns'][ $btn_id ]['btn_text'], 'stcky-cta' ) : ' &nbsp; ';
										?></a>
                                </p>
                            </li>
							<?php
						}

						// Social Icons
						if ( isset( $this->settings['btn_share'] ) ) {
							?>
                            <li class="scta-share-btn">
                                <p>
                                    <a href="#"><span class="fas fa-share-alt"></span> <?php echo ( isset( $this->settings['btn_anim'] ) && $this->settings['btn_anim'] != 'icons' ) ? 'Social Share ' : ' &nbsp;&nbsp; '; ?>
                                    </a>
                                </p>
                                <div class="scta-social-popup">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>"
                                       onclick="window.open(this.href, 'facebook', 'left=60,top=40,width=500,height=500,toolbar=1,resizable=0'); return false;"><span class="fab fa-facebook-f"></span> Facebook</a>
                                    <a href="https://twitter.com/home?status=<?php the_permalink(); ?>"
                                       onclick="window.open(this.href, 'twitter', 'left=60,top=40,width=500,height=500,toolbar=1,resizable=0'); return false;"><span
                                                class="fab fa-twitter"></span> Twitter</a>
                                    <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                                       onclick="window.open(this.href, 'google', 'left=60,top=40,width=500,height=500,toolbar=1,resizable=0'); return false;"><span
                                                class="fab fa-google-plus"></span> Google+</a>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
				<?php
			}
		}

	}

}
