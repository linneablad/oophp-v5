<div class="has-sidebar">
<h1>Tärningsspelet 100 med intelligens och kontroller</h1>

<h5>Senaste tärningskasten för <?= $previousPlayer ?></h5>
<?php for ($i=0; $i < $amountDiceRolls; $i++) : ?>
<li>
    <?php foreach ($valuesDiceRolls[$i] as $value) : ?>
        <?= $value ?>
    <?php endforeach; ?>
</li>
<?php endfor; ?>


<p>Total summa för spelomgången: <strong><?= $sumGameRound ?></strong></p>

<p>
<?php if ($currentPlayer === "Spelare1" && !$canContinue) : ?>
<a href="roll-dices">Rulla tärningarna för Spelare 1</a>

<?php elseif ($currentPlayer === "Dator") : ?>
<a href="roll-dices-computer">Rulla tärningarna för datorn</a>

<?php elseif ($currentPlayer === "Spelare1" && $canContinue) : ?>
<a href="save">Spara</a><br />
<a href="roll-dices">Rulla tärningarna igen</a>
<?php endif ?>
</p>

<h5>Histogram</h5>
<pre>
<?= $histogram ?>
</pre>

<p><a href="do-init">Starta nytt spel</a></p>
</div>

<?php include("points.php");
