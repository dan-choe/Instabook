<?
include ("./include.php");


if(trim($_POST[m_id]) == ""){
    ?>
    <script>
        alert("Plese enter id");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[m_firstname]) == ""){
    ?>
    <script>
        alert("Plese enter firstname");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[m_pass] == ""){
    ?>
    <script>
        alert("Plese enter password");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[m_pass] != $_POST[m_pass2]){
    ?>
    <script>
        alert("Plese recheck the password");
        history.back();
    </script>
    <?
    exit;
}

// echo $_POST[m_id];
$chk_sql = "SELECT * FROM `Employee` WHERE `EmployeeID` = '".trim($_POST[m_id])."'";
$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

if($chk_data[m_idx]){
    ?>
    <script>
        alert("ID is already in use. <?echo $_POST[m_id];?>");
        history.back();
    </script>
    <?
    exit;
}else{

}

$sql = "INSERT INTO Employee (EmployeeID, FirstName, LastName, Address, City, State, ZipCode, Telephone, SSN, Email, HourlyRate, Password, IsManager) "
      ."VALUES ("
      ." '$_POST[m_id]' , '$_POST[m_firstname]', '$_POST[m_lastname]' , '$_POST[m_address]' , '$_POST[m_city]' , '$_POST[m_state]' , '$_POST[m_zipcode]' , '$_POST[m_telephone]' , '$_POST[m_ssn]' , '$_POST[m_email]' , '$_POST[m_rate]' , '$_POST[m_pass]'  , '$_POST[is_manager]'  "
      .")";

sql_query($sql);

?>
<script>
alert("Completed registration!");
location.replace("./manage_employees");
</script>
