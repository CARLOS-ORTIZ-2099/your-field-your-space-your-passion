<?php $row = $data->fetch_assoc(); ?>
<?= debuguear($row); ?>

<section>
  <h1><?= $row['name'] ?></h1>
  <div>
    <img src="<?= '/images/estadio.webp' ?>" alt="">
  </div>

  <div>
    <h2>informacion del la loza <?= $row['name'] ?></h2>
    <p>- precio X hora :<strong><?= $row['rental_price'] ?>$</strong></p>
    <p>- sucursal : <strong><?= $row['nombre_sucursal'] ?></strong></p>
    <p>- direccion : <strong><?= $row['address'] ?></strong></p>
    <p>- distrito : <strong><?= $row['distrito'] ?></strong></p>
    <p>- tipo de loza : <strong><?= $row['tipo_cancha'] ?></strong></p>
  </div>


  <div>
    <?php
    $fechaMax = new DateTime();
    $fechaMax->modify("+1 year");
    $fechaMax = $fechaMax->format("Y-m-d");
    ?>
    <h2>has tu reserva AQUI</h2>
    <label for="date">elige tu fecha</label>
    <input id="date" type="date" min="<?= date('Y-m-d') ?>" max="<?= $fechaMax ?>">

    <label for="hours">elige la cantidad de horas</label>
    <select name="hours" id="hours">
      <option value="">---</option>
      <!-- aqui podriamos hacer que la tabla de fields tenga un campo 
           "maximo de horas a alquilar en vez de darle valores quemados" 
      -->
      <option value="">1 hora (<?= $row['rental_price'] * 1 ?>$)</option>
      <option value="">2 horas (<?= $row['rental_price'] * 2 ?>$)</option>
      <option value="">3 horas (<?= $row['rental_price'] * 3 ?>$)</option>
      <option value="">4 horas (<?= $row['rental_price'] * 4 ?>$)</option>
      <option value="">5 horas (<?= $row['rental_price'] * 5 ?>$)</option>
    </select>

    <h2>aqui van las horas disponibles que tiene esta sucursal</h2>
    <label for="time">elige la hora para alquilar</label>
    <?php
    // horas desde que abre hasta que cierra la sucursal
    $hours = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22];
    // arreglo de horas reservadas
    $horasOcupadas = [
      10 => 13,
      14 => 15,
      15 => 16,
      20 => 22
    ];

    /* aqui lo que hacemos es que comprobamos si el arreglod e horas ocupadas esta la hora que estamos iterando actualmente si es asi slatamos tantas posiciones como la diferencia de las hora de incio y fin esto para que el usuario no pueda seleccionar horas ya reservadas */
    $init = 0;
    while ($init < count($hours)) {
      if (array_key_exists($hours[$init], $horasOcupadas)) {
        $substract = $horasOcupadas[$hours[$init]] - $hours[$init];
        debuguear($substract);
        $init += $substract;
        continue;
      }
      //debuguear($hours[$init]);
      echo '<br/> <button>' . $hours[$init] . '</button> <br/>';
      $init++;
    }

    ?>
  </div>

</section>