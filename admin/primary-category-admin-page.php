<?php

/**
 * The file that outputs html and functions for admin settings page.
 *
 *
 * @link       http://profile.wordpress.org/waleedt93
 * @since      1.0.0
 *
 * @package    Primary_Category
 * @subpackage Primary_Category/includes
 */
function primary_category_admin_page_output(){
    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this settings page.');
    }

    echo '<div class="wrap">';

    	/*update primary category settings in options table*/
	    if ( isset( $_POST[ 'save_primary_category_settings' ] )
	    	&& 	wp_verify_nonce( sanitize_key( $_POST['primary_category_nonce'] ), 'primary-category-settings' )
			) {
		    	if (isset($_POST['primary_category']) && !empty($_POST['primary_category'])) {
					$posted_data = array();
					$posted_data = wp_unslash( $_POST['primary_category'] );
		    	} else {
		    		$posted_data = 'none';
		    	}

				$updated = update_option( 'primary_category_option', $posted_data ); // update settings options

				
		        echo '<div id="message" class="updated fade"><p>';
				echo esc_html__( 'The options has been updated.', 'primary-category' );
		        echo '</p></div>';
			}
    	?>

        <h2><?php _e( 'Primary Category Settings', 'primary-category' ); ?></h2>

        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <p><?php _e( 'This page provide options to manage primary category plugin settings', 'primary-category' ); ?></p>
        </div>

        <div id="poststuff">
        	<div id="post-body">
	            <div class="postbox">
	            	<h3 class="hndle">
	            		<label for="title"><?php _e( 'Enable/Disable primary category feature for specific taxanomies:', 'primary-category' ); ?></label>
	            	</h3>
		            <div class="inside">
		                <form method="post" action="" >
							<?php
							wp_nonce_field( 'primary-category-settings', 'primary_category_nonce' );
							$post_types_args = array( 'show_in_nav_menus' => true );
							$post_types = get_post_types( $post_types_args, 'objects' );
							$taxonomies_args = array( 'hierarchical' => true );
							$taxonomies = get_taxonomies( $taxonomies_args, 'objects' );

							$get_option_data = get_option( 'primary_category_option', array() );

							$data       = array();

							foreach ( $taxonomies as $taxonomy ) {
								foreach ( $post_types as $post_type ) {
									if ( in_array( $post_type->name, $taxonomy->object_type, true ) ) {
										if ( ! isset( $data[ $post_type->name ] ) ) {
											$data[ $post_type->name ]['post_type'] = $post_type;
											
											if ( $get_option_data !== 'none' && array_key_exists( $post_type->name, $get_option_data ) ) {
												$data[ $post_type->name ]['option'] = $get_option_data[ $post_type->name ];
											} else {
												$data[ $post_type->name ]['option'] = array();
											}
										}
										$data[ $post_type->name ]['taxonomies'][] = $taxonomy;
									}
								}
							}

							if ( ! empty( $data ) ) {
							?>
								<ul>
								<?php foreach ( $data as $name => $value ) : ?>
									<li>
										<h3><?php echo esc_html( $value['post_type']->label ); ?></h3>
										<ul>
										<?php foreach ( $value['taxonomies'] as $taxonomy ) : ?>
											<?php
											if ( in_array( $name, $taxonomy->object_type, true ) ) {
												$checked = in_array( $taxonomy->name, $value['option'], true ) ? $taxonomy->name : '';
												?>
												<li>
													<label>
													<input type="checkbox" name="primary_category[<?php echo esc_attr( $value['post_type']->name ); ?>][]" value="<?php echo esc_attr( $taxonomy->name ); ?>"<?php echo esc_attr( checked( $checked, $taxonomy->name ) ); ?> ><?php echo esc_html( $taxonomy->label ); ?></label>
												</li>
											<?php }
										endforeach; ?>
										</ul>
									</li>
								<?php
								endforeach;
								echo '</ul>';
							}	
							?>
			                <div class="submit">
			                    <input type="submit" class="button" name="save_primary_category_settings" value="<?php _e( 'Save Changes', 'primary-category' ); ?>" />
			                </div>
		                </form>
		            </div>
	            </div>
	        </div>
        </div>

	    <script type="text/javascript">
	        jQuery(document).ready(function ($) {
	        $('.fade').click(function () {
	            $(this).fadeOut('slow');
	        });
	        });
	    </script>
	</div>
	<!-- end of wrap -->
    <?php
}