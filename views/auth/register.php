<section class="form-page-auth">

  <div class="container-page-auth">
    <h2>crea tu cuenta </h2>
    <!--  <?php debuguear($user); ?> -->
    <span class="error-message"><?= $errors['badrequest'] ?? '' ?></span>
    <span class="success-message"><?= $info['success'] ?? '' ?></span>

    <div class="form-container">
      <form action="/register" method="POST" novalidate>
        <label for="name">your name</label>
        <input type="text" id="name" name="name" value="<?= $user['name'] ?? '' ?>">
        <span class="error-message"><?= $errors['name'] ?? '' ?></span>

        <label for="last_name">your last_name</label>
        <input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?? '' ?>">

        <span class="error-message"><?= $errors['last_name'] ?? '' ?></span>


        <label for="email">your email</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>">

        <span class="error-message"><?= $errors['email'] ?? '' ?></span>


        <label for="password">your password</label>
        <input type="password" id="password" name="password" value="<?= $user['password'] ?? '' ?>">

        <span class="error-message"><?= $errors['password'] ?? '' ?></span>


        <input type="submit" value="enviar">


      </form>
      <a href="/login">ya tienes una cuenta ? incia sesion</a>
    </div>


  </div>

</section>