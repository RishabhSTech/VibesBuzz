<?php
// Path to the text file that stores the hit count
$counterFile = 'counter.txt';

// Check if the file exists, if not create it and initialize to 0
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, '0');
}

// Read the current count
$count = (int) file_get_contents($counterFile);

// Increment the count
$count++;

// Write the new count back to the file
file_put_contents($counterFile, (string) $count);

// Output the count (for the script to display on the webpage)
echo $count;
?>
