<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<article>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h1><a href="<?= url("cms/blogpost/" . htmlentities($row->slug)) ?>"><?= htmlentities($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= htmlentities($row->published_iso8601) ?>" pubdate><?= htmlentities($row->published) ?></time></i></p>
    </header>
    <p><?= $row->data ?></p>
    <p><a href="<?= url("cms/blogpost/" . htmlentities($row->slug)) ?>">Läs mer >></a></p>
</section>
<?php endforeach; ?>

</article>
