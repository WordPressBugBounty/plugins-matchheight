<?php
/**
 * Plugin Name:       matchHeight
 * Plugin URI:        https://wpbeaches.com/
 * Description:       Makes selected elements equal in height using the jQuery matchHeight library.
 * Version:           1.2.1
 * Requires at least: 5.8
 * Requires PHP:      7.2
 * Author:            Neil Gee
 * Author URI:        https://wpbeaches.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       matchheight
 * Domain Path:       /languages
 *
 * @package MatchHeight
 */

namespace ng_matchheight;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VERSION = '1.2.1';

/**
 * Load plugin translations.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( 'matchheight', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', __NAMESPACE__ . '\\load_textdomain' );

/**
 * Enqueue matchHeight when at least one selector has been configured.
 *
 * @return void
 */
function enqueue_scripts() {
	$options  = get_option( 'matchheight_settings', array() );
	$selector = isset( $options['mh_selectors'] ) ? trim( (string) $options['mh_selectors'] ) : '';

	if ( '' === $selector ) {
		return;
	}

	wp_enqueue_script(
		'matchheight',
		plugins_url( 'js/jquery.matchHeight-min.js', __FILE__ ),
		array( 'jquery' ),
		'0.7.2',
		true
	);

	wp_enqueue_script(
		'matchheight-init',
		plugins_url( 'js/matchHeight-init.js', __FILE__ ),
		array( 'matchheight' ),
		VERSION,
		true
	);

	wp_add_inline_script(
		'matchheight-init',
		'window.matchHeightSettings = ' . wp_json_encode( array( 'selector' => $selector ) ) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );

/**
 * Register plugin settings and fields.
 *
 * @return void
 */
function register_settings() {
	register_setting(
		'mh_settings_group',
		'matchheight_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => __NAMESPACE__ . '\\sanitize_settings',
			'default'           => array( 'mh_selectors' => '' ),
		)
	);

	add_settings_section(
		'mh_matchheight_section',
		__( 'matchHeight settings', 'matchheight' ),
		'__return_false',
		'matchheight'
	);

	add_settings_field(
		'mh_selectors',
		__( 'Element selectors', 'matchheight' ),
		__NAMESPACE__ . '\\render_selectors_field',
		'matchheight',
		'mh_matchheight_section'
	);
}
add_action( 'admin_init', __NAMESPACE__ . '\\register_settings' );

/**
 * Sanitize plugin settings.
 *
 * CSS selector syntax is deliberately not restricted to classes and IDs;
 * attribute selectors, combinators, and pseudo-selectors are also valid.
 *
 * @param mixed $input Submitted setting value.
 * @return array
 */
function sanitize_settings( $input ) {
	$output = array( 'mh_selectors' => '' );

	if ( is_array( $input ) && isset( $input['mh_selectors'] ) && is_string( $input['mh_selectors'] ) ) {
		$output['mh_selectors'] = sanitize_text_field( wp_unslash( $input['mh_selectors'] ) );
	}

	return $output;
}

/**
 * Render the selector setting.
 *
 * @return void
 */
function render_selectors_field() {
	$options  = get_option( 'matchheight_settings', array() );
	$selector = isset( $options['mh_selectors'] ) ? (string) $options['mh_selectors'] : '';
	?>
	<input
		type="text"
		id="mh_selectors"
		name="matchheight_settings[mh_selectors]"
		value="<?php echo esc_attr( $selector ); ?>"
		placeholder="<?php echo esc_attr__( 'For example: .card, .feature', 'matchheight' ); ?>"
		class="large-text"
	/>
	<p class="description">
		<?php esc_html_e( 'Enter CSS selectors for the elements to equalize. Separate multiple selectors with commas.', 'matchheight' ); ?>
	</p>
	<?php
}

/**
 * Register the settings page.
 *
 * @return void
 */
function add_settings_page() {
	add_options_page(
		__( 'matchHeight settings', 'matchheight' ),
		__( 'matchHeight', 'matchheight' ),
		'manage_options',
		'matchheight',
		__NAMESPACE__ . '\\render_settings_page'
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\\add_settings_page' );

/**
 * Render the settings page.
 *
 * @return void
 */
function render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'matchheight' ) );
	}

	require plugin_dir_path( __FILE__ ) . 'inc/options-page-wrapper.php';
}

/**
 * Add a direct Settings link on the Plugins screen.
 *
 * @param string[] $links Existing action links.
 * @return string[]
 */
function add_action_links( $links ) {
	$settings_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'options-general.php?page=matchheight' ) ),
		esc_html__( 'Settings', 'matchheight' )
	);

	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), __NAMESPACE__ . '\\add_action_links' );
