<?php

/* View for plugin settings panel */
?>


<div class="wrap">

	<h2 id="ictt-settings-header">
		<?php _e('Inline Click To Tweet', 'inline-clicktotweet'); ?> 
		<span>-</span> 
		<small><?php _e('Plugin Settings Panel', 'inline-clicktotweet'); ?></small>
	</h2>
		
	<div id="ictt-adminpanel" class="metabox-holder">

		<div id="post-body" class="">
			<div id="post-body-content" class="has-sidebar-content">
				<div id="normal-sortables" class="meta-box-sortables">
					
					<div class="postbox">
						<div class="inside">
							<form method="post" action="options.php">
								<?php settings_fields('ictt_tweet-options'); ?>
								
								<div class="form-field form-field_txt">
									<input type="text" id="ictt-twitterhandle" name="ictt-twitter-handle" value="<?php echo get_option('ictt-twitter-handle'); ?>" placeholder="Add Twitter Handle">
									<label for="ictt-twitterhandle">
									  <p><?php _e('Brand Twitter Handle', 'inline-clicktotweet'); ?>:</p>
										<span>Included at the end of every tweet <em>ex: via @yourhandle</em></span>
									</label>
								</div>

								<div class="form-field form-field_txt">
									<input type="text" id="ictt-defaulthashtags" name="ictt-twitter-hashtag" value="<?php echo get_option('ictt-twitter-hashtag'); ?>" placeholder="Add Hashtags">
									<label for="ictt-defaulthashtags">
									  <p><?php _e('Brand Hashtags', 'inline-clicktotweet'); ?>:</p>
									  <span>Separate with commas, included at end of tweets</span>
									</label>
								</div>

								<div class="form-field form-field_chkbx">
									<input type="checkbox" id="ictt-shorturls" name="ictt-shorten-urls" value="1" <?php if (get_option('ictt-shorten-urls')==1) {echo 'checked="checked"';}?>>
									<label for="ictt-shorturls">
										<p><?php _e('Enable URL Shortening', 'inline-clicktotweet'); ?></p>
										<span>Post url will be shortened using goo.gl, leaving more room for text content in your tweet</span>
									</label>
								</div>

								<div class="form-field form-field_chkbx">
									<input type="checkbox" id="ictt-cssdisable" name="ictt-disable-css" value="1" <?php if (get_option('ictt-disable-css')==1) {echo 'checked="checked"';}?>>
									<label for="ictt-cssdisable">
										<p><?php _ex('Disable Plugin CSS', 'label for checkbox on settings screen', 'inline-clicktotweet'); ?></p>
										<span>Use this option if you want to style tweet content yourself with CSS</span>
									</label>
								</div>

								<div class="form-field form-field_colorpicker">
									<input type="text" id="ictt-csscolor" name="ictt-css-color" value="<?php echo get_option('ictt-css-color'); ?>">
									<label for="ictt-csscolor">
										<p><?php _ex('Override Default Color', 'label for color input on settings screen', 'inline-clicktotweet'); ?></p>
										<span>Choose a color to use in place of the Twitter brand color</span>
									</label>
								</div>

								<div class="form-field form-field_attribution">
									<p> <em> The Inline Click to Tweet Wordpress plugin was built by <a href="http://www.magneticcreative.com" target="_blank">Magnetic Creative</a></em></p>
								</div>

								<div class="form-field-submit">
									<input type="submit" class="button-primary" value="<?php _e('Update Settings', 'inline-clicktotweet'); ?>"/>
								</div>

							</form>
						</div>
					</div>

					

				</div>
			</div>
		</div>
	
	<?php //end #htt-adminpanel ?>
	</div>

</div>