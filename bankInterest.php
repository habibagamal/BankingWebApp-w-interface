<?php
require ('db.php');

echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

if ($conn)
  echo "connected"; 

echo ini_get('display_errors');

// delimiter |


CREATE EVENT e_call_myproc
    ON SCHEDULE
      AT CURRENT_TIMESTAMP + INTERVAL 1 DAY
    DO CALL myproc(5, 27);
?>
//       END |

// delimiter ;