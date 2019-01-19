<?php 


	$message = "";
	
	
	if(isset($_POST['PublishDeleteNews'])){
		
		foreach($_POST as $name => $value) {
			$message = "News saved!";
			if(substr($name,0,3) == "new"){
				$new_id = (int)substr($name,3);
				
				if ($value=="Delete"){
					# briši news ako je odabrano "Delete"
					$query ="DELETE FROM news WHERE new_id=".$new_id;
					$result = @mysqli_query($MySQL, $query);
				} else {
					# ako je bilo što drugo odabrano, postavi tu vrijednost u role
					$query ="UPDATE news SET new_show='".$value."' WHERE new_id=".$new_id;
					$result = @mysqli_query($MySQL, $query);
				}
			}
			
			createRssFeed($MySQL);
			
		}
	}
	
	if(isset($_POST['addnews'])){
		$_SESSION['new_id'] = 0;
		header("Location: index.php?menu=11");
	}
	
	
	# ako je odabran edit, skoči na editiranje tog article-a
	foreach($_POST as $name => $value){
		if( substr($name, 0, 8) == 'editnews') {
			$aid = (int)substr($name, 8);
			$_SESSION['new_id'] = $aid;
			header("Location: index.php?menu=11");
		}
	}
	
	
	
	print '
	<center><h1>News administration</h1></center>
	
	<form action="" id="news_editor" name="news_editor" method="POST">
	
	<input type="submit" value="Add new news" name="addnews" style="width:25%">
	<br />
	
	
	<table class="adminusers">
		<tr class="header">
			<th>&nbsp;News</th>
			<th>&nbsp;Date</th>
			<th>&nbsp;Publish/Delete</th>
			<th>&nbsp;Editing</th>
		</tr>
	';
		
	$query ="SELECT * FROM news";
	$result = @mysqli_query($MySQL, $query);
	$red = 0;
	while($row = @mysqli_fetch_array($result)) {
		$red++;
		print '
		<tr class='.(($red%2==0) ? "odd" : "even").'>
				<td>&nbsp;'.$row['new_title'].'</td>
				<td>&nbsp;'.parseDate($row['new_date']).'</td>
				<td class="adminusers">
					<select class="adminusers" id="new'.$row['new_id'].'" name="new'.$row['new_id'].'">
						<option value="No"'. ($row['new_show']=="No" ? " selected" : "") .'>Hide</option>
						<option value="Yes"'. ($row['new_show']=="Yes" ? " selected" : "") .'>Show</option>';
				if ($_SESSION['pageUser']['role'] == "Administrator"){
					print '
						<option value="Delete">Delete</option>
					';
				}
		print '
					</select>
				</td>
				<td class="editnews">
					<input class="editsubmit" type="submit" value="Edit" name="editnews'.$row['new_id'].'" style="width:75%">
				</td>
		</tr>';
	}
	print '
	</table>
	<br />
	<input type="submit" value="Save edited data" name="PublishDeleteNews">
	
	</form>
	<p class="centerparagraph">'.$message.'</p>
	';
	$message = "";
?>