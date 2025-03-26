<section class="form-page-auth">
  <div class="container-page-auth">
    <h2>inicia sesion</h2>
    <span class="error-message"><?= $errors['badrequest'] ?? '' ?></span>
    <!--  <?= $errors['passwordBad'] ?? '' ?> -->
    <!--   <?= debuguear($user); ?>
    <?= debuguear($errors); ?> -->

    <div class="form-container">
      <form action="/login" method="POST">
        <label for="email">your email</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>">

        <span class="error-message"><?= $errors['email'] ?? '' ?></span>

        <label for="password">your password</label>
        <input type="password" id="password" name="password" value="<?= $user['password'] ?? '' ?>">

        <span class="error-message"><?= $errors['password'] ?? '' ?></span>


        <input type="submit" value="entrar">

      </form>
      <a href="/register">no tienes una cuenta ? crea una</a>
    </div>
  </div>
</section>