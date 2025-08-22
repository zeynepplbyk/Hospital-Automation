<?php
$start_hour = 8;
$end_hour = 16;

$options = "";
for ($hour = $start_hour; $hour <= $end_hour; $hour++) {
    for ($minute = 0; $minute < 60; $minute += 10) {
        $time = sprintf("%02d:%02d", $hour, $minute);
        $options .= "<option value='$time'>$time</option>";
    }
}

echo $options;
?>
