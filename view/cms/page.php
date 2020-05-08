<article>
    <header>
        <h1><?= $title ?></h1>
        <p><i>Latest update: <time datetime="<?= $modified_iso8601 ?>" pubdate><?= $modified ?></time></i></p>
    </header>
    <?= $data ?>
</article>
