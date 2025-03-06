<!--  <?php debuguear($field); ?> -->
<!-- <?php debuguear($errors); ?> -->
<h2>Formulario de Propiedades de Alquiler</h2>


<?= $errors['badrequest'] ?? ''; ?>
<?= $info['success'] ?? ''; ?>
<form action="" method="POST" enctype="multipart/form-data">
  <label for="name">Nombre:</label>
  <input type="text" id="name" name="name" maxlength="60"
    value="<?= $field['name'] ?? '' ?>">
  <?= $errors['name'] ?? '' ?>

  <br><br>

  <label for="rental_price">Precio de Alquiler:</label>
  <input type="number" id="rental_price" name="rental_price"
    step="0.01"
    min="0"
    value="<?= $field['rental_price'] ?? '' ?>">
  <?= $errors['rental_price'] ?? '' ?>
  <br><br>

  <label for="branch_id">elige la sucursal - ID de Sucursal</label>
  <select name="branch_id" id="branch_id">
    <option value="">---</option>
    <?php foreach ($districts as $district): ?>
      <option
        <?php if ($field['branch_id'] === $district['id']): ?>
        selected
        <?php endif; ?>
        value="<?= $district['id'] ?>">
        <?= $district['name'] ?>
      </option>
    <?php endforeach; ?>
  </select>
  <?= $errors['branch_id'] ?? '' ?>
  <br><br>

  <label for="type_id">elige el tipo - ID de Tipo</label>
  <select name="type_id" id="type_id">
    <option value="">---</option>
    <?php foreach ($types as $type): ?>
      <option
        <?php if ($field['type_id'] === $type['id']): ?>
        selected
        <?php endif; ?>
        value="<?= $type['id'] ?>">
        <?= $type['name'] ?>
      </option>
    <?php endforeach; ?>
  </select>
  <?= $errors['type_id'] ?? '' ?>
  <br><br>


  <label for="image">Imagen (URL):</label>
  <input type="file" id="image" name="image"
    accept="image/png, image/jpeg, image/webp">
  <?= $errors['image'] ?? '' ?>
  <br><br>


  <label for="opening_hours">Hora de Apertura:</label>
  <input type="time" id="opening_hours" name="opening_hours"
    value="<?= $field['opening_hours'] ?? '' ?>">
  <?= $errors['opening_hours'] ?? '' ?>
  <br><br>

  <label for="closing_time">Hora de Cierre:</label>
  <input type="time" id="closing_time" name="closing_time"
    value="<?= $field['closing_time'] ?? '' ?>">
  <?= $errors['closing_time'] ?? '' ?>
  <br><br>

  <button type="submit">Enviar</button>
</form>