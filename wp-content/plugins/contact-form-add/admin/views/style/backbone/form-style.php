<div id="formStyleCont"></div>

<script type="text/template" id="formStyle-template">
<div class="form-group">

	<?php if ( version_compare(  '1.7' , get_option( 'smuzform_plugin_version' )  ) === 1 ): ?>
		<div class="checkbox">
			<label><input type="checkbox" id="styleEnabled" <% if ( enabled ) { %> <%- 'checked' %> <% } %> > <?php smuzform_translate_e( 'Enabled' ) ?></label>
		</div>
		<p class="description"><?php smuzform_translate_e( 'If disabled most of the form styling will be inherited from your current WP theme.' ) ?></p>
	<?php else: ?>

		<div class="checkbox">
			<label><input type="checkbox" disabled="disabled"> <?php smuzform_translate_e( 'Enabled' ) ?></label>
		</div>
		<p class="description"><h4><a href="http://web-settler.com/form-builder/?ref=style" target="_blank"><?php smuzform_translate_e( 'Purchase premium version to unlock styles.' ) ?></a></h4></p>

		<p class="description"><?php smuzform_translate_e( 'If disabled most of the form styling will be inherited from your current WP theme.' ) ?></p>

	<?php endif; ?>
</div>

<?php include smuzform_admin_view( 'style/backbone/incsettings.php' ) ?>

</script>
