<?php get_header(); ?>
<section id="content" class="singleContent" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="pageHeader">
		
		<div class="pageHeaderImageContainer">
		<div class="brushBackground">
            <img src="<?php echo get_template_directory_uri(); ?>/images/highlight.png" alt="" class="brush">
		    <?php brushed_title(get_blog_title()); ?>
		</div>
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
          
          <div class="publishedContainer">
             
             <?php $cat = get_the_terms($post, 'content_type'); ?>
             <?php if($cat){ ?>
                  <img src="<?php echo get_field('logo', $cat[0])['url']; ?>" alt="" class="publisher">
                  <div class="articleInfoContainer">
                      <h6 class="original">originally published in:</h6>
                      <h4 class="category"><?php echo $cat[0]->name; ?></h4>
                  </div>
              <?php }
              else{ ?>
                  <img src="<?php echo get_field('logo', get_terms('content_type')[0])['url']; ?>" alt="" class="publisher">
                  <div class="articleInfoContainer">
                      <h6 class="original">originally published in:</h6>
                      <h4 class="category"><?php echo get_terms('content_type')[0]->name; ?></h4>
                  </div>
              <?php } ?>
              
          </div>
          
          
          
          
          <?php if(get_field('block_quote')){ ?>
           <div class="blockquote">
            <div class="quotationMarks">&ldquo;</div>
                <?php echo get_field('block_quote'); ?>
           </div>
           <?php } ?>
        </div>
           
        <div class="singlePageRightContainer">
            <h1 class="pageTitle"><?php the_title(); ?></h1>
		    <?php the_content(); ?>
        </div>
	</section>
	
	
	<section id="feedContent" role="main" class="relatedFeed">
        <div class="innerContent noTopPadding">
            <div class="brushBackground">
                <img src="<?php echo get_template_directory_uri(); ?>/images/highlight.png" alt="" class="brush">
                <?php brushed_title('you might like...'); ?>
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
                'ignore_sticky_posts'=>1,
                'post_type' => array('post','episode')
                
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
				<a href="<?php echo the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
				<div class="post_excerpt">
					<?php the_excerpt(); ?>
				</div>
				
				<?php $landingURL = '';
                    $landingTitle = ''; 
                    $postOutLink = '';
                ?>
                <?php if(get_post_type() == 'post'){ 
                        $landingURL = esc_url(home_url()).'/lets-learn';
                        $landingTitle = 'all articles';
                        $postOutLink = 'Continue Reading';
                    }
                    if(get_post_type() == 'episode'){
                        $landingURL = esc_url(home_url()).'/podcast/episodes';
                        $landingTitle = 'all episodes';
                        $postOutLink = 'Listen Now';
                    }
                ?>  
                
                <a href="<?php echo the_permalink(); ?>"><?php echo $postOutLink ?></a>
                <br>
                <a href="<?php echo $landingURL; ?>" class="landingLinkOut"><?php echo $landingTitle; ?> </a>
				
				
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
                'post_type' => array('post','episode'),
                'post_status' => 'draft, publish, future, pending, private',
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
				<h1><?php echo $recent['post_title']; ?></h1>
				<div class="post_excerpt">
					<?php echo apply_filters('the_content', get_the_excerpt($recent["ID"])); ?>
				</div>
				
				<?php $landingURL = '';
                    $landingTitle = ''; 
                    $postOutLink = '';
                ?>
                <?php if($recent['post_type'] == 'post'){ 
                        $landingURL = esc_url(home_url()).'/lets-learn';
                        $landingTitle = 'all articles';
                        $postOutLink = 'Continue Reading';
                    }
                    if($recent['post_type'] == 'episode'){ 
                        $landingURL = esc_url(home_url()).'/podcast/episodes';
                        $landingTitle = 'all episodes';
                        $postOutLink = 'Listen Now';
                    }
                ?>    
                <a href="<?php echo the_permalink(); ?>"><?php echo $postOutLink ?></a>
                <br>
                
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
<?php get_footer(); ?>