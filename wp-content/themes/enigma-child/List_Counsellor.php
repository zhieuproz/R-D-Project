<!-- this page is to pick a counsellor who is the most suitable for users -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: List Counsellor*/ ?>
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
						echo "Counsellor List";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. "Counsellor List";			
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
				$Name = $current_user->display_name; //getting current user to variable name to use !!
				include("Database/ConnectDatabase.php");
				$sql = "select * from counsellor";
				$result = mysqli_query($conn,$sql);
				
				
				if(mysqli_num_rows($result) != 0)
				{
					
					
					while($row = mysqli_fetch_array($result))
					{
                        echo'<div class="col-sm-4">';
                            echo'<div class="col-item">';
                               
                                echo'<div class="photo">';
                                    echo'<img width="200" height="200" src="'.site_url().'/wp-content/uploads/Counsellors/'.$row['Picture'].'"  alt="a" />';
                                echo'</div>';
                                
                                echo'<div class="info">';
                                   
                                    echo'<div class="row">';
                                       
                                        echo'<div class="price col-md-6">';
						
                                            echo'<h5>'.$row['First_Name'].' </h5>';
                                            echo'<h5>'.$row['Area_Specialty'].' </h5>';
                                            echo'<h5 class="price-text-color" style="color:red !important;"> '.$row['Fee'].'</h5>';
						
                                        echo'</div>';
                                        
                                        echo'<div class="rating hidden-sm col-md-6"></div>';
                                        
                                    echo'</div>';
                                    
                                    echo'<div class="separator clear-left">';
						
						
                                    echo '<form method="post" class="form-horizontal form-group" name="ListForm" action="'.get_site_url().'/detail-counsellor'. '">';
						
                                        echo'<p style="float:right;" class="btn-details"> <button type="submit" class="btn btn-default hidden-sm Show_Detail">details</button> </p>';

						
										echo '<input name="ID" hidden value="'.$row['ID'].'" />';
						
										echo '</form>';
						
						
                                    echo'</div>';
                                    
                                    echo'<div class="clearfix"> </div>';
                                    
                                echo'</div>';
                                
                            echo'</div>';
                        echo'</div>';
						
						
					}
					
				}
			}
			
			
		?>
			
           
                        
		</div>
	</div>	
</div>
<?php get_footer(); ?>