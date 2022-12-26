<?php include 'header.php'; ?>

    <div x-data x-show="$store.install.success" x-cloak>
        <?php includeFile('partials/success.php') ?>
    </div>

    <div x-data x-show="!$store.install.success" x-cloak>
        <?php includeFile('partials/install.php', compact('requirements', 'permissions', 'status')) ?>
    </div>

<?php include 'footer.php'; ?>
