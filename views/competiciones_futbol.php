<h2>Competiciones de Fútbol</h2>

<ul>
    <?php foreach ($competiciones as $c): ?>
        <li><?= $c['nombre'] ?> - <?= $c['fecha_inicio'] ?> a <?= $c['fecha_fin'] ?></li>
    <?php endforeach; ?>
</ul>
