<section>
  <h2>reservations</h2>
  <!-- <?php debuguear($myReservations[0]) ?> -->
  <div class="my-reservations-container">

    <?php foreach ($myReservations as $myReservation): ?>
      <article id="<?= $myReservation['id'] ?>">
        <p>
          <span>total a pagar :<strong><?= $myReservation['total_pay'] ?></strong></span>
        </p>
        <p><span>horas rentadas :<strong><?= $myReservation['rental_time'] ?></strong></span>
        </p>
        <p><span>hora de inicio :<strong><?= $myReservation['start_time'] ?></strong></span></p>
        <p><span>hora de finalizacion :<strong><?= $myReservation['end_time'] ?></strong></span></p>
        <p> <span>fecha de alquiler :<strong><?= $myReservation['rental_date'] ?></strong></span></p>
        <p><span>campo deportivo :<strong><?= $myReservation['field_name'] ?></strong></span>
        </p>
        <p><span>precio de alquiler :<strong><?= $myReservation['rental_price'] ?></strong></span>
        </p>
        <p><span>tipo de campo :<strong><?= $myReservation['type_field'] ?></strong></span></p>
        <p><span>nombre sucursal :<strong><?= $myReservation['branch_name'] ?></strong></span></p>
        <p><span>direccion :<strong><?= $myReservation['address'] ?></strong></span></p>

        <div>
          <?php
          $result = campareDate($myReservation['rental_date']);
          ?>

          <form action="/profile/delete-reservation" method="POST">
            <input type="hidden" name="id" value="<?= $myReservation['id'] ?>">
            <input type="submit" value="eliminar reserva">
          </form>
        </div>

        <button
          <?php if ($result): ?>
          disabled
          <?php endif; ?>>
          <!-- CONTINUAR AQUI -->
          <a href="/field?id=<?= $myReservation['field_id'] ?>">editar reserva</a>
        </button>

      </article>
      <br />
    <?php endforeach; ?>

  </div>
</section>