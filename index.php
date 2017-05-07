<?php
// Pass in an opperation variable to determine what we are doing

//Variable: op [fetch, create, update, delete]

//Example:
//   http://example.org/lab9.php?op=fetch

if (isset($_GET['op']) ) {
	$op = (string) $_GET['op'];
} else {
	$op = "fetch";
}

//set DB connection info below:
$host="104.197.193.136"; #The host address of the DB 
$dbuser="root"; #The DB username
$dbpass="1839bdr"; #The DB password
$db="ndettmer"; #The DataBase to use
$table="contact";
//NOTE THAT THE HOST PROVIDED IN THE DEMO ABOVE IS NOT OPEN TO ALL IPS	
 
// Create the DB Connection and put in mysqli variable ...
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);

//echo ("DB connected!"); #DEBUG

// Check for connection error
if ($mysqli->connect_errno) {
	// The connection failed. Tell the user what happened
	echo "Sorry, this website is experiencing problems.";
	// Give details about the failure (ONLY FOR NON-PUBLIC FACING SITES)
	echo "Error: Failed to make a MySQL connection, here is why: \n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	echo "Error: " . $mysqli->connect_error . "\n";
	exit;
}


//$mysqli->query("DROP DATABASE $db");
if (!$mysqli->select_db($db))
{
  $sql = "CREATE DATABASE $db";
  //$sql = "SHOW DATABASES";

  if ($mysqli->query($sql) === TRUE) {
	echo "Database created successfully";
  } else {
	echo "Error creating database: " . $mysqli->error;
	exit;
  }
}
else {
	//echo("DB Exists!"); #DEBUG
}

$mysqli->close();


$mysqli = new mysqli($host, $dbuser, $dbpass, $db);

if ( !$mysqli->query("SHOW TABLES LIKE '".$table."'")->num_rows ==1 ) 
{
    $sql = "CREATE TABLE $table (`idcontact` int(11) NOT NULL AUTO_INCREMENT,`firstname` varchar(150) DEFAULT NULL,`lastname` varchar(150) DEFAULT NULL,`age` int(11) DEFAULT NULL, `email` varchar(250) DEFAULT NULL, `zip` varchar(25) DEFAULT NULL, UNIQUE KEY `idcontact_UNIQUE` (`idcontact`))";
    //echo($sql."<br/>"); #DEBUG
    $mysqli->query($sql);
    echo $mysqli->error; 
}
else {
	//echo("Table Exists!"); #DEBUG
}



  switch ($op) {
	case 'fetch':
		//get email ...
		if (isset($_GET['email']) ) {
			$email = (string) $_GET['email'];
		} 
		else {
			$email = "!";
		}

	  get($email, $mysqli, $table); 
	  break;
	  
	case 'update':
		$changecount = 0;
		//get email ...
		if (isset($_GET['email']) ) {
			$email = (string) $_GET['email'];
		} 
		else {
			echo("email is a required parameter for the create operation");
			exit;
		}
	  //get fname ...
		if (isset($_GET['fname']) ) {
			$fname = (string) $_GET['fname'];
			$changecount += 1;
		} 
		else {
			$fname = "!";
		}
		//get lname ...
		if (isset($_GET['lname']) ) {
			$lname = (string) $_GET['lname'];
			$changecount += 1;
		} 
		else {
			$lname = "!";
		}
		//get age ...
		if (isset($_GET['age']) ) {
			$age = (string) $_GET['age'];
			$changecount += 1;
		} 
		else {
			$age = "!";
		}
		
		//get zip ...
		if (isset($_GET['zip']) ) {
			$zip = (string) $_GET['zip'];
			$changecount += 1;
		} 
		else {
			$zip = "!";
		}
		if ($changecount > 0){
		update($fname,$lname,$age,$email,$zip,$mysqli,$table); 
		}
		break;


		
	case 'create':
		//get fname ...
		if (isset($_GET['fname']) ) {
			$fname = (string) $_GET['fname'];
		} 
		else {
			echo("fname is a required parameter for the create operation");
			exit;
		}
		//get lname ...
		if (isset($_GET['lname']) ) {
			$lname = (string) $_GET['lname'];
		} 
		else {
			echo("lname is a required parameter for the create operation");
			exit;
		}
		//get age ...
		if (isset($_GET['age']) ) {
			$age = (string) $_GET['age'];
		} 
		else {
			echo("age is a required parameter for the create operation");
			exit;
		}
		//get email ...
		if (isset($_GET['email']) ) {
			$email = (string) $_GET['email'];
		} 
		else {
			echo("email is a required parameter for the create operation");
			exit;
		}
		//get zip ...
		if (isset($_GET['zip']) ) {
			$zip = (string) $_GET['zip'];
		} 
		else {
			echo("zip is a required parameter for the create operation");
			exit;
		}

		create($fname,$lname,$age,$email,$zip,$mysqli,$table); 
		break;
	case 'remove':
	//get email ...
		if (isset($_GET['email']) ) {
			$email = (string) $_GET['email'];
		} 
		else {
			echo("email is a required parameter for the create operation");
			exit;
		}
	  remove($email, $mysqli,$table); break;

	  
  }

