<!DOCTYPE HTML>
<head lang="en">
<link rel="stylesheet" href="assets/stylesheet.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<title>Results</title>

<?php
$hideDebug = true;

require 'calculate.php';

$leftPart = $sunPosition['left'] / $sunPosition['total'];
$rightPart = $sunPosition['right'] / $sunPosition['total'];

$duration = round($sunPosition['total'] / 3600, 1);
$leftDuration = round($sunPosition['left'] / 3600, 1);
$rightDuration = round($sunPosition['right'] / 3600, 1);

$minDiff = 0.1;
if ($leftPart < $minDiff && $rightPart < $minDiff) {
    $x = 'nosun';
} else if ($leftPart > $rightPart + $minDiff) {
    $x = 'sunleft';
} else if ($rightPart > $leftPart + $minDiff) {
    $x = 'sunright';
} else {
    $x = 'both_side_sun';
}

$e = '';
$f = '';
if ($x == 'nosun')
{
    $a = "cloudy.jpg";
    $b = "Enjoy your window seat as the Sun will not annoy you!";
    $c = "blue";
    $d = "whiteup";
}
else if ($x == 'sunright')
{
    $a = "sunback4.jpg";
    $b = "The Sun will be mostly at the right. Enjoy your window seat at the left!";
    $c = "orange";
    $d = "sunright";
    $e = "leftseater.gif";
    $f = "leftseater";
}
else if ($x == 'sunleft')
{
    $a = "sunleft.jpg";
    $b = "The Sun will be mostly at the left. Enjoy your window seat at the right!";
    $c = "orange";
    $d = "sunleft";
    $e = "rightseater.gif";
    $f = "rightseater";
}
else if ($x == 'both_side_sun')
{
    $a = "sun.jpg";
    $b = "The Sun will be on Both the sides";
    $c = "white";
    $d = "bothsun";
}
?>

<body background="assets/<?php echo $a; ?>"> 
<center>
    <div class=<?php echo $d; ?>>
        <center><h3><font face="verdana" color=<?php echo $c; ?>> <?php echo $b; ?></font> </h3> </center>

        <table width="100%">
            <tr>
                <td style="width: 310px; padding-left: 10px"><?php echo $flight->getStartAirport() ?></td>
                <td style="width: 50px; text-align: center">&#8594;</td>
                <td style="width: 210px; text-align: center"><b> Flight Duration: <?php echo $duration ?> hrs </b></td>
                <td style="width: 50px; text-align: center">&#8594;</td>
                <td style="width: 310px; text-align: right; padding-right: 10px"><?php echo $flight->getDestAirport() ?></td>
            </tr>
        </table>
    </div>   
</center>




<img src="assets/aircraft1.png" id="aircraft" width=580 height=580>
<img src="assets/anifire21.gif" width=50 height=50 id="fire">
<div class="leftpanel">
    Left side:<br>
    <?php echo $leftDuration ?> 
    hrs sunny<br>
    <?php echo round($leftPart*100) ?>% of total 
</div>
<div class="rightpanel">
    Right side:<br>
    <?php echo $rightDuration ?> 
    hrs sunny<br>
    <?php echo round($rightPart*100) ?>% of total 
</div>
<?php
if ($x != 'nosun' && $x != 'both_side_sun')
{
    ?>
    <img src="assets/<?php echo $e; ?>" width=250 height=330 id=<?php echo $f; ?>>
    <?php
}
?>

</body>
