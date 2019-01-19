<?php 
	
	$fillUsername = (!isset($_POST['loginusername']) ? "" : $_POST['loginusername']);
	$fillPassword = (!isset($_POST['loginpassword']) ? "" : $_POST['loginpassword']);
	
	print '
	
	<form action="index.php?menu=6" id="login_form" name="login_form" method="POST">
		<center><h1>Login form</h1></center>
		
		<div id="loginform">
			Enter user name and password:
			<hr/>
			<label for="loginusername">User name *</label>
			<input type="text" id="loginusername" name="loginusername" placeholder="Enter your user name" required value="'.$fillUsername.'">
			
			<label for="loginpassword">Enter password *</label>
			<input type="password" id="loginpassword" name="loginpassword" placeholder="Enter password" required value="'.$fillPassword.'">
			
			<input type="submit" name="loginEntered" value="Login">
		</form>
	</div>';
	
	if(isset($_POST['loginEntered'])){
		$query ="SELECT * FROM users WHERE user_name='".strtolower($fillUsername)."'";
		
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		
		if(!password_verify($fillPassword, $row['user_psw'])){
			print '<p class="loginerror">Username or password did not match!</p>';
		} else {
			# postavi u session usera
			$_SESSION['pageUser']['name'] = $row['user_firstname']." ".$row['user_lastname'];
			$_SESSION['pageUser']['user'] = $row['user_username'];
			$_SESSION['pageUser']['role'] = $row['user_role'];
			header("Location: index.php?menu=1");
		}
	}

	
?>