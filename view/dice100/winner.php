<h1>Tärningsspelet 100</h1>

<p><strong><?= $currentPlayer ?> vann!</strong></p>

<h5>Totala poäng</h5>
<p>
    Spelare1:
    <strong><?= $pointsPlayer1 ?></strong>
</p>
<p>
    Dator:
    <strong><?= $pointsComputer ?></strong>
</p>

<h5>Senaste tärningskasten för <?= $currentPlayer ?></h5>
<p>
<?php for ($i=0; $i < $amountDiceRolls; $i++) : ?>
<li>
    <?php foreach ($valuesDiceRolls[$i] as $key => $value) : ?>
        <?= $value ?>
    <?php endforeach; ?>
</li>
<?php endfor; ?>
</p>

<p><a href="do-init">Starta nytt spel</a></p>
