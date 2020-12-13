<?php 
include 'config.php';

$url =  $_SERVER['PHP_SELF'];	
$url = explode("/", $url);

if(isset($url[3]))
$service = $url[3];

if(isset($url[4]))
$method = $url[4];

$data = file_get_contents('php://input');

 switch($service)
 {

	case "user":
	user($method,$mysqli,$data);
	break;

	default :
	echo "Don't do this";
	break;
}

function user($method, $mysqli, $data)
{
	
	$data = json_decode($data,true);
	// echo $data;
	if($method=="login")
	{
		
		$username = $_POST['usrname'];
		$password = $_POST['password'];
		$loginResponse = array();
		$stmt=$mysqli->prepare('SELECT * FROM login where username = ? AND password = ?');
		$stmt->bind_param('ss', $username,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows === 1)
		{
			$user_details = mysqli_fetch_all ($result, MYSQLI_ASSOC);
			json_encode($user_details);
			$loginResponse = array('success' => 'true');
			// echo json_encode($user_details);
			echo "<button style='background:#f09d51; cursor:pointer'><a href='/house-decor/buy.html'>Buy now!</a></button>";				
		}else
		{	
			$loginResponse = array('success' => 'false');
			echo json_encode($loginResponse);
		}
		

	}

	if($method=="register")
	{
		$username = $_POST['usrname'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$pincode = $_POST['pincode'];
		
		
		$password_hash = password_hash($password,PASSWORD_DEFAULT);
		
		$stmt = $mysqli->prepare('INSERT INTO login(username,password,email_id,address,pincode) values (?, ?, ?, ?, ?)');
				$stmt->bind_param('sssss', $username, $password, $email, $address, $pincode);
				$result = $stmt->execute();
				
				if($result)
					echo $result;
				else
				{
					echo "Uh...Oh! There is ";
				}
	}
}



?>

