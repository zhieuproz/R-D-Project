<!-- this page is use for User Function : Therapy Tools page in website -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Therapy Tools*/ ?>
<?php get_header(); // Get header and Footer for this page!!
get_template_part('breadcrums'); ?>
<div class="container">	
	<div class="row enigma_blog_wrapper">
	<div class="col-md-8">
    <?php 
		if(is_user_logged_in() == false) 
			echo'<div style="color:red; font-size:25px;"> Please Login to use this function.!!! </div>';
		else
		{	$link = "http://localhost/rainbow/take-the-free-checkup-now/";
			header ("Location:".$link);// direct link from therapy tools to body signs introduction
		}
	?>
	</div>
	</div>	
</div>
<?php get_footer(); ?>