<?php

# Stop Hacking attempt
define('__APP__', TRUE);

# Start session
session_start();

$MySQL = mysqli_connect("localhost","root","","goginphprojekt") or die('Error connecting to MySQL server.');

# Variables MUST BE INTEGERS
if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }

# Variables MUST BE STRINGS A-Z
if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }

if (!isset($menu)) { $menu = 1; }

function parseDate($dtm){
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $dtm);
	return $date->format('d.m.Y, H:i:s');
}
function createRssFeed($MySQL){
	
	$query ="SELECT * FROM news WHERE new_show='Yes' ORDER BY new_date DESC";
	$result = @mysqli_query($MySQL, $query);
	
	$rssfeed  = '<?xml version="1.0" encoding="utf-8"?>';
	$rssfeed .= '<rss version="2.0">';
	$rssfeed .= '<channel>';
	$rssfeed .= '<title>Surfers page</title>';
	$rssfeed .= '<link>http://localhost/Goga_projekt_pHp/index.php</link>';
	$rssfeed .= '<description>News from surfers points round the Globe</description>';
	
	while($row = @mysqli_fetch_array($result)){
		$rssfeed .= '<item>';
		$rssfeed .= '<title>'.$row['new_title'].'</title>';
		$rssfeed .= '<link>http://localhost/Goga_projekt_pHp/commands.php?command=2&amp;new_id='.$row['new_id'].'</link>';
		$rssfeed .= '<description>'.$row['new_shorttext'].'</description>';
		$rssfeed .= '<pubDate>'.$row['new_date'].'</pubDate>';
		$rssfeed .= '</item>';
	}
	$rssfeed .= '</channel>';
	$rssfeed .= '</rss>';
	
	$file = 'feed/rss.xml';
	file_put_contents($file, $rssfeed);
}

# Funkcija za brisanje svih slika koje nisu u bazi
function pictureFoldersCleanup($MySQL){
}

print '

<!DOCTYPE html>
<html lang="hr">

	<head>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Projektni zadatak HTML i CSS" />
		<meta name="keywords" content="projektni zadatak HTML i CSS,PHP" />
		<meta name="author" content="Gordana Delišimunović" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Projektni zadatak HTML i CSS - Index page</title>
	</head>


	<body>
		<header>
			<div class="banner-image"></div>
			<nav>
				<ul>
					<li><a href="index.php?menu=1">Home</a></li>
					<li><a href="index.php?menu=2">About</a></li>
					<li><a href="index.php?menu=3">News</a></li>
					<li><a href="index.php?menu=4">Gallery</a></li>
					<li><a href="index.php?menu=5">Contact</a></li>';
					
					if (isset($_SESSION['pageUser']['role']) && (
						$_SESSION['pageUser']['role'] == "Administrator" ||
						$_SESSION['pageUser']['role'] == "Editor"))
					{
						print'<li><a href="index.php?menu=11">Edit news</a></li>';
						print'<li><a href="index.php?menu=9">News administration</a></li>';
					}
					
					if (isset($_SESSION['pageUser']['role']) && 
						$_SESSION['pageUser']['role'] == "User")
					{
						print'<li><a href="index.php?menu=11">Add news</a></li>';
					}
					
					if (isset($_SESSION['pageUser']['role']) &&
						$_SESSION['pageUser']['role'] == "Administrator")
					{
						print'<li><a href="index.php?menu=10">User administration</a></li>';
					}
					
					if (isset($_SESSION['pageUser']['role']) &&
						($_SESSION['pageUser']['role'] == "Administrator" ||
						 $_SESSION['pageUser']['role'] == "Editor" ||
						 $_SESSION['pageUser']['role'] == "User"))
					{
						print '<li class="nav-right"><a href="commands.php?command=1">Log out</a></li>';
					} else {
						print '<li class="nav-right"><a href="index.php?menu=6">Log in</a></li>';
						print '<li class="nav-right"><a href="index.php?menu=7">Register</a></li>';
					}
					
					
				print '
				</ul>
			</nav>
		</header>';	
print '
		<div class="user-message">';
		if(isset($_SESSION['pageUser']['user'])) print 'User: '.$_SESSION['pageUser']['name'].' ('.$_SESSION['pageUser']['user'].')';
		print '</div>
		<main>';
		
		if (!isset($_GET['news'])) {
			if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
			else if ($_GET['menu'] == 2) { include("about.php"); }
			else if ($_GET['menu'] == 3) { include("news.php"); }
			else if ($_GET['menu'] == 4) { include("gallery.php"); }
			else if ($_GET['menu'] == 5) { include("contact.php"); }
			else if ($_GET['menu'] == 6) { include("login.php"); }
			else if ($_GET['menu'] == 7) { include("register.php"); }
			else if ($_GET['menu'] == 8) { include("registration_data.php"); }
			else if ($_GET['menu'] == 9) { include("news_administration.php"); }
			else if ($_GET['menu'] == 10) { include("user_administration.php"); }
			else if ($_GET['menu'] == 11) { include("edit_news.php"); }
			else if ($_GET['menu'] == 12) { include("show_news.php"); }
		}
		
		print '
		
			<footer>
			  <p>Copyright: &copy; Gordana Delišimunović, 2019. | Contact information: <a href="mailto:april.mood@yahoo.com">april.mood@yahoo.com</a> | Github link: 
			  <a href="https://github.com/AprillMood/PHP-surfers-page">AprillMood</a> | RSS feed: <a type="application/rss+xml" href="http://localhost/Goga_projekt_pHp/feed/rss.xml" target="_blank">
			Surfers page</a> <img src="images/RssFeed.png" style="width:10px;" alt="RSS feed" title="RSS feed for Surfers page"/>
		  </p>
			</footer> 
			
			
			
		</main>
	</body>

</html>'; 

?>