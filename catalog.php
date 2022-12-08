<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-panel</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/catalog.css">
</head>
<body>
    <?php include("./sidePanels/adminHeader.php"); ?>
    <div class="catalog-list">
        <?php
        $catalog = simplexml_load_file('base/catalog.xml') or die("Error: Cannot create object");
        foreach ($catalog->item as $item){
            $name = $item->name;
            $info = $item->info;
            $id = $item->attributes()->id;
            ?>
            <div class="container">
                <div class="product" id="product-<?= $id ?>">
                    <img src="<?= $item->img ?>" alt="<?= $item->name ?>">
                    <div class="product-title">
                        <?= $name ?>
                    </div>
                    <div class="product-price"><?= $item->cost ?> RUB</div>
                </div>
                <div class="panel">
                    <a href="catalog.php?id=<?= $id ?>">id: <?= $id ?></a>
                    <a href="/base/change.php?id=<?= $id ?>" class="change">Change</a>
                    <button class="delete" onclick="DeleteItemById(<?= $id ?>)">Delete</button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
            if (!empty($_GET['id']))
            {
                $getId = $_GET['id'];
                $i = 0;
                $elem;
                foreach ($catalog->item as $item){
                    if($item['id'] == $getId){
                        $elem = $item;
                        break;
                    }
                    $i++;
                }
                ?>
                    <script src="./js/modalEventListener.js"></script>
                    <link rel="stylesheet" href="./css/product-modal-window.css">
                    <div class="modal-window-background">
                        <div class="modal-window">
                            <a href="catalog.php" class="close" id='close-modal'>&times;</a>
                            <div class="specifications">
                                <img src="<?= $item->img ?>" alt="<?= $item->name ?>">
                                <ul>
                                    <li> id: <?= $getId ?> </li>
                                    <li> Produser: <?= $elem->producer ?> </li>
                                </ul> 
                            </div>
                            <div class="main-info">
                                <span class="elem-name"><?= $elem->name ?></span>
                                <span class="cost"><?= $elem->cost ?> R</span>
                                <span class="elem-info"><?= $elem->info ?></span>
                                <span> keywords: <?= $elem->keywords ?> </span>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
    <script src="./js/delete.js"></script>
   
</body>
</html>