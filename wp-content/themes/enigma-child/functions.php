<?php
// this page is working with functions.php in its parent theme : enigma theme by running all code in both sheets
// this page executes : embeding CSS and Javascript sheet to Wordpress. In addition, it also declares all of main website functions and process AJAX Technique

//Begin our R&D coding part
//Begin Adding Timeline's CSS & JS to theme
?>


<?php
$GLOBALS['Check_Attitude'];
require_once("Custom_Widget/Contact_Widget.php"); 
?>


<?php 
// Timeline 
function TimelineStyle() 
{
	wp_register_style( 'Timeline-Reset', get_stylesheet_directory_uri() . '/timeline/css/reset.css', 'all' );
	wp_register_style( 'Timeline-Style', get_stylesheet_directory_uri() . '/timeline/css/style.css', 'all' );
	wp_register_style( 'Timeline', get_stylesheet_directory_uri() . '/timeline/css/timeline.css', 'all' );
	
	// adding time picker Style
	wp_register_style( 'time', get_stylesheet_directory_uri() . '/timeline/css/jquery-ui.css', 'all' );
	
  	wp_enqueue_style( 'Timeline-Reset' );
	wp_enqueue_style( 'Timeline-Style' );
	wp_enqueue_style( 'Timeline' );
	wp_enqueue_style( 'time' );
	
}
	add_action( 'wp_enqueue_scripts', 'TimelineStyle' );
		

function TimelineJS()
{
	wp_register_script( 'Timeline-main', get_stylesheet_directory_uri() . '/timeline/js/main.js', 'all' );
	wp_register_script( 'Timeline-modernizr', get_stylesheet_directory_uri() . '/timeline/js/modernizr.js', 'all' );
	
	// adding time picker JS
	 wp_register_script( 'time1',get_stylesheet_directory_uri() . '/timeline/js/jquery-1.10.2.js', 'all' );
	 wp_register_script( 'time2',get_stylesheet_directory_uri() . '/timeline/js/jquery-ui.js', 'all' );
	 
	// adding ajax
	wp_register_script( 'Timeline-button', get_stylesheet_directory_uri() . '/timeline/js/timeline.js', 'all' );
	wp_localize_script('Timeline-button', 'AJAX', array('url' => admin_url('admin-AJAX.php')));
	
	
  	wp_enqueue_script( 'Timeline-main' );
	wp_enqueue_script( 'Timeline-modernizr' );	
	wp_enqueue_script( 'Timeline-button' );
	wp_enqueue_script( 'time1' );
	wp_enqueue_script( 'time2' );
}
	add_action( 'wp_enqueue_scripts', 'TimelineJS' );


// Body Signs
function Body_SignsStyle()
{
	//adding Body Signs CSS
	wp_register_style( 'illustration', get_stylesheet_directory_uri() . '/Body_Signs/css/illustration-style.css', 'all' );
	
	//adding Bootstrap Slider CSS
	wp_register_style( 'Slider',get_stylesheet_directory_uri() . '/Body_Signs/css/jquery-ui.css', 'all' );
	wp_register_style( 'datepicker1',get_stylesheet_directory_uri() . '/Body_Signs/css/datepicker.css', 'all' ); //adding date picker css
	wp_register_style( 'datepicker2',get_stylesheet_directory_uri() . '/Body_Signs/css/main.css', 'all' );// date picker 2 
	
	wp_enqueue_style( 'illustration' );
	wp_enqueue_style( 'Slider' );
	wp_enqueue_style( 'datepicker1' );
	wp_enqueue_style( 'datepicker2' );
}

	add_action( 'wp_enqueue_scripts', 'Body_SignsStyle' );


