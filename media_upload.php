<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
</head>

<body>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >

  <p style="margin:0; padding:0">
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
   <input  name="file" type="file" size="50" /></p><br>
   Title: <input name="title" type="text" maxlength="15"/><br>
   Description: <input name="description" type="text" /><br>
   Category: <select name="category">
   <option value="image">Image</option>
   <option value="video">Video</option>
   <option value="audio">Audio</option>
	</select><br>

  Keywords: <br><textarea rows="5" cols="50" placeholder="Enter keywords separated by commas (,)." name="keywords"></textarea><br>

	<input value="Upload" name="submit" type="submit" />
  </p>


 </form>

</body>
</html>
