<?php


//Error Messages
echo '<div class="alert alert-danger"><ul>';
foreach (app()->messages('error') as $error) {
    echo '<li>'. $error .'</li>';
}
echo '</ul></div>';

//Warning Messages
echo '<div class="alert alert-info"><ul>';
foreach (app()->messages('info') as $warning) {
    echo '<li>'. $warning .'</li>';
}
echo '</ul></div>';

//Info Messages
echo '<div class="alert alert-warning"><ul>';
foreach (app()->messages('warning') as $info) {
    echo '<li>'. $info .'</li>';
}
echo '</ul></div>';

//Success Messages
echo '<div class="alert alert-success"><ul>';
foreach (app()->messages('success') as $success) {
    echo '<li>'. $success .'</li>';
}
echo '</ul></div>';
