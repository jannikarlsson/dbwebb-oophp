<h1>Guess the number!</h1>
<?php
if ($_SESSION["tries"] >= 1) { ?>
<form method="post" action="view/guess_processing.php">
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start over">
    <input type="submit" name="doCheat" value="Cheat">
</form>
<?php } else { ?>
<form method="post" action="view/guess_processing.php">
        <input type="submit" name="doInit" value="Start over">
    </form>
<?php }

if ($doGuess) : ?>
<p><?= $_SESSION["res"] ?></p>
    <?php if ($guess != $number) { ?>
        <p>Tries left: <?= $_SESSION["tries"] ?></p>
    <?php } ?>
<?php endif; ?>
<?php if ($doCheat) : ?>
    <p>The correct number is <?= $number ?></p>
<?php endif; ?>
