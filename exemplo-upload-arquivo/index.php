<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="Upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="foto-perfil">
<!--        <input type="file" accept="image/*" name="foto-perfil">-->
        <input type="text" name="titulo">

        <button> Enviar imagem</button>
    </form>
</body>
</html>