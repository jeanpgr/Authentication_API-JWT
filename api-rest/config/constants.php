<?php

// Carga util de jwt
define('ISS', 'localhost'); // dominio emisor (opcional)
define('AUD', 'CLIENTS'); // audiencia (opcional)
define('IAT', time()); // momento en el que se emiitio (opcional)
define('NBF', time() + 1); // debe ser posterios a la fecha actual (opcional)
define('EXP', time() + 604800); // tiempo de expiracion se suma en segundos (opcional)

// Status Codes
define('SUCCESS_RESPONSE', 200);
define('ACCESS_DENIED', 401);
define('BAD_REQUEST', 400);
define('FORBIDDEN', 403);


?>