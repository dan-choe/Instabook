<?
// db setting
    $host_name  = "db659055917.db.1and1.com";
    $database   = "db659055917";
    $user_name  = "dbo659055917";
    $password   = "Instabook0";

    $connect = mysqli_connect($host_name, $user_name, $password, $database);

    if(mysqli_connect_errno())
    {
		echo 'MySQL Server error: '.mysqli_connect_error().'<br/>';
    }
    else
    {
		echo 'MySQL Server Connected.<br/>';
    }

// access and select database function
function sql_connect($db_host, $db_user, $db_pass, $db_name)
{
    $result = mysql_connect($db_host, $db_user, $db_pass) or die(mysql_error());
    //mysql_select_db("test") or die(mysql_error());
    return $result;
}

// query functions
function sql_query($sql)
{
    global $connect;

	// echo "<pre>Debug1: $sql</pre>";

   // $connect = mysqli_connect($host_name, $user_name, $password, $database);
	$result = mysqli_query($connect, $sql);// or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER[PHP_SELF]");

	if ( false===$result ) {
		printf("error: %s\n", mysqli_error($connect));
	}else {
		// echo 'done...........';
	}

    return $result;
}

// return total count
function sql_total($sql)
{
    global $connect;
    $result_total = sql_query($sql, $connect);
    $data_total = mysql_fetch_array($result_total);
    $total_count = $data_total[cnt];
    return $total_count;
}

// paging function for posting pages
function paging($page, $page_row, $page_scale, $total_count, $ext = '')
{
    // total number of pages
    $total_page  = ceil($total_count / $page_row);

    // initialize variant which prints paging
    $paging_str = "";

    // first page link
    if ($page > 1) {
        $paging_str .= "<a href='".$_SERVER[PHP_SELF]."?page=1&'".$ext.">First</a>";
    }

    // Start page
    $start_page = ( (ceil( $page / $page_scale ) - 1) * $page_scale ) + 1;

    // End page
    $end_page = $start_page + $page_scale - 1;
    if ($end_page >= $total_page) $end_page = $total_page;

    // Previous Link
    if ($start_page > 1){
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($start_page - 1)."&'".$ext.">Previous</a>";
    }

    // the number of link pages
    if ($total_page > 1) {
        for ($i=$start_page;$i<=$end_page;$i++) {
            // other link pages
            if ($page != $i){
                $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$i."&'".$ext."><span>$i</span></a>";
            // set the number as bold type for current page
            }else{
                $paging_str .= " &nbsp;<b>$i</b> ";
            }
        }
    }

    // Next Link
    if ($total_page > $end_page){
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($end_page + 1)."&'".$ext.">Next</a>";
    }

    // Last page
    if ($page < $total_page) {
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$total_page."&'".$ext.">Last</a>";
    }

    return $paging_str;
}
?>
