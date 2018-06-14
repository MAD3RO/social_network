<div id="content" class="container">
				<div>
					<img class="img" src="images/image.jpg"/>
				</div>
			<div id="form2" class="row main">
					<div class="panel-heading">
		               <div class="panel-title text-center">
		               		<h1 class="title">Sign Up Here!</h1>
		               	</div>
	           	 	</div>

				<div class="main-login main-center" id="form2">
					<form class="form-horizontal" method="post" action="">
						
						<div class="form-group">
							<label class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="u_name"  placeholder="Enter your Name" required="required" />
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="u_email"  placeholder="Enter your Email" required="required"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="u_pass" placeholder="Enter your Password" required="required"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="c_pass"  placeholder="Confirm your Password" required="required"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Country</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<select name="u_country" required="required">
									<option value="" id="opcija">Select a Country</option>
									<option>Afganistan</option>
									<option>Belgia</option>
									<option>Croatia</option>
									<option>Denmark</option>
									<option>England</option>
								</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Gender</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<select name="u_gender" required="required">
									<option value="" id="opcija">Select a Gender</option>
									<option>Male</option>
									<option>Female</option>
								</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="cols-sm-2 control-label">Birthday</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar fa-md" aria-hidden="true"></i></span>
									<input type="date" class="form-control" name="u_birthday" required="required"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button class="btn btn-primary btn-lg btn-block login-button" name="sign_up">Sign Up</button>
						</div>
					</form>
						<?php 
							include("user_insert.php");
						?>
				</div>
			</div>
</div>


			