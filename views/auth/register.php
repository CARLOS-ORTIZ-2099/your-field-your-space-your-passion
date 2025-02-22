<section>
  <h2>crea tu cuenta </h2>
  <!--  <?php

        debuguear($user); ?> -->
  <?= $errors['badrequest'] ?? '' ?>
  <?= $info['success'] ?? '' ?>

  <form action="/register" method="POST">
    <label for="name">your name</label>
    <input type="text" id="name" name="name" value="<?= $user['name'] ?? '' ?>">
    <?= $errors['name'] ?? '' ?>
    <br>
    <label for="last_name">your last_name</label>
    <input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?? '' ?>">
    <?= $errors['last_name'] ?? '' ?>
    <br>
    <label for="email">your email</label>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>">
    <?= $errors['email'] ?? '' ?>
    <br>
    <label for="password">your password</label>
    <input type="password" id="password" name="password" value="<?= $user['password'] ?? '' ?>">
    <?= $errors['password'] ?? '' ?>
    <br>

    <input type="submit" value="enviar">


  </form>
  <a href="/login">ya tienes una cuenta ? incia sesion</a>
</section>