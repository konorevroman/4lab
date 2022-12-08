<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!checking()){
            addItem();
            ?><script>alert("Ошибка: товар уже существует.")</script><?php
        }
        else{
            addItem();
            ?><script>alert("Товар успешно добавлен")</script><?php
        }
        
    }

    function checking(){
        $catalog = simplexml_load_file('base/catalog.xml');
        $searchName = $_POST["item_name"];
        foreach( $catalog->item as $child){
            if ($child->name == $searchName){
                return false;
            }
        }
        return true;
    }

    function createNewID(){
        $catalog = simplexml_load_file('base/catalog.xml');
        $id = 0;
        foreach( $catalog->item as $child){
            if ((int)($child->attributes()['id']) > $id){
                $id = $child->attributes()['id'];
            }
        }
        return $id + 1;
    }

    function addItem()
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML(simplexml_load_file('base/catalog.xml')->asXML());
        
        $item_id = createNewID();
        $item_name = $_POST["item_name"];
        $item_cost = $_POST["cost"];
        $item_info = $_POST["info"];
        $itme_producer = $_POST["item-producer"];
        $item_keywords = $_POST["item-keywords"];


        $uploaddir = "uploads/catalog-img/";
        $item_img = $_FILES["item_img"]['name'];
        move_uploaded_file($_FILES['item_img']['tmp_name'], $uploaddir . $item_img);

        
        $item = $dom->createElement("item");
        $dom->documentElement->appendChild($item);
        $item->setAttribute('id', $item_id);
        
        $name = $dom->createElement("name", $item_name);
        $cost = $dom->createElement("cost", $item_cost);
        $info = $dom->createElement("info", $item_info);
        $img = $dom->createElement("img", $uploaddir . $item_img);
        $producer = $dom->createElement("producer", $itme_producer);
        $keywords = $dom->createElement("keywords", $item_keywords);
        
        $item->appendChild($name);
        $item->appendChild($cost);
        $item->appendChild($info);
        $item->appendChild($producer);
        $item->appendChild($keywords);
        if(($uploaddir . $item_img )!= $uploaddir){
            $item->appendChild($img);
        }
        $dom->save('base/catalog.xml');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-panel</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/create-item.css">
</head>
<body>
    <?php include("./sidePanels/adminHeader.php"); ?>
    <div class="main">
        <div class="catalog-add-form">
            <p>Введите данные товара</p>
            <form id="post-element" action="create.php" method="post" enctype="multipart/form-data">
                <input type="text" class="required-field" name="item_name" placeholder="Название товара">
                <div><input type="text" class="required-field" name="cost" placeholder="Цена"><p>₽</p></div>
                <textarea name="info" id="" cols="30" rows="10" placeholder="Описание"></textarea>
                <div class="img">Загрузите изображение товара:<br><input type="file" name="item_img"></div></br>
                <input type="text" name="item-producer" placeholder="Производитель">
                Ключевые слова (через запятую)
                <input type="text" name="item-keywords" placeholder="Ключевые слова">
                <input type="submit" class="enter" value="Создать" disabled>
            </form>
            <?php
                function exist(){
                    echo("Ошибка: товар уже существует.");
                }
            ?>
        </div>
    </div>
    
    <script src="./js/create.js"></script>
</body>
</html>