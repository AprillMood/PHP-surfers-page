<?php 
	$message = "";
	if(isset($_POST['editusers'])){
		
		foreach($_POST as $name => $value) {
			$message = "User data saved!";
			if(substr($name,0,3) == "usr"){
				$userid = (int)substr($name,3);
				
				if ($value=="Removed"){
					# briši usera alp je odabrano "Delete user/Removed"
					$query ="DELETE FROM users WHERE user_id=".$userid;
					$result = @mysqli_query($MySQL, $query);
				} else {
					# ako je bilo što drugo odabrano, postavi tu vrijednost u role
					$query ="UPDATE users SET user_role='".$value."' WHERE user_id=".$userid;
					$result = @mysqli_query($MySQL, $query);
				}
			}
		}
	}

	print '
	<center><h1>User administration</h1></center>
	
	<form action="" id="user_editor" name="user_editor" method="POST">
	
	<table class="adminusers">
		<tr class="header">
			<th>&nbsp;User name</th>
			<th>&nbsp;First and last name</th>
			<th>&nbsp;E-mail address</th>
			<th>&nbsp;User role</th>
		</tr>
	';
		
	$query ="SELECT * FROM users";
	$result = @mysqli_query($MySQL, $query);
	$red = 0;
	while($row = @mysqli_fetch_array($result)) {
		$red++;
		print '
		<tr class="'.(($red%2==0) ? "odd" : "even").'">
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['user_name'].'</td>
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['user_firstname'].' '.$row['user_lastname'].'</td>
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['user_email'].'</td>
				<td class="adminusers">
					<select class="adminusers" id="usr'.$row['user_id'].'" name="usr'.$row['user_id'].'"'. ($row['user_name']==$_SESSION['pageUser']['user'] ? " disabled" : "") .'>
						<option value="PendingRole"'. ($row['user_role']=="PendingRole" ? " selected" : "") .'>PendingRole</option>
						<option value="User"'. ($row['user_role']=="User" ? " selected" : "") .'>User</option>
						<option value="Editor"'. ($row['user_role']=="Editor" ? " selected" : "") .'>Editor</option>
						<option value="Administrator"'. ($row['user_role']=="Administrator" ? " selected" : "") .'>Administrator</option>
						<option value="Removed">Delete user</option>
					</select>
				</td>
		</tr>';
	}
	print '
	</table>
	<br />
	<input type="submit" value="Save edited data" name="editusers">
	
	</form>
	<p class="centerparagraph">'.$message.'</p>
	';
	$message = "";
?>