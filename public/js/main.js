jQuery(document).ready(function() {
	jQuery('#contactApp-container__addContent-trigger').click(function()
	{
		jQuery('#contactApp-container__addContent').toggle('slow');
    	jQuery('#contactApp-container__addContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	jQuery('#contactApp-container__viewContent-trigger').click(function()
	{
		jQuery('#contactApp-container__viewContent').toggle('slow');
    	jQuery('#contactApp-container__viewContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	jQuery('#contactApp-container__trashContent-trigger').click(function()
	{
		jQuery('#contactApp-container__trashContent').toggle('slow');
    	jQuery('#contactApp-container__trashContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	jQuery("form[name='contact_form']").submit(function()
	{
		jQuery('.overlay').toggle();
	});


	if (jQuery('.notice-contact-container-content')){
		setTimeout(function(){
    	jQuery(".notice-contact-container-content").animate({opacity: 0}, 1000);
    },3000)}
});