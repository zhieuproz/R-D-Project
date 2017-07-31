<!-- this page is to review booking counsellor -->
<!-- this page can be used when users finished their booking -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Review Booking*/ ?>
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
						echo $current_user->display_name. "'s Booking";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. $current_user->display_name. "'s Booking";			
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
			
			if(is_user_logged_in() == false) 
			{
				echo'<div style="color:red; font-size:25px;"> Please Login to use this function.!!! </div>';
			}
			else
			{
				$Name = $current_user->display_name;
				include("Database/ConnectDatabase.php");
				$sql = "select First_Name , Last_Name , Title , Date_Of_Birth , Address , Email , Reason_Seeking , Counsellor_ID from booking where User_Identify = '$Name'";			
				$result = mysqli_query($conn,$sql);

					if(mysqli_num_rows($result) != 0)
					{
						$row = mysqli_fetch_array($result);
						echo'<div style="color:#900; font-size:25px;">Your appointment </div><br>';
						
						
						echo'<table class="table"  style=" font-size:18px;" > ';
						
							echo'<tr>'; // personal information
								echo'<td>';
						
									echo'Name :'.$row['Title'].$row['First_Name'].$row['Last_Name'].'<br>';
									echo'<p>Date Of Birth:'.$row['Date_Of_Birth'].'<br>';
									echo'Your Address :'.$row['Address'].'<br>';
									echo'Your Email :'.$row['Email'].'<br>';
									echo'Reason seeking help :'.$row['Reason_Seeking'].'<br>';
						
								echo'</td>';
							
						
								echo'<td>'; //consellor information
									echo'consellor information:'.$row['Counsellor_ID'].'<br>';
									echo'<input onclick="return DeleteBooking();" style="margin-top:20%; margin-right:-80%;"  type="button" class="btn btn-danger" value="delete">';
								echo'</td>';
							echo'</tr>';

						echo'</table>';

					}
					else
					{
						echo '<div class="alert alert-info" role="alert"><strong>You have no appointment now, want to make an appointment?</strong> </div>';
					}
			}

					
			?>
		</div>
	</div>	
</div>
<?php get_footer(); ?>