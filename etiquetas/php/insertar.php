<?php
$departamento = $_POST['departamento'];
$sociedad = $_POST['sociedad']; 
$acFijo = $_POST['acFijo'];
$anio = $_POST['anio'];
$resultado = $_POST['resultado'];
$fechaActual = $_POST['fechaActual'];

$serverName = "172.26.11.13,49188";
$connectionOptions = array(
    "Database" => "InventarioAF",
    "UID" => "sa",
    "PWD" => "Monte01!"
);
$arr = array();
$arr2 = array();
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn){
    $sqlletra ="SELECT [LETRAEAN] FROM [dbo].[TIPOACTIVOFIJO] WHERE TIPOAF = $acFijo";
    $getletra = sqlsrv_query($conn,$sqlletra);
     if($getletra == False){
        die(FormatErrors(sqlsrv_errors()));
     }else{ 
       while ($row2 = sqlsrv_fetch_array($getletra, SQLSRV_FETCH_ASSOC)) {
           array_push($arr2,$row2);
        }
        sqlsrv_free_stmt($getletra);

         
       $codeBar = $departamento.$sociedad.$arr2[0]['LETRAEAN'].substr($anio, 2, 4).$resultado;
        
       $subcodigo = $departamento.'-'.$sociedad.'-'.$arr2[0]['LETRAEAN'].'-'.substr($anio, 2, 4).'-'.$resultado;

      $tsql ="INSERT INTO [dbo].[ACTIVOFIJOSINASIGNAR]
    ([TIPOAF],[SOCIEDAD],[EJERCICIO],[DEPARTAMENTO],[CODEBAR],[SUBCODIGO],[TEXTO],[IMPRESO],[FECHAIMPRESO])
    VALUES
    ('$acFijo','$sociedad','$anio','$departamento','$codeBar','$subcodigo','$fechaActual','No','0')";

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
}


    
?>
