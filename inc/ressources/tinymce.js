(function() {
	tinymce.create('tinymce.plugins.ccl', {
		init : function(ed, url) {
			jQuery( '#insert_custom_content_list' ).live( "click", function( e ) {
				e.preventDefault();
				
				ed.execCommand(
					'mceInsertContent',
					false,
					ccl_create_shortcode()
				);
				
				tb_remove();
			} );
			ed.addButton('ccl', {
				title : 'Custom Content List',
				image : url + '/images/text_list_bullets.png',
				onclick : function() {
					tb_show('Custom Content List', ajaxurl+'?action=ccl_shortcodePrinter&width=600&height=700');
				}
			});
		},
	});
	tinymce.PluginManager.add('ccl', tinymce.plugins.ccl);
})();

function ccl_create_shortcode() {
	var inputs = jQuery('.ccl-form').serializeArray();
	var shortcode = ' [custom-list  ';
	for( var a in inputs ) {
		if( inputs[a].value == "" )
			continue;
			
		inputs[a].name = inputs[a].name.replace( 'ccl_', '' );
		shortcode += ' '+inputs[a].name+'="'+inputs[a].value+'"';
	}
	
	shortcode += ' ] ';
	
	return shortcode;
}