function Body_SignsJS()
{
	// adding Body Signs JS
	wp_register_script( 'ext_organs', get_stylesheet_directory_uri() . '/Body_Signs/js/ext-organs.js', 'all' );
	wp_register_script( 'ext_spots', get_stylesheet_directory_uri() . '/Body_Signs/js/ext-spots.js', 'all' );
	wp_register_script( 'int_organs', get_stylesheet_directory_uri() . '/Body_Signs/js/int-organs.js', 'all' );
	wp_register_script( 'int_spots', get_stylesheet_directory_uri() . '/Body_Signs/js/int-spots.js', 'all' );
	wp_register_script( 'interact', get_stylesheet_directory_uri() . '/Body_Signs/js/interact-script.js', 'all' );
	
	
	// adding Jquery Slider JS
	wp_register_script( 'Slider-Jquery',get_stylesheet_directory_uri() . '/Body_Signs/js/jquery-1.12.4.js', 'all' );
	wp_register_script( 'Slider-JqueryUI',get_stylesheet_directory_uri() . '/Body_Signs/js/jquery-ui.js', 'all' );
	wp_register_script( 'Body_Signs',get_stylesheet_directory_uri() . '/Body_Signs/js/Body_Signs.js', 'all' );
	wp_register_script( 'Body_Signs_Process',get_stylesheet_directory_uri() . '/Body_Signs/js/Body_Sign_Process.js', 'all' );
	
	
	wp_register_script( 'datepicker',get_stylesheet_directory_uri() . '/Body_Signs/js/datepicker.js', 'all' ); //adding date picker 
	wp_register_script( 'main',get_stylesheet_directory_uri() . '/Body_Signs/js/main.js', 'all' );// date picker 2 
	wp_register_script( 'line-chart',get_stylesheet_directory_uri() . '/Body_Signs/js/canvasjs.min.js', 'all' );// Line Chart
	
	wp_enqueue_script( 'ext_organs' );
	wp_enqueue_script( 'ext_spots' );
	wp_enqueue_script( 'int_organs' );
	wp_enqueue_script( 'int_spots' );
	wp_enqueue_script( 'interact' );
	wp_enqueue_script( 'Slider-Jquery' );
	wp_enqueue_script( 'Slider-JqueryUI' );
	wp_enqueue_script( 'Body_Signs' );
	wp_enqueue_script( 'Body_Signs_Process' );
	
	wp_enqueue_script( 'datepicker' );
	wp_enqueue_script( 'main' );
	wp_enqueue_script( 'line-chart' );
}

	add_action( 'wp_enqueue_scripts', 'Body_SignsJS' );

//Counsellor 
function CounsellorStyle()
{
	// add photo counsellor
}
	add_action( 'wp_enqueue_scripts', 'CounsellorStyle' );

function CounsellorJS()
{
	wp_register_script( 'Main_Counsellor',get_stylesheet_directory_uri() . '/Counsellors/js/Counsellor.js', 'all' );// Counsellor
	wp_register_script( 'Main_Counsellor','http://code.jquery.com/jquery-latest.min.js', 'all' );// Counsellor
	
	
	wp_enqueue_script( 'Main_Counsellor' );
}

	add_action( 'wp_enqueue_scripts', 'CounsellorJS' );
?>

<?php 


// Button Adding a New Post
function Add_Post()
{	
	//Button
		echo '<button type="button" class="btn btn-info btn-md" id="AddingBox"  data-target="#Adding_Model">Add a new post</button>';
	
	// Modal
	echo '<div id="Adding_Model" class="modal fade" role="dialog">'; 
		echo '<div class="modal-dialog modal-lg">';
	
			//Modal Content
			    echo'<div class="modal-content">'; // Modal Content
					echo'  <div class="modal-header">'; // Header 
						echo'	<button type="button" class="close" data-dismiss="modal">&times;</button>';
						echo'	<h4 id="TitleOfPost" class="modal-title">Adding a new Post </h4>';
				 	echo'</div>'; // End Header
	
				echo' <div class="modal-body">'; // Body
echo '<form id="timeline-form" name="PostingForm" class="form-group">'; // starting form
										
		
											echo '<div class="row">'; // 1st row (title + date)

												echo '<div class="col-xs-12 col-lg-6">';  //title

													echo '<div id="main-title" class="form-group">';
														echo '<label id="lbtimeline"> Title of Post </label>'.' ' .'(*)'; 
														echo '<input type="text" name="title" id="title" class="form-control">';
													echo '</div>';


												echo '</div>'; //end title

												echo '<div class="col-xs-12 col-lg-6">'; // date 
													echo '<div id="main-date" class="form-group">'; 

														echo '<label id="lbtimeline">Date of Post</label>'.' ' . '(*)'.	'';  
														echo '<input type="text" name="date" id="date" class="form-control">';

													echo '</div>';
												echo '</div>'; // end date 
											echo'</div>';// end 1st row

	
											echo '<div class="row">'; // 2nd row (attitude-Feeling)
												
												if($GLOBALS['Check_Attitude'] == 1)// positive attitude // Attitude will not be showed, this is for identifying kinds of posts
												{
													echo '<div hidden="true" class="attitude">';
													echo 'Positive';
													echo '</div>';
												}
												else if($GLOBALS['Check_Attitude'] == 0) // negative attitude
												{
													echo '<div hidden="true" class="attitude">';
													echo 'Negative';
													echo '</div>';
												} // end attitude
												
												echo '<div class="col-xs-12">'; //Feeling

														echo '<div id="main-feeling">'; 
															echo '<label id="lbtimeline">Your Feeling : </label>'.' '; 
															echo'<label class="radio-inline">Sad<input value="Sad" type="radio" name="Feeling" ></label>';
															echo'<label class="radio-inline">Happy<input value="Happy" type="radio" name="Feeling"></label>';
															echo'<label class="radio-inline">Anxiety<input value="Anxiety" type="radio" name="Feeling"></label>';
															echo'<label class="radio-inline">Angry<input value="Angry" type="radio" name="Feeling"></label>';	
															echo'<label class="radio-inline">Relaxed<input value="Relaxed" type="radio" name="Feeling"></label>';
														echo '</div>';
															
														  
												echo '</div>'; // end Feeling
											echo '</div>';	 // end 2nd row
	

											echo '<div class="row">'; // 3nd row ( Content )
												echo '<div class="col-xs-12">'; //content

														echo '<div id="main-content" class="form-group">'; 
															echo '<label id="lbtimeline">Content</label>'.' ' . '(*)'; 
															echo '<textarea name="content" id="content" rows="10" class="form-control" ></textarea>';
														echo '</div>';

												echo '</div>'; // end content
											echo '</div>';	 // end 3nd row
				echo '  </div>'; // End Body
	
	
				echo ' <div class="modal-footer">'; // Footer 
												echo '<span style="color:red; font-weight:bold; float:left;">'.'(*)-Required'.'</span>';
	
												echo '<input class="btn btn-primary" type="button" name="Update" value="Update" id="Update" style="float:right; margin-right:13px; margin-top:-5px;" />';
	
												echo '<input class="btn btn-primary" type="button" name="submit" id="submit" value="post" style="float:right; margin-right:13px; margin-top:-5px;" onclick="return CheckPost();"/>'; // careful type of this input is "button" instead of submit
										echo '</form>'; // ending form
				echo '  </div>'; // End Footer 
	
				echo '</div>'; // End Modal Content

		echo '</div>';// End Modal
	echo '</div>';// End Modal

}




