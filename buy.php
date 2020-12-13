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

	if($method=="buy")
	{
		$username = "temp";
		$password = "temp";
		$email = $_POST['email'];
		$address = $_POST['address'];
		$pincode = $_POST['pincode'];
		// $stmt = $mysqli->prepare('INSERT INTO login(email_id,address,pincode) values (?, ?, ?)');
        //             $stmt->bind_param('sss', $email, $address, $pincode);
		$stmt=$mysqli->prepare('SELECT * FROM login where email_id = ? AND pincode = ?');
		$stmt->bind_param('ss', $email,$pincode);
		$stmt->execute();
		$result = $stmt->get_result();
// $result = $stmt->get_result();
        if ($result->num_rows === 1)
		{
			echo "<h1>Your Order Has been Placed !</h1>";
			echo "<br><br><p>The page will redirect to home page in 5 seconds.</p>";
			header("refresh: 5; url = https://localhost/house-decor");
        }
        else{
            $stmt1 = $mysqli->prepare('INSERT INTO login(username,password,email_id,address,pincode) values (?, ?, ?, ?, ?)');
				$stmt1->bind_param('sssss', $username, $password, $email, $address, $pincode);
				$result1 = $stmt1->execute();
				if($result){
					echo "<h1>Your Order Has been Placed !</h1>";
					echo "<br><br><p>The page will redirect to home page in 5 seconds.</p>";
					header("refresh: 5; url = https://localhost/house-decor");
				}
				else
				{
					echo "Uh...Oh! There is error placing the order. ";
					header("refresh: 5; url = https://localhost/house-decor");
				} 
        }
		// $password_hash = password_hash($password,PASSWORD_DEFAULT);
		
	}
}



?>