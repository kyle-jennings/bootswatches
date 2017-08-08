<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bootswatch
 */

get_header();

/**
 * get all the settings needed for the the template layout
 *
 * returns:
 * $template
 * $main_width
 * $hide_content
 * $sidebar_position
 *
 */
extract( bootswatch_template_settings() );

if( !$hide_content ):
?>

<div class="section section--body">
    <div class="container">
        <div class="row">

    <?php
    if($sidebar_position == 'left'):
        bootswatch_get_sidebar($template, $sidebar_position);
    endif;
    ?>
    <div class="main-content <?php echo esc_attr($main_width); ?>">
    	<?php
    	while ( have_posts() ) : the_post();

    		get_template_part( 'template-parts/content/content', 'page' );


    	endwhile; // End of the loop.
    	?>
    </div>
    <?php
    if($sidebar_position == 'right'):
        bootswatch_get_sidebar($template, $sidebar_position);
    endif;
    ?>

</div><!-- /row -->
</div><!-- container -->
</div><!-- / section--body -->

<?php
endif;

get_footer();