function Show_Timeline()
{
	global $current_user; // get current user information
	get_currentuserinfo();
	$user = $current_user->display_name;	
	include("Database/ConnectDatabase.php");
	if($GLOBALS['Check_Attitude'] == 1)
	{
		$sql = mysqli_query($conn,"select * from timeline where User_Identify like '$user' and Attitude like 'Positive' ");
	}
	
	else if($GLOBALS['Check_Attitude'] == 0)
	{	
		$sql = mysqli_query($conn,"select * from timeline where User_Identify like '$user' and Attitude like 'Negative' ");
	}
	
									if(mysqli_num_rows($sql) != 0) 
									{
										while($row = mysqli_fetch_array($sql))
										{
											echo '<div class="cd-timeline-block">'; //Begin Timeline
											echo	'<div class="cd-timeline-img cd-picture">';

											if($row['Attitude'] == 'Positive') 
											{
												echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//timeline/img/Positive.png" title="Positive Feeling" alt="Positive feeling" />'; 
											}
											
											if($row['Attitude'] == 'Negative')
											{
												echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//timeline/img/Negative.png" title="Negative Feeling" alt="negative feeling" />';
											}
											
											echo	'</div> <!-- cd-timeline-img -->';
	
											echo '<div class="cd-timeline-content">';
											
											echo '<div>';
											echo '<h3>'. $row['Title']. '</h3>';
											echo '<p style="color:burlywood;">'. $row['Feeling']. '</p>';
											echo '<p>' . $row['Content']. '</p>';
											echo '</div>';
											
											echo '<form btn-content="" name="timeline" style="float:right;">';
												
												echo '<input class="id-edit btn btn-primary" idEdit="'.$row['ID']. '" titleEdit="'.$row['Title']. '" dateEdit="'.$row['Date']. '" contentEdit="'.$row['Content']. '" feelingEdit="'.$row['Feeling']. '" type="button" value="Edit" style="border-radius:5px;" />  ';
												
												echo '<input class="id-Del btn btn-primary" idDelete="'.$row['ID']. '" type="button" value="Delete" name="delete" style="border-radius:5px;" />  '; //deleting function is executed by Jquery technique in timeline.js file			
												
											echo '</form>';
											echo '<span class="cd-date">' .$row['Date'] . '</span>';
											echo '</div> <!-- cd-timeline-content -->';
											echo '</div> <!-- cd-timeline-block -->';
											
										}
									}
				
}






