<?php
namespace Anax\View;

?>

<h1>Återskapa databasen</h1>

<p>
<form method="post">
    <input type="submit" name="doReset" value="Reset database">
</form>
</p>

<?php
if ($resetSuccess) : ?>
    <p><strong>Databasen är återskapad</strong></p>

    <a href="<?= url("cms/admin") ?>">Tillbaka till adminsidan</a>
<?php endif; ?>
