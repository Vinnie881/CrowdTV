<?
//ini_set('display_errors',0); 
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
date_default_timezone_set('America/Chicago');


$servername = "localhost";
$username = "vinnie881";
$password = "ljfva0987654FK";
$dbname = "crowdtv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



$sql = "select colorcode as c from presentation where xpixel = 29 and ypixel = 12 order by sequence";
$result = $conn->query($sql);
$rows = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }


$arrayfinal = array();

$arrayfinal['data'] = $rows;

} else {
    echo "0 results";
}

$conn->close();
//$arrayfinal['time'] = microtime(true) * 1000;
//$arrayfinal['times'] =  microtime(true) * 1000 + 8000;
$arrayfinal['count'] = count($rows);
$hour = date('H'); 
$minute = date('i');
if( $minute + 2 > 59) 
{
	$minute = 0;
	$hour = $hour + 1;
}
else
{
	$minute = (floor($minute) %2) ? ($minute + 2) : ($minute + 1);

}

$arrayfinal['times'] =round(strtotime(date("M-d-Y").' '.$hour.":".$minute) * 1000); //every ten minutes
//$arrayfinal['times'] =round(strtotime("11/1/2014 4:22PM") * 1000);

echo json_encode($arrayfinal);

/*
$i = 1;
while($i < 10000)
{

if($i % 2 == 0)
{
$sql = "INSERT INTO crowdtvcolor (crowdtv_seat_id, colorcode)
VALUES (2, 'ffffff')";
}
else
{
$sql = "INSERT INTO crowdtvcolor (crowdtv_seat_id, colorcode)

VALUES (2, '000000')";
}


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$i++;
}

*/
?>

