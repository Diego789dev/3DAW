<?php
    $v1 = $_GET["a"];
    $v1 = $_GET["b"];
    $oper=$_GET["op"];
    $result = 0;
    if ($oper=="+"){
        $result = $v1 + $v2;
        echo "<h1>Resultado:<br>$result</h1>";
    }
    elseif ($oper== "-"){
        $result = $v1 - $v2;
        echo "<h1>Resultado:<br>$result</h1>";
    }
    elseif ($oper== "*"){
        $result = $v1 * $v2;
        echo "<h1>Resultado:<br>$result</h1>";
    }
    else{
        $result = $v1 / $v2;
        echo "<h1>Resultado:<br>$result</h1>";
    }
?>