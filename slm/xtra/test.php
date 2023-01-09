<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "functions.php";
$thistime = date("M,d,Y h:i:s A");


/*
echo<<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sobre la mesa</title>
   
   <meta name="viewport" content="width=device-width">
   <meta name="author" content="Sodio - Comunicación Visual">
   <meta name="apple-mobile-web-app-capable" content="yes" />
   <link href="https://fonts.googleapis.com/css?family=Raleway:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i|Roboto+Slab:300,400,700,800|Roboto:400,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
   <style type="text/css">
      html,body{
         width: 100%;
         font-family:'Raleway', sans;
         color: #266981;
      }
      table {
         border-collapse: collapse;
         margin:1em;
      }
      table th {
         padding:0.4em 1em;
         background-color: rgba(0, 80, 220, 0.1);
         border-bottom: 2px solid gray;
      }
      td {
         padding:0.4em 1em;
         border:1px solid #fafafa;
      }

   </style>
</head>
<body>
<h1>Test1</h1>
HTML;

*/



/*
 table evento

 id
fecha_cotizacion
cliente_id
agente_id
estatus
1.- Cotizando
2.-Pagado
3.-Autorizado
4.-Con abonos
tipo_evento
no_personas
iva
fecha_evento
hora_evento
fecha_entrega
hora_entrega
fecha_recoleccion
hora_recoleccion
domicilio_entrega
status_entrega
flete
montaje
lavado_desinfeccion
descuento
url_seguimiento
firma
status_recibido
created_at
updated_at
*/

   
   if (!empty($_REQUEST['eID'])) {
      $eID = TRIM($_REQUEST['eID']);
   } else {
      echo "no eID!"; exit;
   }

    $TestArr = array ();

/*
   $query = "SELECT * FROM evento WHERE `fecha_evento` > '2022-10-19 21:52:15' ";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx));
   while ($line=mysqli_fetch_array($result)){
      $TestArr[$line['id']]=$line['fecha_cotizacion'];
   }

   echo json_encode($TestArr);
*/

   

   $query = "SELECT fecha_entrega, fecha_recoleccion FROM evento WHERE `id` = '$eID' ";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx)." $query");
   while ($line=mysqli_fetch_array($result)){
      $fe = $line['fecha_entrega'];
      $fr = $line['fecha_recoleccion'];
   }


   $Pc = array();

   if (!empty($_POST['myProds'])) {
      foreach(explode('|', $_POST['myProds']) as $pr) {
         if (!empty($pr)) {
            $Pc[$pr] = 1;      
         }
      }
   }

   
   $query = "SELECT producto_id, cantidad FROM detalle_evento WHERE `evento_id` = '$eID' ";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx)." $query");
   
   while ($line=mysqli_fetch_array($result)){
      $Pc[$line['producto_id']] = $line['cantidad'];
       //echo $line['producto_id']." = ".$line['cantidad']."<br>";
   }
   
   /*
0.- Cancelado
1.- Cotizado
2.- Pagado
3.- Autorizado
4.- Pagado en abonos
5.- Firmado
   */

   $Ev = array();
   $query = "SELECT id, fecha_entrega, fecha_recoleccion FROM evento";
   $query .= " WHERE ((fecha_entrega >= '$fe' AND fecha_entrega <= '$fr') ";
   $query .= " OR (fecha_recoleccion >= '$fe' AND fecha_entrega <= '$fr')) ";
   $query .= " AND id != '$eID' AND `estatus` > 1 AND `estatus` < 5";

   // echo "<hr>$query <hr>";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx)." $query");
   while ($line=mysqli_fetch_array($result)){
      $Ev[$line['id']]=$line['fecha_entrega'].' | '.$line['fecha_recoleccion'];
      // echo "Ev[".$line['id']."] = ".$line['fecha_entrega'].' | '.$line['fecha_recoleccion']."<br>";
   }

   $eventos = ""; $prods = "";
   foreach($Ev as $k=>$v){
      $eventos .= "$k ,";
   }
   foreach($Pc as $k=>$v){
      $prods .= "$k ,";
   }

   $eventos = substr($eventos, 0,-2);
   $prods = substr($prods, 0,-2);

   $Stock = array();
   $query = "SELECT id, stock FROM producto WHERE id IN ($prods) ";
   // echo "<hr>$query <hr>";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx)." $query");
   while ($line=mysqli_fetch_array($result)){
      $Stock[$line['id']] = $line['stock'];
      // echo $line['id']." - ".$line['stock']."<br>";
   }



   $Used = array();

   if (!empty($eventos)){

   $query = "SELECT producto_id, cantidad, evento_id FROM detalle_evento WHERE producto_id IN ($prods) AND evento_id IN ($eventos) ";
   // echo "<hr>$query <hr>";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx)." $query");
   while ($line=mysqli_fetch_array($result)){
      if (empty($Used[$line['producto_id']])) {
         $Used[$line['producto_id']] = 0;
      }
      $Used[$line['producto_id']] += $line['cantidad'];
      // echo "Used[".$line['producto_id']."] += ".$line['cantidad']." (ev ".$line['evento_id'].")<br>";
   }

   }
   

   $Avail = array();

   foreach ($Stock as $k=>$v) {
      $Avail[$k]=$v;
      if (!empty($Used[$k])) {
         $Avail[$k] = $Stock[$k] - $Used[$k]; 
      }
   }

   echo json_encode($Avail);

/*
$log_f = array('user',  'when', 'IP');

echo "<table><tr>\n";
   foreach ($log_f as $thf){
      echo "<th>$thf</th>";
   }
echo "</th>\n";

   $query = "SELECT * FROM log";
   $result=mysqli_query($cx,$query) or die(mysqli_error($cx));
   while ($line=mysqli_fetch_array($result)){

echo "<tr>\n";
   foreach ($log_f as $thf){
      echo "<td>".$line[$thf]."</td>";
      if (($thf=='IP') && (!empty($line[$thf])) ) {
         //echo "<td>".IPtoLocation($line[$thf])."</td>";
      }
   }
echo "</th>\n";
   }
echo "</table>\n";

*/

?>
