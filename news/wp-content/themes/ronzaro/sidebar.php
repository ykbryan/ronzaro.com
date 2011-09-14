<div id="sidebar">
    <div id="search-div">
		<?php get_search_form(); ?>
		<!-- <input type="text" class="searchbox" /><img src="images/search_button.gif" alt="Search" /> -->
    </div>
    <div class="sidebar-div">
        <strong class="sidebar-title">Categories</strong>
        <ul><?php wp_list_categories('orderby=name&show_count=1&title_li='); ?></ul>
    </div>
    <div class="sidebar-div">
        <strong class="sidebar-title">Tags</strong>
        <p><?php wp_tag_cloud('smallest=8&largest=22'); ?></p>
    </div>
    <div class="sidebar-div">
        <strong class="sidebar-title">Archives</strong>
        <p>
            <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
                <?php wp_get_archives( 'type=monthly&format=option&show_post_count=1' ); ?>
            </select>
        </p>
    </div>
</div><!-- End sidebar -->