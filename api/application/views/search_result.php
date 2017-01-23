<?php if(count($res)>0){ ?>
<table class="table table-striped">
    <tdead>
        <tr>
            <th>#</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Дата рождения</th>
            <th>Снилс</th>
            <th>Адрес</th>
            <th>Группа диспан</th>
            <th>Диагноз</th>
        </tr>
    </tdead>
    <tbody>
    <?php
    $i = 1;

    foreach ($res as $result) {
        $date = new DateTime($result->BIRTHDAY);
        $date =  ($date->format('d.m.Y'));
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $result->SURNAME; ?></td>
            <td><?php echo $result->NAME; ?></td>
            <td><?php echo $result->SECNAME; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $result->SNILS; ?></td>
            <td><?php echo $result->FULLADR; ?></td>
            <td><?php echo $result->GR_U; ?></td>
            <td><?php echo $result->DIAG; ?></td>
        </tr>
        <?php
        $i++;
    }


    ?>

    </tbody>
</table>

<?php }else{ ?>
    <div class="alert alert-warning" role="alert">По данному запросу результаты отсутствуют.</div>
<?php }?>
