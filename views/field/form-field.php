<section class="rental-form">
  <div class="rental-child">
    <h2>Formulario de Propiedades de Alquiler</h2>

    <span class="error"><?= $errors['badrequest'] ?? ''; ?></span>
    <span class="success"><?= $info['success'] ?? ''; ?></span>

    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" maxlength="60"
          value="<?= $field['name'] ?? '' ?>">
        <!-- <p class="error"><?= $errors['name'] ?? '' ?></p> -->
        <span class="error"><?= $errors['name'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="rental_price">Precio de Alquiler:</label>
        <input type="number" id="rental_price" name="rental_price" step="0.01" min="0"
          value="<?= $field['rental_price'] ?? '' ?>">
        <span class="error"><?= $errors['rental_price'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="branch_id">Elige la sucursal:</label>
        <select name="branch_id" id="branch_id">
          <option value="">---</option>
          <?php foreach ($branches as $branch): ?>
            <option value="<?= $branch['id'] ?>"
              <?= $field['branch_id'] === $branch['id'] ? 'selected' : '' ?>>
              <?= $branch['name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors['branch_id'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="type_id">Elige el tipo:</label>
        <select name="type_id" id="type_id">
          <option value="">---</option>
          <?php foreach ($types as $type): ?>
            <option value="<?= $type['id'] ?>"
              <?= $field['type_id'] === $type['id'] ? 'selected' : '' ?>>
              <?= $type['name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors['type_id'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="image">Imagen:</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp">
        <span class="error"><?= $errors['image'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="opening_hours">Hora de Apertura:</label>
        <input type="time" id="opening_hours" name="opening_hours"
          value="<?= $field['opening_hours'] ?? '' ?>">
        <span class="error"><?= $errors['opening_hours'] ?? '' ?></span>
      </div>

      <div class="form-group">
        <label for="closing_time">Hora de Cierre:</label>
        <input type="time" id="closing_time" name="closing_time"
          value="<?= $field['closing_time'] ?? '' ?>">
        <span class="error"><?= $errors['closing_time'] ?? '' ?></span>
      </div>

      <button type="submit">Enviar</button>
    </form>
  </div>
</section>