<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content">
	<?php if (have_posts()) : ?>

		<h2 style="background:#D9C49C; color:#593528; border:2px solid #593528; width:165px; padding:5px; margin-bottom:5px; font-weight:200; letter-spacing:2px">Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>
        	<?php if (is_type_page()) continue; ?>
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
                    <?php the_excerpt(); ?>
                </div>
                
                <div class="content-footer">
                    <div class="content-footer-categories">Posted in <?php the_category(', ') ?></div>
                    <div class="content-footer-tags"><?php the_tags('Tags: ', ', ', '<br />'); ?></div>
                </div>
    
            </article>
		<?php endwhile; ?>

	<?php else : ?>

		<h2 style="background:#D9C49C; color:#593528; border:2px solid #593528; width:170px; padding:5px; margin-bottom:5px; font-weight:200; letter-spacing:2px">No posts found.</h2>

	<?php endif; ?>
    </div>

<?php get_footer(); ?>
