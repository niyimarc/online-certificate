<?php
if(isset($_REQUEST['submit'])){
    include 'db/dbcon.php';
    $username=$_REQUEST['email'];
    $password=$_REQUEST['password'];
    
  
    $sql="SELECT email,reference FROM application WHERE email='$username' AND reference='$password'";
    $result= mysqli_query($conn, $sql) or die(mysqli_error());
    $rws=  mysqli_fetch_array($result);
    
    $user=$rws[0];
    $pwd=$rws[1];    
    
    if($user==$username && $pwd==$password){
        session_start();
        $_SESSION['user_certificate']=1;
        $_SESSION['certificate_id']=$username;
    header('location:index.php'); 
    }
   
else{
    header('location:view.php');  
}}
?>
<?php 
session_start();
        
if(isset($_SESSION['user_certificate'])) 
    header('location:index.php');   
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>HACK WITH DREY || CERTIFICATE</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta tag Keywords -->
	<!--/Style-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--//Style-CSS -->
</head>

<body>
	<!-- /login-section -->

	<section class="w3l-forms-23">
		<div class="forms23-block-hny">
			<div class="wrapper">
				<h1>HACK WITH DREY CHECK CERTIFICATE</h1>
								
				<div class="d-grid forms23-grids">
					<div class="form23">
						<div class="main-bg">
							<h6 class="sec-one">HWD</h6>
							<div class="speci-login first-look">
								<img src="images/user.png" alt="" class="img-responsive">
							</div>
						</div>
						<div class="bottom-content">
							<form action="" method="post">
								<input type="email" name="email" class="input-form" placeholder="Your Email"
										required="required" />
								<input type="password" name="password" class="input-form"
										placeholder="Your Password" required="required" />
								<button type="submit" value="submit" name="submit" class="loginhny-btn btn">Check Certificate</button>
							</form>
							
						</div>
					</div>
				</div>
				<div class="w3l-copy-right text-center">
					<p>© 2020 <a href="drey.org.ng/"> Hack With Drey.</a> All Rights Reserved</p>
				</div>
			</div>
		</div>
	</section>
	<!-- //login-section -->
</body>

</html>