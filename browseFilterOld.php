<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function saveDownload(id)
{
	$.post("media_download_process.php",
	{
       id: id,
	},
	function(message)
    { }
 	);
}
</script>
</head>

<body>

<div class="topnav">
  <a class="active" href="browse.php">MeTube</a>
	<table align="right">
  <form action="browseFilter.php" method="post">
      <td><input type="text" placeholder="Search.." name="searchwords"></td>
			<td><input type="submit" value="Search" name="search"></td>
</form>
</table>
  <?php
	if (! empty($_SESSION['logged_in']))
	{
  		echo "<a href='logout.php'>Logout</a>
  		<a href='update.php'>Profile</a>";
	}
	else {
		echo"<a href='index.php'>Login</a>";
		echo"<a href='registration.php'>Register</a>";
	}

	if(isset($_POST['search'])){

	}

  ?>
</div>

<h1>Search Results For: <?php $sw = $_POST['searchwords']; echo " '$sw'" ?></h1>
<br/><br/>

<?php
  $srch = $_POST['searchwords'];
  	if(isset($_POST['type'])) {
		$type = $_POST['type'];
		if($type == 'all'){
			$query = "SELECT DISTINCT media.mediaid, media.filename, media.filepath, media.type, media.lastaccesstime, media.title, media.description, media.category, media.user FROM media LEFT JOIN keywords ON media.mediaid = keywords.mediaid WHERE media.title LIKE '%$srch%' OR media.description LIKE '%$srch%' OR keywords.keyword LIKE '%$srch%' OR media.user LIKE '%$srch%'";
		}
		else if($type == 'images') {
			$query = "SELECT * from media WHERE category='image' AND title LIKE '%$srch%' OR description LIKE '%$srch%'";
		}
		else if($type == 'videos'){
			$query = "SELECT * from media WHERE category='video' AND title LIKE '%$srch%'";
		}
		else if($type == 'audio'){
			$query = "SELECT * from media WHERE category='audio' AND title LIKE '%$srch%'";
		}
		else{
			$query = "SELECT DISTINCT media.mediaid, media.filename, media.filepath, media.type, media.lastaccesstime, media.title, media.description, media.category, media.user FROM media LEFT JOIN keywords ON media.mediaid = keywords.mediaid WHERE media.title LIKE '%$srch%' OR media.description LIKE '%$srch%' OR keywords.keyword LIKE '%$srch%' OR media.user LIKE '%$srch%'";
		}
	}
	else {
		$query = "SELECT DISTINCT media.mediaid, media.filename, media.filepath, media.type, media.lastaccesstime, media.title, media.description, media.category, media.user FROM media LEFT JOIN keywords ON media.mediaid = keywords.mediaid WHERE media.title LIKE '%$srch%' OR media.description LIKE '%$srch%' OR keywords.keyword LIKE '%$srch%' OR media.user LIKE '%$srch%'";
	}

	$result = mysqli_query($con, $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysqli_error($con));
	}
?>

    <br/>
    <div class="all_media">
		<?php
			while ($result_row = mysqli_fetch_row($result))
			{

		?>

		<div class="media_box">
			<?php
				$filename=$result_row[1];
				$filepath=$result_row[2];
				$type=$result_row[3];
				if(substr($type,0,5)=="image") //view image
				{
					echo "<img src='".$filepath.$filename."' height=200 width=300/>";
				}
				else //view movie
				{
			?>
		    <object id="MediaPlayer" width=300 height=200 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

			<param name="filename" value="<?php echo $result_row[2].$result_row[1];  ?>">
			<param name="Showcontrols" value="True">
			<param name="autoStart" value="True">

			<embed type="application/x-mplayer2" src="<?php echo $result_row[2].$result_row[1];  ?>" name="MediaPlayer" width=320 height=200></embed>

			</object>
			<?php } ?>
			<h4><a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[5];?></a></h4>
			<a href="<?php echo $result_row[2].$result_row[1];?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[0];?>);">Download</a>
		</div>
		<?php
		}
	?>
	</div>
</body>
</html>
