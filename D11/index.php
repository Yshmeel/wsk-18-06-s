<?php

$currentPage = $_GET['page'] ?? 1;
$limit = 5;

$data = json_decode(file_get_contents('./data.json'), true);

$paginationPages = [];
$leftButtonDisabled = false;
$rightButtonDisabled = false;

for($i = 1; $i < count($data)/$limit; $i++) {
    $paginationPages[] = $i;
}

if($currentPage == 1) {
    $leftButtonDisabled = true;
}

if($currentPage == count($data)) {
    $rightButtonDisabled = true;
}

$currentData = array_slice($data, ($currentPage-1)*$limit, $limit);
$currentPages = array_slice($paginationPages, $currentPage-1, $limit);

// kak ono vashe rabotaet???
if(count($currentPages) < $limit) {
    $currentPages = array_merge(
        array_slice($paginationPages, ($currentPage-1)-($limit-count($currentPages)), $limit-count($currentPages)),
        $currentPages,
    );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination</title>

    <style type="text/css">
        body {
            padding: 200px;
        }

        .pagination {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 30px;
            width: 100%;
            justify-content: center;
        }

        .pagination-button {
            width: 48px;
            height: 48px;
            background: #556688;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Trebuchet MS";
            font-size: 18px;
            transition: .2s ease;
        }

        .pagination-button:hover {
            opacity: .7;
        }

        .pagination-dot {
            width: 36px;
            height: 36px;
            border-radius: 100%;
            background: #0474D7;
            display: flex;
            color: #fff;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-family: "Trebuchet MS";
            transition: .2s ease;
        }

        .pagination-dot:hover {
            opacity: .7;
        }

        .pagination-dot.active {
            background: #214462;
        }

        .pagination-button.disabled {
            background: #AAB2C3;
        }

        .current-page {
            text-align: center;
            display: block;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="list">
        <?php foreach($currentData as $item): ?>
            <div class="list-item">
                ID: <?= $item['id']; ?>
                Age: <?= $item['age']; ?>
                Name: <?= $item['name']; ?>
                Company: <?= $item['company']; ?>
                Email: <?= $item['email']; ?>
                Phone: <?= $item['phone']; ?>
                Address: <?= $item['address']; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="?page=<?= $currentPage; ?>" class="current-page">
        You are at page number: <?= $currentPage; ?>
    </a>

    <div class="pagination">
        <?php if($leftButtonDisabled): ?>
            <button type="button" class="pagination-button disabled" disabled>
                <
            </button>
        <?php else: ?>
            <a href="?page=<?= $currentPage - 1; ?>" class="pagination-button">
                <
            </a>
        <?php endif; ?>

        <?php foreach($currentPages as $page): ?>
            <a href="?page=<?= $page; ?>" class="pagination-dot <?= $currentPage == $page ? 'active' : ''; ?>">
                <?= $page; ?>
            </a>
        <?php endforeach; ?>

        <?php if($rightButtonDisabled): ?>
            <button type="button" class="pagination-button disabled" disabled>
                >
            </button>
        <?php else: ?>
            <a href="?page=<?= $currentPage + 1; ?>" class="pagination-button">
                >
            </a>
        <?php endif; ?>
    </div>
</body>
</html>