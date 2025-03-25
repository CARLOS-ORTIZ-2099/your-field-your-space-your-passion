<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!--  <link rel="stylesheet" href='/styles.css'> -->
  <link rel="stylesheet" href='/build/css/app.css'>
</head>

<body>
  <header class="header">
    <div class="logo-container">
      <span>
        <a href="/">
          <img src="/build/img/logo.svg" width="70px" alt="logo">
        </a>
      </span>
    </div>

    <div class="menu-hidden">
      <img
        src="/build/img/menu.svg"
        alt="menu-movil"
        width="40px">
    </div>

    <?php $urlNew = checkUserPath(); ?>
    <?php

    if ($urlNew[0] === 'profile'): ?>
      <?php require_once __DIR__ . '/template/nav-profile.php' ?>
    <?php else: ?>
      <nav>
        <a href="/aboutUs">about us</a>
        <a href="/fields">fields</a>
        <a href="/blog">blog</a>
        <?php if (isset($_SESSION['user'])) : ?>
          <a href="/profile"><?= 'hola' . ' ' . $_SESSION['user']['name'] ?></a>
          <a href="/logout">logout</a>
        <?php else : ?>
          <a href='/login'>login</a>
        <?php endif; ?>

      </nav>
    <?php endif; ?>


  </header>


  <main>
    <?php require_once $url; ?>
  </main>

  <footer>
    Copyright @2025 - Todos los derechos reservados
  </footer>

  <?php echo $script ?? null; ?>
</body>

</html>