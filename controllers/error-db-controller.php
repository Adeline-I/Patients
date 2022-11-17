<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');

$error = intval(filter_input(INPUT_GET, 'error', FILTER_SANITIZE_NUMBER_INT));

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/error-db.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
