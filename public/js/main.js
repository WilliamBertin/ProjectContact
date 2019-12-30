jQuery(document).ready(function() {

	//plus to minus icon trigger display/hide content add form
	jQuery('#contactApp-container__addContent-trigger').click(function()
	{
		jQuery('#contactApp-container__addContent').toggle('slow');
    	jQuery('#contactApp-container__addContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	//plus to minus icon trigger display/hide content edit form
	jQuery('#contactApp-container__viewContent-trigger').click(function()
	{
		jQuery('#contactApp-container__viewContent').toggle('slow');
    	jQuery('#contactApp-container__viewContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	//plus to minus icon trigger display/hide content trash form
	jQuery('#contactApp-container__trashContent-trigger').click(function()
	{
		jQuery('#contactApp-container__trashContent').toggle('slow');
    	jQuery('#contactApp-container__trashContent-trigger').find('.deploy-icon').toggleClass('deployed');
	});

	//on submit any form display overlay
	jQuery("form[name='contact_form']").submit(function()
	{
		jQuery('.overlay').toggle();
	});

	//autocomplete input fullname on add form on focus if fullname & lastname not empty
	jQuery("#contact_form_fullname").focus(function() {
		if (jQuery('#contact_form_firstname').val() && jQuery('#contact_form_lastname').val()) {
			this.value = jQuery('#contact_form_firstname').val()+' '+jQuery('#contact_form_lastname').val();
		}
	});

	//enable edit button of edit form on change
	jQuery(".view-list form :input").change(function() 
	{
		jQuery(this).closest('form').find('button').first().prop("disabled", false) 
	});

	//hide notice message after 3s if exist
	if (jQuery('.notice-contact-container-content')){
		setTimeout(function(){
    	jQuery(".notice-contact-container-content").animate({opacity: 0}, 1000);
    },3000)}
});
