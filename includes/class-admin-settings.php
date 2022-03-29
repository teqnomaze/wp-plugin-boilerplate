<?php
/**
 * The plugin settings page file.
 *
 * @package Wpb
 */

namespace Wpb;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The plugin settings class.
 */
class Admin_Settings {

	/**
	 * Instantiate class.
	 *
	 * @return self
	 */
	public function init(): self {

		// Add admin settings sub menu and page.
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );

		// Register settings options.
		add_action( 'admin_init', array( $this, 'register_settings_fields' ) );

		return $this;
	}

	/**
	 * Add admin pages.
	 *
	 * @return void
	 */
	public function add_admin_pages(): void {

		add_options_page(
			__( 'WP Plugin Bolierplate', 'wpb-text' ),
			__( 'Plugin Bolierplate', 'wpb-text' ),
			'manage_options',
			'wpb',
			array( $this, 'page_callback' )
		);
	}

	/**
	 * Settings page display callback.
	 *
	 * phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	 *
	 * @return void
	 */
	public function page_callback(): void {

		echo '<div class="wrap"><h1>' . esc_html( get_admin_page_title() ) . '</h1>';
		echo '<form method="post" enctype="multipart/form-data" action="options.php">';

		settings_fields( 'wpb-settings' );
		do_settings_sections( 'wpb-settings' );
		submit_button();

		echo '</form>';
	}

	/**
	 * Register settings options.
	 *
	 * @return void
	 */
	public function register_settings_fields(): void {
		// Register the fields.
		register_setting( 'wpb-settings', 'wpb_settings' );

		// Get the default values.
		$options = get_option( 'wpb_settings' );

		// Add the global section.
		add_settings_section( 'wpb-settings', '', '__return_false', 'wpb-settings' );

		// Add the headscript field.
		add_settings_field(
			'optionone',
			__( 'Option One', 'wpb-text' ),
			array( $this, 'render_field' ),
			'wpb-settings',
			'wpb-settings',
			array(
				'type'    => 'text',
				'id'      => 'optionone',
				'name'    => 'optionone',
				'class'   => 'regular-text',
				'default' => ! empty( $options['optionone'] ) ? $options['optionone'] : '',
				'desc'    => esc_html__( 'These is an example option.', 'wpb-text' ),
			)
		);
	}

	/**
	 * Render input field callback.
	 *
	 * @param  array $args The additional params.
	 * @return void
	 */
	public function render_field( $args ): void {

		$args['name'] = 'wpb_settings[' . $args['name'] . ']';
		$html         = '';
		$checked      = '';

		if ( 'textarea' === $args['type'] ) {
			$html = sprintf(
				'<textarea id="%s" name="%s" rows="3" class="%s">%s</textarea>',
				esc_attr( $args['id'] ),
				esc_attr( $args['name'] ),
				esc_attr( $args['class'] ),
				esc_attr( $args['default'] )
			);
		} elseif ( 'select' === $args['type'] ) {
			$html .= sprintf(
				'<select id="%s" name="%s" class="%s">',
				esc_attr( $args['id'] ),
				esc_attr( $args['name'] ),
				esc_attr( $args['class'] )
			);

			if ( ! empty( $args['options'] ) && is_array( $args['options'] ) ) {
				foreach ( $args['options'] as $key => $value ) {
					$selected = ( (string) $args['default'] === (string) $value['id'] ) ? 'selected' : '';
					$html    .= sprintf(
						'<option %s value="%s">%s</option>',
						$selected,
						esc_attr( $value['id'] ),
						esc_attr( $value['text'] )
					);
				}
			}

			$html .= '</slect>';
		} else {
			if ( 'checkbox' === $args['type'] || 'radio' === $args['type'] ) {
				if ( isset( $args['value'] ) && $args['value'] === $args['default'] ) {
					$checked = 'checked="checked"';
				}
			}
			$html .= sprintf(
				'<input type="%s" id="%s" name="%s" class="%s" value="%s" %s />',
				esc_attr( $args['type'] ),
				esc_attr( $args['id'] ),
				esc_attr( $args['name'] ),
				esc_attr( $args['class'] ),
				esc_attr( $args['default'] ),
				$checked
			);
		}

		if ( $args['desc'] ) {
			$html .= sprintf( '<br><em><span class="description">%s</span></em>', $args['desc'] );
		}

		echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
