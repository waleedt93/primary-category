<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://profile.wordpress.org/waleedt93
 * @since      1.0.0
 *
 * @package    Primary_Category
 * @subpackage Primary_Category/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Primary_Category
 * @subpackage Primary_Category/admin
 * @author     Waleed <waleedt93@gmail.com>
 */
class Primary_Category_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the plugin settings page for admin area.
	 *
	 * @since    1.0.0
	 */
	public function primary_category_admin_menu() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Category_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Category_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		// add submene page under settings menu and call function primary_category_admin_page_output()
		add_submenu_page(
			'options-general.php',
			esc_html__( 'Primary Category Settings', 'primary-category' ),
			esc_html__( 'Primary Category', 'primary-category' ),
			'manage_options',
			$this->plugin_name,
			'primary_category_admin_page_output'
		);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Category_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Category_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/primary-category-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Category_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Category_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$primary_category_options = get_option( 'primary_category_option', array() ); //get primary category options
		$screen = get_current_screen(); // get current screen
		global $pagenow; // to get current post type
		if (
			!empty($primary_category_options) // if primary category options are saved
			&& $primary_category_options !== 'none' // if primary category options are not empty
			&& ($pagenow == 'post.php' || $pagenow == 'post-new.php') // if current screen is post-edit or post-new
			&& array_key_exists( $screen->post_type, $primary_category_options ) // if primary categry is enabled for current post type
		) {
			wp_enqueue_script( $this->plugin_name.'_js', plugin_dir_url( __FILE__ ) . 'js/primary-category-admin.js', array( 'jquery' ), $this->version, false );

			$taxonomies = $primary_category_options[$screen->post_type]; // get taxonomies for current post type
			wp_localize_script(
				$this->plugin_name.'_js',
				'PRIMARY_CAT',
				array(
					'label' => __( 'Set as Primary', 'primary-category' ), // pass label to JS
					'taxonomies' => (array) $taxonomies,// pass taxonomies to JS
				)
			);
		}

	}


	/**
	 * Generates hidden html input fields with selected primary category terms ids.
	 *
	 * @since    1.0.0
	 */
	public function edit_form_input_fields($post) {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Category_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Category_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$primary_category_options = get_option( 'primary_category_option', array() );  //get primary category options
		global $pagenow; // to get current post type
		if (
			!empty($primary_category_options) // if primary category options are saved
			&& $primary_category_options !== 'none' // if primary category options are not empty
			&& ($pagenow == 'post.php' || $pagenow == 'post-new.php') // if current screen is post-edit or post-new
			&& array_key_exists( $post->post_type, $primary_category_options ) // if primary categry is enabled for current post type
		) {
			$taxonomies = $primary_category_options[$post->post_type]; // get taxonomies for current post type
			foreach ( $taxonomies as $taxonomy ) { //for every taxonomy
				$term_id = get_post_meta( $post->ID, '_primary_category_' . $taxonomy, true ); //get current primary category
				?>
				<!-- Create hidden input field with selected primary category -->
				<input type="hidden" name="primary_category[<?php echo esc_attr( $taxonomy ); ?>]" id="primary-input-<?php echo esc_attr( $taxonomy ); ?>" value="<?php if(!empty($term_id)) { echo absint( $term_id ); }; ?>">
			<?php } ?>
		<?php
		}

	}

	/**
	 * Save selected primary category term-id on post-edit and post-new in post meta.
	 *
	 * @since    1.0.0
	 */
	public function save_post_primary_category($post_id) {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Primary_Category_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Primary_Category_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if (isset( $_POST['primary_category'] )	) {

			$data = wp_unslash( $_POST['primary_category'] );

			if ( ! empty( $data ) ) {
				foreach ( $data as $taxonomy => $term_id ) {
					update_post_meta( $post_id, '_primary_category_' . $taxonomy, $term_id );// save current taxonomy term id for post id
				}

				update_post_meta( $post_id, '_primary_category', $data ); // save all taxonmies and their selected primary categories in seriliazed form
			}
		}

	}
}