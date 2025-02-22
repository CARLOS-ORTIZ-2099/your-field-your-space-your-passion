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
    <?php $urlpath = $_SERVER['PATH_INFO'] ?? '/'; ?>
    <?php if ($urlpath === '/profile'): ?>
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

</body>

</html>