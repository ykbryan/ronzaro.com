<?php get_header(); ?>
	
<?php get_sidebar(); ?>

	<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<table style="width:100%"><tr>
            <td class="content-date">
            	<div class="content-date-month"><?php the_time('M') ?></div>
                <div class="content-date-day"><?php the_time('j') ?></div>
                <div class="content-date-year"><?php the_time('Y') ?></div>
            </td>
            <td>
            	<h2 class="content-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                <div class="content-author">written by <strong><?php echo get_the_author(); ?></strong></div>
            </td>
            </tr></table>
            <div class="content-body">
				<?php the_content(); ?>
			[ <?php edit_post_link('Edit this entry','',''); ?> ]
			</div>
            
            <div class="content-footer">
            	<div class="content-footer-categories">Posted in <?php the_category(', ') ?></div>
                <div class="content-footer-tags"><?php the_tags('Tags: ', ', ', '<br />'); ?></div>
            </div>
			
            <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
            
			
		</article>

	<?php endwhile; endif; ?>
    </div>

<?php get_footer(); ?>