function Add_BodySign()
{
	include("Database/ConnectDatabase.php");
	global $current_user; // get current user information
	get_currentuserinfo();
	$user = $current_user->display_name;
	
	if(isset($_POST['feeling']) || ($_POST['head']) || ($_POST['neck']) || ($_POST['chest']) || ($_POST['abdomen']) || ($_POST['shoulder']) || ($_POST['arm']) || ($_POST['upperlime']) || ($_POST['lowerlimb']) || ($_POST['leg']) || ($_POST['hand']) || ($_POST['lungs']) || ($_POST['thought']) || ($_POST['heart']) || ($_POST['stomach']) || ($_POST['feeling_icon']) )
	{ // Validating isset variables from Body_Sign page will not be executed because php will behave with variable 0 = not isset , so we must use || instead of &&
		
		//Getting Value from Sliders
		$Icon = $_POST['feeling_icon'];
		$Feeling = $_POST['feeling']; // Head Area 
		$Head = $_POST['head'];
		
		$Neck = $_POST['neck']; // Body Area
		$Chest = $_POST['chest'];
		$Abdomen = $_POST['abdomen'];
		$Shoulder = $_POST['shoulder'];
		$Arm = $_POST['arm'];
		
		$Upperlime = $_POST['upperlime']; //Limbs Area
		$Lowerlime = $_POST['lowerlimb'];
		$Leg= $_POST['leg'];
		$Hand= $_POST['hand'];
		
		$Lungs = $_POST['lungs']; // internal Area
		$Heart = $_POST['heart'];
		$Stomach = $_POST['stomach'];
		$Thought = $_POST['thought'];
		$ThoughtArea = $_POST['thought-area'];
		
		$GLOBALS['CountOrgans'] = 0 ; //Counting how many organs were submitted
		$GLOBALS['Sum'] = 0;
		
		if($Feeling != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Feeling;
		}
	
		if($Head != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Head;
		}
		
		if($Neck != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Neck;
		}
		
		if($Chest != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Chest;
		}
		
		if($Abdomen != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Abdomen;
		}
		
		if($Shoulder != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Shoulder;
		}
		
		if($Arm != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Arm;
		}

		if($Upperlime != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Upperlime;
		}
		
		if($Lowerlime != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Lowerlime;
		}
		
		if($Leg != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Leg;
		}
		
		if($Hand != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Hand;
		}
		
		if($Lungs != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Lungs;
		}
		
		if($Heart != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Heart;
		}
		
		if($Stomach != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Stomach;
		}
		
		if($Thought != 0 )
		{
			$GLOBALS['CountOrgans'] += 1;
			$GLOBALS['Sum'] += $Thought;
		}
		
		$GLOBALS["Average"] = $GLOBALS['Sum']/$GLOBALS['CountOrgans'];
		$avg = $GLOBALS["Average"];
		$avg = (float)$avg;
		$date = date("m/d/Y");
		
		$sql = "INSERT INTO bodysign(User_Identify , Average ,Feeling ,  Feeling_Scale , Head_Scale , Thought , Thought_Scale , Neck_Scale , Chest_Scale  , Abdomen_Scale , Shoulder_Scale , Arm_Scale , Lungs_Scale , Heart_Scale , Stomach_Scale , Date)VALUES('$user' , '$avg','$Icon','$Feeling','$Head','$ThoughtArea' , '$Thought' , '$Neck' ,'$Chest' , '$Abdomen' , '$Shoulder' , '$Arm' , '$Lungs' , '$Heart' ,'$Stomach' ,'$date')";
		$Result = mysqli_query($conn,$sql);
		if(!$Result)
		{
			echo "cannot insert new body signs";	
		}
		else
		{
			header('Location:'.get_site_url().'/Bucket-Model'); //preventing popup form resubmission
		}
		
	}
	
}


