<?php
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

deslogar();
redirecionar('view/LoginView.php');
