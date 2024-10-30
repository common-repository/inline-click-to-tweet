;(function() {

	tinymce.PluginManager.add('ictt', function(editor,url) {

		editor.addButton('ictt', {
			text: '',
			tooltip: 'Inline Click to Tweet',
			icon: 'ictt-tweet',
			onclick: function() {

				editor.windowManager.open({
					title: 'Inline Click to Tweet - Shortcode Generator',
					id: 'ictt-plugin-dialog',
					body: [{
						type: 'listbox',
						name: 'tweettype',
						label: 'Type of tweet',
						values: [
							{text:'Inline tweet',value:'inline'},
							{text:'Blockquote tweet',value:'blockquote'}
						]
					}, {
						type: 'checkbox',
						name: 'disablehashtags',
						label: 'DO NOT include hashtags in the tweet',
						text: 'Disable hashtags for this tweet'
					}, {
						type:'textbox',
						name:'hashtags',
						label:'Hashtags (override default hashtags - comma separated)'
					}, {
						type: 'checkbox',
						name: 'disablevia',
						label: 'DO NOT include "via @handle" in the tweet',
						text: 'Disable @via for this tweet'
					}, {
						type: 'textbox',
						name: 'customvia',
						label: 'Custom Via (attribute tweet to a different handle)'
					}],
					width: 750,
					height: 390,
					inline: 1,


					onsubmit: function(e) {
						
						//console.log(e.data);
						//var via = e.data.includevia ? 
						var customvia = e.data.customvia.replace('@','');

						var result = '[ictt-tweet-'+e.data.tweettype;
						
						if (e.data.hashtags.length) {
							result += ' hashtags="'+e.data.hashtags+'"';
						}  else if (e.data.disablehashtags) {
							result += ' hashtags=""';
						}

						if (e.data.disablevia) {
							result += ' via=""';
						} else if (customvia.length > 1) {
							result += ' via="'+customvia+'"'
						}

						result += ']';
						result += tinymce.activeEditor.selection.getContent();
						result += '[/ictt-tweet-'+e.data.tweettype+']';
						
						editor.insertContent(result);
					}
				});

			}
		});

	});

})();