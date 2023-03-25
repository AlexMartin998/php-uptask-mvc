<?php include_once __DIR__ . '/../dashboard/header-dashboard.php' ?>


<?php if (empty($projects)) : ?>
  <p class="no-projects">No Hay Proyectos Aún <a href="/crear-proyecto">Comienza creando uno</a></p>

<?php else : ?>
  <ul class="project-list">
    <?php foreach ($projects as $project) : ?>
      <li class="project">
        <a href="/proyecto?id=<?= $project->url ?>"><?= $project->title ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>


<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php' ?>