<?php

namespace Anax\View;

/**
* Render content within an article.
*/

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
?>

<h1>Dice game roll view</h1>
<p>Active player: <?= $active ?></p>
<?php if (($action != null) && ($youSum < 100 && $compSum < 100)) { ?>
    <p><?= $action ?></p>
<?php }
if ($dices) { ?>
    <span class="dice-utf8">
        <?php foreach ($dices as $value) : ?>
            <span class="dice-<?= $value ?>"></span>
        <?php endforeach; ?>
    </span>
    <p>Current sum in round: <?= $sum ?> </p><?php
}
if ($youSum >= 100 || $compSum >= 100) {
    echo "We have a winner! <br><br><a href='init'>Börja om</a>";
} elseif ($active != "Computer") { ?>
    <form method="post">
        <?php if ($loss != true) { ?>
            <input type="submit" name="roll" value="Roll dice">
            <?php if ($sum != 0) { ?>
                <input type="submit" name="save" value="Save value" formaction="save">
            <?php } ?>
        <?php } else {
                echo "You lost the round."?><br><br>
            <input type="submit" name="round" value="Hand over turn" formaction="round">
        <?php } ?>
    </form>
<?php } else { ?>
    <form method="post" action="continue">
        <input type="submit" name="continue" value="Continue">
    </form>
<?php } ?>
<br><br>Scoreboard: You (<?= $youSum ?>), Computer (<?= $compSum ?>)
