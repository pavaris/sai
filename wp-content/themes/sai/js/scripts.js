var $ = jQuery.noConflict();

$(document).ready(function(){
    $("#menuButton, #headerOuter").click(function(){
        $("#headerDrawer").toggleClass("active");
        $('#menuClose').toggleClass("active");
    });
    
    
    $('.searchIcon').click(function(){
        $("#headerLeft input[type='text']").focus();
    });
    
    if($('.podcastsHeaderCarousel').length > 0 ){
	    $('.podcastsHeaderCarousel').slick({
	        arrows: false,
	        dots: true,
	        touchMove: false,
	        speed: 300,
	        slidesToScroll: 1,
	        autoplay: true,
	        autoplaySpeed: 2000,
	        cssEase: 'ease-in-out',
	        easing:'easeInOutQuint',
	    });
    }
    
    if($('#homeViolatorImages').length > 0 ){
	    $('#homeViolatorImages .innerContent').on('init', function(event, slick){
            console.log('slider was initialized');
            $('#homeViolatorImages').addClass('active');
        })
	    $('#homeViolatorImages .innerContent').slick({
	        arrows: false,
	        dots: true,
	        touchMove: false,
	        speed: 1000,
	        fade:true,
	        slidesToScroll: 1,
	        autoplay: true,
	        autoplaySpeed: 6000,
	        cssEase: 'ease-in-out',
	        easing:'easeInOutQuint',
	    });
    }
    
    $('#headerRight a').click(function(){
        if(!$('.headerMegaphonePlayer').hasClass('active')){
            $('.headerMegaphonePlayer').toggleClass('active'); 
            $('.podcastContainer').fadeToggle(200);
            $('.activePodcastContainer').delay(300).css("display", "flex").hide().fadeIn();    
        }
        else{
            $('.headerMegaphonePlayer').toggleClass('active'); 
            $('.activePodcastContainer').fadeToggle(200);
            $('.podcastContainer').delay(300).fadeToggle();    
        }
        
        $(".headerMegaphonePlayer iframe").contents().find("#play").trigger('click');
	   return false;
    });
    
    $('#navParentsList li a[gotskids=1]').click(function(){
	   var menuID = $(this).attr('menuid');
	   $('.childUl').hide();
	   $('#children_of_'+menuID).show();
	   $('#navContainer').toggleClass('active');
	   return false;
    });
    
    $('#navChildren ul li a.backToParent').click(function(){
	   $('#navContainer').toggleClass('active');
	   $('.childUl').fadeOut(200);
	   return false;
    });
    

	    $('.blogArrow, .blogSearchDiv h4').click(function(){
		   $('.blogSearch').slideToggle();
            $('.darkBg').fadeToggle();
            $('.blogArrow svg line').toggleClass('active');
            
	    });
    
    //
    $(".alignnone, .aligncenter").wrap('<div class="postImageContainer"/>');
    
    
    
    

    //newletter popup
    var newsletterShown = Cookies.get('newsletterShown');
    var cookieNewsletterID = Cookies.get('newsletterID');
    var pageNewsLetterID = $('.newsletterPopup').attr('newsletter_id');
    
    
    if(newsletterShown != 'true' || pageNewsLetterID != cookieNewsletterID){
        setTimeout(function(){
            $('.newsletterPopup').addClass('active');
            Cookies.set('newsletterID', pageNewsLetterID); 
            Cookies.set('newsletterShown', 'true');
        }, 3000);
    }
    
    $('.newsletterPopup .closeButton').click(function(){
        $('.newsletterPopup').removeClass('active');
    });
    
    
    //ask Farnoosh open popup
    $('.askFarnooshButton').click(function(){
       $(".askFarnooshPopup").fadeToggle(500);
    });
    
    //ask Farnoosh close popup
    $('.askFarnooshClose').click(function(){
       $(".askFarnooshPopup").fadeToggle(300);
    });
    
    $('.askFarnooshGrad').click(function(){
       $(".askFarnooshPopup").fadeToggle(300);
    });
    
    
    
    //ask Farnoosh textarea limit
     $('#askFarnText').keyup(function() {
        var text_length = $('#askFarnText').val().length;
        $('.charRemain').html(text_length + '/<span>150</span');
    });
    
    //Mobile Specific JS
	if($(window).width()<768){
		flipAboutPage();
	}
	
    

    
});

$(window).resize(function(){
	if($(window).width()<768){
		flipAboutPage();
	}
});


function flipAboutPage(){
	if($(".my-story").length>0){
		console.log();
		$(".farnFact").each(function(i,x){
			console.log(x);
			var z = i+1;
			$(".aboutFarnoosh:eq("+z+")").after($(this));
		})
		
	}
}

