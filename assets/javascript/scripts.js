jQuery(document).ready(function(){
	jQuery("#productSelect").on("change", function(){
		var productVal = jQuery(this).children(":selected").val();
		if(productVal !== -1) {
			jQuery('#description_container').children().hide();
			jQuery("#product_"+productVal).toggle();
		} else {
			jQuery('#description_container').children().hide();
		}
		if(jQuery(this).children(":selected").attr('data-date-start')) {
			var fromDate =  jQuery(this).children(":selected").attr('data-date-start');
			toDate = jQuery(this).children(":selected").attr('data-date-end');
			fromDate = fromDate.split("-");
			toDate = toDate.split("-");

			var picker = $input.pickadate('picker');

			picker.set('min', new Date(fromDate[0],fromDate[1]-1,fromDate[2]));
			picker.set('max', new Date(toDate[0],toDate[1]-1,toDate[2]));
			picker.render();
		} else {
			var picker = $input.pickadate('picker');
			picker.set('min', false);
			picker.set('max', false);
		}
		
	});

	var $input = jQuery(".datepicker").pickadate();

	jQuery('#booking-manager-form').submit(function(){
		var picker = $input.pickadate('picker');
		if(picker.get() == "") {
			jQuery('<div class="message message-error"><p>Please enter a date value.</p></div>').insertBefore('.booking-manager');
			jQuery('.booking-manager').scrollTop();
			return false;
		} 
		return true;
	});
});