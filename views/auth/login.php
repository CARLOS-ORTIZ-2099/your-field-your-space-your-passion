<section>
  <h2>inicia sesion</h2>
  <?= $errors['badrequest'] ?? '' ?>
  <!--  <?= $errors['passwordBad'] ?? '' ?> -->
  <!--   <?= debuguear($user); ?>
  <?= debuguear($errors); ?> -->

  <form action="/login" method="POST">
    <label for="email">your email</label>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>">

    <?= $errors['email'] ?? '' ?>

    <label for="password">your password</label>
    <input type="password" id="password" name="password" value="<?= $user['password'] ?? '' ?>">

    <?= $errors['password'] ?? '' ?>

    <input type="submit" value="entrar">

  </form>
  <a href="/register">no tienes una cuenta ? crea una</a>
</section>