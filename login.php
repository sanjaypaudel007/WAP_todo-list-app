<?php  error_reporting(0);
include_once 'includes/header.php'; ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in </h1>
            <div class="account-wall">
              
                <form class="form-signin" action="validate-login.php" method="post">
						<input type="hidden" name="call" value="Login">
						<input type="text" class="form-control" placeholder="User Name" name="username" id="username" required autofocus>
						<input type="password" class="form-control" placeholder="Password"  name="password" id="password" required>
						<button class="btn btn-lg btn-primary btn-block" id="signin" type="submit">Sign in</button>
						<div class="msg"><?php if($_SESSION['error']){ 
						echo $_SESSION['error'];
						unset($_SESSION['error']);
						} ?></div>
					
                </form>
            </div>
			<div id="errors"></div>
            <a href="signup.php" class="text-center new-account">Create an account </a>
        </div>
    </div>


 <?php include_once 'includes/footer.php';?>      

