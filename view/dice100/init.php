<h1>Tärningsspelet 100</h1>

<p>Kasta en tärning, den som får högst börjar spelet med en spelrunda.</p>

<?php if (!isset($winner)) : ?>
    <a href="roll">Rulla tärningen</a>
<?php elseif (isset($winner)) : ?>
    <p>Spelare 1 fick: <?= $resPlayer1 ?></p>
    <p>Datorn fick: <?= $resComputer ?></p>
    <p><?= $winner ?> får börja!</p>

    <a href="play">Starta spelet</a>
<?php endif ?>
