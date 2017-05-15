<!-- this page is to display the old results after user finishing their checking-up Body Signs and generate healthy recommendation to users -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Old Test*/ ?>
<?php get_header(); // Get header and Footer for this page!!
//get_template_part('breadcrums'); ?>



<!-- Begin displaying title -->
<div class="enigma_header_breadcrum_title">	 <!-- display the title( by getting the username ) and url of this page  -->
	<div class="container"> <!-- Because of the asynchronous in displaying tag name on the menu and Page Titile , This section is necessary!! -->
		<div class="row">
			<div class="col-md-12">
				<h1>
					<?php 
						global $current_user;
      					get_currentuserinfo();
						echo $current_user->display_name. "'s Bucket Model";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. $current_user->display_name. "'s Body Signs Result";			
				 ?>
                
			</div>
		</div>
	</div>	
</div>
<!-- End displaying title -->



<div class="container">	
	<div class="row enigma_blog_wrapper">
		<div class="col-md-12"> 
				<p style="color:dodgerblue; font-size: 1.5em;">Review Your Body Signs!!!</p>
				
					<form method="post" class="form-horizontal form-group" name="SearchForm"> <!-- Starting form -->
						
						<div class="row"> <!-- starting 1st Row : datepick + Search Button -->
						
							<div class="col-xs-6"> <!-- Starting Div Search  -->
								<input id="old_date" type="text" class="form-control docs-date" name="date" placeholder="Pick a date"> <!-- Date Picker -->
								</div>
						
							<div class="col-xs-6">
								<input id="Search_Old_Test" type="button" class="btn btn-info" value="Search"> </input>
							</div>
							 <!-- End Div Search -->
						</div>

					</form> <!-- End form -->
									
				
				<div id="Old-Result">

				</div>
		</div>
	</div>	
</div>
<?php get_footer(); ?>