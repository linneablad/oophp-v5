<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>You won!</h1>

<p>Your guess <?= $guessNum ?> is <b><?= $res ?></b></p>

<a href="init">Play again</a>
