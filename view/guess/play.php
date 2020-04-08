<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>Guess my number</h1>

<p>Guess a number between 1 and 100, you have <?= $tries ?> tries left.</p>

<p>
<form method="post" action="make-guess">
    <input type="text" name="guessNum">
    <input type="submit" name="doGuess" value="Make a guess">
</form>

<form action="cheat">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<form action="init">
    <input type="submit" name="doInit" value="Start from the beginning">
</form>
</p>

<?php if ($res) : ?>
    <p>Your guess <?= $guessNum ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>CHEAT: Current number is <?= $number ?>.</p>
<?php endif; ?>
