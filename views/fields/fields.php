<section>


  <aside>
    <label for="deport">filtrar por deporte</label>
    <select name="deport" id="deport">
      <option value="">---</option>
      <option value="futbol">futbol</option>
      <option value="voley">voley</option>
      <option value="basquet">basquet</option>
      <option value="tenis">tenis</option>
    </select>

    <label for="district">filtrar por distrito</label>
    <select name="district" id="district">
      <option value="">---</option>
      <option value="miraflores">miraflores</option>
      <option value="surco">surco</option>
      <option value="la molina">la molina</option>
      <option value="san juan de miraflores">san juan de miraflores</option>
    </select>

    <br>
    <button>filtrar</button>
    <button>limpiar</button>

  </aside>


  <article>
    <h2>Alquileres</h2>


    <?php while ($row = $data->fetch_assoc()) : ?>
      <!--  <?php debuguear($row); ?> -->
      <h3><?= $row['name'] ?></h3>
      <img src="<?= '/images/estadio.webp' ?>" alt="image-estadio">
      <div>
        <span> apertura: <strong><?= $row['opening_hours'] ?></strong></span>
        <span> cierre: <strong><?= $row['closing_time'] ?></strong></span>
      </div>
      <a href="/field?id=<?= $row['id'] ?>">ver sucursal</a>
    <?php endwhile; ?>
  </article>


</section>