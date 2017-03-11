<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
$parentID = wp_get_post_parent_id(get_the_ID());

	$x = 0;
	$class = 'simplePage';
	//Page has a thumb and the floating side image
	if($parentID == 12782){
		$x = 1;
		$class = 'podcastChild';
		//Page is a child of Podcast
	}
	if( have_rows('farnoosh_fact')){ 
		$x = 2;
				$class = 'my-story';

		//Page is a about Page child (and probably my-story)
		} 
	if(!has_post_thumbnail()){
		$x = 3;
				$class = 'iconPage';

		//Page has no thumbnail and a small gutter 
		}
	
	


	
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<section class="entry-content <?php echo $class;?>">
	<?php if($parentID == 12782){ ?>
		<?php echo podcastHeader(); ?>
	<?php } ?>
	<div class="innerContent pageHeaderContainer <?php echo $parentID == 12782 ? 'noTopPadding' : ''; ?>">
		<?php if($parentID != 12782){ ?>
		    <div class="brushBackground">
		        <img src="<?php echo get_template_directory_uri(); ?>/images/highlight.png" alt="" class="brush">
		        <?php the_field('general_call_to_action');?>
		    </div>
	   <?php } ?>
	   <div class="pageContent"> 
		    <?php if ( has_post_thumbnail() ) {  ?> 
	        <?php } ?>
		    <header class="header">
				<?php if($parentID == 0){ ?>
					<?php $parentID = get_the_id(); ?>
				<?php } ?>
				<?php if(isset($parentID)){ ?>
					<?php $children = get_posts(array('post_parent' => $parentID, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_type'=> 'page')); ?>
					<?php if(count($children) > 0){ ?>
						<div id="pageChildrenMenu">
							<?php foreach($children as $child){ ?>
								<a href="<?php echo get_the_permalink($child); ?>" class="pageChildrenMenuItem<?php echo $child->ID == get_the_id() ? ' current_page': ''; ?>"><?php echo $child->post_title; ?></a>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
			</header>
	    </div>
	</div>
    
	<div class="pageInnerContent">
		<div class="innerContent<?php if(!has_post_thumbnail()){echo " noTopPadding";} ?>">
			
			<div class="pageLeftContainer <?php if(!has_post_thumbnail()){echo "smallwideWidth"; } ?>">
				
				<div class="pageHeaderImage <?php if( have_rows('farnoosh_fact')){ echo 'my-story';} ?> ">
					
					
					
					<?php if ( has_post_thumbnail() ) { 
							$imgsize = 'portrait_image';
							$imgAttrs = wp_get_attachment_metadata( get_post_thumbnail_id() );
							if($imgAttrs['width'] > $imgAttrs['height']){
								$imgsize = 'landscape_image';
							}
							$adjArray = array('articleBoxBg', 'backgroundCenter');
							array_push($adjArray, $imgsize);
							$adjustable = adjImg(get_post_thumbnail_id(), $adjArray, 'large', 'postFeed', get_the_ID()); 
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
							
			            ?>
			               <img src="<?php echo $large_image_url[0]; ?>" alt="">

							
					<?php }else{
						if(get_field('icon_image')){
						 ?>
					
			               <img src="<?php echo get_field('icon_image')['url']; ?>" alt="">
			        <?php 
				        }
				        } ?>
        		</div>
				<?php

		            // check if the repeater field has rows of data
		            if( have_rows('farnoosh_fact') ):
		
		                // loop through the rows of data
		                while ( have_rows('farnoosh_fact') ) : the_row();
		                ?>
		                    
		                    <div class="farnFact">
		                        <?php echo get_sub_field("fact_info"); ?> 
		                        <?php $factImage = get_sub_field("fact_image"); ?>    
		                        <img src="<?php echo $factImage['url']; ?>" alt="" />
		                        <div class="factFooter">
		                            Farnoosh Facts
		                            <div class="factUnderline"></div>
		                        </div>
		                        
		                    </div>        
		    <?php
		                endwhile;
		            endif; ?>
    		</div>
    
		    <div class="pageRightContainer <?php if(!has_post_thumbnail()){echo "wideWidth"; } ?>">
		    <?php the_content(); ?>
		            
		    <?php
		
		            // check if the repeater field has rows of data
		            if( have_rows('about_farnoosh') ):
		
		                // loop through the rows of data
		                while ( have_rows('about_farnoosh') ) : the_row();
		                ?>
		                    
		                    <div class="aboutFarnoosh">
		                        <h6><?php echo get_sub_field("paragraph_title"); ?> </h6>
		                        <p>
		                            <?php echo get_sub_field('paragraph'); ?>
		                        </p>
		                    </div>           
		    <?php endwhile;
		            endif; ?>
		       </div>
		</div>
    </div>
    
    </section>
    
    <?php global $post;
//        if ($post->post_parent == 21 || get_the_title()=='contact') {
//            echo 'hello';
//        } 
    ?>
	    <section class="getInTouchContainer">
	        <div class="getInTouch">Get in touch:</div>
	        <div class="contactPerson"><span>Adam Kirschner</span>, Alk Talent</div>
	        <div class="contactNumber"><span>212-731-2144</span></div>
	        <a class="contactEmail" href=''>email Adam</a>
	    </section>
</article>
<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
<?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>