function Show_BodySign($avg)
{
	if($avg >= 1 && $avg < 2) // Stress Level 1 
	{
		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level1.png" title="Level 1" alt="Level 1 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L1.png" title="Level 1" alt="Level 1 " />'; 
		echo '</div>';

	}

	if($avg >= 2 && $avg < 3) // Stress Level 2 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level2.png" title="Level 2" alt="Level 2 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L2.png" title="Level 2" alt="Level 2 " />'; 
		echo '</div>';

	}

	if($avg >= 3 && $avg < 4) // Stress Level 3 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level3.png" title="Level 3" alt="Level 3 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L3.png" title="Level 3" alt="Level 3" />'; 
		echo '</div>';

	}

	if($avg >= 4 && $avg < 5) // Stress Level 4 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level4.png" title="Level 4" alt="Level 4 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L4.png" title="Level 4" alt="Level 4 " />'; 
		echo '</div>';

	}

	if($avg >= 5 && $avg < 6) // Stress Level 5 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level5.png" title="Level 5" alt="Level 5 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L5.png" title="Level 5" alt="Level 5 " />'; 
		echo '</div>';

	}

	if($avg >= 6 && $avg < 7) // Stress Level 6 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level6.png" title="Level 6" alt="Level 6 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L6.png" title="Level 6" alt="Level 6 " />'; 
		echo '</div>';

	}

	if($avg >= 7 && $avg < 8) // Stress Level 7 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level7.png" title="Level 7" alt="Level 7 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L7.png" title="Level 7" alt="Level 7 " />'; 
		echo '</div>';

	}

	if($avg >= 8 && $avg < 9) // Stress Level 8 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level8.png" title="Level 8" alt="Level 8 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L8.png" title="Level 8" alt="Level 8 " />'; 
		echo '</div>';

	}

	if($avg >= 9 && $avg < 10) // Stress Level 9
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level9.png" title="Level 9" alt="Level 9 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L9.png" title="Level 9" alt="Level 9" />'; 
		echo '</div>';

	}

	if($avg == 10) // Stress Level 10 
	{

		echo '<div class="col-xs-8">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/Level10.png" title="Level 10" alt="Level 10 " />'; 
		echo '</div>';

		echo '<div class="col-xs-4">';
		echo '<img src="'; ?> <?php echo get_stylesheet_directory_uri().'//Body_Signs/Images/Strees_Level/L10.png" title="Level 10" alt="Level 10 " />'; 
		echo '</div>';

	}
}

function Add_Counsellor()
{
//Button
		echo '<button type="button" class="btn btn-info btn-md" id="AddingCounsellor"  data-target="#Adding_Counsellor">Add Counsellor</button>';
	
	// Modal
	echo '<div id="Adding_Counsellor" class="modal fade" role="dialog">'; 
		echo '<div class="modal-dialog modal-lg modal-counsellor">';
	
			//Modal Content
			    echo'<div class="modal-content">'; // Modal Content
					echo'  <div class="modal-header">'; // Header 
						echo'	<button type="button" class="close" data-dismiss="modal">&times;</button>';
						echo'	<h4 id="Title_Counsellor" class="modal-title">Adding Counsellor </h4>';
				 	echo'</div>'; // End Header
	
				echo' <div class="modal-body">'; // Body
echo '<form id="counsellor-form" name="CounsellorForm" class="form-group" enctype="multipart/form-data" >'; // starting form
										
		
											echo '<div class="row">'; // 1st row (First Name - Photo)

												echo '<div class="col-xs-6">';  // First Name 

													echo '<div id="counsellor-first-name" class="form-group">';
														echo '<h5><span class="label label-default">First Name</span> (*)</h5>'; 
														echo '<input type="text" name="First_Name" id="First_Name" class="form-control">';
													echo '</div>';
												
												echo '</div>';
						
												
	
												echo '<div class="col-xs-6">';  // Photo

													echo '<div id="counsellor-photo" class="form-group">';
														echo '<h5><span class="label label-default">Upload Photo</span> (*)</h5>'; 
													   echo'<input type="file" id="Photo" name="upload">';
													echo '</div>';
												
												echo '</div>';
	

											echo'</div>';// end 1st row

	

											echo '<div class="row">'; // 2nd row (Area specialty)

												echo '<div class="col-xs-6">'; 

													echo '<div id="counsellor-specialty" class="form-group">';
														echo '<h5><span class="label label-default">Specialty Area</span> (*)</h5>'; 
														echo '<input type="text" name="specialty" id="specialty" class="form-control">';
													echo '</div>';


												echo '</div>';

											echo'</div>';// end 2nd row


											echo '<div class="row">'; // 3rd row (Region)

												echo '<div class="col-xs-6">'; 

													echo '<div id="counsellor-region" class="form-group">';
														echo '<h5><span class="label label-default">Region</span> (*)</h5>'; 
														echo '<input type="text" name="region" id="region" class="form-control">';
													echo '</div>';


												echo '</div>';

											echo'</div>';// end 3rd row
	
											echo '<div class="row">'; // 4th row (Year Experience)

												echo '<div class="col-xs-6">'; 

													echo '<div id="counsellor-experience" class="form-group">';
														echo '<h5><span class="label label-default">Experience Year</span> (*)</h5>'; 
														echo '<input type="text" name="experience" id="experience" class="form-control">';
													echo '</div>';


												echo '</div>';

											echo'</div>';// end 4th row
	
											echo '<div class="row">'; // 5th row (Fee)

												echo '<div class="col-xs-6">'; 

													echo '<div id="counsellor-fee" class="form-group">';
														echo '<h5><span class="label label-default">Fee</span> (*)</h5>'; 
														echo '<input type="text" name="fee" id="fee" class="form-control">';
													echo '</div>';


												echo '</div>';

											echo'</div>';// end 5th row

												echo '<div class="row">'; // 6th row (Brief Information)

												echo '<div class="col-xs-6">'; 

													echo '<div id="counsellor-information" class="form-group">';
														echo '<h5><span class="label label-default">Brief Information </span> (*)</h5>'; 
														echo '<textarea class="form-control" rows="5" name="information" id="information"></textarea>';
													echo '</div>';


												echo '</div>';

											echo'</div>';// end 6th row
	
	
											echo '<input  type="hidden" name="counsellor-id-row" id="counsellor-id-row" class="form-control">';
								
	
				echo '  </div>'; // End Body
	
	
				echo ' <div class="modal-footer">'; // Footer 
												echo '<span style="color:red; font-weight:bold; float:left;">'.'(*)-Required'.'</span>';
	
												echo '<input class="btn btn-primary" type="button" value="Update Information" id="Counsellor-Update" style="float:right; margin-right:13px; margin-top:-5px;" />';
				
	
												echo '<input onclick="return Add_Counsellor();" class="btn btn-primary" type="button" name="Counsellor-Submit" id="Counsellor-Submit" value="Add Counsellor" style="float:right; margin-right:13px; margin-top:-5px;"/>'; // careful type of this input is "button" instead of submit
										echo '</form>'; // ending form
				echo '  </div>'; // End Footer 
	
				echo '</div>'; // End Modal Content

		echo '</div>';// End Modal
	echo '</div>';// End Modal

}

