<!-- <?= debuguear($field); ?> -->
<!-- <?php debuguear($_SESSION); ?> -->
<!-- <?php debuguear($reservation); ?> -->
<!-- <?php debuguear($reservationId); ?> -->
<!-- pagina con la informacion de la reserva -->

<section class="reservation-container">

  <div class="field-container">
    <h1 class="reservation-title"><?= $field['name'] ?></h1>

    <div class="reservation-image">
      <img src="<?= '/uploads/' . $field['image'] ?>" alt="imagen del campo">
    </div>

    <div class="reservation-info">
      <h2 class="info-title">Información de la loza <?= $field['name'] ?></h2>
      <p>- Precio por hora: <strong><?= $field['rental_price'] ?>$</strong></p>
      <p>- Sucursal: <strong><?= $field['nombre_sucursal'] ?></strong></p>
      <p>- Dirección: <strong><?= $field['address'] ?></strong></p>
      <p>- Distrito: <strong><?= $field['distrito'] ?></strong></p>
      <p>- Tipo de loza: <strong><?= $field['tipo_cancha'] ?></strong></p>
      <p>- Abrimos: <strong><?= $field['opening_hours'] ?> <?= checkShift($field['opening_hours']) ?></strong></p>
      <p>- Cerramos: <strong><?= $field['closing_time'] ?> <?= checkShift($field['closing_time']) ?></strong></p>
    </div>

    <!-- seccion de reserva -->
    <?php if ($id): ?>
      <!-- seccion de reserva -->
      <div class="reservation-form">
        <?php
        $fechaMax = new DateTime();
        $fechaMax->modify("+1 year");
        $fechaMax = $fechaMax->format("Y-m-d");
        ?>

        <h2 class="form-title">
          <?= $reservation ? "Edita tu reserva aquí" : "Haz tu reserva aquí" ?>
        </h2>

        <!-- seleccionar fecha -->
        <label for="date">Elige tu fecha</label>
        <input class="form-input date" id="date" type="date" min="<?= date('Y-m-d') ?>" max="<?= $fechaMax ?>" value="<?= $reservation ? $reservation['rental_date'] : "" ?>">

        <!-- seleccionar cantidad de horas -->
        <?php $quantityHours = 9; ?>
        <label for="hours">elige la cantidad de horas</label>
        <select class="form-select quantity-hours" name="hours" id="hours">
          <option
            <?= $reservation ? "disabled" : "" ?>
            value="">
            ---
          </option>

          <?php for ($init = 1; $init <= $quantityHours; $init++): ?>
            <option
              value="<?= $field['rental_price'] ?>-<?= $init ?>"
              <?php if ($reservation && $init == $reservation['rental_time']): ?>
              selected
              <?php elseif ($reservation && $init !=  $reservation['rental_time']): ?>
              disabled
              <?php endif; ?>>

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

        <button class="button-reservation hidden">
          <?= $reservation ? "Editar reserva" : "Generar reserva" ?>
        </button>

        <!--  formulario para eliminar reserva -->
        <?php if ($isAdmin && !$reservationId): ?>
          <form action="/profile/delete-field" method="POST">
            <input type="hidden" name="id" value="<?= $field['id'] ?>">
            <input class="form-button delete-button" type="submit" value="Eliminar campo deportivo">
          </form>
          <a class="edit-link" href="/profile/edit-field?id=<?= $field['id'] ?>">Editar campo deportivo</a>
        <?php endif; ?>
      </div>

      <?php
      $script = "<script src='build/js/field.js'></script>";
      ?>

    <?php else : ?>
      <h2 class="login-message"> para hacer una reserva debes loguearte</h2>
    <?php endif; ?>

  </div>


</section>