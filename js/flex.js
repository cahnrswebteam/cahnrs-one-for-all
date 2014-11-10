jQuery( document ).ready( function( $ ){
	var init_flex_js = function(){
		var self = this;
		
		self.init_dpdwn = function(){
			var dr = this;
			dr.menu_items = $( '.is_dropdown > li');
			
			$('body').on( 'hover' , '.is_dropdown > li', function( e ){
				if (e.type == "mouseenter") {
					var c = $( this );
					c.addClass('activedrop');
					setTimeout(function(){ dr.active_drop( c ) }, 150);  
				} else { 
					dr.close_drop( $( this ) );
				}
			});
			
			dr.active_drop = function( ih ){
				if( ih.hasClass('activedrop')){
					console.log( ih.children('ul').length );
					ih.children('ul').slideDown('fast');
				}
			}
			dr.close_drop = function( ih ){
				ih.removeClass('activedrop');
				ih.children('ul').slideUp('fast');
			}
		}
		
		if( $('.is_dropdown').length > 0 ) self.init_dpdwn();
	}
	
	var flex_js = new init_flex_js();
	
});