<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-panel</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/change.css">
</head>
<body>
    <?php 
    include("../sidePanels/adminHeader.php"); 
    
    if (!empty($_GET['id']))
    {
        $catalog = simplexml_load_file('catalog.xml');
        $getId = $_GET['id'];
        $i = 0;
        $elem;
        foreach ($catalog->item as $item){
            if($item['id'] == $getId){
                $elem = $item;
                echo($elem->id);
                break;
            }
            $i++;
        }

        $name = $elem->name;
        $info = $elem->info;
        $cost = $elem->cost;
        $producer = $elem->producer;
        $keywords = $elem->keywords;
        $img = $elem->img;


        function addFile($elem){
            if ($_FILES["item_img"]['name']) {
                $uploaddir = "/uploads/catalog-img/";
                $item_img = $_FILES["item_img"]['name'];
                move_uploaded_file($_FILES['item_img']['tmp_name'], '..' . $uploaddir . $item_img);
                $img_link = $uploaddir . $item_img;
                if(($uploaddir . $item_img )!= $uploaddir){
                    unlink('..' . $elem->img);
                    $elem->img = $img_link;
                }
            }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $elem->name = $_POST['item_name'];
            $elem->cost = $_POST["cost"];
            $elem->info = $_POST["info"];
            $elem->producer = $_POST["item-producer"];
            $elem->keywords = $_POST["item-keywords"];
            addFile($elem);
            $catalog->saveXML('catalog.xml');
        }


        ?>
        <form action="change.php?id=<?= $getId ?>" method="post" enctype="multipart/form-data"> 
            <div class="modal-window">
                <a href="../catalog.php" class="close" id='close-modal'>&times;</a>
                <div class="specifications">
                    <img src="../<?= $item->img ?>" alt="<?= $item->name ?>">
                    <ul>
                        <li><div class="img"><input type="file" calss="item-img" name="item_img"></div></br></li>
                        <li> id: <?= $getId ?> </li>
                        <li> <input type="text" name="item-producer" placeholder="Производитель" value="<?=$producer?>"> </li>
                    </ul> 
                </div>
                <div class="main-info">
                    <input type="text" class="required-field" name="item_name" placeholder="Название товара" value="<?=$name?>">
                    <div><input type="text" class="required-field" name="cost" placeholder="Цена" value="<?=$cost?>"><p>₽</p></div>
                    <textarea name="info" id="" cols="30" rows="10" placeholder="Описание"><?=$info?></textarea>
                    <input type="text" name="item-keywords" placeholder="Ключевые слова" value='<?= $keywords ?>'>
                </div>
            </div>
            <input type="submit" class="enter" value="Обновить">
        </form>
        <!-- <script src="../js/create.js"></script>     -->
        <?php
    } 

    else {
        ?><script>alert("Product is not found. Please, check the ID");</script><?php 
    }
    ?>
    
</body>
</html>