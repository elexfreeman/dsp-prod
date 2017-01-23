<div class="container">
    <table class="table">
        <?php
        foreach ($res as $row)
        {
            ?>
                <tr>
                    <td>
                        <?php print_r($row); ?>
                    </td>
                </tr>
            <?php
        }
        ?>
    </table>

</div>