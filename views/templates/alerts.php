<?php
    foreach($alerts as $key => $alert) {
        foreach($alert as $message) {
?>
    <div class="alert alert__<?php echo $key; ?> z-0 mb-0 p-0"><?php echo $message; ?></div>
<?php
        }
    }

?>