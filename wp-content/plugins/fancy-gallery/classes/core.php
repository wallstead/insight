<?php Namespace WordPress\Plugin\GalleryManager;

abstract class Core {
  const
    version = '1.6.23'; # Current release number

  public static
    $base_url, # url to the plugin directory
    $plugin_file, # the main plugin file
    $plugin_folder; # the path to the folder the plugin files contains

  static function init($plugin_file){
    static::$plugin_file = $plugin_file;
    static::$plugin_folder = DirName(static::$plugin_file);

    register_Activation_Hook(static::$plugin_file, Array(static::class, 'installPlugin'));
    add_Action('plugins_loaded', Array(static::class, 'loadBaseUrl'));
    add_Filter('post_class', Array(static::class, 'addContentUnitPostClass'));
    add_Filter('body_class', Array(static::class, 'addTaxonomyBodyClass'));
    add_Filter('wp_get_attachment_link', Array(static::class, 'filterAttachmentLink'), 10, 6);
    add_Filter('get_the_archive_title', Array(static::class, 'filterArchiveTitle'));
  }

  public static function installPlugin(){
    Gallery_Taxonomies::updateTaxonomyNames();
    Gallery_Post_Type::updatePostTypeName();
    Gallery_Taxonomies::registerTaxonomies();
    Gallery_Post_Type::registerPostType();
    flush_Rewrite_Rules();
  }

  public static function loadBaseURL(){
    $absolute_plugin_folder = RealPath(static::$plugin_folder);

    if (StrPos($absolute_plugin_folder, ABSPATH) === 0)
      static::$base_url = site_url().'/'.SubStr($absolute_plugin_folder, Strlen(ABSPATH));
    else
      static::$base_url = Plugins_Url(BaseName(static::$plugin_folder));

    static::$base_url = Str_Replace("\\", '/', static::$base_url); # Windows Workaround
  }

  static function addContentUnitPostClass($arr_class){
    setType($arr_class, 'ARRAY');
    $arr_class[] = 'gallery-content-unit';
    return $arr_class;
  }

  static function addTaxonomyBodyClass($arr_class){
    setType($arr_class, 'ARRAY');
    if (Query::isGalleryTaxonomyArchive()) $arr_class[] = 'gallery-taxonomy';
    return $arr_class;
  }

  static function filterAttachmentLink($link, $id, $size, $permalink, $icon, $text){
    if (WP_Attachment_Is_Image($id)){
      $image = get_Post($id);
      $image_title = esc_Attr($image->post_title);
      $image_description = esc_Attr($image->post_content);

      if (StrPos($link, ' title=') === False)
        $link = Str_Replace('<a ', "<a title='{$image_title}' ", $link);

      if (StrPos($link, ' data-description=') === False)
        $link = Str_Replace('<a ', "<a data-description='{$image_description}' ", $link);
    }

    return $link;
  }

  static function filterArchiveTitle($title){
    if (is_Post_Type_Archive(Gallery_Post_Type::post_type_name))
      return post_type_archive_title('', false);
    else
      return $title;
  }

}
