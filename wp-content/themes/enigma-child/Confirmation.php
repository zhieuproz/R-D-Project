<!-- Confirmation Page after Booking -->

<!-- this page is the separated page and using same template of the website : Enigma -->



<?php /*Template Name: Confirmation Booking*/ ?>

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

						echo "Confirmation Booking";

					?>

                

                </h1>

					

                <?php

					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. "Confirmation Booking";			

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

				if(isset($_POST['title']) || ($_POST['contact']) || ($_POST['ethnic_group'])  || ($_POST['Relationship']) || ($_POST['income']) && ($_POST['counsellor_id']))  

				{

					//Get Information from booking page

					//section A: personal

					

					$first_name =  $_POST['firstname'];

					$last_name = $_POST['last_name'];

					$title = $_POST['title'];

					$gender = $_POST['gender'];

					$dob = $_POST['dob'];

					$address = $_POST['address'];

					$home = $_POST['home'];

					$work = $_POST['work'];

					$mobile = $_POST['mobile'];

					$email = $_POST['email'];

					$contact = $_POST['contact'];

					$ethnic = $_POST['ethnic_group'];

					$others = $_POST['others'];

					$language = $_POST['language'];

					$relationship = $_POST['Relationship'];

					

					//section B : Family

					$firstname_partner = $_POST['firstname_partner'];

					$lastname_partner = $_POST['last_name_partner'];

					$dob_family = $_POST['dob_family'];

					$home_partner = $_POST['home_partner'];

					$work_partner = $_POST['work_partner'];

					$mobile_partner = $_POST['mobile_partner'];

					

					$childname1 = $_POST['1stchildname'];

					$childdob1 = $_POST['1stchildob'];

					$childage1 = $_POST['1stchildage'];

					$childgender1 = $_POST['genderchild'];

					

					$childname2 = $_POST['2ndchildname'];

					$childdob2 = $_POST['2ndchilddob'];

					$childage2 = $_POST['2ndchildage'];

					$childgender2 = $_POST['genderchild2'];

					

					$childname3 = $_POST['3rdchildname'];

					$childdob3 = $_POST['3rdchildob'];

					$childage3 = $_POST['3rdchildage'];

					$childgender3 = $_POST['genderchild3'];

					

					//section C : Income

					$income = $_POST['income'];

					$service_card = $_POST['cardnumber'];

					$expiry_date = $_POST['expiry'];

					$profession = $_POST['profession'];

					$notes = $_POST['notes'];

					

					//section D : Information

					$reason = $_POST['reason'];

					$time = $_POST['time'];

					$before = $_POST['before'];

					$utifising = $_POST['utifising'];

					$mentalhealth = $_POST['mentalhealth'];

					$medications = $_POST['medications'];

					$doctorname = $_POST['doctorname'];

					$fee = $_POST['fee'];

					

					$ID = $_POST['counsellor_id'];

					$Name = $current_user->display_name;

					include("Database/ConnectDatabase.php");

					

					$sql = "INSERT INTO booking(User_Identify, First_Name , Last_Name , Title , Gender , Date_Of_Birth  , Address , Home,Work,Mobile,Email,Method_Contact ,Ethnic_Group ,Others,Home_Language ,Relationship,Partner_First_Name ,Partner_Last_Name ,Partner_DOB ,Partner_Home ,Partner_Work ,Partner_Mobile ,Child_Name1 ,Child_DOB1 ,Child_Age1 ,Child_Gender1 ,Child_Name2 ,Child_DOB2 ,Child_Age2 ,Child_Gender2 ,Child_Name3 ,Child_DOB3 ,Child_Age3 ,Child_Gender3 ,Income,Service_Card ,Expiry_Date ,Profession,Notes,Reason_Seeking ,Available_Time ,Previously_Conselling ,Utifising_Agencies ,Mental_Health ,Medications,Doctor_Name ,Fee,Counsellor_ID ) 

					

					values('$Name', '$first_name' , '$last_name' , '$title', '$gender','$dob','$address','$home','$work','$mobile','$email','$contact','$ethnic','$others','$language','$relationship','$firstname_partner','$lastname_partner','$dob_family','$home_partner','$work_partner','$mobile_partner','$childname1','$childdob1','$childage1','$childgender1','$childname2','$childdob2','$childage2','$childgender2','$childname3','$childdob3','$childage3','$childgender3','$income','$service_card','$expiry_date','$profession','$notes', '$reason' , '$time' , '$before' ,'$utifising' ,'$mentalhealth' ,'$medications' ,'$doctorname' ,'$fee' , '$ID') ";

					

					$result = mysqli_query($conn,$sql);

					if(!$result)

						echo "Cannot make an appointment!!";

					else

					{
						$to = 'xhieuprox@yahoo.com';

						$subject = 'New Appointment from User';

						
						send_mail($to, $subject, email_template("New Appoinment", array(
							"First Name:".$first_name,
							"Last Name:".$last_name,
							"Title:".$title,
							"Gender:".$gender,
							"Date Of Birth:".$dob,
							"Address:".$address,
							"Contact Information:",
							"Home:".$home,
							"Work:".$work,
							"Mobile:".$mobile,
							"Email:".$email,
							"Prefer Method of contact:".$contact,
							"Ethnic Group:".$ethnic,
							"Others".$others,
							"Home Language:".$language,
							"Relationship Status::".$relationship,
							"Family Information",
							"Partner First Name:".$firstname_partner,
							"Partner Last Name:".$lastname_partner,
							"Partner DOB:".$dob_family,
							"Contact Information Partner",
							"Home:".$home_partner,
							"Work:".$work_partner,
							"Mobile:".$mobile_partner,
							"Children/Dependants:",
							
							"Child Name 1:".$childname1,
							"Child DOB:".$childdob1,
							"Child Age".$childage1,
							"Child Gender:".$childgender1,
							
							"Child Name 2:".$childname2,
							"Child DOB:".$childdob2,
							"Child Age:".$childage2,
							"Child Gender:".$childgender2,
							
							"Child Name 3:".$childname3,
							"Child DOB:".$childdob3,
							"Child Age".$childage3,
							"Child Gender:".$childgender3,
							
							"Income Information",
							"Kind of Income:".$income,
							"Service Card Number:".$service_card,
							"Expiry Date:".$expiry_date,
							"Profession:".$profession,
							"Notes:".$notes,
							"Additional Information",
							"Reason for seeking help:".$reason,
							"Times you are available for counselling?:".$time,
							"Have you been anywhere previously for counselling?:".$before,
							"Are you currently utifising any other agencies?:".$utifising,
							"Have you any contact with a Mental Health Agency?:".$mentalhealth,
							"Are you taking any prescribed medications?:".$medications,
							"Doctor name and surgery:".$doctorname,
							"Fees: $".$fee,
						 )));
						
						echo '<div class="alert alert-success" role="alert"><strong>Your appointment is sent to Counsellor!<br>

								You can review your booking on Your Booking Page

							</strong> 

						</div>';

						echo '<div class="alert alert-info" role="alert"><strong>You will be directed to home page after 5 seconds</strong> </div>';

						header( 'refresh:5;url='.get_site_url() );

					}

				}

				

				else

				{

					echo "Cannot receive information from booking page!!";

					header( 'refresh:5;url='.get_site_url() );

				}

			

			?>

                                                

		</div>

	</div>	

</div>

<?php get_footer(); ?>