<?php Namespace WordPress\Plugin\GalleryManager;

abstract class Mocking_Bird {

  static function init(){
    add_Action('admin_init', Array(static::class, 'checkCreatedPost'));
    add_Action('untrash_post', Array(static::class, 'checkUntrashedPost'));
    add_Action('admin_footer', Array(static::class, 'changeCreateGalleryLink'));
    add_Action('admin_bar_menu', Array(static::class, 'removeAdminBarCreateGalleryButton'), PHP_INT_MAX);
    add_Action('gallery-manager-lightbox-wrapper', Array(static::class, 'printLighboxBranding'));

    #add_Filter('attachment_fields_to_edit', Array(static::class, 'addProNoticeToEditAttachmentDialog'), 10, 2 );
    #add_Action('admin_footer', Array(static::class, 'addMediaFrameUpgradeNotice'));
  }

  static function printProNotice($message_id){
    echo static::getProNotice($message_id);
  }

  static function getProNotice($message_id){
    $arr_message = Array(
      'count_limit' => I18n::t('In the <a href="%s" target="_blank">premium version of Gallery Manager</a> you can take advantage of the gallery management without any limitations.'),
      'upgrade' => I18n::t('Upgrade to Pro'),
      'upgrade_url' => '%s',
      'feature' => I18n::t('This feature is available in the <a href="%s" target="_blank">premium version</a>.'),
      'unlock' => sprintf('<a href="%%s" title="%s" class="unlock" target="_blank"><span class="dashicons dashicons-lock"></span></a>', I18n::t('Unlock this feature')),
    );

    $website_url = I18n::t('http://dennishoppe.de/en/wordpress-plugins/gallery-manager', 'Link to the authors website');

    if (isSet($arr_message[$message_id]))
      return sprintf($arr_message[$message_id], $website_url);
    else
      return False;
  }

  static function getNumberOfGalleries($limit = -1){
    static $count;

    if ($count){
      return $count;
    }
    else {
      $query_args = Array(
        'post_type' => Gallery_Post_Type::post_type_name,
        'post_status' => 'any',
        'numberposts' => $limit
      );
      $arr_posts = get_Posts($query_args);
      $count = count($arr_posts);
      return $count;
    }
  }

  static function printGalleryCountLimit(){
    $message = static::getProNotice('count_limit');
    $back_link = sprintf('<a href="%s" class="button">%s</a>', Admin_URL('edit.php?post_type=' . Gallery_Post_Type::post_type_name), I18n::t('&laquo; Back to your galleries'));
    $error = sprintf('<p>%s</p><p>%s</p>', $message, $back_link);
    WP_Die($error);
  }

  static function checkUntrashedPost($post_id){
    if (get_Post_Type($post_id) == Gallery_Post_Type::post_type_name && !static::checkGalleryCount()) static::printGalleryCountLimit();
  }

  static function checkCreatedPost(){
    $created_new_post = isSet($_SERVER['SCRIPT_NAME']) && BaseName($_SERVER['SCRIPT_NAME']) == 'post-new.php';
    $is_gallery_post = isSet($_GET['post_type']) && $_GET['post_type'] == Gallery_Post_Type::post_type_name;
    if ($created_new_post && $is_gallery_post && !static::checkGalleryCount()) static::printGalleryCountLimit();
  }

  static function checkGalleryCount(){
    return static::getNumberOfGalleries(3) < 3;
  }

  static function printLighboxBranding(){
    if (current_User_Can('install_plugins')): ?>
    
    <?php endif;
  }

  static function changeCreateGalleryLink(){
    if (!static::checkGalleryCount()): ?>
    <script type="text/javascript">
    (function($){
      $('a[href*="post-new.php?post_type=<?php echo Gallery_Post_Type::post_type_name ?>"]')
        .text('<?php static::printProNotice('upgrade') ?>')
        .attr({
          'title': '<?php static::printProNotice('upgrade') ?>',
          'href': '<?php static::printProNotice('upgrade_url') ?>',
          'target': '_blank'
        })
        .css({
          'color': '#46b450',
          'font-weight': 'bold'
        });
    }(jQuery));
    </script>
    <?php endif;
  }

  static function removeAdminBarCreateGalleryButton($admin_bar){
    $node = sprintf('new-%s', Gallery_Post_Type::post_type_name);
    if (!static::checkGalleryCount()) $admin_bar->remove_Node($node);
  }

  /*
  static function addProNoticeToEditAttachmentDialog($form_fields, $post){
    if (WP_Attachment_Is_Image($post->ID)){
      $form_fields['gallery-manager-pro'] = Array(
        'tr' => sprintf('<tr><td colspan="2">%s</td></tr>', 'Lorem ipsum dolor sit amet.')
      );
    }

    return $form_fields;
  }

  static function addMediaFrameUpgradeNotice(){
    ?>
    <script type="text/javascript">
    (function($){
      $(document).on('DOMSubtreeModified', function(event){
        var
          target = event.target,
          $target = $(target),
          is_media_frame = $target.hasClass('media-frame');

        if (is_media_frame){
          var
            $media_menu = $target.find('div.media-menu').first(),
            $image_column = $target.find('div.column-image'),
            notice_class = 'gallery-manager-notice',
            $notice = $('<a>').prop('class', notice_class).css('background', 'red');

          if ($media_menu.find('.' + notice_class).length < 1){
            $notice.html('Here I am!').appendTo($media_menu);
          }

          if ($image_column.find('.' + notice_class).length < 1){
            $notice.html('Here I am!').appendTo($image_column);
          }

        }
      });
    }(jQuery));
    </script>
    <?php
  }
  */

}

Mocking_Bird::init();
