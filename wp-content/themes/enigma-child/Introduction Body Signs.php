<!-- tThis page is use for User Function : Therapy Tools page in website -->
<!-- This page is the separated page and using same template of the website : Enigma -->
<!-- The main Function of this page is to give the brief introuction about body signs to users-->

<?php /*Template Name: Body Signs Introduction*/ ?>
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
						echo "Body Signs Introduction";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. $current_user->display_name. "'s Body Signs";			
				 ?>
                
			</div>
		</div>
	</div>	
</div>
<!-- End displaying title -->


<div class="container">
	<div class="row enigma_blog_wrapper">
		<div class="col-xs-12">
	
		<!-- Introduction Of Body Sign -->
		<h2 style="color:#1EE2EC;">Introduction to Body Signs and Feelings </h2><br/>
		
			<div class="body_sign">

			<p>Sit somewhere comfortably and when you are ready take a slow, deep breath and pause for about 3 to 5 seconds (Do not strain, let it be a natural rhythm) then breath out slowly. do this three or four times with your eyes closed then tune in to your body. Pause again for a moment, Now imagine a scanner taking a reading from your head to your toes. Imagine it was printing a read-out for us, what would it highlight? </p><br/>

			<b>What do you notice in your body?</b> <br/>
			<b>Is there any tension or aches and pains,  or do you feel relaxed? </b> <br/><br/>

			<p>Look at your chosen caricature image, there are a few areas highlighted to help you with you with your own "self-awareness". Click on the areas you have noticed in your self that comes to mind. </p>

				<p>You will see a slide bar next to your Caricature slide it to a place that indicates high or low tension or stress in that area of your body. this maybe due to different factors like pain or injury or low tension if you have been enjoying a relaxing time. You chose what feels right for you at this time.</p>
				<?php echo '<img width="200" src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_signs/Images/Level1.png" />'; ?>
			</div>
			
			<div align="right"><input type="button" class="btn btn-primary" value="Start Your Test" onClick="window.location='localhost/rainbow/body-signs/'";></input></div>
		</div>
	</div>
</div>
<?php get_footer(); ?>