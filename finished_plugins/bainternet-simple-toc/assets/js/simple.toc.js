(function() {
	tinymce.PluginManager.add('simple_toc', function( editor, url ) {
		editor.addButton( 'simple_toc', {
			text: '',
			icon: 'simple_toc',
			type: 'menubutton',
			menu: [
				{
					text: 'Auto TOC',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Simple TOC',
							body: [
								{
									type: 'label',
									text: '',
									multiline: true,
									onPostRender : function() {
										this.getEl().innerHTML =
											"Auto TOC heading:<br/>"+
											"insert once in the place you want your TOC to show,<br/>" + 
											"and specify the tag for heading (eg: h2,h3)";
									}
								},
								{
									type: 'textbox',
									name: 'by_tag',
									label: 'heading by tag',
									value: '',
								},
								{
									text: 'Set the tag, ex: h2,h3',
									type: 'label',
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[---ATOC---] <br>[---TAG:' + e.data.by_tag + '---]');
							}
						});
					}
				},
				{
					text: 'Place Holder',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Simple TOC',
							body: [
								{
									type: 'label',
									text: '',
									multiline: true,
									onPostRender : function() {
										this.getEl().innerHTML =
											"TOC place holder:<br/>"+
											"insert once in the place you want your TOC to show<br/>";
									}
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[---TOC---]');
							}
						});
					}
				},
				{
					text: 'TOC Header',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Simple TOC',
							body: [
								{
									type: 'label',
									text: '',
									multiline: true,
									onPostRender : function() {
										this.getEl().innerHTML =
											"TOC Header:<br/>"+
											"insert once or none at all, anywhere you want,<br/>" + 
											"this will show as the TOC heading";
									}
								},
								{
									type: 'textbox',
									name: 'header',
									label: 'TOC header',
									value: '',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[---TOC Header:'+ e.data.header + '---]' );
							}
						});
					}
				},
				{
					text: 'TOC Heading',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Simple TOC',
							body: [
								{
									type: 'label',
									text: '',
									multiline: true,
									onPostRender : function() {
										this.getEl().innerHTML =
											"TOC Heading:<br/>"+
											"insert as many headings as you want include there heading<br/>" + 
											"this will be the text at the TOC link, insert where the heading is.";
									}
								},
								{
									type: 'textbox',
									name: 'heading',
									label: 'TOC ITEM heading',
									value: '',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[---TOC Heading:' +  e.data.heading + '---]');
							}
						});
					}
				}
			]
		});
	});
})();