<?PHP
ini_set('display_errors',0); 
ini_set('max_execution_time', 0);
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
date_default_timezone_set('America/Chicago');
?>
<html>
<style>
div { 
display: inline-block;
  position: relative;
height:2px;

}
</style>
<body>

<?

$venuename = 'Test Venue 1';
$venuenotes = 'This is my first test venue';
$venuerows = 25;
$venuecolumns = 50;
$videoname = 'testvideo';
$fps = 30;


$servername = "localhost";
$username = "vinnie881";
$password = "ljfva0987654FK";
$dbname = "crowdtv";
$video_id = 0;
$venue_id = 0;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 





$sql = "select * from video where videoname = '$videoname'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	 $video_id = $row['video_id'];
    }

}
else
{

 $sql = "insert into video(videoname,fps)
	values('$videoname',$fps);";

$result = $conn->query($sql);

$sql = "select * from video where videoname = '$videoname'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	 $video_id = $row['video_id'];
    }

}
else
{
echo 'THERE WAS AN ERROR THE IMPORT DID NOT WORK for Video';
exit;
}

}









$sql = "select * from venue where venuename = '$venuename'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

	  while($row = $result->fetch_assoc()) {
			 $venue_id = $row['venue_id'];
		    }

	}	
else
{

	$sql = "insert into venue(venuename,venuenotes,venuerows,venuecolumns)
	values('$venuename','$venuenotes',$venuerows,$venuecolumns);";

	$result = $conn->query($sql);

	$sql = "select * from venue where venuename = '$venuename';";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		 $venue_id = $row['venue_id'];
	    }

	}
	else
	{
		echo 'THERE WAS AN ERROR THE IMPORT DID NOT WORK for Venue';
		exit;
	}

}








function right($str, $length) {
     return substr($str, -$length);
}


function hexcolor($c) {
        $r = ($c >> 16) & 0xFF;
        $g = ($c >> 8) & 0xFF;
        $b = $c & 0xFF;
        return str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }



$counter = '00000';
$mysequence = 1;
$lastframe = 322;

for($mysequence=1;$mysequence <= $lastframe;$mysequence++)
{
$image = 'videotest/Sequence 01'.right($counter.$mysequence,3).'.jpg';

$size = getimagesize($image);
//print_r($size);

$i = 0;
$im = imagecreatefromjpeg($image);

		$sql = "insert into presentation(xpixel,ypixel,sequence,video_id,venue_id,colorcode)
			values";

for($i =0; $i<$size[1];$i++)
{

	for($z=0; $z <$size[0];$z++)
	{
		$rgb = imagecolorat($im,$z , $i);
		$hex = hexcolor($rgb);		



		$sql1 = $sql1."($z,$i,$mysequence,$video_id,$venue_id,'$hex'),";

		//echo '<div style="background:#'.$hex.'">&nbsp;</div>';
	}

//	echo '<br/>';

}
	$sql1 = rtrim($sql1, ",");
	$result = $conn->query($sql.$sql1);
	$sql1 = "";

	echo $mysequence;
	echo '<br/>';
if($mysequence==100)
{
//	exit;
}

}

$conn->close();
?>
</body>
</html>