jQuery(document).ready(function() {
	
	jQuery('#add-contact').click(function(){
		jQuery('#add-form').css({
    		"opacity":"0",
    		"display":"block",
		}).show().animate({opacity:1})
	});
});