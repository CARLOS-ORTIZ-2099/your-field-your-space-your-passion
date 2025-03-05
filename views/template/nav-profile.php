<nav>
  <!-- aui nos sersionamos si el usuario es un admin -->
  <a href="/profile">profile</a>
  <a href="/profile/my-reservations">my reservations</a>
  <a href="/logout">logout</a>
  <?php if ($_SESSION['user']['is_admin']): ?>
    <a href="/profile/all-reservations">see all reservations</a>
    <!-- <a href="/see-branches">see branches</a> -->
    <a href="/profile/see-fields">see fields</a>
  <?php endif; ?>
</nav>