
<table class="table table-hover table-vcenter">
    <thead>
    <tr>
        <th class="text-center">Дата выдачи</th>
        <th>Фамили</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th class="text-center">Дата рождения</th>

        <th>Адрес регистрации</th>
        <th class="text-center">СНИЛС</th>
        <th class="text-center">ЛПУ</th>
        <?php if($auth->login!='admin'){ ?>
            <th></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($patients as $patient)
    {
        ?>
        <tr>

            <td><?php
               /* if($patient['xml']!='')
                {
                    $xml = new SimpleXMLElement($patient['xml']);
                    if(isset($xml->ProtocolDate))
                    {
                        $ProtocolDate = strtotime( $xml->ProtocolDate );
                        $ProtocolDate = date( 'd.m.Y', $ProtocolDate );
                        echo $ProtocolDate;
                    }
                }*/
                $ProtocolDate = strtotime( $patient['ProtocolDate'] );
                $ProtocolDate = date( 'd.m.Y', $ProtocolDate );
                echo $ProtocolDate;


                      ?></td>
            <td>
                <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span class="text-semibold"><?php echo $patient['LastName']; ?></span></a>
            </td>
            <td>
                <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span class="text-semibold"><?php echo $patient['FirstName']; ?></span></a>
            </td>
            <td>
                <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span class="text-semibold"><?php echo $patient['SecondName']; ?></span></a>
            </td>
            <td class="text-center">
                <?php
                $patient['BirthDate'] = strtotime( $patient['BirthDate'] );
                $patient['BirthDate'] = date( 'd.m.Y', $patient['BirthDate'] );
                echo $patient['BirthDate']; ?>
            </td>
            <td><?php echo $patient['RegAddress']; ?></td>
            <td class="text-center"><?php echo $patient['SNILS']; ?></td>
            <td class="text-center"><?php echo $patient['LPUCODE'];
                if($auth->login=='admin')
                {
                ?>
                <a href="<?php echo site_url('patient/edit/'.$patient['id']);  ?>" class="btn btn-info" type="button" id="search-button">Изменить</a>
                <?php
                }
                ?></td>


            <?php if($auth->login!='admin'){ ?>
                <td>
                    <?php if(strlen($patient['f_date'])<3) { ?>
                        <button onclick="ToWork(<?php echo $patient['id']; ?>)" class="btn btn-info" type="button" >В работе</button>
                    <?php }else{ echo $patient['f_date'];} ?>
                </td>
            <?php } ?>

        </tr>
        <?php
    }

    ?>



    </tbody>
</table>