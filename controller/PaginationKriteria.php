<nav class="pagination" role="navigation" aria-label="pagination">
    <?php if ($aktif > 1) : ?>
        <a class="pagination-previous" href="index.php?halaman=datakriteria&page=<?= $aktif - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php if ($aktif < $total) : ?>
        <a class="pagination-next" href="index.php?halaman=datakriteria&page=<?= $aktif + 1; ?>">Next Page</a>
    <?php endif; ?>

    <ul class="pagination-list">
        <?php for ($i = 1; $i <= $total; $i++) : ?>
            <?php if ($i == $aktif) : ?>
                <li><a class="pagination-link is-current" aria-current="page" href="index.php?halaman=datakriteria&page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php else : ?>
                <li><a class="pagination-link" href="index.php?halaman=datakriteria&page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>
    </ul>
</nav>