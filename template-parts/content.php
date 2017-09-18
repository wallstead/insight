<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BF_FUTURETASTIC
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<?php
		$textColor = rwmb_meta( 'color_text');
		$bgColor = rwmb_meta( 'color_bg');
		$excerpt = rwmb_meta( 'excerpty');
		$pubDate = rwmb_meta( 'original_pub_date');
		$byLine = rwmb_meta( 'by_line');
		$content = get_the_content();
	?>
	<div class="article-outter" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
		<div class="article-inner" style="background-color: <?php echo $bgColor; ?>; background: linear-gradient(to bottom, <?php echo $bgColor; ?>, rgba(0,0,0,0));">
			<header class="entry-header <?php if (!is_home()) { echo 'single'; } ?>">
				<?php
					if ( is_home() ) {
						the_title( '<a href="' . esc_url( get_permalink() ) . '"><h2 class="entry-title" style="color: '.$textColor.'">', '</h2></a>' );
					} else {
						the_title( '<h1 class="entry-title"><a style="color: '.$textColor.'" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
					}
				 ?>
				<?php
				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta" style="color: <?php echo $textColor;?>">
					<p><?php echo date( 'F d, Y', strtotime( $pubDate ) ); ?> <span class="fa fa-circle" aria-hidden="true"></span> By <?php echo $byLine; ?></p>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</header><!-- .entry-header -->

			<?php
				if ( is_home() ) {
					echo '<div class="entry-content" style="color: '.$textColor.'; text-shadow: 0 0 20px '.$bgColor.';" ><p>'.$excerpt.' <a class="readmore" href="' . esc_url( get_permalink() ) . '" style="color: '.$textColor.'; text-shadow: 0 0 20px '.$bgColor.';">Read More <span class="fa fa-chevron-right" aria-hidden="true"></span></a></p></div>';
				}
			?>
		</div>

	</div>
	<?php
		if ( !is_home() ) {
			echo '<div class="entry-content single">'.$content.'</div>';
		}
	?>


</article><!-- #post-## -->
