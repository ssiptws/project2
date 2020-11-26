<?php 
$row1 = (int)$_GET['row1']; 
$col1 = (int)$_GET['col1']; 
$row2 = (int)$_GET['row2']; 
$col2 = (int)$_GET['col2']; 

session_start();
$_SESSION['row1'] = $row1;
$_SESSION['col1'] = $col1;
$_SESSION['row2'] = $row2;
$_SESSION['col2'] = $col2;
//echo $row1;
//echo $col1;
//echo $row2;
//echo $col2;
//var_dump(is_int($row1));
//var_dump(is_int($col1));
//var_dump(is_int($row2));
//var_dump(is_int($col2));


echo "<center>";
echo "<form action=countmatrix.php method=post>";
for ($i = 0; $i < $row1; $i++){
    for ($j = 0; $j < $col1; $j++){
        echo "<input type='text' name=matrix1$i$j>";
    }
    echo "<br>";
}
echo "<br>";
for ($i = 0; $i < $row2; $i++){
    for ($j = 0; $j < $col2; $j++){
        echo "<input type='text' name=matrix2$i$j>";
    }
    echo "<br>";
}
echo "<input type='submit' name='submit'>";
echo "</form>";
echo "</center>";

    
?> 