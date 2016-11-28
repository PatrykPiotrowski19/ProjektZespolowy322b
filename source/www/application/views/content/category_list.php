                <?php foreach($name as $i){ ?>

                    <p style="font-size: 20px; color:#637ed5; text-align: left "><a href="/index.php/Products?Subcategory=<?php echo $i->ID; ?>" style="color: inherit; text-decoration:none;"><?php echo $i->name; ?></a></p>
            <?php } ?>