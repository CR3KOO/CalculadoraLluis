<?php
session_start();

$nomUsuari="";
$Operand_1="";
$Operand_2="";
$Operand_3="";
$resultat="";
$usuariAnterior="";

if (!isset($_SESSION['SavedData'])) {
    $_SESSION['SavedData'] = [];
}
if (!isset($_SESSION['id'])) {
    $_SESSION['id']=0;
}

function ProcesarValors ($Operand_1, $Operand_2, $Operand_3){

    if (is_numeric($Operand_1) && is_numeric($Operand_2) && is_numeric($Operand_3)){
        $suma=$Operand_1+$Operand_2+$Operand_3;
        return $suma;
    } elseif (is_numeric($Operand_1) && is_numeric($Operand_2) && $Operand_3==="" ){
        $suma=$Operand_1+$Operand_2;
        return $suma;
    } else {
        $concatenar=$Operand_1.$Operand_2.$Operand_3; 
        return $concatenar;       
    }

}

function SearchData ($array, $id, $Operand_1, $Operand_2, $Operand_3){

    foreach ($array as $entry) {
        if ($entry['Operand_1'] == $Operand_1 && $entry['Operand_2'] == $Operand_2 && $entry['Operand_3'] == $Operand_3) {
            if($id != $entry['id'] ){
                return $entry['nomUsuari'];
            } else {
                return "";    
            }
        } 
    }
    return "";
    
}

function MostraResultat($resultat, $nomUsuari, $usuariAnterior) {

    if($resultat!="") echo "<h2>Resultat: $resultat</h2>";
    if($usuariAnterior!=""){
        if($usuariAnterior===$nomUsuari){
            echo "<h2>Ja has realitzat la mateixa operació anteriorment</h2>";
        }else {    
            echo "<h2>El usuari $usuariAnterior ha realitzat la mateixa operació anteriorment</h2>";
        }
    }

}

if($_POST){
    $nomUsuari = ( isset($_POST['nomUsuari']) )?$_POST['nomUsuari']:"";
    $Operand_1 = ( isset($_POST['Operand_1']) )?$_POST['Operand_1']:"";
    $Operand_2 = ( isset($_POST['Operand_2']) )?$_POST['Operand_2']:"";
    $Operand_3 = ( isset($_POST['Operand_3']) )?$_POST['Operand_3']:"";

    $resultat = ProcesarValors($Operand_1,$Operand_2,$Operand_3);
    $_SESSION['SavedData'][] = [
        'id' => $_SESSION['id'],
        'nomUsuari' => $nomUsuari,
        'Operand_1' => $Operand_1,
        'Operand_2' => $Operand_2,
        'Operand_3' => $Operand_3,
        'resultat'  => $resultat
    ];
    $usuariAnterior=SearchData ($_SESSION['SavedData'], $_SESSION['id'], $Operand_1, $Operand_2, $Operand_3);
    $_SESSION['id']++;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="CalculadoraLluis.php" method="post" onsubmit="return validarFormulario()">
        <label for="txtName">Nom Usuari:
            <input value="" type="text" name="nomUsuari" id="nomUsuari" required>
        </label></br>
        <label for="txtName">Valor 1:
            <input value="" type="text" name="Operand_1" id="Operand_1">
        </label></br>
        <label for="txtName">Valor 2:
            <input value="" type="text" name="Operand_2" id="Operand_2">
        </label></br>
        <label for="txtName">Valor 3:
            <input value="" type="text" name="Operand_3" id="Operand_3">
        </label></br>
        </br><input type="submit" value="Calcular" name="calcular" id="calcular" class="custom-submit"></br>
    </form>
    
    <script>
    function validarFormulario() {
        var valor1 = document.getElementById('Operand_1').value;
        var valor2 = document.getElementById('Operand_2').value;
        if (valor1 === '' || valor2 === '') {
            alert('Els camps Valor1 i Valor 2 no poden estar buits.');
        return false; 
        }
    }
    </script>        
    
    <div><?php MostraResultat($resultat, $nomUsuari, $usuariAnterior);?> </div>
    
</body>
</html>