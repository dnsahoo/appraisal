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
$csv_file = CSV_PATH . "test_data_with_manager.csv";


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
        $query = "INSERT INTO employeeappraisal(id, eid, doj, name, designation, process, email, mgr1_name, mgr1_email, mgr2_name, mgr2_email, parent, role, pswd) VALUES('" . $col[0] . "','" . $col[1] . "','" . date('Y-m-d', strtotime($col[2])) . "','" . $col[3] . "', '" . $col[4] . "', 'Content Engg','" . $col[5] . "','" . $col[6] . "','" . $col[7] . "','" . $col[8] . "','" . $col[9] . "','" . $col[10] . "','" . $col[11] . "','" . md5('123456') . "')";
        //echo $query;
        $s = mysql_query($query, $connect);
    }
    fclose($handle);
}

echo "File data successfully imported to database!!";
mysql_close($connect);
?>