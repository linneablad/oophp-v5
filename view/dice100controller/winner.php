<div class="has-sidebar">
<h1>Tärningsspelet 100 med intelligens och kontroller</h1>

<p><strong><?= $currentPlayer ?> vann!</strong></p>

<h5>Senaste tärningskasten för <?= $currentPlayer ?></h5>
<p>
<?php for ($i=0; $i < $amountDiceRolls; $i++) : ?>
<li>
    <?php foreach ($valuesDiceRolls[$i] as $value) : ?>
        <?= $value ?>
    <?php endforeach; ?>
</li>
<?php endfor; ?>
</p>

<h5>Histogram</h5>
<pre>
<?= $histogram ?>
</pre>

<p><a href="do-init">Starta nytt spel</a></p>
</div>

<?php include("points.php");
