<?php
namespace Anax\View;

?>

<h1>Uppdatera en sida eller blogginlägg</h1>

<p><a href="<?= url("cms/admin") ?>">Gå till adminsidan</a></p>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= $id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= $title ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath" value="<?= $path ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" value="<?= $slug ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData"><?= $data ?></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input type="text" name="contentType" value="<?= $type ?>"/>
     </p>

     <p>
         <label>Filter:<br>
         <input type="text" name="contentFilter" value="<?= $filter ?>"/>
     </p>

     <p>
         <label>Publish:<br>
         <input type="datetime" name="contentPublish" value="<?= $published ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave" value="Save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete" value="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
