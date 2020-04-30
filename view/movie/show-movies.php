<?php
if (!$resultset) {
    return;
}
?>


<table>
    <tr class="first">
        <th>Row</th>
        <th>Id</th>
        <th>Image</th>
        <th>Title</th>
        <th>Year</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="../<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
