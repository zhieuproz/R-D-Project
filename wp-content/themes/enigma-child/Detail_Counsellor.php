<!-- this page is to view detail a counsellor who is the most suitable for users -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Detail Counsellor*/ ?>
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
						echo "Detail Counsellor";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. " Detail Counsellor";			
				 ?>
                
			</div>
		</div>
	</div>	
</div>
<!-- End displaying title -->



<div class="container">	
	<div class="row enigma_blog_wrapper">
		<div class="col-md-12"> 
		
			<?php
			
			if(isset($_POST['ID'])) //Receive ID value from listing page when user click to counsellor
			{
				
				$Counsellor_ID = $_POST['ID'];
				
				$Name = $current_user->display_name; //getting current user to variable name to use !!
				include("Database/ConnectDatabase.php");
				$sql = "select * from counsellor where ID like '$Counsellor_ID'";
				$result = mysqli_query($conn,$sql);
				
				if(mysqli_num_rows($result) != 0)
				{
					$row = mysqli_fetch_array($result);
					
					echo'<div class="col-md-9">';
						echo'<section class="panel">';
							echo'<div class="panel-body">';

								echo'<div class="col-md-6">';
									echo'<div class="pro-img-details">';
										echo'<img width="350" height="350" src="'.site_url().'/wp-content/uploads/Counsellors/'.$row['Picture'].'"  alt="a" />';
									echo'</div>';

								echo'</div>';

								echo'<div class="col-md-6">';

									echo'<h4 class="pro-d-title">';
					
										echo'<a href="#" class="">';
										echo $row['First_Name'];
										echo'</a> <hr>';
										
									echo'</h4>';

									echo'<p> Area Specialty : '.$row['Area_Specialty'].' </p>';
									echo'<p> Region : '.$row['Region'].' </p>';
									echo'<p> Experience : '.$row['Year_Experience'].' Year </p>';
									echo'<p> Description : '.$row['Brief_Information'].' </p> <hr>';

									echo'<div class="m-bot15"> <strong>Budget : </strong> <span class="pro-price"> '.$row['Fee'].'</span></div>';
									
									echo '<form method="post" class="form-horizontal form-group" name="DetailForm" action="'.get_site_url().'/booking'. '">';
					
									echo'<p><button class="btn btn-round btn-danger" type="submit">Make an appointment	</button> </p>';
								echo'</div>';
									
									echo '<input name="ID" hidden value="'.$row['ID'].'" />';
									echo '</form>';

							echo'</div>';
						echo'</section>';
					echo'</div>';
				}

			}
			else
			{
				echo "Please pick a counsellor before viewing detail!!";
			}
			
			
			?>
               
                        

  
                                                                    
		</div>
	</div>	
</div>
<?php get_footer(); ?>