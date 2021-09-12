<?php

use Engine\Application\Common;

return [
    'host' => Common::protocol() . '://' . $_SERVER['SERVER_NAME'] . '/',
];
