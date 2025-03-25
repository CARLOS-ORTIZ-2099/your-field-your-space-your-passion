<!-- <section>
  <h2>este es mi perfil</h2>

  <div>name : <strong><?= $_SESSION['user']['name']  ?></strong></div>
  <div>lastname : <strong><?= $_SESSION['user']['lastname']  ?></strong></div>
  <div>email : <strong><?= $_SESSION['user']['email']  ?></strong></div>
</section> -->

<section class="profile">
  <h2 class="profile-title">Este es mi perfil</h2>

  <div class="profile-info">
    <p><span>Nombre:</span> <strong><?= $_SESSION['user']['name'] ?></strong></p>
    <p><span>Apellido:</span> <strong><?= $_SESSION['user']['lastname'] ?></strong></p>
    <p><span>Email:</span> <strong><?= $_SESSION['user']['email'] ?></strong></p>
  </div>
</section>