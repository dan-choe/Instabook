<?php
include ("./include.php");


	
	$testquery = "SELECT C.fID, C.cname, S.sname
				FROM Student S, Enrolled E, Class C
				
				GROUP BY C.fID, S.sname
				
				";
				
	$testqueryRun = sql_query($testquery);
	//$testqueryResult = mysqli_fetch_array($testqueryRun);
	$count = 0;
	
	while ($testqueryResult = mysqli_fetch_array($testqueryRun)) {
		    $count = $count + 1;
			echo $count." ";
			echo $testqueryResult[fID]."  ".$testqueryResult[1]."  ".$testqueryResult[2];
			echo "<br>";
			
	}

	/*
	
	SELECT DISTINCT S.sname


FROM Student S, Enrolled E, Class C


WHERE E.sID = S.sID


            AND E.cname = C.cname


GROUP BY S.sname, C.fID


HAVING COUNT(C.cname) >= 2; 

*/
	
	
	
?>


