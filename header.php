<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BF_FUTURETASTIC
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">

        <script> /* this will stop the page from showing until text is loaded */
          (function(d) {
            var config = {
              kitId: 'eok4egk',
              scriptTimeout: 3000,
              async: false
            },
            h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
          })(document);
        </script>
        <script src="https://use.fontawesome.com/69aa1143c1.js"></script>

        <?php wp_head(); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
        <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>


    </head>

    <body <?php body_class(); ?>>
    <div id="page" class="site">
    	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bf_futuretastic' ); ?></a>
    	<div id="header-container">
            <div class="header-bg">
                <div class="nav-container">
                    <nav id="navbar" role="navigation">
            			<section class="logo-container" role="banner" aria-label="Brushfire Logo">
                            <button id="navburger" class="hamburger hamburger--slider" type="button" aria-label="Menu" aria-controls="navigation">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
            				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand mr-10" rel="home"><img class="logo" src="/wp-content/uploads/2017/06/Insight_Logo.png" alt="Insight"></a>
            			</section>
                        <div class="navlinks" role="menubar" aria-label="Navigation Links">
                            <section class="links" role="menu" aria-label="Main Navigation Links" >
                				<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
                			</section>
                        </div>
            		</nav>
                </div>

                <div id="issuu-docs">
                    <?php
                        $response = wp_remote_get( 'http://search.issuu.com/api/2_0/document?q=username:insightunr&responseParams=%2A&sortBy=epoch' );
                        if( is_array($response) ) {
                          $header = $response['headers']; // array of http header lines
                            $body = $response['body']; // use the content
                            $array = json_decode( $body, true );
                            if( ! empty( $array ) ) {

                                $counter = 0;
                                foreach($array['response']['docs'] as $doc) {

                                    $docTitle = str_replace('Insight: ', '', $doc['title']);
                                    if($counter == 0) {
                                        echo '<a href="https://issuu.com/insightunr/docs/'.$doc['docname'].'"><div class="recent-journal index-'.$counter.'"><p><span>New</span> '.$docTitle.'</p><img src="https://image.isu.pub/'.$doc['documentId'].'/jpg/page_1_thumb_large.jpg" alt="'.$doc['title on Issuu'].'"></div></a>';
                                    } else {
                                        echo '<a href="https://issuu.com/insightunr/docs/'.$doc['docname'].'"><div class="recent-journal index-'.$counter.'"><p>'.$docTitle.'</p><img src="https://image.isu.pub/'.$doc['documentId'].'/jpg/page_1_thumb_large.jpg" alt="'.$doc['title on Issuu'].'"></div></a>';
                                    }

                                    $counter++;
                                }
                            }
                        }
                    ?>
                    <!-- loading animation -->
                    <div class="la-ball-spin-clockwise la-2x loading-header">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
    	</div>

        <script>
        $( window ).on( "load", function() {
            $('.loading-header').fadeOut( "slow", function() {
                $('.loading-header').css("display", "none");
                $('.recent-journal').each(function(i, obj) {
                    $(this).css("display", "block");
                    $(this).css("display");
                    $(this).delay(75*i).queue(function(){
                        $(this).addClass("loaded-journal").clearQueue();
                    });
                });
            });
        });
        </script>

    	<div id="content" class="site-content">
