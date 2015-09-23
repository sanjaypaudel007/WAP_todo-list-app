<?php include_once 'includes/header.php'; ?>
<body>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">User Sign Up </h1>
            <div class="account-wall">
              
                <form class="form-signin" action="validate-login.php" method="post">
						<input type="hidden" name="call" value="Login">
						<input type="hidden" name="call" value="Insert">
						<input type="text" class="form-control" placeholder="User Name" name="username" id="username" value="<?php if($_SESSION['username']){echo $_SESSION['username']; }?>" required autofocus>
						<input type="password" class="form-control" placeholder="Password"  name="password" id="password" required>
						<input type="password" class="form-control" placeholder="Retype Password"  name="password_confirm" id="password_confirm" required>
						<input type="email" class="form-control" placeholder="Email"  name="email" id="email" value="<?php if($_SESSION['email']){echo $_SESSION['email']; }?>" required>
						<button class="btn btn-lg btn-primary btn-block" id="signup" type="submit">Sign up</button>
                </form>
            </div>
			<div id="msg">
			<?php if($_SESSION['msg']){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
			unset($_SESSION['username']);
			unset($_SESSION['email']);
			}?>
			</div>
           
        </div>
    </div>

 <?php include_once 'includes/footer.php';?>      
</body>

</html>
