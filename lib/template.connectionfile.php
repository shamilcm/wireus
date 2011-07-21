<?php

function dbconfn(){
$hostname = 'localhost';        //specify the ip address of the host or localhost if the databse is in the server itself
$username = '';        //Specify the username of the database user
$password = '';         //Specify the password of the database user
$dbtype = '';              // Specify the type of database you are using ( mysql/pgsql); 
$dbname = '';       // Specify the database name;
try {
        
    $dbconn = new PDO("$dbtype:dbname=$dbname ;host=$hostname", $username, $password );

    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    exit();
    }

    return $dbconn;
}
?>
