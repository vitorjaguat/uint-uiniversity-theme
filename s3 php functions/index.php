<!-- <h1><?php blogInfo('name'); ?></h1>
<h3><?php blogInfo('description'); ?></h3>

<?php
function greet($name, $color)
{
    echo "<p>Hi, my name is $name and my favorite color is $color.</p>";
}
greet('John', 'green');
greet('Jane', 'red');
?> -->

<?php
$myName = "Jaguat";
$names = array("John", "Jane", "Brad", "Asha");

$count = 0;

// while($count <= 10) {
//     echo "<li>$count</li>";
//     $count++;
// }

while ($count < count($names)) {
    echo "<li>Hi, my name is $names[$count].</li>";
    $count++;
}
?>
<p>Hi, my name is <?php echo $myName; ?>.</p>
<p>Hi, my name is <?php echo $names[0] ?>, her name is <?php echo $names[1] ?> and his name is <?php echo $names[2]; ?>.</p>

<li>

</li>