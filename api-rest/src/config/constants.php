<?php

// Carga util de jwt
define('ISS', 'localhost'); //Dominio emisor (opcional)
define('AUD', 'CLIENTS'); // Audiencia (opcional)
define('IAT', time()); // Momento en el que se emitió (opcional)
define('NBF', time() + 1); // Debe ser posterior a la fecha actual (opcional)
define('EXP', time() + 604800); // Tiempo de expiración que se suma en segundos (opcional)

// Status Codes
define('SUCCESS_RESPONSE', 200);
define('ACCESS_DENIED', 401);
define('BAD_REQUEST', 400);
define('FORBIDDEN', 403);


?>
