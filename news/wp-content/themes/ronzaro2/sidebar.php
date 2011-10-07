<div id="sidebar">
    <div id="search-div">
		<?php get_search_form(); ?>
		<!-- <input type="text" class="searchbox" /><img src="images/search_button.gif" alt="Search" /> -->
    </div>
    
    <div class="sidebar-div" style="margin-bottom:1px">
    	<a href="http://www.ronzaro.com">
        	<strong class="sidebar-title">Visit RONZARO</strong><br />
        	<img src="http://ronzaronews.ronzaro.netdna-cdn.com/news/wp-content/uploads/2011/08/Screen-Shot-2011-08-31-at-10.24.04-AM-300x191.png" width="140" title="Visit Ronzaro Homepage"  />
        </a>
    </div>
    
    <div class="sidebar-div" style="margin-bottom:1px">
        <a href="http://twitter.com/ronzaro_men" class="twitter-follow-button" data-show-count="false">Follow @ronzaro_men</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
        <div id="lifestream">&nbsp;</div>
    </div>
    
    <div class="sidebar-div">
        <strong class="sidebar-title">Categories</strong>
        <ul><?php wp_list_categories('orderby=name&show_count=1&title_li=&exclude=3'); ?></ul>
    </div>
    <div class="sidebar-div">
        <strong class="sidebar-title">Tag Cloud</strong>
        <div><?php wp_tag_cloud('smallest=8&largest=22'); ?></div>
    </div>
    <div class="sidebar-div" style="margin-bottom:2px">
        <strong class="sidebar-title">Archives</strong>
        <p>
            <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
                <?php wp_get_archives( 'type=monthly&format=option&show_post_count=1' ); ?>
            </select>
        </p>
    </div>
    
    <div class="sidebar-div">
        <a href="http://www.ronzaro.com/contact"><strong class="sidebar-title">Ask a Question</strong></a>
    </div>
    <div class="sidebar-div" style="margin-bottom:2px">
        <a href="http://www.ronzaro.com/coming"><strong class="sidebar-title">Subscribe to Mailing List</strong></a>
    </div>
</div><!-- End sidebar -->