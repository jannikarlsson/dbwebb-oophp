<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
?>

<h1>Dice game</h1>
Rolling dice to decide who gets to start.<br><br>
You:<br> <span class="dice-utf8"><span class="dice-<?= $dices[0] ?>"></span></span><br>
Computer:<br> <span class="dice-utf8"><span class="dice-<?= $dices[1] ?>"></span></span><br>
<?= $active ?> will start playing.<br><br>
<a href="round">Start playing</a><br>


<a href="init">Börja om</a>
