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
                            <div onclick="closeModal()" class="close" id='close-modal'>&times;</div>
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