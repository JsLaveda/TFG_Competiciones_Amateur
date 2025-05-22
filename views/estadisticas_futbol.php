<h2>Competiciones de Fútbol</h2>

<?php if (!empty($competiciones)): ?>
    <ul>
        <?php foreach ($competiciones as $c): ?>
            <li>
                <?= htmlspecialchars($c['nombre']) ?> |
                Del <?= $c['fecha_inicio'] ?> al <?= $c['fecha_fin'] ?> |
                <?= $c['privacidad'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay competiciones disponibles.</p>
<?php endif; ?>
