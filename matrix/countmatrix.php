<?php 

session_start();
$row1 = $_SESSION['row1'];
$col1 = $_SESSION['col1'];
$row2 = $_SESSION['row2'];
$col2 = $_SESSION['col2']; 

function multiply(&$mat1, &$mat2, &$res, &$row1, &$col1)
{
    for ($i = 0; $i < $row1; $i++)
    {
        for ($j = 0; $j < $row1; $j++)
        {
            $res[$i][$j] = 0;
            for ($k = 0; $k < $col1; $k++)
                $res[$i][$j] += $mat1[$i][$k] * $mat2[$k][$j];
        }
    }
}
                                    

$mat1= array(array());
    
$mat2 = array(array());

if(isset($_POST['submit'])){

    for ($i = 0; $i < $row1; $i++){
        for($j = 0; $j < $col1; $j++){
            $mat1[$i][$j]=$_POST['matrix1'.$i.$j];
        }
    }
    for ($i = 0; $i < $row2; $i++){
        for($j = 0; $j < $col2; $j++){
            $mat2[$i][$j]=$_POST['matrix2'.$i.$j];
        }
    }
    
multiply($mat1, $mat2, $res, $row1, $col1);

echo "<center>";
echo "<pre>";

//print array
echo ("First matrix is \n");
for ($i = 0; $i < $row1; $i++)
{
    for ($j = 0; $j < $col1; $j++)
    {
        echo ($mat1[$i][$j]);
        echo(" ");
    }
    echo ("\n");
}

echo ("Second matrix is \n");
for ($i = 0; $i < $row2; $i++)
{
    for ($j = 0; $j < $col2; $j++)
    {
        echo ($mat2[$i][$j]);
        echo(" ");
    }
    echo ("\n");
}

echo ("Result matrix is \n");
for ($i = 0; $i < $row1; $i++)
{
    for ($j = 0; $j < $row1; $j++)
    {
        echo ($res[$i][$j]);
        echo(" ");
    }
    echo ("\n");
}
echo"</pre>";
echo "<a style='text-decoration : none'; href=test.html>Go Back To Input Row and Col</a></center>";
}
?>