function get($email, $mysqli, $table) {

if($email == "!")
	{
	  $sql="SELECT * from ".$table."";
	  //echo($sql); #DEBUG
	  $result = $mysqli->query($sql); echo $mysqli->error;
	  $rows = array();
	  while($r = $result->fetch_array(MYSQLI_ASSOC)) {
		$rows[] = $r;
	  }
	  echo json_encode($rows);
	}
	else {
		$sql="SELECT * from ".$table." where email = '$email'";
		//echo($sql); #DEBUG
		$result = $mysqli->query($sql); echo $mysqli->error;
		if ($result->num_rows > 0) {
			$rows = array();
			while($r = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[] = $r;
			}
			echo json_encode($rows);
		}
		else {
			echo("Contact with provided email not found!");
			exit;

		}

	}
}

function update($fname,$lname,$age,$email,$zip,$mysqli,$table) {
 
	$sql="SELECT idcontact from ".$table." where email='$email'";
        //echo($sql); #DEBUG
	$result = $mysqli->query($sql); echo $mysqli->error;
	if ($result->num_rows > 0) {
		$sql = "Update ".$table." Set email = '$email'";
		if ($fname != "!"){ 
		$sql .= ", firstname = '$fname'";
		}
		if ($lname != "!"){ 
		$sql .= ", lastname = '$lname'";
		}
		if ($age != "!"){ 
		$sql .= ", age = '$age'";
		}
		if ($zip != "!"){ 
		$sql .= ", zip = '$zip'";
		}
		$sql .= " WHERE email = '$email'";

		//echo($sql."<br/>"); #DEBUG
		if ($mysqli->query($sql) === TRUE) {
			echo json_encode(array("firstname"=>$fname,"lastname"=>$lname,"action" => "updated"));
		}
		else { 
		 echo $mysqli->error;
                 exit;
		}
        }
	else { 
		echo "Contact not found!";
		exit;

		}
	
                
 }
  




function create($fname,$lname,$age,$email,$zip,$mysqli,$table) {
 
	$sql="SELECT idcontact from ".$table." where email='$email'";
	$result = $mysqli->query($sql); echo $mysqli->error;
	if ($result->num_rows > 0) {
		echo "Contact already exists!";
		exit;
	}
	else {
		$sql = "INSERT into ".$table." (firstname, lastname, age, email, zip) VALUES ('$fname', '$lname', '$age', '$email', '$zip')";
		//echo($sql); #DEBUG
		if ($mysqli->query($sql) === TRUE) {
			echo json_encode(array("firstname"=>$fname,"lastname"=>$lname,"action" => "created"));
		}
		else { 
		echo $mysqli->error; 
                exit;
		}
	}
  
}



function remove($email, $mysqli,$table) {
  
  $sql="SELECT idcontact from $table where email='$email'";
  //echo($sql."<br/>"); #DEBUG
  $result = $mysqli->query($sql); echo $mysqli->error;
  if ($result->num_rows > 0) {
	$sql = "DELETE from $table where email='$email'";
        //echo($sql."<br/>"); #DEBUG
	$mysqli->query($sql); echo $mysqli->error;
	echo json_encode(array("Contact with email"=>$email, "action"=>"deleted"));
  }
  else {
	echo "Contact doesn't exist!";
	exit;
  }
}


?>