<!-- this page is the sub page of therapy page which is used for User Function : User's Negative Timeline Function !!!
<!-- this page is the separated page and using same template of the website : Enigma -->
<?php /*Template Name: Negative Posts*/ ?>
<?php get_header(); // call header and Footer for this page!!?> 



<!-- Begin displaying title -->
<div class="enigma_header_breadcrum_title">	 <!-- display the title( by getting the username ) and url of this page  -->
	<div class="container"> <!-- Because of the asynchronous in displaying tag name on the menu and Page Titile , This section is necessary!! -->
		<div class="row">
			<div class="col-md-12">
				<h1>
					<?php 
						global $current_user;
      					get_currentuserinfo();
						echo $current_user->display_name. "'s Timeline";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. $current_user->display_name. "'s Timeline";			
				 ?>
                
			</div>
		</div>
	</div>	
</div>
<!-- End displaying title -->


<!-- Begin Timeline -->
<div class="container">	 <!-- Main Timeline function -->
	<div class="row enigma_blog_wrapper">
		<div class="col-md-12">
        
     		<div id="titlename"> <h1 style="font-size:25px; color:#900;"> Negative Timeline </h1></div>
        
    	<?php 
			$Name = $current_user->display_name; //getting current user to variable name to use !!
			include("Database/ConnectDatabase.php");
			$GLOBALS['Check_Attitude'] = 0;
			$sql = mysqli_query($conn,"select * from timeline where User_Identify like '$Name' and Attitude like 'Negative' ");
			if(mysqli_num_rows($sql) != 0) 
			{
									echo "<br />";
									
									// Adding a post to diary ( From functions.php);
									
									Add_Post();
									// End a post
									$i = 0;
									while($i<5)
									{
										echo '<br/>';
										$i++;
									}
                            		
									//Filter_Timeline();
									// Showing  timeline/diary
									echo '<section id="cd-timeline" class="cd-container">';
									
									Show_Timeline(); // this function is called from function.php of root folder
									
									echo '</section> <!-- cd-timeline -->';
									// end timeline/diary
									
			}
					
			else
			{
				// In case users have no post!!!
				echo "<br/>";
				echo "<Span id='first-time' style='color:red;'>You have no timeline's post , please input at least 1 post!! </span> <br /> <br />";
				
				Add_Post(); //function's role is to open adding box (from function.php)
				$i = 0;
				while($i<5)
				{
					echo '<br/>';
					$i++;
				}
				
				echo '<section id="cd-timeline" class="cd-container" hidden="true">';
									
				Show_Timeline(); // this function is called from function.php of root folder
									
				echo '</section> <!-- cd-timeline -->';
			}
				
			mysqli_close($conn);
			
		?>
		</div>
	</div>
</div>
<!-- End Timeline -->
                    
                   <!--  -->
<?php get_footer(); ?>

