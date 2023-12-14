<!-- FILEPATH: /c:/xampp/htdocs/SafeSave/Vista/login.html -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');
</style>

<!DOCTYPE html>
<html lang = "es">
<head>
  <meta charset="UTF-8">
  <link href='styles/style_login.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Iconos -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <!-- Fuente Poppins -->
  <link href='https://fontawesome.com/icons/user?f=classic&s=solid' rel='stylesheet'>
  <link href='https://fontawesome.com/icons/lock?f=classic&s=solid' rel='stylesheet'>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
    <form action="validar/validar_login.php" method="post">
      <h1> Sistema de Almacén </h1>
      <div class="input-container">
        <i class="fas fa-user"></i>
          <p>Usuario: <input type="text" name="usuario" placeholder="Usuario"></p>
      </div>
      <div class="input-container">
        <i class="fas fa-lock"></i>
      <p>Contraseña: <input type="password" name="contraseña" placeholder="Contraseña"></p>
      </div>
      <input type="submit" value="Ingresar">
    </form>
  </body>

  
</html>


