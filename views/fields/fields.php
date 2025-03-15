<section>
  <!-- <?php debuguear($profile); ?> -->
  <aside>
    <form class="form" action="">

      <label for="deport">filtrar por deporte</label>
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

      <br>
      <input class="filtrar " type="submit" value="filtrar" disabled>
      <input class="limpiar " type="submit" value="limpiar" disabled>

    </form>
  </aside>

  <h2>Alquileres</h2>

  <div class="fields-container">

  </div>
  <?php if ($isAdmin === 'profile'): ?>
    <div>
      <br><br><br>
      <a href="/profile/create-field" class="admin-link">crear nuevo campo</a>
    </div>

  <?php endif; ?>

  <?php
  $script = "<script src='/build/js/fields.js'></script>";
  ?>

</section>