<?php

function connectToDatabase()
{
//login to sql
//Change this to your connection info.
$DATABASE_HOST = 'tethys.cse.buffalo.edu';
// Currently using my ubit name, had to change my cheshire mysql passowrd so I didnt expose my own.
// It may be prudent to see if Hertz can set us up with a team database user credential.
// --Salapadakey, slgreco@buffalo.edu, 5:22pm
$DATABASE_USER = 'slgreco';
$DATABASE_PASS = 'mysqlsofly';
$DATABASE_NAME = 'cse442_542_2020_summer_teama_db';
// Try and connect using the info above.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if ( mysqli_connect_errno() ) {
       // If there is an error with the connection, stop the script and display the error.
       die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  return $con;
} catch (Exception $e) {
 die ('Failed to connect to MySQL: ' . $e->getMessage());
}
}
