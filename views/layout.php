<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href='/styles.css'>
</head>

<body>
  <header>
    <div>
      <span>
        <a href="/">logo empresa</a>
      </span>
    </div>
    <nav>
      <a href="/about">nosotros</a>
      <a href="/fields">alquileres</a>
      <a href="/blog">blog</a>
      <a href="/login">inicia session</a>
    </nav>
  </header>


  <main>
    <?php require_once $url; ?>
  </main>

  <footer>
    Copyright @2025 - Todos los derechos reservados
  </footer>

</body>

</html>