<section>
  <h2>inicia sesion</h2>
  <?= $errores['notFound'] ?? '' ?>
  <?= $errores['passwordBad'] ?? '' ?>
  <!--   <?= debuguear($user); ?>
  <?= debuguear($errores); ?> -->

  <form action="/login" method="POST">
    <label for="email">your email</label>
    <input type="email" id="email" name="email" value="<?= $user->email ?? '' ?>">

    <?= $errores['email'] ?? '' ?>

    <label for="password">your password</label>
    <input type="password" id="password" name="password" value="<?= $user->password ?? '' ?>">

    <?= $errores['password'] ?? '' ?>

    <input type="submit" value="entrar">

  </form>
  <a href="/register">no tienes una cuenta ? crea una</a>
</section>