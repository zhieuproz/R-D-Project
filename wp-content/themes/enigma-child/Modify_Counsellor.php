<!-- this page is to add/Edit/Delete a counsellor -->
<!-- this page just display when user == ADMIN -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Modify Counsellor*/ ?>
<?php get_header(); // Get header and Footer for this page!!
//get_template_part('breadcrums'); ?>


<!-- Begin displaying title -->
<div class="enigma_header_breadcrum_title">	 <!-- display the title( by getting the username ) and url of this page  -->
	<div class="container"> <!-- Because of the asynchronous in displaying tag name on the menu and Page Titile , This section is necessary!! -->
		<div class="row">
			<div class="col-md-12">
				<h1>
					<?php
						echo" Control Counsellor";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. " Control Counsellor";			
				 ?>
                
			</div>
		</div>
	</div>	
</div>
<!-- End displaying title -->



<div class="container">	
	<div class="row enigma_blog_wrapper">
		<div class="col-md-12"> 
		
		<div id="result"></div>
		
		<div class="alert alert-info" role="alert" hidden="true">
		  <strong></strong>
		</div>
		
		
		<div class="alert alert-success" role="alert" hidden="true">
		  <strong>Edited successfully !</strong> 
		</div>
		
		<div class="alert alert-danger" role="alert" hidden="true">
		  <strong>Deleted successfully !</strong> 
		</div>
			<?php
			
					Add_Counsellor();
					$i = 0;
					while($i<3)
					{
						echo '<br/>';
						$i++;
					}
					$Name = $current_user->display_name; //getting current user to variable name to use !!
					include("Database/ConnectDatabase.php");
					$sql = mysqli_query($conn,"select * from counsellor ");
					if(mysqli_num_rows($sql) != 0) 
					{
						echo '<section id="counsellor-list">';
							Show_Counsellor();

						echo '</section>'; //End counsellor-list
					}
					else
					{
						echo "<Span id='1st-time' style='color:red;'>There is no Counsellor in database , want to add ? </span> <br /> <br />";


						echo '<section id="counsellor-list" class="cd-container" hidden="true">';

						Show_Counsellor();
						
						echo '</section>';

					}
			mysqli_close($conn);
					
			
			?>

			 


		</div>
	</div>	
</div>
<?php get_footer(); ?>