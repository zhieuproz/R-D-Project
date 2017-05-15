<?php if ( ! isset( $_GET['entry_id'] ) ): ?>
<div id="smuzform-cont">

<nav class="navbar navbar-inverse mainnavbar">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand">
				<?php smuzform_translate_e( 'Entry Manager' ) ?>
			</a>
			
			<ul class="nav navbar-nav navbar-right" id="navBarActionsCont">
				<li class="navBarActionsLi">
					<a id="formEntriesAction" href="<?php echo admin_url( 'admin.php?page=smuz-forms&form_id='.intval($_GET['form_id']) ); ?>"><?php smuzform_translate_e( 'Go Back to Form Builder <' ) ?></a>
				</li>
			</ul>
			
		
		</div>


	</div>
</nav>

<div class="container">
	<div class="row">

		<div class="col-xs-3 contInfoCard formInfoCard">

			<div class="contInfoInlineCont">
				<h3><?php esc_html_e( $entryManager->getTitle() ) ?></h3>

				<p><?php esc_html_e( $entryManager->getDescription() ) ?></p>
			</div>

		</div>

		<?php do_action( 'smuzform_admin_entry_card_display', $entryManager->getId(), $entryManager ) ?>

		<div class="col-xs-3 contInfoCard entryCountCard">
			<div class="contInfoInlineCont">
				<h3>No of Entries</h3>

				<h4 id="entriesCountHeading"><?php echo $entryManager->getCount() ?></h4>
			</div>
		</div>

	</div>

	<div class="row">
		
		<div id="entryDataGridCont">
			<?php include smuzform_admin_view( 'entry/datatable.php' ) ?>	
		</div>

	</div>
</div>


</div>

<?php else: ?>
<?php include smuzform_admin_view( 'entry/edit-entry.php' ) ?>
<?php endif; ?>


<?php if ( version_compare(  '1.7' , get_option( 'smuzform_plugin_version' )  ) !== 1 ): ?>
<!-- Modal -->
  <div class="modal show" id="premiumModal" role="dialog">
    <div class="modal-dialog" style="width: 45%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title" id="premiumModalUnlockHeading">Unlock Entries</h4>
        </div>
        <div class="modal-body" style="text-align: center;">
        <a href="http://web-settler.com/form-builder/?ref=entry" target="_blank" style="color: #fff; font-size:22px "><img src="<?php echo SMUZFORM_PLUGIN_URL.'/admin/assets/img/stack.png'; ?>" style="width: 200px;"></a>
          <p id="premiumModalUnlockDescription"><div style="text-align: center; padding:10px 30px; background:#03A9F4; "><a href="http://web-settler.com/form-builder/?ref=entry" target="_blank" style="color: #fff; font-size:22px ">Purchase Paid Version To Unlock</a></div></p>
        </div>
        <div class="modal-footer">
         <a id="formEntriesAction" href="<?php echo admin_url( 'admin.php?page=smuz-forms&form_id='.intval($_GET['form_id']) ); ?>"><?php smuzform_translate_e( 'Go Back to Form Builder..' ) ?></a>
        </div>
      </div>
      
    </div>
  </div>

  <?php endif; ?>