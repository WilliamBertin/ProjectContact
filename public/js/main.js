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

	jQuery("#contact_form_fullname").focus(function() {
		if (jQuery('#contact_form_firstname').val() && jQuery('#contact_form_lastname').val()) {
			this.value = jQuery('#contact_form_firstname').val()+' '+jQuery('#contact_form_lastname').val();
		}
	});

	jQuery(".view-list form :input").change(function() 
	{
		jQuery(this).closest('form').find('button').first().prop("disabled", false) 
	});

	if (jQuery('.notice-contact-container-content')){
		setTimeout(function(){
    	jQuery(".notice-contact-container-content").animate({opacity: 0}, 1000);
    },3000)}
});
