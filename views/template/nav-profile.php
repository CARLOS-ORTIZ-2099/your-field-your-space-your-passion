<nav>
  <!-- aui nos sersionamos si el usuario es un admin -->
  <a href="/profile">profile</a>
  <a href="/my-reservations">my reservations</a>
  <a href="/logout">logout</a>
  <?php if ($_SESSION['user']['is_admin']): ?>
    <a href="/see-all-reservations">see all reservations</a>
    <a href="/see-branches">see branches</a>
    <a href="/see-fields">see fields</a>
  <?php endif; ?>
</nav>