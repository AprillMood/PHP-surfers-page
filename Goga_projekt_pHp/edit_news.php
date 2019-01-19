<?php 

$news_id = 0;
if (isset($_SESSION['new_id'])) {
	$news_id = (int)$_SESSION['new_id'];
}


$newsUpdate = true;
$message = "";

if ($news_id == 0) {
	$query ="SELECT new_id FROM news ORDER BY new_id DESC LIMIT 1";
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$news_id = $row["new_id"]+1;
	$newsUpdate = false;
}

function fileNameCheckInFolder($filename) {
    $fn = $filename;
	$fp = substr($fn, 0, (strrpos($fn, ".")) );
	$fe = strtolower(substr($fn, (strrpos($fn, ".")) ));
	
	if ( $fe != '.jpg' && $fe != '.jpeg' && $fe != '.png' && $fe != '.gif' ) {
		$fn = "-";
	} else {
		$ind = 0;
		while ( file_exists($fn) ){
			$ind++;
			$fn = $fp."_".$ind.$fe;
		}
	}
	return $fn;
}  

function newsDbQuery($new, $upd){
	$q = "";
	if ($upd == true){
		$q = "UPDATE news SET new_title='".$new['new_title']."', new_shorttext='".$new['new_shorttext'];
		$q .= "', new_text='".$new['new_text'];
		$q .= "', new_date='".$new['new_date']."', new_show='".$new['new_show']."', new_image='".$new['new_image'];
		$q .= "', new_imagetext='".$new['new_imagetext']."' WHERE new_id=".$new['new_id'];
	} else {
		$q = "INSERT INTO news (new_id, new_title, new_shorttext, new_text, new_date, new_show, new_image, new_imagetext)";
		$q .= " VALUES (".$new['new_id'].", '".$new['new_title']."', '".$new['new_shorttext']."', '".$new['new_text']."',  '";
		$q .= $new['new_date']."', '".$new['new_show']."', '".$new['new_image']."', '".$new['new_imagetext']."')";
	}
	return $q;
}


if(isset($_POST['editNews'])){
	
	# ARTICLES UPLOAD PIC AND UPDATE DATABASE
	
		$dbNews = array();
		
		# slika od news za upload
		$target_dir = "images/News/";
		$target_file = $target_dir . basename($_FILES["picfile"]["name"]);
		
		#print $target_file."<hr />";
		$uploadNewFilename = fileNameCheckInFolder($target_file);
		#print "upload: ".$uploadNewFilename."<br>";
		
		# uploadaj sliku ako je postavljena nova
		if ($uploadNewFilename == "-"){
			$dbNewPicfilename = $_POST["newpicfilenamehidden"];
		} else {
			$dbNewPicfilename = substr($uploadNewFilename, (strrpos($uploadNewFilename, "/"))+1 );
			copy($_FILES['picfile']['tmp_name'], $uploadNewFilename);
		}
		
		$dbNews["new_id"] = $news_id;
		$dbNews["new_shorttext"] = $_POST["new_shorttext"];
		$dbNews["new_text"] = $_POST["new_text"];
		$dbNews["new_title"] = $_POST["new_title"];
		$dbNews["new_image"] = $dbNewPicfilename;
		$dbNews["new_imagetext"] = $_POST["new_imagetext"];
		$dbNews["new_date"] = date('Y-m-d H:i:s');
		$dbNews["new_show"] = "No";
		#print "Za News:<br>";
		$query = newsDbQuery($dbNews, $newsUpdate);
		# ovdje šalji query za news
		$result = @mysqli_query($MySQL, $query);
		#print $query."<br>";
	
		
		# PICTURES UPLOAD PICS AND UPDATE DATABASE
		
		$indx = 1;
		while ( isset($_POST["picfilenamehidden".$indx] )){
			
			# slika od news za upload
			$target_dir = "images/News/";
			$target_file = $target_dir . basename($_FILES["picfile".$indx]["name"]);
			#print $target_file."<br />";
			$uploadNewFilename = fileNameCheckInFolder($target_file);
			#print "upload: ".$uploadNewFilename."<br>";
			
			# uploadaj sliku ako je postavljena nova
			if ($uploadNewFilename == "-"){
				$dbNewPicfilename = $_POST["picfilenamehidden".$indx];
			} else {
				$dbNewPicfilename = substr($uploadNewFilename, (strrpos($uploadNewFilename, "/"))+1 );
				copy($_FILES['picfile'.$indx]['tmp_name'], $uploadNewFilename);
			}
			$indx++;
		}
		$message = "Data successfully saved!";
}


$query ="SELECT * FROM news WHERE new_id=".$news_id;
$resultNew = @mysqli_query($MySQL, $query);

$rowNew = @mysqli_fetch_array($resultNew);
$newName = $rowNew["new_title"];
$newText = $rowNew["new_text"];
$newShortdisplay = $rowNew["new_shorttext"];
$newPicfilename = $rowNew["new_image"];
$newPictext = $rowNew["new_imagetext"];
$newNewsdate = $rowNew["new_date"];
$newDisplayed = "No";

print '
	<center><h1>Edit news</h1></center>
	
	<div id="newsediting">
		<form action="" id="contact_form" name="contact_form" method="POST" enctype="multipart/form-data">';
		
		if ($message) {
			print '<p class="centerparagraph">'.$message.'</p>';
			$message = "";
		}
		print '
			<hr />
			
			<label for="new_title">News name *</label>
			<input type="text" id="new_title" name="new_title" placeholder="Enter name of news" required value="'.$newName.'">
			
			<label for="new_shorttext">Short display of an news *</label>
			<textarea id="new_shorttext" name="new_shorttext" placeholder="Write news short display..." style="height:100px" required="required">'.$newShortdisplay.'</textarea>
			
			<p class="centerparagraph">News picture: "'.$newPicfilename.'"</p>
			
			<img alt="'.$newPictext.'" style="width:10%; border:3px solid #29497c;" src="';
			
			if (!$newPicfilename) { print 'images/no_image.jpg'; }
							 else { print 'images/News/'.$newPicfilename; }
			
			print '">
			
			<input type="file" id="picfile" name="picfile" class="editsubmit"';
			
			if (!$newPicfilename) { print ' required'; }
			
			print '>
			
			<br />
			<label for="new_imagetext">News picture text *</label>
			<input type="text" id="new_imagetext" name="new_imagetext" placeholder="Enter text for picture" value="'.$newPictext.'" required>
			
			<input type="text" id="newpicfilenamehidden" name="newpicfilenamehidden" value="'.$newPicfilename.'" hidden="true">
			
			<br /><br />
			
			<label for="newstext">News text *</label>
			<textarea id="new_text" name="new_text" placeholder="Write news text..." style="height:250px" required="required">'.$newText.'</textarea>
			
			<hr />
			
			<input type="submit" name="editNews" value="Submit all news data" style="width:50%">';
			
			
			print '
			
		</form>
	</div>
';



?>