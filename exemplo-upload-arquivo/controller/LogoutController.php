<?php
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';
require_once __DIR__ . '/../components/FashComponent.php';

deslogar();
setFlash('sucesso', 'Deslogado com sucesso');
redirecionar();
