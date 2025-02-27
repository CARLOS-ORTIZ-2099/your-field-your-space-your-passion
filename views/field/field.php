<!-- <?= debuguear($field); ?> -->
<!-- <?php debuguear($_SESSION); ?> -->
<section>
  <h1><?= $field['name'] ?></h1>
  <div>
    <img src="<?= '/images/estadio.webp' ?>" alt="">
  </div>

  <div>
    <h2>informacion del la loza <?= $field['name'] ?></h2>
    <p>- precio X hora :<strong><?= $field['rental_price'] ?>$</strong></p>
    <p>- sucursal : <strong><?= $field['nombre_sucursal'] ?></strong></p>
    <p>- direccion : <strong><?= $field['address'] ?></strong></p>
    <p>- distrito : <strong><?= $field['distrito'] ?></strong></p>
    <p>- tipo de loza : <strong><?= $field['tipo_cancha'] ?></strong></p>
    <p>- abrimos : <strong><?= $field['opening_hours'] ?> am</strong></p>
    <p>- cerramos : <strong><?= $field['closing_time'] ?> pm</strong></p>
  </div>


  <?php if ($id): ?>
    <!-- seccion de reserva -->
    <div>
      <?php
      $fechaMax = new DateTime();
      $fechaMax->modify("+1 year");
      $fechaMax = $fechaMax->format("Y-m-d");
      ?>


      <h2>has tu reserva AQUI</h2>
      <!-- seleccionar fecha -->
      <label for="date">elige tu fecha</label>
      <input class="date" id="date" type="date" min="<?= date('Y-m-d') ?>" max="<?= $fechaMax ?>">

      <!-- seleccionar cantidad de horas -->
      <label for="hours">elige la cantidad de horas</label>
      <select class="quantity-hours" name="hours" id="hours">
        <option value="">---</option>
        <!-- aqui podriamos hacer que la tabla de fields tenga un campo 
           "maximo de horas a alquilar en vez de darle valores quemados" 
      -->
        <option value="<?= $field['rental_price'] ?>-1">1 hora (<?= $field['rental_price'] * 1 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-2">2 horas (<?= $field['rental_price'] * 2 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-3">3 horas (<?= $field['rental_price'] * 3 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-4">4 horas (<?= $field['rental_price'] * 4 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-5">5 horas (<?= $field['rental_price'] * 5 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-6">6 horas (<?= $field['rental_price'] * 6 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-7">7 horas (<?= $field['rental_price'] * 7 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-8">8 horas (<?= $field['rental_price'] * 8 ?>$)</option>
        <option value="<?= $field['rental_price'] ?>-9">9 horas (<?= $field['rental_price'] * 9 ?>$)</option>
      </select>

      <input type="hidden" id="user-id" value="<?= $id ?>">
      <input type="hidden" id="opening_hours" value="<?= substr($field['opening_hours'], 0, 2) ?>">
      <input type="hidden" id="closing_time" value="<?= substr($field['closing_time'], 0, 2) ?>">



      <!-- AQUI VAN LAS HORAS DISPONIBLES ESTAS VENDRAN DE LA BASE DEL BACKEND -->
      <div class="free-hours-container">


      </div>


      <button class="hidden button-reservation">generar reserva</button>

    </div>
    <?php
    $script = "<script src='js/field.js'></script>";
    ?>
  <?php else : ?>
    <h2>para hacer una reserva debes loguearte</h2>
  <?php endif; ?>



</section>