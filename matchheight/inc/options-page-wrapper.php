<?php
/**
 * Settings page markup.
 *
 * @package MatchHeight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'matchHeight', 'matchheight' ); ?></h1>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'mh_settings_group' );
		do_settings_sections( 'matchheight' );
		submit_button( __( 'Save changes', 'matchheight' ) );
		?>
	</form>
</div>
