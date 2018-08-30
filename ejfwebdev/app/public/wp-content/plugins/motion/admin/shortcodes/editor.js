(function() {
	// TinyMCE plugin start.
	tinymce.PluginManager.add( 'MOTIONTinyMCE', function( editor, url ) {
		// Register a command to open the dialog.
		editor.addCommand( 'motion_open_dialog', function( ui, v ) {

			motionSelectedShortcodeType = v;
                        selectedText = editor.selection.getContent({format: 'text'});
                        motion_tb_dialog_helper.loadShortcodeDetails();
                        motion_tb_dialog_helper.setupShortcodeType( v );

			jQuery( '#motiondialog-shortcode-options' ).addClass( 'shortcode-' + v );
			jQuery( '#motiondialog-selected-shortcode' ).val( v );

			var f=jQuery(window).width();
			b=jQuery(window).height();
			f=720<f?720:f;
			f+=32;
			b-=120;

			tb_show( "Insert ["+ v +"] shortcode", "#TB_inline?width="+f+"&height="+b+"&inlineId=motiondialog" );
		});

		/* Register a command to insert the self-closing shortcode immediately. */
                editor.addCommand( 'motion_insert_self_immediate', function( ui, v ) {
                        editor.insertContent( '[' + v + ']' );
                });

                /* Register a command to insert the enclosing shortcode immediately. */
                editor.addCommand( 'motion_insert_immediate', function( ui, v ) {
                        var selected = editor.selection.getContent({format: 'text'});

                        editor.insertContent( '[' + v + ']' + selected + '[/' + v + ']' );
                });

                /* Register a command to insert the N-enclosing shortcode immediately. */
                editor.addCommand( 'motion_insert_immediate_n', function( ui, v ) {
                        var arr = v.split('|'),
                                selected = editor.selection.getContent({format: 'text'}),
                                sortcode;

                        for (var i = 0, len = arr.length; i < len; i++) {
                                if (0 === i) {
                                        sortcode = '[' + arr[i] + ']' + selected + '[/' + arr[i] + ']';
                                } else {
                                        sortcode += '[' + arr[i] + '][/' + arr[i] + ']';
                                };
                        };
                        editor.insertContent( sortcode );
                });

		// Add a button that opens a window
		editor.addButton( 'motion_button', {
			icon: 'icon motion-icon',
			tooltip: 'Insert a Motion Shortcode',
			onclick: function() { editor.execCommand( 'motion_open_dialog', false, 'motion', { title: 'Motion' } ); }
		});
	}); // TinyMCE plugin end.
})();
