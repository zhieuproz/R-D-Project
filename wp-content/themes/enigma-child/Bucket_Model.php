<!-- this page is to display the current  result after user finishing their checking-up Body Signs and generate healthy recommendation to users -->
<!-- this page is also generating useful advices for users in choosing the best counsellor with their health condition-->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Bucket_Model*/ ?>
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
			<?php 
				if(is_user_logged_in() == false) 
					echo'<div style="color:red; font-size:25px;"> Please Login to use this function.!!! </div>';
				else
				{
					Add_BodySign();
					$Name = $current_user->display_name; //getting current user to variable name to use !!
					include("Database/ConnectDatabase.php");
					$sql = mysqli_query($conn,"select Average from bodysign where User_Identify = '$Name' order by Date desc limit 1"); //Getting newest Date in Database
					if(mysqli_num_rows($sql) != 0) 
					{
						$row = mysqli_fetch_array($sql);

						Show_BodySign($row[0]);
						
						echo '<div class="row">';
						echo '<a href="'.site_url()."/recommendation".'">Link to Recommendation Page</a> ';
						echo '</div>';
						
						
				
						?>

						<?php

					}
					else
					{
						echo "<Span id='first-time' style='color:red; font-size:1.5em;'>You have no Body Sign post yet!!! </span> <br /> <br />";
						echo '<span id="first-time" style="font-size:1.3em;">'.'Please take your test then you can view your bucket by this <a href="'.site_url().'//Body Signs"'.'>link</a></span>';
					}
				}
			?>
		</div>
	</div>	
</div>
<?php get_footer(); ?>