/*function to update query string parameter*/
function updateQueryStringParameter(uri, key, value) {
	
	/*if(!value) { value=""; }*/
	if(!uri) { return false; }
  //console.log('value of the uri is > ' + uri);
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

/*-------------------------------------------------------------------------------------*/
$(window).on('load',function(event_load) {
	
	var screen_WIDTH_ = $(window).width();
	console.log('screen width is > ' + screen_WIDTH_);
	console.log("window is loaded and working");
	
	if (screen_WIDTH_ <= 1024)
	{
		$('#sidebar-expand-collapse').closest('.cmp-container-sidebar-menu').addClass("collapsed_");
		
		var exp_clp_value = $('#sidebar-expand-collapse').attr("data-mstate");
		
		if(exp_clp_value) { return; }
		$('#sidebar-expand-collapse').attr("data-mstate", "clp");
		
		return;
	}
	
	/*$('#sidebar-expand-collapse').attr("data-mstate", "exp");*/
	
 });

/*-------------------------------------------------------------------------------------*/
$(document).ready(function() {
	
	
	$('ul.nav_state li a').hover(function()
	//$('ul#sidebar-menu li a').hover(function()
	{
		
		if($(this).attr('id') == 'sidebar-expand-collapse') { return false; }
		
		var exp_clp_value = $('#sidebar-expand-collapse').attr("data-mstate");
		
		var exp_clp_value_hover_item = $(this).attr("data-mstate");
		
		if(exp_clp_value_hover_item) { return; }
		
		/* For some browsers, `attr` is undefined; for others,
		 `attr` is false.  Check for both.*/
		/*if (typeof exp_clp_value_hover !== typeof undefined && exp_clp_value_hover !== false) {
		    return
		}*/
		
		console.log('menu state is > ' + exp_clp_value);
		
		if(!exp_clp_value) exp_clp_value = "";
		
		$(this)
			.attr
			(
				"href",
				updateQueryStringParameter
				(
					$(this).attr("href"),
					"mstate",
					exp_clp_value
				)
			);
		
		
	});
	
	
	/*.....................................................................................*/

    $('#sidebar-expand-collapse').on("click",function(event_) {

      event_.preventDefault();
      event_.stopPropagation();
      if ($('#sidebar-expand-collapse').closest('.cmp-container-sidebar-menu').hasClass("collapsed_"))
      {
    	  $('.row.cmp-container-sidebar-menu').addClass('fullwidth');
    	  $('#sidebar-expand-collapse').closest('.cmp-container-sidebar-menu').toggleClass("collapsed_");
    	  
    	  $('#sidebar-expand-collapse').attr("data-mstate", "exp");
    	  $('#menustate').val('exp');
       return;
      }
      
      
      
      $('.row.cmp-container-sidebar-menu').removeClass('fullwidth');
      /* $('#sidebar-expand-collapse').parent('li').toggleClass("collapsed_"); */
      $('#sidebar-expand-collapse').closest('.cmp-container-sidebar-menu').toggleClass("collapsed_");
      $('#sidebar-expand-collapse').attr("data-mstate", "clp");
      $('#menustate').val('clp');
      /*console.log("menu expand collapse detected");*/

     });
     
     /*.....................................................................................*/

});