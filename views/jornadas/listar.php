<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario de la Competición</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('views/fotos/futbol.avif');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      color: white;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.75);
      padding: 2rem;
      margin: 3rem auto;
      border-radius: 1rem;
      max-width: 900px;
    }

    h1, h2 {
      text-align: center;
    }

    table {
      width: 100%;
      margin-bottom: 2rem;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid white;
      padding: 0.8rem;
      text-align: center;
    }

    .volver {
      display: block;
      text-align: center;
      margin-top: 2rem;
      color: #fff;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Calendario de la competición: <?= htmlspecialchars($competicion->getNombre()) ?></h1>

    <?php if (empty($jornadas)) : ?>
      <p>No hay jornadas disponibles.</p>
    <?php else: ?>
      <?php foreach ($jornadas as $jornada): ?>
        <div class="jornada">
          <h2>Jornada - <?= date("d/m/Y", strtotime($jornada['fecha_jornada'])) ?></h2>
          <table>
            <thead>
              <tr>
                <th>Equipo Local</th>
                <th>Equipo Visitante</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($jornada['partidos'] as $partido): ?>
                <tr>
                  <td><?= htmlspecialchars($partido['equipo1']) ?></td>
                  <td><?= htmlspecialchars($partido['equipo2']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <a href="index.php?controlador=competicion&accion=verCompeticion&id=<?= $competicion->getId_competicion() ?>" class="volver">Volver a la competición</a>
  </div>

</body>
</html>
