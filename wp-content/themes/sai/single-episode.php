<?php get_header(); ?>

<div class="singleEpisodeBanner">
    <div class="innerContent">
        <div class="episodeCategory">So Money</div>
        <div class="episodesShareContainer">
            <div class="shareDownContainer">
                <div class="shareDown">
                    <a href="">                    
                        <span>share</span>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/share.png" alt="">
                    </a>
                </div>
                    
                <div class="shareDown">
                    <a href="">
                        <span>download</span>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/download.png" alt="">
                    </a>
                </div>
            </div>
            <div class="subscribeContainer">
                subscribe
                <a href="https://itunes.apple.com/us/podcast/so-money-with-farnoosh-torabi/id955939085?mt=2&ls=1"><img src="<?php echo get_template_directory_uri(); ?>/images/apple.png" alt=""></a>
                <a href="http://www.stitcher.com/podcast/farnoosh-torabi/so-money-with-farnoosh-torabi?refid=stpr"><img src="<?php echo get_template_directory_uri(); ?>/images/stitcher.png" alt=""></a>
                <a href="http://podcast.farnoosh.tv/feed"><img src="<?php echo get_template_directory_uri(); ?>/images/bars.png" alt=""></a>
            </div>
        </div>
    </div>
    
</div>
<section id="content" class="singleContent singleEpisode" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="pageHeader">
		<div class="brushBackground">
               <img src="<?php echo get_template_directory_uri(); ?>/images/highlight-purple.png" alt="" class="brush">
                <?php echo get_the_title();?>
        </div>
        <h6 class="singleEpisodeNumber">Episode <?php echo get_field('ecpt_episodenumber'); ?></h6>
		<div class="pageHeaderImageContainer">
			<?php if ( has_post_thumbnail() ) { 
				$imgsize = 'portrait_image';
				$imgAttrs = wp_get_attachment_metadata( get_post_thumbnail_id() );
				if($imgAttrs['width'] > $imgAttrs['height']){
					$imgsize = 'landscape_image';
				}
				$adjArray = array('articleBoxBg', 'backgroundCenter');
				array_push($adjArray, $imgsize);
				$adjustable = adjImg(get_post_thumbnail_id(), $adjArray, 'large', 'postFeed', get_the_ID()); ?>
				<?php echo $adjustable; ?>
			<?php } ?>
		</div>
	</div>
	<section class="entry-content singlePageContent">
        <div class="singlePageLeftContainer">
           <?php if(get_field("ecpt_transcripturl")){ ?>
           <div class="downloadTranscript"><a href='<?php echo get_field("ecpt_transcripturl"); ?>' target="_blank"><div>download transcript</div></a></div>
           <?php } ?>
           
           <?php if(get_field('block_quote')){ ?>
           <div class="blockquote">
            <div class="quotationMarks">&ldquo;</div>
                <?php echo get_field('block_quote'); ?>
           </div>
           <?php } ?>
        </div>
          
           
        <div class="singlePageRightContainer">
            <?php $playershortcode = get_field('ecpt_playershortcode'); ?>
           <?php if($playershortcode) { ?> 
           <?php if (strpos($playershortcode, '?light=true') == false) {
                $index = strpos($playershortcode, '?');
                $playershortcode = substr_replace($playershortcode, '?'.'light=true', $index, strlen('?'));
                }
                echo $playershortcode; 
              }
            ?>
           
           
           
           <div class="singleEpisodeAuthor">
		       <?php echo the_title(); 
                    echo ", ", get_field("ecpt_subtitle");
               ?>
		   </div> 
           
           <?php the_content(); ?>
           
           
     
           
        </div>
	</section>
	
   
    <section id="feedContent" role="main" class="relatedFeed">
        <div class="innerContent noTopPadding">
            <div class="brushBackground">
               <img src="<?php echo get_template_directory_uri(); ?>/images/highlight.png" alt="" class="brush">
                <?php brushed_title("you might like..."); ?>
            </div>
            <div class="relatedFeedCarousel">
    <?php
        $orig_post = $post;
        global $post;
        $tags = wp_get_post_tags($post->ID);
         $relatedPosts = array();

        if ($tags) {
            $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
            $args=array(
                'tag__in' => $tag_ids,
                'post__not_in' => array($post->ID),
                'posts_per_page'=>3, // Number of related posts to display.
                'ignore_sticky_posts'=>1
            );
 
        $my_query = new wp_query( $args );
 
            
        while( $my_query->have_posts() ) {
            $my_query->the_post();
        ?>
         
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="post_container">
				<?php $cTypes = get_the_terms(get_the_id(), 'content_type'); ?>
				<h4><?php 
                    if(count($cTypes) > 0 && $cTypes){
                        echo $cTypes[0]->name;  
                    }
                    else{
                    echo 'Farnoosh';    
                    // no content type
                    }
                        
                    ?></h4>
				<?php $adjustable = adjImg(get_post_thumbnail_id( get_the_ID() ), array('articleBoxBg', 'backgroundCenter'), 'medium', 'postFeed', get_the_ID()); ?>
				<?php echo $adjustable; ?>
                <a href="<?php echo get_the_permalink(); ?>"><h1><?php the_title(); ?></h1>
				    </a>				<div class="post_excerpt">
					<?php the_excerpt(); ?>
				</div>
				<a href="<?php echo get_the_permalink(); ?>">Continue Reading</a>
			</div>
		</article> 
         
         
          
        <?php 
            
            array_push($relatedPosts, get_the_ID());
            }
        }
            
            if(count($relatedPosts) < 3){
                

            $args = array(
                'numberposts' => 3 - count($relatedPosts),
                'offset' => 0,
                'category' => 0,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'include' => '',
                'exclude' => $relatedPosts,
                'meta_key' => '',
                'meta_value' =>'',
                'post_type' => 'post',
                'post_status' => 'publish',
                'suppress_filters' => true
            );

            $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
            
            foreach( $recent_posts as $recent ){
                ?>
              
              
          <article id="post-<?php $recent['ID']; ?>" <?php post_class(); ?>>
			<div class="post_container">
				<?php $cTypes = get_the_terms($recent['ID'], 'content_type'); ?>
				<h4><?php 
                    if(count($cTypes) > 0 && $cTypes){
                        echo $cTypes[0]->name;  
                    }
                    else{
                    echo 'Farnoosh';    
                    // no content type
                    }
                        
                    ?></h4>
				<?php $adjustable = adjImg(get_post_thumbnail_id( $recent['ID'] ), array('articleBoxBg', 'backgroundCenter'), 'medium', 'postFeed', $recent['ID']); ?>
				<?php echo $adjustable; ?>
				<a href="<?php echo get_permalink($recent['ID']); ?>"><h1><?php echo $recent['post_title']; ?></h1></a>
				<div class="post_excerpt">
					<?php echo apply_filters('the_content', get_the_excerpt($recent["ID"])); ?>
				</div>
				<a href="<?php echo get_permalink($recent['ID']); ?>">Continue Reading</a>
			</div>
		</article>
          
          
            
            <?php }    
                
            }
        
        $post = $orig_post;
        wp_reset_query();
        ?>
    </div>

	        
	  <?php endwhile; endif; ?>
            </div>      
    </section>
<footer class="footer">
<!--<?php get_template_part( 'nav', 'below-single' ); ?>-->
</footer>
</section>

<!--
<script>
 $('.relatedFeedCarousel').slick({
     slidesToShow: 3,
     slidesToScroll: 3      
 });

</script>
-->
<?php get_footer(); ?>