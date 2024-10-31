<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_PMD
 * @license       Copyright JLT_PMD
 */

if ( ! function_exists( 'jltpmd_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltpmd_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltpmd_option( $section = 'jltpmd_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jltpmd_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltpmd_exclude_pages() {
		return jltpmd_option( 'jltpmd_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jltpmd_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltpmd_exclude_pages_except() {
		return jltpmd_option( 'jltpmd_triggers', 'exclude_pages_except', array() );
	}
}