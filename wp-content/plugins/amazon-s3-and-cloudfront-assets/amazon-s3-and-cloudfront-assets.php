<?php
/*
Plugin Name: WP Offload S3 - Assets Addon (Deprecated)
Plugin URI: https://deliciousbrains.com/wp-offload-s3/doc/assets-addon/
Description: An addon for WP Offload S3 to serve your site's JS, CSS and other assets from S3, CloudFront, or another CDN.
Author: Delicious Brains
Version: 1.2.8
Author URI: https://deliciousbrains.com
Network: True

// Copyright (c) 2015 Delicious Brains. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
//
*/

require_once dirname( __FILE__ ) . '/version.php';

$as3cfpro_plugin_version_required = '1.7';

require dirname( __FILE__ ) . '/classes/as3cf-compatibility-check.php';
global $as3cf_assets_compat_check;
$as3cf_assets_compat_check = new AS3CF_Compatibility_Check(
	'WP Offload S3 - Assets Addon',
	'amazon-s3-and-cloudfront-assets',
	__FILE__,
	'WP Offload S3',
	'amazon-s3-and-cloudfront-pro',
	$as3cfpro_plugin_version_required,
	null,
	false,
	'https://deliciousbrains.com/wp-offload-s3/'
);

/**
 * @param Amazon_S3_And_CloudFront_Pro $as3cf
 *
 * @throws Exception
 */
function as3cf_assets_init( $as3cf ) {
	global $as3cf_assets_compat_check;
	global $as3cf_assets;

	if ( ! $as3cf_assets_compat_check->is_compatible() ) {
		return;
	}

	$abspath = dirname( __FILE__ );

	require_once $abspath . '/classes/amazon-s3-and-cloudfront-assets.php';
	require_once $abspath . '/classes/class-minify.php';
	require_once $abspath . '/classes/class-process-assets.php';
	require_once $abspath . '/classes/class-recursive-callback-filter-iterator.php';
	require_once $abspath . '/classes/class-upgrade.php';
	require_once $abspath . '/classes/async-requests/as3cf-scan-files-for-s3.php';
	require_once $abspath . '/classes/async-requests/as3cf-remove-files-from-s3.php';
	require_once $abspath . '/classes/background-processes/class-minify-background-process.php';
	require_once $abspath . '/classes/background-processes/class-process-assets-background-process.php';
	require_once $abspath . '/classes/minify/class-provider-interface.php';
	require_once $abspath . '/classes/minify/class-cssmin-provider.php';
	require_once $abspath . '/classes/minify/class-jshrink-provider.php';

	require_once $abspath . '/wp-offload-s3-autoloader.php';
	new WP_Offload_S3_Autoloader( 'WP_Offload_S3_Assets', $abspath );

	$as3cf_assets = new Amazon_S3_And_CloudFront_Assets( __FILE__ );
}
add_action( 'as3cf_pro_init', 'as3cf_assets_init', 12 );
