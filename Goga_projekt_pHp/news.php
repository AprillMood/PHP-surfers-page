<?php 

print '
	<h1>News list</h1>
	<div class="news">';

$query ="SELECT * FROM news";
$result = @mysqli_query($MySQL, $query);
while($row = @mysqli_fetch_array($result)) {
	
	if ($row['new_show'] == "Yes"){
		print '
		<a href="commands.php?command=2&new_id='.$row['new_id'].'"><img src="images/News/'.$row['new_image'].'" alt="'.$row['new_image'].'" title="'.$row['new_image'].'"></a>
		<a href="commands.php?command=2&new_id='.$row['new_id'].'"><h2>'.$row['new_title'].'</h2></a>
		<p>'.nl2br($row['new_shorttext']).' <a href="commands.php?command=2&new_id='.$row['new_id'].'">More ...</a></p>
		<p><time datetime="'.parseDate($row['new_date']).'">Date of article: '.parseDate($row['new_date']).'</time></p>
		<hr />
	';
	}
}
print '
	</div>
';
?>