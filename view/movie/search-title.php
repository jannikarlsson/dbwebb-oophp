<form method="get">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Title (use % as wildcard):<br>
            <input type="search" name="searchTitle" value='<?= esc($searchTitle) ?>'>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
