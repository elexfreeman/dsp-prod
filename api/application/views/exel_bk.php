<?php

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=patients.xls;");
header("Content-Transfer-Encoding:� cp1251");

//echo "�������;���;��������;���� ��������;����� �����������;�����;���;���� ��������"." \n";
/*foreach($patients as $p)
{
    foreach($p as $key=>$value)
    {
        echo $key.';';
    }
    echo "\n";
    break;
}


 foreach($patients as $p) {
    foreach($p as $key=>$value)
    {
        echo iconv('UTF-8', 'CP1251', $p[$key]).';';
    }
     echo "\n";

 }*/


?>
<table border="1">
    <tr>
        <td>��� ������������</td>
        <td>������������ �������</td>
        <td>�������</td>
        <td>��� �������</td>
        <td>��� �����</td>
        <td>������������� �����</td>
        <td>�������</td>
        <td>���</td>
        <td>��������</td>
        <td>�������</td>
        <td>���� ��������</td>
        <td>���</td>
        <td>���</td>
        <td>���</td>
        <td>�������</td>
        <td>��� ���������������</td>
        <td>���</td>
    </tr>
<?php foreach($patients['rows'] as $row){  ?>
    <tr ng-repeat="a in exel.rows">
        <td><?php echo $row['lpubase']; ?></td>
        <td><?php echo $row['NAME']; ?></td>
        <td><?php echo $row['lpubase_u']; ?></td>
        <td><?php echo $row['typeui']; ?></td>
        <td><?php echo $row['drcode']; ?></td>
        <td><?php echo $row['speccode']; ?></td>
        <td><?php echo $row['surname1']; ?></td>
        <td><?php echo $row['name1']; ?></td>
        <td><?php echo $row['secname1']; ?></td>
        <td><?php echo $row['age']; ?></td>
        <td><?php echo $row['birthday1']; ?></td>
        <td><?php echo $row['sex']; ?></td>
        <td><?php echo $row['enp']; ?></td>
        <td><?php echo $row['disp_lpu']; ?></td>
        <td><?php echo $row['disp_quarter']; ?></td>
        <td><?php echo $row['disp_type']; ?></td>
        <td><?php echo $row['disp_year']; ?></td>
    </tr>
<?php } ?>
</table>

