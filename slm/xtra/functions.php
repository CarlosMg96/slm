<?php

session_set_cookie_params(8640000);
ini_set('session.gc_maxlifetime', 8640000);
ini_set('session.cookie_lifetime', 8640000);
  
date_default_timezone_set("America/Mexico_City");
setlocale(LC_ALL,"es_CO.utf8");
  //setlocale(LC_TIME, 'ca_ES', 'Catalan_Spain', 'Catalan');
  //setlocale(LC_TIME, 'es_MX', 'Spanish_Mexico', 'Spanish');
$hora_mysql = date("Y-m-d H:i:s");
$Hoy = date("Y-m-d");
$ahora = date("Y-m-d_H-i-s");

$Mes = Array('ZERO', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
$Mth = Array('ZERO', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
$Mes3 = Array('ZERO', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$dow = Array('zero','LUN','MAR','MIE','JUE','VIE','SAB','DOM');
$dow2 = Array('DOM','LUN','MAR','MIE','JUE','VIE','SAB');
$dow3 = Array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');

$Edos = Array('SON'=>'Sonora', 'VER'=>'Veracruz', 'CHP'=>'Chiapas', 'OAX'=>'Oaxaca',
'GRO'=>'Guerrero', 'TAB'=>'Tabasco', 'MIC'=>'Michoacán', 'PUE'=>'Puebla',
'MOR'=>'Morelos', 'MEX'=>'México', 'COL'=>'Colima', 'CAM'=>'Campeche',
'JAL'=>'Jalisco', 'CDX'=>'Ciudad de México', 'TLA'=>'Tlaxcala', 'HID'=>'Hidalgo', 'GTO'=>'Guanajuato',
'QRO'=>'Querétaro', 'YUC'=>'Yucatán', 'ZAC'=>'Zacatecas', 'SLP'=>'San Luis Potosí',
'AGS'=>'Aguascalientes', 'ROO'=>'Quintana Roo', 'NAY'=>'Nayarit', 'DUR'=>'Durango',
'NLE'=>'Nuevo León', 'COA'=>'Coahuila', 'SIN'=>'Sinaloa', 'CHH'=>'Chihuahua',
'BCS'=>'Baja California Sur', 'BC'=>'Baja California', 'TAM'=>'Tamaulipas');

$tColor = array ('#399ac8','#f6b264','#efdd3b','#ee5f62','cyan','#f1816c','#b33321','#bad23a','#9a5aa6','orange');

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
session_start();

foreach($_POST as $k=>$v) {
  $_POST[$k] = addslashes($v);
}


$database = 'sobrelamesa_sobrelamesa';
$hostname = 'localhost';
$user = 'sobrelamesa_us_admon';
//$password = 'MyHolidayParty!';
$password = 'T6[0VEG]k(FB';

// ns100.nsresponse.com
// ns101.nsresponse.com

if (is_dir("/Volumes/SamUSB")){
  $database = 'sobrelamesa_sobrelamesa';
  $hostname = 'localhost';
  $user = 'root';
  $password = 'root';
}

$cx = mysqli_connect($hostname,$user,$password,$database) or die("error".mysqli_error());
mysqli_set_charset($cx, 'utf8'); 
$query="SET collation_connection = utf8_spanish2_ci";
$result=mysqli_query($cx,$query) or die(mysqli_error($cx));



foreach ($_REQUEST as $key => $input_arr) {
  $_REQUEST[$key] = addslashes($input_arr); 
} 
  

  /*
  $query = "";
  $result=mysqli_query($cx,$query) or die(mysqli_error($cx));
  while ($line=mysqli_fetch_array($result)){  
  }
  */
  
  function ll($thing) {   // ----------------------------------------------  limpiar strings
    return str_replace("'", "\'", $thing);
  }    
    
    function fdate($fecha) {
      return "<span style='color:#A38A83'>".strftime("%a %e %b</span> <span style='color:#4F8BB7'>%l:%M %P</span>", strtotime($fecha))."</span>";
    }

    function fdate2($fecha) {
      return "<span style='color:#A38A83'>".strftime("%a %e %b</span> <span style='color:#4F8BB7'>%l:%M %p</span>", strtotime($fecha))."</span>";
    }

    function miFecha($fecha) {
      global $Mes;
      $diahr = explode(' ',$fecha);
      $ddia = explode('-',$diahr[0]);
      return $ddia[2].' '.$Mes[(int)$ddia[1]].' '.substr($ddia[0],-2);
    }

    function miFechaw($fecha) {
      global $Mes, $dow;
      $diahr = explode(' ',$fecha);
      $ddia = explode('-',$diahr[0]);

      $fmt = new \IntlDateFormatter('es_MX', NULL, NULL);
      $fmt->setPattern('c'); 
      $dw = $fmt->format(new \DateTime($fecha)); 
      $dw = ((int)$dw) - 1; if ($dw<1) {$dw=7;} 
       $dw = strtolower($dow[$dw]);

      return $dw.' - '.(int)$ddia[2].' '.$Mes[(int)$ddia[1]].' '.$ddia[0];

    }
    

    function miHora($fecha) {
       global $Mes;
      $diahr = explode(' ',$fecha);
      $hhra = explode(':',$diahr[1]);
      $hora = $hhra[0];
      $ampm = 'AM';
      if ($hora > 11) {$ampm = 'PM';}
      if ($hora > 12) {$hora = $hora - 12;}
      return $hora.':'.$hhra[1].' '.$ampm;     
    }
   
    function soloHora($hh) {
      $hhra = explode(':',$hh);
      $hora = $hhra[0];
      $ampm = 'AM';
      $ampm = 'AM';
      if ($hora > 11) {$ampm = 'PM';}
      if ($hora > 12) {$hora = $hora - 12;}
      return $hora.':'.$hhra[1].' '.$ampm;     
    }

   function formattimedatesimple($time) {

      global $Mes;
      //$hhoy=strtotime($time);
      // echo $hhoy,'=',$current_time,'!'; 

     $pieces = explode(" ", $time);
     $mifecha = explode("-", $pieces[0]);  $mifecha[1] = intval($mifecha[1]);    
     $horas = explode(":", $pieces[1]); $ampm='am'; if ($horas[0]>12){$horas[0]-=12; $ampm='pm';}
     if ($horas[1]<10 && strlen($horas[1])<2){$horas[1]='0'.$horas[1];}
     if ($horas[0]<10 && strlen($horas[0])<2){$horas[0]='<br>'.$horas[0];}

    $result= <<<HTML
<font color=gray>$mifecha[2]<font style="color:#888; font-size:11px;">{$Mes[$mifecha[1]]}</font></font> $horas[0]:$horas[1]<font style="color:gray; font-size:11px;">$ampm</font>
HTML;

    return $result;

    }

function myTime($time) {

      global $Mes, $Mth;
      //$hhoy=strtotime($time);
      // echo $hhoy,'=',$current_time,'!'; 

     $pieces = explode(" ", $time);
     $mifecha = explode("-", $pieces[0]);  $mifecha[1] = intval($mifecha[1]);    
     $horas = explode(":", $pieces[1]); $ampm='am'; if ($horas[0]>12){$horas[0]-=12; $ampm='pm';}
     if ($horas[1]<10 && strlen($horas[1])<2){$horas[1]='0'.$horas[1];}
     if ($horas[0]<10 && strlen($horas[0])<2){$horas[0]='<br>'.$horas[0];}

    $result= <<<HTML
<font color=gray>$mifecha[2]<font style="color:#888; font-size:11px;">{$Mth[$mifecha[1]]}</font></font> $horas[0]:$horas[1]<font style="color:gray; font-size:11px;">$ampm</font>
HTML;

    return $result;

    }



function eliminar_acentos($cadena){
    
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );
    
    return $cadena;
  }
    
    
?>