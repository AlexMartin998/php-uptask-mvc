<?php include_once __DIR__ . '/../dashboard/header-dashboard.php' ?>

<div class="container-sm">
  <div class="new-task-container">
    <button type="button" class="add-task" id="add-task">
      &#43; Nueva Tarea
    </button>
  </div>

  <ul id="task-list" class="task-list">

  </ul>
</div>

<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php' ?>



<?php
$script = '
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="build/js/tasks.js"></script>
';
?>