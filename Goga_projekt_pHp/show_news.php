<?php 

$new_id = 0;
if (isset($_SESSION['new_id'])) {
	$new_id = (int)$_SESSION['new_id'];
}

$query ="SELECT * FROM news WHERE new_id=".$new_id;
$resultNew = @mysqli_query($MySQL, $query);

$rowNew = @mysqli_fetch_array($resultNew);

print '
	<h1>'.$rowNew["new_title"].'</h1>';
	
print '
		<img class="news-gallery" src="images/News/'.$rowNew["new_image"].'" alt="'.$rowNew["new_imagetext"].'" title="'.$rowNew["new_imagetext"].'"/>';

print '
	<div class="news">';

	print '
		<p>'.nl2br($rowNew["new_text"]).'</p>';
		
print '
		<p><time datetime="'.$rowNew["new_date"].'">'.$rowNew["new_date"].'</time></p>
		<p><a href="index.php?menu=3">&lt;&lt; Back to News page &lt;&lt;</a></p>
	</div>
';
?>