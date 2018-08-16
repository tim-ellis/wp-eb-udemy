<?php
$version = '1.7.2';

// We set versions for both slugs to avoid undefined index errors for free slug
$GLOBALS['aws_meta']['amazon-s3-and-cloudfront-pro']['version'] = $version;
$GLOBALS['aws_meta']['amazon-s3-and-cloudfront']['version']     = $version;

$GLOBALS['aws_meta']['amazon-s3-and-cloudfront-pro']['supported_addon_versions'] = array(
	'amazon-s3-and-cloudfront-assets'      => '1.2.8',
	'amazon-s3-and-cloudfront-assets-pull' => '1.0.2',
);
