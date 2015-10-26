<?php
// Check if a file has b
een uploaded

if(isset($_FILES['uploaded_file'])) {
    // Make sure th
e file was sent without errors

    if($_FILES['uploaded_file']['e
rror'] == 0) {

        //&nbs
p;Connect to the database

        $dbLin
k = new mysqli('10.59.51.201', 'root',
 'sahyog', 'upload');

        if(mys
qli_connect_errno()) {

         
   die("MySQL connection faile
d: ". mysqli_connect_error());

        }
 
        //&nbs
p;Gather all required data

        $name&
nbsp;= $dbLink->real_escape_string($_FILES['upl
oaded_file']['name']);

        $mime&
nbsp;= $dbLink->real_escape_string($_FILES['upl
oaded_file']['type']);

        $data&
nbsp;= $dbLink->real_escape_string(file_get_con
tents($_FILES  ['uploaded_file']['tmp_name'])
);

        $size&
nbsp;= intval($_FILES['uploaded_file']['size']);

 
        //&nbs
p;Create the SQL query

        $query
 = "

         
   INSERT INTO `file` (

         
       `name`, 
`mime`, `size`, `data`, `created`

         
   )

         
   VALUES (

         
       '{$name}',&nb
sp;'{$mime}', {$size}, '{$data}', NOW()

         
   )";

 
        //&nbs
p;Execute the query

        $resul
t = $dbLink->query($query);

 
        //&nbs
p;Check if it was successfull

        if($re
sult) {

         
   echo 'Success! Your fi
le was successfully added!';

        }
        else&n
bsp;{

         
   echo 'Error! Failed to
 insert the file'

         
      . "<pre>
{$dbLink->error}</pre>";

        }
    }
    else {
        echo&n
bsp;'An error accured while the&nbs
p;file was being uploaded. '

         
  . 'Error code: '. intva
l($_FILES['uploaded_file']['error']);

    }
 
    // Close the my
sql connection

    $dbLink->close();
}
else {
    echo 'Error! A 
file was not sent!';

}
 
// Echo a link back to t
he main page

echo '<p>Click <a href="index.
html">here</a> to go back</p
>';

?>
 