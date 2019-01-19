<?php 
	
	# get user data from session
	$fillUsername = (!isset($_SESSION['fillUsername']) ? "-" : $_SESSION['fillUsername']);
	$fillPassword = (!isset($_SESSION['fillPassword']) ? "-" : $_SESSION['fillPassword']);
	$fillFirstname = (!isset($_SESSION['fillFirstname']) ? "-" : $_SESSION['fillFirstname']);
	$fillLastname = (!isset($_SESSION['fillLastname']) ? "-" : $_SESSION['fillLastname']);
	$fillEmail = (!isset($_SESSION['fillEmail']) ? "-" : $_SESSION['fillEmail']);
	$fillCountry = (!isset($_SESSION['fillCountry']) ? "-" : $_SESSION['fillCountry']);
	# get country name from database
	$query ="SELECT country_name FROM countries WHERE country_code='".$fillCountry."'";
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$fillCountry = $row['country_name'];
	
	print '
		<center><h1>Registration information</h1>
		<hr />
		<p class="centerparagraph">User <b>'.$fillUsername.'</b> is successfully registrated on our site with following data:</p>
		<hr />
		<table>
			<tr>
				<td class="label">Username:</td>
				<td class="value">'.$fillUsername.'</td>
			</tr>
			<tr>
				<td class="label">Password:</td>
				<td class="value">'.$fillPassword.'</td>
			</tr>
			<tr>
				<td class="label">First name:</td>
				<td class="value">'.$fillFirstname.'</td>
			</tr>
			<tr>
				<td class="label">Last name:</td>
				<td class="value">'.$fillLastname.'</td>
			</tr>
			<tr>
				<td class="label">E-mail:</td>
				<td class="value">'.$fillEmail.'</td>
			</tr>
			<tr>
				<td class="label">Country:</td>
				<td class="value">'.($fillCountry=="" ? "-" : $fillCountry).'</td>
			</tr>
		</table>
		<hr />
		<p class="centerparagraph">You are welcome to log in with your SuperSurf Name.</p></center>';
	
	# clear session data for this page after display
	unset($_SESSION['fillUsername']);
	unset($_SESSION['fillPassword']);
	unset($_SESSION['fillFirstname']);
	unset($_SESSION['fillLastname']);
	unset($_SESSION['fillEmail']);
	unset($_SESSION['fillCountry']);
	
?>