<?php include_once __DIR__ . '/../dashboard/header-dashboard.php' ?>

<div class="container-sm">
  <div class="new-task-container">
    <button type="button" class="add-task" id="add-task">
      &#43; Nueva Tarea
    </button>
  </div>
</div>

<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php' ?>


<?php
$script = '
  <script src="build/js/tasks.js"></script>
';
?>