<?php

//Second approach to storing passwords (using Secure Hash algorithm by MD5)

//Insert the user with the password being hashed by MD5 first.
function insertUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "INSERT INTO  Users(Username,Password)
         VALUES(?,?)";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,hashshift($password))); //execute the query
}

//Check if the credentials match a user in the system with MD5 hash
function validateUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "SELECT  UserID FROM Users WHERE  Username=? AND
        Password=?";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,hashshift($password))); //execute the query
  if($smt->rowCount()){
    return "User found!"; //record found, return true.
  }
  return "User not found!"; //record not found matching credentials, return false
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

insertUser('Charlie','password1');
insertUser('David', 'password2');
//Sample Login and Password
echo validateUser('Charlie', 'password1');
echo "<br>";
echo validateUser('David', 'password2');
echo "<br>";
echo validateUser('David', 'password');



?>
<!--
----------------------------------------------------------------------------------------------------------------------------
Password Storage: Secure Hash Method  MD5("password"); 

user1 password: "password"
user2 password: "password"

User Id (int) 		User Name (varchar)		Password (varchar)
1			Smith				gastiweiwcnbmxncxcvuyw28e29es
2			David				gastiweiwcnbmxncxcvuyw28e29es
-->