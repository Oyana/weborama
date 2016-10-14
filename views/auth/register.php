<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<h1 class="text-center login-title">Register to continue</h1>
			<div class="account-wall">
				<img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
						alt="">
				<form class="form-signin" method="post">
					 <input name='email' type="text" class="form-control" placeholder="Email" required autofocus>
					 <input name='password' type="password" class="form-control" placeholder="Password" required>
					 <input name='validatepassword' type="password" class="form-control" placeholder="Validate Password" required>
					 <button class="btn btn-lg btn-primary btn-block" type="submit">
						Register</button>
				</form>
			</div>
			<a href="<?php route('login') ?>" class="text-center new-account">Log In</a>
		</div>
	</div>
</div>
