<?php

//Third approach: An Authentication system using salted passwords

function generateRandomSalt(){
  return base64_encode(mcrypt_create_iv(12, MCRYPT_DEV_RANDOM));
}
// Insert the user with the password salt generated, stored, and
// password hashed
function insertUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $salt = generateRandomSalt();
  $sql = "INSERT INTO Users(Username,Password,Salt)
           VALUES(?,?,?)";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,md5($password.$salt),$salt));
}

/*
//Check if the credentials match a user in the system with MD5 Salt hash
function validateUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "SELECT  Salt FROM Users WHERE  Username=?";
  $smt = $pdo->prepare($sql);

  while ($row = $stmt->fetch()) {

    $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
    $sql = "SELECT  UserID FROM Users WHERE  Username=? AND
          Password=?";

$smt->execute(array($username,md5($password.$row['salt']))); //execute the query
if($smt->rowCount()){
  return true; //record found, return true.
}
return false; //record not found matching credentials, return false
}
}
*/
insertUser('Smith','password1');
//insertUser('David', 'password2');
//echo validateUser('Smith', 'password1');
//echo "<br>";
//echo validateUser('David', 'password2');


?>

<!--
----------------------------------------------------------------------------------------------------------------------------
Password Storage: Salted passwords encrypted with a one-way Hash

user1: MD5("password12345a");
user2: MD5("password54321a");

User Id (int) 		User Name (varchar)	Salt		Password (varchar)
1			Smith			12345a	 	jsdkskdksdkqtywtqywcbaueiuwe64
2			David			54321a	 	flkfdlkfldkfldflkgle9wenbxvnzxuquwe
-->