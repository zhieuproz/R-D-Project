<!-- this page is to view detail a counsellor who is the most suitable for users -->
<!-- this page is the separated page and using same template of the website : Enigma -->

<?php /*Template Name: Booking Counsellor*/ ?>
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
						echo "Booking Counsellor";
					?>
                
                </h1>
					
                <?php
					echo '<a style="font-size:18px;" href="'; ?> <?php echo site_url(); ?> <?php echo '"> Home </a>'. ' / '. " Booking Counsellor";			
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
				if(isset($_POST['ID']))
				{
					$Counsellor_ID = $_POST['ID'];
					
					$first_name = um_user('first_name'); //get user information to assign to booking form
					$last_name = um_user('last_name');
					$gender = um_user('gender');
					$address = um_user('user_address');
					$phone_number = um_user('phone_number');
					$birth_day = um_user('birth_date');
					$email = um_user('user_email');
					
					
					include("Database/ConnectDatabase.php");
					
                  echo '<form method="post" class="form-Inline" id="BookingForm" name="BookingForm" action="'.get_site_url().'/confirmation">';
					
                 		echo'<label style="text-align:right; font-size: 2em; color:steelblue;">Application and Intake Form</label><br><br>';
						
							echo'<label style="text-align:right; font-size: 1.5em; text-decoration: underline;">Section A - Personal and Contact Details</label>';
				
						echo'<div class="row"> <!-- Personal Name-->
							<div class="form-group col-xs-6">
								<label for="firstname">First Name: </label>
								<input value="'.$first_name.'" name="firstname" id="firstname"  type="text" class="form-control">
							</div>

							<div class="form-group col-xs-6">
								<label for="last_name">Last Name:</label>
								<input value="'.$last_name.'"  name="last_name" id="last_name" type="text" class="form-control">
							</div>
						</div> <!-- End Personal Name-->


						<div class="row"> <!-- Title + Gender -->
							<div class="form-group col-xs-6">
								<label for="title">Title(please stick): </label>
									<label class="radio-inline"><input type="radio" value="Mr" name="title">Mr</label>
									<label class="radio-inline"><input type="radio" value="Mrs" name="title">Mrs</label>
									<label class="radio-inline"><input type="radio" value="Miss" name="title">Miss</label>
									<label class="radio-inline"><input type="radio" value="Ms"  name="title">Ms</label>
									<label class="radio-inline"><input type="radio" value="Others" name="title">Others</label>
							</div>		

							<div class="form-group col-xs-6">
								<label for="gender">Gender: </label>
								<input value="'.$gender.'" name="gender" id="gender"  type="text" class="form-control">
							</div>

						</div>	 <!-- End Title + Gender -->	


							<div class="row"> <!-- DOB + Address -->
								<div class="form-group col-xs-6">
									<label for="dob">Date of Birth:</label>
										<input value="'.$birth_day.'" type="text" class="form-control docs-date" name="dob" placeholder="Pick a date">
								</div>


								<div class="form-group col-xs-12">
									<label for="address">Address:</label>
										<input value="'.$address.'"   name="address"  id="address" type="text" class="form-control">
								</div>
							</div>	<!-- End DOB + Address -->


						<label><h3>Contact Information: </h3></label><br>	<!-- Contact Information -->
							<div class="form-group col-xs-6">
									<label for="home" >Home:  </label>
									<input  name="home" id="home" type="text" class="form-control">
							</div>

							<div class="form-group col-xs-6">
									<label for="work">Work:  </label>
									<input  name="work" id="work" type="text" class="form-control">
							</div>			

							<div class="form-group col-xs-6">	
									<label for="mobile">Mobile: </label>
									<input value="'.$phone_number.'"   name="mobile" id="mobile" type="text" class="form-control">
							</div>

							<div class="form-group col-xs-6">	
									<label for="email">Email:  </label>
									<input value="'.$email.'"   name="email" id="email" type="text" class="form-control">
							</div> 


						<div class="form-group col-xs-12">
							<label for="contact">Perferred method of contact(please stick): </label>
								<label class="radio-inline"><input type="radio" value="text" name="contact">Text</label>
								<label class="radio-inline"><input type="radio" value="Home" name="contact">Home Phone</label>
								<label class="radio-inline"><input type="radio" value="Post" name="contact">Post</label>
								<label class="radio-inline"><input type="radio" value="Mobile" name="contact">Mobile</label>
								<label class="radio-inline"><input type="radio" value="Email" name="contact">Email</label>
						</div>	


						<div class="form-group col-xs-12">
							<label for="ethnic_group"><h3>Ethnic Group: </h3></label>
							<label class="radio-inline"><input type="radio" value="european" name="ethnic_group">Nz European</label>
							<label class="radio-inline"><input type="radio" value="Maori" name="ethnic_group" >Maori(Iwi)</label>
							<label class="radio-inline"><input type="radio" value="Pacific" name="ethnic_group">Pacific Island</label>
							<label class="radio-inline"><input type="radio" value="Asian" name="ethnic_group">Asian</label><br>
							<label for="others">Others: </label>  <input id="others" name="others" type="text" class="form-control"/><br>
							<label for="language">Home Language: </label>  <input id="language" name="language" type="text" class="form-control"/>
						</div>


						<div class="form-group col-xs-12">					
							<label for="Relationship">Relationship status(please stick) : </label>
								<label class="radio-inline"><input type="radio" value="single" name="Relationship">Single</label>
								<label class="radio-inline"><input type="radio" value="Married" name="Relationship">Married</label>
								<label class="radio-inline"><input type="radio" value="Facto" name="Relationship">De Facto</label>
								<label class="radio-inline"><input type="radio" value="Separated" name="Relationship">Separated/Divorced</label>
								<label class="radio-inline"><input type="radio" value="Widowed" name="Relationship">Widowed</label>

						</div><br> <!-- End Contact Information -->


						<label style="text-align:right; font-size: 1.5em; text-decoration: underline;">Section B : Family Information</label>

							<div class="row"> <!-- Partner Name-->
								<div class="form-group col-xs-6">
									<label for="firstname_partner">Partners First Name: </label>
									<input name="firstname_partner" id="firstname_partner"  type="text" class="form-control">
								</div>


								<div class="form-group col-xs-6">
									<label for="last_name_partner">Partners Last Name:</label>
									<input  name="last_name_partner" id="last_name_partner" type="text" class="form-control">
								</div>

							</div>  <!-- End Partner Name-->


							<div class="row"> <!-- DOB Partner-->
								<div class="form-group col-xs-6">
									<label for="dob_family">Date of Birth:</label>
										<input type="text" class="form-control docs-date" name="dob_family" placeholder="Pick a date">
								</div>
							</div><!-- End DOB Partner-->



							<label><h3>Contact Information: </h3></label><br>	<!-- Contact information Partner-->
								<div class="form-group col-xs-12">
										<label for="home_partner" >Home:  </label>
										<input  name="home_partner" id="home_partner" type="text" class="form-control">
								</div>

								<div class="form-group col-xs-12">
										<label for="work_partner">Work:  </label>
										<input  name="work_partner" id="work_partner" type="text" class="form-control">
								</div>			

								<div class="form-group col-xs-12">	
										<label for="mobile_partner">Mobile: </label>
										<input  name="mobile_partner" id="mobile_partner" type="text" class="form-control">
								</div> <!-- End Contact information Partner-->


							<label><h3>Children/Dependants: </h3></label><br>	

							<table class="table table-hover">
								<tr>
									<td><b>Child Name</b></td>
									<td><b>Date of Birth</b></td>
									<td><b>Age</b></td>
									<td><b>Gender</b></td>
								</tr>

								<tr>
									<td><input  name="1stchildname" id="1stchildname" type="text" class="form-control"></td>
									<td><input  name="1stchildob" id="1stchildob" type="text" class="form-control"></td>
									<td><input  name="1stchildage" id="1stchildage" type="text" class="form-control"></td>

									<td>
										<label class="radio-inline"><input value="male" type="radio" name="genderchild">Male</label>
										<label class="radio-inline"><input vale="female" type="radio" name="genderchild">Female</label>
									</td>
								</tr>

								<tr>
									<td><input  name="2ndchildname" id="2ndchildname" type="text" class="form-control"></td>
									<td><input  name="2ndchilddob" id="2ndchilddob" type="text" class="form-control"></td>
									<td><input  name="2ndchildage" id="2ndchildage" type="text" class="form-control"></td>

									<td>
										<label class="radio-inline"><input type="radio" value="male" name="genderchild2">Male</label>
										<label class="radio-inline"><input type="radio" value="female" name="genderchild2">Female</label>
									</td>
								</tr>

								<tr>
									<td><input  name="3rdchildname" id="3rdchildname" type="text" class="form-control"></td>
									<td><input  name="3rdchildob" id="3rdchildob" type="text" class="form-control"></td>
									<td><input  name="3rdchildage" id="3rdchildage" type="text" class="form-control"></td>

									<td>
										<label class="radio-inline"><input type="radio" value="male" name="genderchild3">Male</label>
										<label class="radio-inline"><input type="radio" value="female" name="genderchild3">Female</label>
									</td>
								</tr>

							</table><br>

							<label style="text-align:right; font-size: 1.5em; text-decoration: underline;">Section C : Income Information</label><br>


							<div class="form-group col-xs-12">					
								<label for="income">Income: </label>
									<label class="radio-inline"><input type="radio" value="wages" name="income">Wages</label>
									<label class="radio-inline"><input type="radio" value="Self" name="income">Self-Employed</label>
									<label class="radio-inline"><input type="radio" value="Benefit" name="income">Benefit</label>
							</div>


								<div class="form-group col-xs-12">
										<label for="cardnumber" >Community Services Card No:  </label>
										<input  name="cardnumber" id="cardnumber" type="text" class="form-control">
								</div>

								<div class="form-group col-xs-12">
										<label for="expiry">Expiry Date:  </label>
										<input type="text" class="form-control docs-date" name="expiry" placeholder="Pick a date">
								</div>			

								<div class="form-group col-xs-12">	
										<label for="profession">Profession: </label>
										<input  name="profession" id="profession" type="text" class="form-control">
								</div>

								<div class="form-group col-xs-12">	
										<label for="notes">Notes: </label>
										<textarea name="notes" class="form-control" rows="5" id="notes"></textarea>
								</div>

							<label style="text-align:right; font-size: 1.5em; text-decoration: underline;">Section D : Additional Information</label>

							<div class="row">
								<div class="form-group col-xs-6">
									<label for="reason">Reasons for seeking help?</label>
										<input  name="reason"  id="reason" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="time">Times you are available for counselling?</label>
										<input  name="time"  id="time" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="before">Have you been anywhere previously for counselling?</label>
										<input  name="before"  id="before" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="utifising">Are you currently utifising any other agencies?</label>
										<input  name="utifising"  id="utifising" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="mentalhealth">Have you any contact with a Mental Health Agency?</label>
										<input  name="mentalhealth"  id="mentalhealth" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="medications">Are you taking any prescribed medications?</label>
										<input  name="medications"  id="medications" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="doctorname">Doctor name and surgery:</label>
										<input  name="doctorname"  id="doctorname" type="text" class="form-control">
								</div>
							</div>	

							<div class="row">	
								<div class="form-group col-xs-6">
									<label for="fee">Fees: $</label>
										<input  name="fee"  id="fee" type="text" class="form-control">
								</div>
							</div>



				<strong><p> Cancellation Policy: </p></strong>

				<strong><p> Due to the fact that the appointments are 1 hour duration and reserved excluslvely for the client. It is expected that unless 24 hours notice is given, in advance, for any cancellations, missed or rescheduling of appointments, full payment of fees is required.(This is common practice in counselling practice.)</p></strong>

				<strong><p> Confidentiality Disclosure: </p></strong>
				<ul>
					<li><p><strong> Collection of information: </strong> Counselling is provided by a Counsellor whose practices are governed by the code of ethics of the professional organisation they belong. The information they collect will enable them to keep records of session notes, goal plans, and any other correspondence.</p></li>
					<li><p><strong> Use of information:  </strong> This information is kept soley for the purpose of counselling. This information will be treated as confidential.</p></li>
					<li><p><strong> Access to information: </strong>Records will be kept in a secure client database or/and in lockable drawers in the premises and access to this information will be restricted to your counsellor. You may request access to personal information that is held about you. you may also requrest us to correct any error or delete any information that is held about you. Your Rainbow insight Counsellor will not disclose any personal information to any other party without your consent unless there is a sercious risk of safety to yourself or others.<br/>
					 Information discussed in counselling sessions is confidential between the counsellor and the client unless the clent signs a form giving permission for the counsellor to share the information. In the event that the counsellor judges, in their personal opinion, the client or someone else to be at a serious risk of harm, they are ethically required to consult the appropnate people to ensure safety.</p></li>
				</ul>

						<div class="form-group col-xs-12" align="right">
							<input value="agree"  name="agree" id="agree" type="checkbox" > <label for="agree"><strong> I agree with the policy above.</strong></label>
						</div>

					</div >
							<input name="counsellor_id" type="hidden" value="'.$Counsellor_ID.'" class="btn btn-default"  />
						<div class="form-group col-xs-12" align="right">
							<input type="submit" value="submit" class="btn btn-default" onclick="return Check_Booking();" />
						</div>';
		                                   

                echo'</form>';
					
				}
				
				else
				{
					echo 'Having a temrorarily issue in system';
				}
			?>
           
		</div>
	</div>	
</div>
<?php get_footer(); ?>