<h1>Tärningsspelet 100</h1>

<p>Kasta en tärning, den som får högst börjar spelet med en spelrunda.</p>

<?php if (!isset($currentPlayer)) : ?>
    <a href="roll">Rulla tärningen</a>
<?php elseif (isset($currentPlayer)) : ?>
    <p>Spelare1 fick: <strong><?= $resPlayer1 ?></strong></p>
    <p>Dator fick: <strong><?= $resComputer ?></strong></p>
    <p><?= $currentPlayer ?> får börja!</p>

    <a href="play">Starta spelet</a>
<?php endif ?>
