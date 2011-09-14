		<footer id="footer" class="source-org vcard copyright">
    		<div>Brought to you by <a href="http://www.ronzaro.com">Ronzaro.com</a></div>
			<small>&copy; <?php echo date("Y"); echo " <a href=".esc_url(home_url( '/' )).">"; bloginfo('name'); ?></a></small>
		</footer>

	</div>

	<?php wp_footer(); ?>

<script src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>
<script>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-24580239-4']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

(function(){
  var count = 0,
  list = [
	{
	  service: 'twitter',
	  user: 'ronzaro_men'
	}
  ];

  Date.prototype.toISO8601 = function(date) {
	  var pad = function (amount, width) {
		  var padding = "";
		  while (padding.length < width - 1 && amount < Math.pow(10, width - padding.length - 1))
			  padding += "0";
		  return padding + amount.toString();
	  }
	  date = date ? date : new Date();
	  var offset = date.getTimezoneOffset();
	  return pad(date.getFullYear(), 4)
		  + "-" + pad(date.getMonth() + 1, 2)
		  + "-" + pad(date.getDate(), 2)
		  + "T" + pad(date.getHours(), 2)
		  + ":" + pad(date.getMinutes(), 2)
		  + ":" + pad(date.getUTCSeconds(), 2)
		  + (offset > 0 ? "-" : "+")
		  + pad(Math.floor(Math.abs(offset) / 60), 2)
		  + ":" + pad(Math.abs(offset) % 60, 2);
  };

  $("#lifestream").lifestream({
	limit: 10,
	list: list,
	feedloaded: function(){
	  count++;
	  // Check if all the feeds have been loaded
	  if( count === list.length ){
		$("#lifestream li").each(function(){
		  var element = $(this),
			  date = new Date(element.data("time"));
		  element.append(' <abbr class="timeago" title="' + date.toISO8601(date) + '">' + date + "</abbr>");
		})
		$("#lifestream .timeago").timeago();
	  }
	}
  });
  
})();
</script>
</body>
</html>
