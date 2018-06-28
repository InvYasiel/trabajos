<?php
$tiempo = $_POST['tiempo'];
$serverName = "172.26.11.13,49188";
$connectionOptions = array(
    "Database" => "InventarioAF",
    "UID" => "sa",
    "PWD" => "Monte01!"
);
$arr = array();
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn){
    $tsql ="UPDATE [dbo].[ACTIVOFIJOSINASIGNAR] SET [IMPRESO] = 'Si',[FECHAIMPRESO] = '$tiempo' WHERE [IMPRESO] = 'No' ";

    $getResults = sqlsrv_query($conn,$tsql);
    if($getResults == False){
        die(FormatErrors(sqlsrv_errors()));
    }else{
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

array_push($arr,$row);

        }
        sqlsrv_free_stmt($getResults);
    }
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
}
?>
