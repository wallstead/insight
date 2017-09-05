<?php

/*
Plugin Name: Gallery Manager Lite
Plugin URI: http://dennishoppe.de/en/wordpress-plugins/gallery-manager
Description: This awesome Gallery Manager enables you to create and manage image galleries easily. Furthermore it associates linked images in posts and pages with a nice and responsive touch-enabled lightbox.
Version: 1.6.23
Author: Dennis Hoppe
Author URI: http://DennisHoppe.de
*/

if (Version_Compare(PHP_VERSION, '5.5', '<')){
  die(sprintf('Your PHP version (%s) is far too old. <a href="http://php.net/supported-versions.php" target="_blank">Please upgrade immediately.</a> Then activate the plugin again.', PHP_VERSION));
}

$includeFiles = function($pattern){
  $arr_files = glob($pattern);
  if (is_Array($arr_files)){
    foreach ($arr_files as $include_file){
      include_once $include_file;
    }
  }
};

# Load core classes
$includeFiles(__DIR__ . '/classes/*.php');
$includeFiles(__DIR__ . '/widgets/*.php');

# Inititalize Plugin
WordPress\Plugin\GalleryManager\Core::init(__FILE__);