function Show_Counsellor()
{
	
	include("Database/ConnectDatabase.php");
	global $current_user; // get current user information
	get_currentuserinfo();
	$user = $current_user->display_name;	
	$sql = mysqli_query($conn,"select * from counsellor"); 
	if(mysqli_num_rows($sql) != 0) 
	{
		echo'<table class="table table-hover">';
			echo'<tr>';
				echo'<td><b>Photo</b></td>';
				echo'<td><b>First Name</b></td>';
				echo'<td><b>Area_Specialty</b></td>';
				echo'<td><b>Region</b></td>';
				echo'<td><b>Experience</b></td>';
				echo'<td><b>Fee</b></td>';
				echo'<td><b>Brief Information</b></td>';
				echo '<td><b>Modifying</b></td>';
			echo'</tr>';
		
		while($row = mysqli_fetch_array($sql))
		{
			
			
			echo'<tr>';
				echo'<td id="pic-'.$row['ID'].'">' .'<img title="'.$row['Picture'].'" width="100" src="'.site_url(). '/wp-content/uploads/Counsellors/'.$row['Picture'].'"/>'.'</td>';
				echo'<td id="name-'.$row['ID'].'">' .$row['First_Name'].'</td>';
				echo'<td id="specialty-'.$row['ID'].'">' .$row['Area_Specialty'].'</td>';
				echo'<td id="region-'.$row['ID'].'">' .$row['Region'].'</td>';
				echo'<td id="year-'.$row['ID'].'">' .$row['Year_Experience'].'</td>';
				echo'<td id="fee-'.$row['ID'].'">' .$row['Fee'].'</td>';
				echo'<td id="infor-'.$row['ID'].'">' .$row['Brief_Information'].'</td>';
			
				echo '<form name="Edit-counsellor">';
			
				echo '<td>
				<input onclick="EditCounsellor('.$row['ID'].');"  value="Edit" class="EditC btn btn-warning" type="button"/>
				
				<input value="Delete" class="DelC btn btn-danger" type="button" DelCounsellor="'.$row['ID'].'" />
				
				</td>';
				echo '</form>';
			echo'</tr>';
		}	
		echo'</table>'; 
	}
	
}

