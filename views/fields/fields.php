<section class="fields-page-container">

  <!-- <?php debuguear($profile); ?> -->
  <aside class="aside-fields-page">
    <form class="form" action="">
      <label for="type">filtrar por deporte</label>
      <select class="type select" name="type" id="type">
        <option value="">---</option>
        <?php foreach ($types as $type): ?>
          <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
        <?php endforeach; ?>
      </select>

      <label for="district">filtrar por distrito</label>
      <select class="district select" name="district" id="district">
        <option value="">---</option>
        <?php foreach ($districts as $district): ?>
          <option value="<?= $district['id'] ?>"><?= $district['name'] ?></option>
        <?php endforeach; ?>
      </select>

      <!-- <br> -->
      <input class="filtrar " type="submit" value="filtrar" disabled>
      <input class="limpiar " type="submit" value="limpiar" disabled>

    </form>

    <?php if ($isAdmin === 'profile'): ?>

      <a href="/profile/create-field" class="admin-link">crear nuevo campo</a>

    <?php endif; ?>
  </aside>

  <section class="section-fields-page">
    <h2>Alquileres</h2>

    <div class="fields-container">

    </div>
  </section>




  <?php
  $script = "<script src='/build/js/fields.js'></script>";
  ?>
  <!--  <img src="/build/img/estadio.webp" alt=""> -->

</section>