<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<h1>Hantera databasen</h1>

<a href="<?= url("cms/create") ?>">Skapa ny sida eller blogginlägg</a> | 
<a href="<?= url("cms/reset") ?>">Återskapa databasen</a>

<table class="content-table">
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a class="icons" href="<?= url("cms/edit?contentId=$row->id") ?>" title="Edit this content">
                <i class="fas fa-edit" aria-hidden="true"></i>
            </a>
            <a class="icons" href="<?= url("cms/delete?contentId=$row->id") ?>" title="Delete this content">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
