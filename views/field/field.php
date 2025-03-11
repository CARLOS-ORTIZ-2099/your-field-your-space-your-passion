<!-- <?= debuguear($field); ?> -->
<!-- <?php debuguear($_SESSION); ?> -->
<!-- <?php debuguear($reservation); ?> -->
<!-- <?php debuguear($reservationId); ?> -->

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
    <p>- abrimos : <strong><?= $field['opening_hours'] ?> <?= checkShift($field['opening_hours']) ?></strong></p>
    <p>- cerramos : <strong><?= $field['closing_time'] ?> <?= checkShift($field['opening_hours']) ?></strong></p>
  </div>


  <?php if ($id): ?>
    <!-- seccion de reserva -->
    <div>
      <?php
      $fechaMax = new DateTime();
      $fechaMax->modify("+1 year");
      $fechaMax = $fechaMax->format("Y-m-d");
      ?>


      <h2><?= $reservation ? "edita tu reserva AQUI" : "has tu reserva AQUI" ?></h2>
      <!-- seleccionar fecha -->
      <label for="date">elige tu fecha</label>
      <input class="date" id="date" type="date" min="<?= date('Y-m-d') ?>" max="<?= $fechaMax ?>" value="<?= $reservation ? $reservation['rental_date'] : "" ?>">

      <!-- seleccionar cantidad de horas -->
      <?php $quantityHours = 9; ?>
      <label for="hours">elige la cantidad de horas</label>
      <select class="quantity-hours" name="hours" id="hours">
        <option
          <?php
          if ($reservation): ?>
          disabled
          <?php endif; ?>
          value="">
          ---
        </option>
        <?php for ($init = 1; $init <= $quantityHours; $init++): ?>
          <option
            <?php if ($reservation && $init == $reservation['rental_time']): ?>
            selected
            <?php elseif ($reservation && $init !=  $reservation['rental_time']): ?>
            disabled
            <?php endif; ?>
            value="<?= $field['rental_price'] ?>-<?= $init ?>">

            <?= $init >= 2 ? "$init horas" : " $init hora"; ?> (<?= $field['rental_price'] * $init ?>$)

          </option>
        <?php endfor; ?>

      </select>

      <input type="hidden" id="user-id" value="<?= $id ?>">
      <input type="hidden" id="opening_hours" value="<?= substr($field['opening_hours'], 0, 2) ?>">
      <input type="hidden" id="closing_time" value="<?= substr($field['closing_time'], 0, 2) ?>">



      <!-- AQUI VAN LAS HORAS DISPONIBLES ESTAS VENDRAN DE LA BASE DEL BACKEND -->
      <div class="free-hours-container">


      </div>


      <button class="hidden button-reservation">generar reserva</button>

      <!-- <?php debuguear($isAdmin) ?> -->
      <?php if ($isAdmin && !$reservationId): ?>
        <form action="/profile/delete-field" method="POST">
          <input type="hidden" name="id" value="<?= $field['id'] ?>">
          <input type="submit" value="eliminar campo deportivo">
        </form>
        <br>
        <a href="/profile/edit-field?id=<?= $field['id'] ?>">editar campo deportivo</a>
      <?php endif; ?>
    </div>
    <?php
    $script = "<script src='js/field.js'></script>";
    ?>
  <?php else : ?>
    <h2> para hacer una reserva debes loguearte</h2>
  <?php endif; ?>



</section>