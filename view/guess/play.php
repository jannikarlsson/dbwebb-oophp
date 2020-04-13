<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
?>

<h1>Guess the number!</h1>
<?php
if ($_SESSION["tries"] >= 1) { ?>
<form method="post">
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start over" formaction="init">
    <input type="submit" name="doCheat" value="Cheat" formaction="cheat">
</form>
<?php } else { ?>
<form method="post" action="init">
        <input type="submit" name="doInit" value="Start over">
</form>
<?php }

if ($res) : ?>
<p><?= $res ?></p>
    <?php if ($tries != 0) { ?>
        <p>Tries left: <?= $tries ?></p>
    <?php } ?>
<?php endif; ?>
<?php if ($doCheat) : ?>
    <p>The correct number is <?= $number ?></p>
<?php endif; ?>
