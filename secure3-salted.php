<?php

//Third approach: An Authentication system using salted passwords

function generateRandomSalt(){
  return base64_encode(random_bytes(12));
}
// Insert the user with the password salt generated, stored, and
// password hashed
function insertUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $salt = generateRandomSalt();
  $sql = "INSERT INTO Users(Username,Password,Salt)
           VALUES(?,?,?)";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,hashshift($password.$salt),$salt));
}


//Check if the credentials match a user in the system with MD5 Salt hash
function validateUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "SELECT  Salt FROM Users WHERE  Username=?";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username)); //execute the query

  if ($row = $smt->fetch()) {
    $sql = "SELECT  UserID FROM Users WHERE  Username=? AND
          Password=?";
    $smt = $pdo->prepare($sql);
    $smt->execute(array($username,hashshift($password.$row['Salt']))); //execute the query
    if($smt->rowCount()){
      return "User found!"; //record found, return true.
    }
    return "User not found!"; //record not found matching credentials, return false
}
}

function hashshift($pass) {
  $pass = strtolower(md5($pass));
  $chars = str_split($pass);
  $res = array();

  foreach ($chars as $idx => $char) {
      $res[$idx] = chr(97 + (ord($char) - 91) % 26);
  }   
  return join("", $res);
}

insertUser('Emma','password1');
insertUser('Felix', 'password2');
//Sample Login and Password
echo validateUser('Emma', 'password1');
echo "<br>";
echo validateUser('Felix', 'password2');
echo "<br>";
echo validateUser('Felix', 'password');
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