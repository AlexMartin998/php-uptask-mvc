<?php

/* 
function printAlertMessage($mensaje, $key)

  echo '<div class="alert ' . $key. '">' . $mensaje . '</div>';
}

// 
*/

foreach ($alerts as $key => $alert) :
  foreach ($alert as $message) :

?>

    <div class="alert <?php echo $key; ?>">
      <?php echo $message ?>
    </div>


<?php
  endforeach;
endforeach;

?>