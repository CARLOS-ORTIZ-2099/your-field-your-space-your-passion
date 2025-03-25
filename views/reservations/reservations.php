<section class="reservations-page">
  <h2 class="reservations-title">Mis Reservas</h2>

  <div class="reservations-container">
    <?php foreach ($myReservations as $myReservation): ?>
      <article class="reservation-card" id="<?= $myReservation['id'] ?>">
        <div class="reservation-details">
          <p><span>Total a pagar:</span> <strong><?= $myReservation['total_pay'] ?></strong></p>
          <p><span>Horas rentadas:</span> <strong><?= $myReservation['rental_time'] ?></strong></p>
          <p><span>Hora de inicio:</span> <strong><?= $myReservation['start_time'] ?></strong></p>
          <p><span>Hora de finalización:</span> <strong><?= $myReservation['end_time'] ?></strong></p>
          <p><span>Fecha de alquiler:</span> <strong><?= $myReservation['rental_date'] ?></strong></p>
          <p><span>Campo deportivo:</span> <strong><?= $myReservation['field_name'] ?></strong></p>
          <p><span>Precio de alquiler:</span> <strong><?= $myReservation['rental_price'] ?></strong></p>
          <p><span>Tipo de campo:</span> <strong><?= $myReservation['type_field'] ?></strong></p>
          <p><span>Nombre sucursal:</span> <strong><?= $myReservation['branch_name'] ?></strong></p>
          <p><span>Dirección:</span> <strong><?= $myReservation['address'] ?></strong></p>
        </div>

        <div class="reservation-actions">
          <?php $result = campareDate($myReservation['rental_date']); ?>

          <form action="/profile/delete-reservation" method="POST">
            <input type="hidden" name="id" value="<?= $myReservation['id'] ?>">
            <input type="submit" value="Eliminar Reserva" class="btn btn-delete">
          </form>

          <?php if ($result): ?>
            <a href="/field?id=<?= $myReservation['field_id'] ?>&edit=<?= $myReservation['id'] ?>" class="btn btn-edit">Editar Reserva</a>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>