<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<table style="width:100%"><tr>
            <td class="content-date">
                <div class="content-date-day"><?php the_time('j M') ?></div>
                <div class="content-date-year"><?php the_time('Y') ?></div>
            </td>
            <td class="content-title">
            	<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                <div>written by <a href="mailto:<?php echo the_author_meta('user_email') ?>"><strong><?php echo get_the_author(); ?></strong></a></div>
            </td>
            </tr></table>
            <div class="content-body">
				<?php the_content(); ?>
				<?php edit_post_link('[ Edit this entry ]','',''); ?>
			</div>
            
            <div class="content-footer">
            	<div class="content-footer-categories">Posted in <?php the_category(', ') ?></div>
                <div class="content-footer-tags"><?php the_tags('Tags: ', ', ', '<br />'); ?></div>
            </div>
			
		</article>
        
        <div id="navigation-below">
            <div class="nav-previous"><?php previous_post_link( '%link', __( '<span>&larr;</span> Previous', 'ronzaro' ) ); ?></div>
            <div class="nav-next"><?php next_post_link( '%link', __( 'Next <span>&rarr;</span>', 'ronzaro' ) ); ?></div>
        </div>

	<?php endwhile; endif; ?>
    </div>

<?php get_footer(); ?>