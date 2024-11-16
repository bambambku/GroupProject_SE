// HERE IS AN EXAMPLE OF A QUERY WITH PARAMETERS
// IT IS NOT MEANT TO BE IMPORTED INTO ANOTHER FILE
// COPY AND PASTE THE CODE INTO THE FILE WHERE YOU NEED IT AND ADJUST IT

<?php
include("dbconnect.php");
include("querry.php");


//YOU CREATE A QUERY WITH PARAMETERS SUCH AS :eid and :pid
$sql = "SELECT (Employees.employee_fname || ' ' || Employees.employee_mname || ' ' || Employees.employee_lname) AS Employee, 
Projects.project_name, hours, Employees.employee_ID, Projects.project_ID FROM Assignments
INNER JOIN Employees ON (Employees.employee_ID = Assignments.employee_ID)
INNER JOIN Projects ON (Projects.project_ID = Assignments.Project_no) WHERE 
(Assignments.employee_ID = :eid AND Assignments.project_no = :pid);";


$stmt = $db->prepare($sql); 
// THEN YOU BIND THE PARAMETERS TO THE QUERY
$stmt->bindParam(':eid', $_GET['eid'], SQLITE3_TEXT);
$stmt->bindParam(':pid', $_GET['pid'], SQLITE3_TEXT);
$result= $stmt->execute();

//FINALLY YOU FETCH THE RESULTS INTO AN ARRAY
while($row=$result->fetchArray(SQLITE3_NUM)){
    $arrayResult [] = $row;
};

?>