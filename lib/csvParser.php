<?php

    /*  
    TODO issue #108
    this will parse a .csv, expecting correct formmatting (from code in #107)
    once parsed, will create SQL insert statements and run them to the database
    
    This is sepecifically for user story #51 to handle insertions to students table
    */

    //error logging
    error_reporting(-1); // reports all errors
    ini_set("display_errors", "1"); // shows all errors
    ini_set("log_errors", 1);
    ini_set("error_log", "~/php-error.log");
   

    /*
        function: csv_check
        inputs: $tmp - the tmp_name of the .csv
        output: boolean, true if file is formatted correctly, false if otherwise
        This function checks if the csv is formatted to have 2 columns in every row.
        Otherwise, provides errorrasdaasdsad
    */
    function csv_check($tmp) {
        //TODO
        // get file reference
        $csv = fopen(($tmp), 'r');
        // variables for tracking errors
        $count = 1; $correct = true;
        while ($row = fgetcsv($csv)) { // for each row in .csv file
            if (sizeof($row) != 2) {
                $correct = false;
                echo 'error: row '.$count.' has '.sizeof($row).' columns'.'<br>';
            }
            $count++;
        }
        return $correct;
    }


    /*
        function: insert_students
        inputs: $tmp - the tmp_name of the .csv 
        outputs: a string with messages with information of which students were added or not
        Using a loop, inserts all students to the database.
    */
    function insert_students($tmp) {
        require 'database.php';
        $con = connectToDatabase();
        //get file reference
        $csv = fopen($tmp, 'r');
        while ($row = fgetcsv($csv)) { // for each row in .csv file
            $id = 0; // database is formatted to handle this
            $name = $row[0] ; $email = $row[1];
            // compare to database
            $sql_get = $con->prepare('SELECT email from students WHERE email=?');
            $sql_get-> bind_param('s', $email);
            $sql_get-> execute();
            $sql_get-> bind_result($flag);
            $sql_get-> store_result();
            $sql_get-> fetch();
            if ($sql_get-> num_rows != 0) { 
                // email is already in database, don't add
                echo $name.' is already registered to the system.'.'<br>';
            }
            else {
                // prepare SQL statement, bind parameters and execute
                $sql_ins = $con->prepare("INSERT INTO students (student_id, email, name) VALUES (?,?,?)"); 
                $sql_ins-> bind_param('iss', $id, $email, $name);
                $sql_ins-> execute();
                echo $name.' was added to the system.'.'<br>';
            }
        }
        echo '<br>'.'Updates completed.';
    }
?>
