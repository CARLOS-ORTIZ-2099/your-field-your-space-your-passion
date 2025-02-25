<section>


  <aside>
    <form class="form" action="">

      <label for="deport">filtrar por deporte</label>
      <select class="type select" name="type" id="type">
        <option value="">---</option>
        <option value="1">futbol</option>
        <option value="2">voley</option>
        <option value="3">basquet</option>
        <option value="4">tenis</option>
      </select>

      <label for="district">filtrar por distrito</label>
      <select class="district select" name="district" id="district">
        <option value="">---</option>
        <option value="1">miraflores</option>
        <option value="2">surco</option>
        <option value="3">la molina</option>
        <option value="4">chorrillos</option>
        <option value="5">san borja</option>
        <option value="6">san juan de miraflores</option>
      </select>

      <br>
      <input class="filtrar " type="submit" value="filtrar" disabled>
      <input class="limpiar " type="submit" value="limpiar" disabled>

    </form>
  </aside>

  <h2>Alquileres</h2>

  <div class="fields-container">

  </div>


  <?php
  $script = "<script src='js/fields.js'></script>";
  ?>

</section>