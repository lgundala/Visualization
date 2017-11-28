
<?php
$file  = fopen('FebExternal.csv', 'r');
// You can use an array to store your search words, makes things more flexible.
// Supports any number of search words.

$words = array('XX','Donald');    
// Make the search words safe to use in regex (escapes special characters)
$words = array_map('preg_quote', $words);
// The argument becomes '/wii|guitar/i', which means 'wii or guitar, case-insensitive'
$regex = '/'.implode('|', $words).'/i';
$bad_symbols = array(",", ".");
$line = fgetcsv($file);
list($curr,$n) = $line;
echo "<tr>";
        foreach ($line as $cell) {
                echo "<th>" . htmlspecialchars($cell) . "</th>";
        }
        echo "</tr>\n";
while (($line = fgetcsv($file)) !== FALSE) { 
    list($curr,$n) = $line;
    if(preg_match($regex, $curr)) {
            $n = number_format($n);
       $n = str_replace($bad_symbols, "", $n);
       echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
// echo "$curr,$n<br />\n";
    }
}

?>