// Process AJAX Technique
function processing() // this function is to return values from server of Ajax Request in posting/Editing/Deleting
{
    include("Database/ConnectDatabase.php");
	if(isset($_POST['title']) && ($_POST['date']) && ($_POST['content']) && ($_POST['attitude']) && ($_POST['feeling']) ) // adding timeline process
	{
		$Title = $_POST['title'];
		$Date = $_POST['date'];
		$Content = $_POST['content'];
		$Attitude = $_POST['attitude'];
		$Feeling = $_POST['feeling'];
		
		global $current_user; // get current user information
		get_currentuserinfo();
		$user = $current_user->display_name;
		
		$sql = "INSERT INTO timeline(User_Identify, Title, Content, Date , Attitude , Feeling)VALUES('$user','$Title','$Content','$Date' , '$Attitude' , '$Feeling')";
		$Result = mysqli_query($conn,$sql);
	
			if(!$Result)
			{
				echo "cannot post";	
			}
			else
			{
				if($Attitude == 'Positive')
				{
					$GLOBALS['Check_Attitude'] = 1;
					Show_Timeline();
				}
				
				else if($Attitude == 'Negative')
				{
					$GLOBALS['Check_Attitude'] = 0;
					Show_Timeline();
				}
				
			}
			
			die();
	} // end adding process
	
	
	if(isset($_POST['TitleUpdate']) && ($_POST['DateUpdate']) && ($_POST['ContentUpdate']) && ($_POST['idEdit']) && ($_POST['FeelingUpdate']) && ($_POST['attitude'])) //Editing timeline process
	{
		
		$Title = $_POST['TitleUpdate'];
		$Date = $_POST['DateUpdate'];
		$Content = $_POST['ContentUpdate'];
		$edit = $_POST['idEdit'];
		$Feeling = $_POST['FeelingUpdate'];
		$Attitude = $_POST['attitude'];
		
		$sql = "UPDATE timeline SET Title = '$Title' , Content = '$Content' , Date = '$Date' , Feeling = '$Feeling' where ID like '$edit'";
		$Result = mysqli_query($conn,$sql);
		if(!$Result)
		{
			echo "cannot Edit post";	
		}
		else
		{
			if($Attitude == 'Positive')
			{
				$GLOBALS['Check_Attitude'] = 1;
				Show_Timeline();
			}
				
			else if($Attitude == 'Negative')
			{
				$GLOBALS['Check_Attitude'] = 0;
				Show_Timeline();
			}
				
		}
		die();
	} // end editing process
	
	
	if(isset($_POST['deleting']) && $_POST['attitude']) // Deleting timeline process
	{
		
		$del = $_POST['deleting'];
		$sql = "DELETE FROM timeline where ID like '$del'";
		$Attitude = $_POST['attitude'];
		$Result = mysqli_query($conn,$sql);
		if(!$Result)
		{
			echo "cannot delete";	
		}
		else
		{
				if($Attitude == 'Positive')
				{
					$GLOBALS['Check_Attitude'] = 1;
					Show_Timeline();
				}
				
				else if($Attitude == 'Negative')
				{
					$GLOBALS['Check_Attitude'] = 0;
					Show_Timeline();
				}
				
		}
		die();
	} // end deleting timeline process
	
	if(isset($_POST['search_date'])) // searching old body sign process
	{
		global $current_user; // get current user information
		get_currentuserinfo();
		$user = $current_user->display_name;
		$Search_Date = $_POST['search_date'];
		if($Search_Date == '')
		{
			echo '<h4>Please Input date before reviewing your test!!</h4>';
			die();
		}
		else
		{
		
			$sql = "select * from bodysign where Date like '$Search_Date' and User_Identify like '$user'";

			$Result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($Result) == 0)
			{
				echo '<h4>Sorry but there is no body sign test on <b>'.$Search_Date. '</b>!! </h4>';
			}
			else
			{
				$row = mysqli_fetch_array($Result);
				echo '<h4>Test Date : '.$Search_Date.'</h4>';

				echo '<div class="row">';
					echo '<p> <textarea readonly class="form-control" rows="5">'.$row['Thought']. '</textarea> </p>';
				echo '</div>';


				echo'<div class="row table-responsive">';
					echo'<table class="table table-hover">';
						echo'<tr>';
							echo'<td></td>';
							echo'<td>Feeling</td>';
							echo'<td>Head</td>';
							echo'<td>Thought</td>';
							echo'<td>Neck</td>';
							echo'<td>Chest</td>';
							echo'<td>Abdomen</td>';
							echo'<td>Shoulder</td>';
							echo'<td>Arm</td>';
							echo'<td>Lungs</td>';
							echo'<td>Heart</td>';
							echo'<td>Stomach</td>';

						echo'</tr>';

						echo'<tr>';
							echo'<td><b>Stress Level</b></td>';
							echo'<td>'.$row['Feeling_Scale'].'</td>';
							echo'<td>'.$row['Head_Scale'].'</td>';
							echo'<td>'.$row['Thought_Scale'].'</td>';
							echo'<td>'.$row['Neck_Scale'].'</td>';
							echo'<td>'.$row['Chest_Scale'].'</td>';
							echo'<td>'.$row['Abdomen_Scale'].'</td>';
							echo'<td>'.$row['Shoulder_Scale'].'</td>';
							echo'<td>'.$row['Arm_Scale'].'</td>';
							echo'<td>'.$row['Lungs_Scale'].'</td>';
							echo'<td>'.$row['Heart_Scale'].'</td>';
							echo'<td>'.$row['Stomach_Scale'].'</td>';

						echo'</tr>';


						echo'<tr>';
							echo '<td> <b>Summary </b> </td>';
							echo '<td> <b> Average Stress Level '.$row['Average'].'</b></td>';
							echo '<td> <b> Emotional Icon '.$row['Feeling'].'</b></td>';
						echo'</tr>';

					echo'</table>';
				echo'</div>';
			}
			die();
		}
	}
	
	if(isset($_POST['Counsellor_Name']) && ($_POST['Counsellor_Specialty']) && ($_POST['Counsellor_Region']) && ($_POST['Counsellor_Experience']) && ($_POST['Counsellor_Fee']) && ($_POST['Counsellor_Information']) && ($_POST['Counsellor_Photo']) ) // add counsellor process
	{
		$name = $_POST['Counsellor_Name'];
		$specialty = $_POST['Counsellor_Specialty'];
		$region = $_POST['Counsellor_Region'];
		$experience = $_POST['Counsellor_Experience'];
		$fee = $_POST['Counsellor_Fee'];
		$infor = $_POST['Counsellor_Information'];
		$photo = $_POST['Counsellor_Photo'];
		
		global $current_user; // get current user information
		get_currentuserinfo();
		$user = $current_user->display_name;
		
		$sql = "INSERT INTO counsellor(First_Name, Picture, Area_Specialty , Region , Year_Experience , Fee , Brief_Information )VALUES('$name','$photo','$specialty','$region' , '$experience' , '$fee' , '$infor')";
		$Result = mysqli_query($conn,$sql);
		
		if(!$Result)
		{
			echo "cannot add counsellor";	
		}
		else
		{
			Show_Counsellor();
		}
		die();
		
	}
	
	if(isset($_POST['idEditCounsellor']) || ($_POST['NameC']) || ($_POST['SpecialtyC']) || ($_POST['RegionC']) || ($_POST['ExperienceC']) || ($_POST['FeeC']) || ($_POST['InforC']) && ($_POST['PhotoC']) ) //Editing Counsellor process
	{
		$idC = $_POST['idEditCounsellor'];
		$nameC = $_POST['NameC'];
		$specialtyC = $_POST['SpecialtyC'];
		$regionC = $_POST['RegionC'];
		$experienceC = $_POST['ExperienceC'];
		$feeC = $_POST['FeeC'];
		$inforC = $_POST['InforC'];
		$photoC = $_POST['PhotoC'];		
		
		$sql = "UPDATE counsellor SET First_Name = '$nameC' , Picture = '$photoC' ,  Area_Specialty = '$specialtyC' , Region = '$regionC' , Year_Experience = '$experienceC' , Fee = '$feeC' , Brief_Information = '$inforC' where ID = '$idC' ";
		
		
		$Result = mysqli_query($conn,$sql);
		if(!$Result)
		{
			echo "cannot Edit Counsellor";	
		}
		else
		{
			Show_Counsellor();
		}
		die();
	} // end editing Counsellor process
	
	
	if(isset($_POST['DelCounsellor']) ) // Deleting Counsellor process
	{
		$del = $_POST['DelCounsellor'];
		$sql = "DELETE FROM counsellor where ID like '$del'";
		$Result = mysqli_query($conn,$sql);
		if(!$Result)
		{
			echo "cannot delete this counsellor";	
		}
		else
		{
			Show_Counsellor();
		}
		die();
	}

}
add_action('wp_ajax_processing', 'processing');


