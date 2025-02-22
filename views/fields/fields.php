<section>


  <aside>

    <form action="">
      <label for="deport">filtrar por deporte</label>
      <select name="type" id="type">
        <option value="">---</option>
        <option value="1">futbol</option>
        <option value="2">voley</option>
        <option value="3">basquet</option>
        <option value="4">tenis</option>
      </select>

      <label for="district">filtrar por distrito</label>
      <select name="district" id="district">
        <option value="">---</option>
        <option value="1">miraflores</option>
        <option value="2">surco</option>
        <option value="3">la molina</option>
        <option value="4">chorrillos</option>
        <option value="5">san borja</option>
        <option value="6">san juan de miraflores</option>
      </select>

      <br>
      <input type="submit" value="filtrar">
      <input type="submit" value="limpiar">



    </form>


  </aside>


  <article>
    <h2>Alquileres</h2>
    <?php foreach ($fields as $field) : ?>
      <h3><?= $field['name'] ?></h3>
      <img src="<?= '/images/estadio.webp' ?>" alt="image-estadio">
      <div>
        <span> apertura: <strong><?= $field['opening_hours'] ?></strong></span>
        <span> cierre: <strong><?= $field['closing_time'] ?></strong></span>
      </div>
      <a href="/field?id=<?= $field['id'] ?>">ver sucursal</a>
    <?php endforeach; ?>



</section>