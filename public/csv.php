<?php

//database connection details
$connect = mysql_connect('localhost', 'root', '');

if (!$connect) {
    die('Could not connect to MySQL: ' . mysql_error());
}

//your database name
$cid = mysql_select_db('gl_appraisal', $connect);

// path where your CSV file is located
define('CSV_PATH', 'C:/xampp/htdocs/appraisal/public/');

// Name of your CSV file
$csv_file = CSV_PATH . "GL_Non_Google_Projects_Appraisal_Eligible_Data.csv";


if (($handle = fopen($csv_file, "r")) !== FALSE) {
    fgetcsv($handle);
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        for ($c = 0; $c < $num; $c++) {
            $col[$c] = $data[$c];
        }

        echo '<pre>';
        //print_r($col);
        echo '</pre>';

// SQL Query to insert data into DataBase
        $query = "INSERT INTO employeeappraisal(id, eid, doj, name, designation, email, pswd, mgr1_name, mgr1_email, mgr2_name, mgr2_email, process, parent, role, period) VALUES('" . $col[0] . "','" . $col[1] . "','" . date('Y-m-d', strtotime($col[2])) . "','" . $col[3] . "', '" . $col[4] . "','" . strtolower($col[5]) . "','" . md5($col[6]) . "','" . $col[7] . "','" . $col[8] . "','" . $col[9] . "','" . $col[10] . "','" . $col[11] . "','" . $col[12] . "','" . $col[13] . "','2015-16')";
        //echo $query;die;
        $s = mysql_query($query, $connect);
    }
    fclose($handle);
}

echo "File data successfully imported to database!!";
mysql_close($connect);
?>