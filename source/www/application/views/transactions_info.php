<font style="font-size:23px; color: #209dee;"><p align="center">Moje zamówienia</p></font>



<table align="center" border="1">
<tr><td width="160" align="center" style="color: white; font-size:18px;">ID Transakcji</td><td width="210" align="center" style="color: white; font-size:18px;">Status</td></tr>


</table>



                <?php foreach($i as $transactions){ ?>

                    <p style="font-size: 20px; color:#637ed5; text-align: left "><a href="/index.php/Products?Subcategory=<?php echo $i->ID; ?>" style="color: inherit; text-decoration:none;"><?php echo $i->ID; ?></a></p>
            <?php } ?>