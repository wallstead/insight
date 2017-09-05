<?php Namespace WordPress\Plugin\GalleryManager;

abstract class Styles {

  static function init(){
    add_Action('wp_enqueue_scripts', Array(static::class, 'enqueueStyles'));
  }

  static function enqueueStyles(){
    WP_Enqueue_Style('gallery-manager', Core::$base_url . '/assets/css/gallery-manager.css');
  }

}

Styles::init();
