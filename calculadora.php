<?php

$op = $_GET["op"];

$v1 = $_GET["a"];
$v2 = $_GET["b"];
$result = 0;

switch($op){
    case "1":
        $result = $v1 + $v2;
        break;
    case "2":
        $result = $v1 - $v2;
        break;
    case "3";
        $result = $v1 * $v2;
        break;
    case "4";
        $result = $v1 / $v2;
        break;
    default:
        echo "Insira uma operação válida";
        break;
}

echo "<h1>Resultado: $result</h1>";

?>