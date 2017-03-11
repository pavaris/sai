<?php get_header(); ?>
<section id="content" role="main">
<?php if(get_post_feed(array('post_type' => array('post','episode'), 'posts_per_page' => 8, 'paged' => 1, 's' => get_search_query()))): ?>
<header class="header">
<div class="blogSearchDiv">
    <div class="searchHeader">
	    <div class="searchIcon"></div>
	    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	        <label class="screen-reader-text" for="s"></label>
	        <input type="text" value="" name="s" id="s" placeholder="<?php echo get_search_query(); ?>">
	        <input type="submit" id="searchsubmit" value="">
	    </form>
	</div>
</div>
</header>
<div class="innerContent noTopPadding">
	<section id="feedContent" role="main" class="blogFeed">
		<div class="feedGutter"></div>
		<?php echo get_post_feed(array('post_type' => array('post','episode'), 'posts_per_page' => 8, 'paged' => 1, 's' => get_search_query())); ?>
		<div class="loadingIcon">
		   <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
	<g>
		<path fill-rule="evenodd" clip-rule="evenodd" d="M17.875,4.634c-3.133,1.476-3.914,4.37-4.709,7.274
			c-0.785,2.869-2.928,4.662-5.42,4.714c-1.405,0.03-2.152-0.462-2.106-1.965c0.047-1.538,0.157-3.548,0.923-5.126
			c-1.078,0.562-1.868,1.843-2.216,2.627c-0.333,0.75-0.51,1.568-0.781,2.44C2.117,11.247,3.57,7.237,6.821,5.381
			C9.574,3.81,15.373,3.364,17.875,4.634z"/>
	</g>
	</svg>
		    
		    
		</div>
		
	</section>
</div>

<script>
	var $container = $('#feedContent');
		$container.isotope({
		    itemSelector: 'article',
		    resizable: false, // disable normal resizing
		    layoutMode: 'fitRows',
		    fitRows:{
			    gutter: '.feedGutter',
		    }
		});
    
    var paged = 1;
    var ajaxRun = false;
    var postContent;
    $(window).scroll(function(){
       var blogFeed = $('.blogFeed').offset().top; 
       var blogFeedHeight = $('.blogFeed').outerHeight();

       if(!ajaxRun){
        if($(window).scrollTop() > (blogFeed + blogFeedHeight - 600)){
            console.log("SCROLLED TO END OF .blogFeed");
            paged++;
            ajaxRun = true;    
            get_next_posts();
            $('.loadingIcon').fadeIn(1000);
        }
       }
    });
    
    function get_next_posts(){
      $.ajax({
            url: ajaxurl, 
            data: {
                action: 'do_ajax',
                fn: 'get_search_posts',
                paged: paged,
                searchby: <?php echo get_search_query(); ?>,
            },
            success: function(data){
                append_new_posts(data);
                //ajaxRun = false;
            }
        });
    }
    
    function append_new_posts(postContent){
        var $items = $(postContent);
        $container.append($items).isotope( 'appended', $items );
        
    }
    
    $container.on( 'layoutComplete', function( event ) {
        ajaxRun = false;
        $('.loadingIcon').fadeOut(500);
    });
</script>
<?php else: ?>
<article id="post-0" class="post no-results not-found">
<header class="header">
<h2 class="entry-title"><?php _e( 'Nothing Found', 'blankslate' ); ?></h2>
</header>
<section class="entry-content">
<p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'blankslate' ); ?></p>
<?php get_search_form(); ?>
</section>
</article>
<?php endif; ?>
</section>
<?php get_footer(); ?>