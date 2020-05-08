<h1>Radera en sida eller blogginlägg</h1>

<form method="post">
    <fieldset>
    <legend>Delete</legend>

    <input type="hidden" name="contentId" value="<?= $id ?>"/>

    <p>
        <label>Title:<br>
            <input type="text" name="contentTitle" value="<?= $title ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete" value="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
