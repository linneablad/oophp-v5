<h1>Guess my number</h1>

<?php if ($res !== "CORRECT" && $_SESSION["tries"] > 0) : ?>
    <p>Guess a number between 1 and 100, you have <?= $_SESSION["tries"] ?> tries left.</p>

    <form method="post">
        <input type="text" name="guessNum">
        <input type="submit" name="doGuess" value="Make a guess">
        <input type="submit" name="doInit" value="Start from the beginning">
        <input type="submit" name="doCheat" value="Cheat">
    </form>

    <?php if ($doGuess) : ?>
        <p>Your guess <?= $guessNum ?> is <b><?= $res ?></b></p>
    <?php endif; ?>

    <?php if ($doCheat) : ?>
        <p>CHEAT: Current number is <?= $number ?>.</p>
    <?php endif; ?>

<?php elseif ($res !== "CORRECT" && $_SESSION["tries"] <= 0) : ?>
    <p>Your guess <?= $guessNum ?> is <b><?= $res ?></b></p>
    <p>Correct number was <?= $number ?>.</p>
    <p>You have 0 tries left.</p>
    <form method="post">
        <input type="submit" name="doInit" value="Play again">
    </form>

<?php else : ?>
    <p>You won!</p>
    <form method="post">
        <input type="submit" name="doInit" value="Play again">
    </form>
<?php endif; ?>