function wpse_183245_upload_dir( $dirs ) // Temporarily change dir path to store image
{
    $dirs['subdir'] = '/Counsellors';
    $dirs['path'] = $dirs['basedir'] . '/Counsellors';
    $dirs['url'] = $dirs['baseurl'] . '/Counsellors';
	
    return $dirs;
}


function UploadPhoto()// Upload Counsellor Image by Ajax 
{
	add_filter( 'upload_dir', 'wpse_183245_upload_dir' );
	$support_title = !empty($_POST['supporttitle']) ? 
	$_POST['supporttitle'] : 'Support Title';

	if (!function_exists('wp_handle_upload')) 
	{
		require_once(ABSPATH . 'wp-admin/includes/file.php');
	}
	
	$uploadedfile = $_FILES['file'];
	$upload_overrides = array('test_form' => false);
	$movefile = wp_handle_upload($uploadedfile, $upload_overrides);

	
	if ($movefile && !isset($movefile['error'])) 
	{
		
		echo "File Upload Successfully";
	}
	
	else 
	{
		echo $movefile['error'];
	}
	die();
	
	remove_filter( 'upload_dir', 'wpse_183245_upload_dir' );
}
add_action( 'wp_ajax_UploadPhoto','UploadPhoto' );
add_action( 'wp_ajax_nopriv_UploadPhoto','UploadPhoto' );
?>