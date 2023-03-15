<?php
require_once '../vendor/connect.php';

session_start();

if(isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 4800) {
        header('Location: ../logout.php');
    }
}

$_SESSION['last_activity'] = time();

$SfQL = json_decode($_POST['SfQL']);
$name = $_POST['group_number'];
$disciplinaName = $_SESSION['disciplina'];
$number_table = $_SESSION['number_table'];
$json = $_POST['cmplt'];
if ($json != "") {
    $sql = "UPDATE lessons_hours SET completed_state = '$json' WHERE discName = '$disciplinaName'";
    mysqli_query($connect,$sql);
}

function SQLrequest($connect,$tema,$count,$id,$number_table) {  // функция, формирующая и отправляющая данные в бд для обновления
        $sql = "UPDATE disciplina_10 
        SET tema_$tema = '$count' 
        WHERE disciplina_10.id = $id;";

    $sql = "UPDATE disciplina_$number_table 
    SET tema_$tema = '$count' 
    WHERE disciplina_$number_table.id = $id;";
    mysqli_query($connect,$sql);
    printf(mysqli_error($connect));
    
};

foreach ($SfQL as $items) { //проход циклом по всем данным, которые нужно изменить
    $id = $items[0];
    $tema = $items[1];
    $count = $items[2];
    SQLrequest($connect,$tema,$count,$id,$number_table);
}
mysqli_close($connect);
header("Location: select.php");

//'{"tema_1" : {"complete" : 0, "date": 0}, "tema_2" : {"complete" : 0, "date": 0}, "tema_3" : {"complete" : 0, "date": 0}, "tema_4" : {"complete" : 0, "date": 0}, "tema_5" : {"complete" : 0, "date": 0}, "tema_6" : {"complete" : 0, "date": 0}, "tema_7" : {"complete" : 0, "date": 0}, "tema_8" : {"complete" : 0, "date": 0}, "tema_9" : {"complete" : 0, "date": 0}, "tema_10" : {"complete" : 0, "date": 0}, "tema_11" : {"complete" : 0, "date": 0}, "tema_12" : {"complete" : 0, "date": 0}, "tema_13" : {"complete" : 0, "date": 0}, "tema_14" : {"complete" : 0, "date": 0}, "tema_15" : {"complete" : 0, "date": 0}, "tema_16" : {"complete" : 0, "date": 0}, "tema_17" : {"complete" : 0, "date": 0}, "tema_18" : {"complete" : 0, "date": 0}, "tema_19" : {"complete" : 0, "date": 0}, "tema_20" : {"complete" : 0, "date": 0}, "tema_21" : {"complete" : 0, "date": 0}, "tema_22" : {"complete" : 0, "date": 0}, "tema_23" : {"complete" : 0, "date": 0}, "tema_24" : {"complete" : 0, "date": 0}, "tema_25" : {"complete" : 0, "date": 0}, "tema_26" : {"complete" : 0, "date": 0}, "tema_27" : {"complete" : 0, "date": 0}, "tema_28" : {"complete" : 0, "date": 0}, "tema_29" : {"complete" : 0, "date": 0}, "tema_30" : {"complete" : 0, "date": 0}, "tema_31" : {"complete" : 0, "date": 0}, "tema_32" : {"complete" : 0, "date": 0}, "tema_33" : {"complete" : 0, "date": 0}, "tema_34" : {"complete" : 0, "date": 0}, "tema_35" : {"complete" : 0, "date": 0}, "tema_36" : {"complete" : 0, "date": 0}, "tema_37" : {"complete" : 0, "date": 0}, "tema_38" : {"complete" : 0, "date": 0}, "tema_39" : {"complete" : 0, "date": 0}, "tema_40" : {"complete" : 0, "date": 0}, "tema_41" : {"complete" : 0, "date": 0}, "tema_42" : {"complete" : 0, "date": 0}, "tema_43" : {"complete" : 0, "date": 0}, "tema_44" : {"complete" : 0, "date": 0}, "tema_45" : {"complete" : 0, "date": 0}, "tema_46" : {"complete" : 0, "date": 0}, "tema_47" : {"complete" : 0, "date": 0}, "tema_48" : {"complete" : 0, "date": 0}, "tema_49" : {"complete" : 0, "date": 0}, "tema_50" : {"complete" : 0, "date": 0}, "tema_51" : {"complete" : 0, "date": 0}, "tema_52" : {"complete" : 0, "date": 0}, "tema_53" : {"complete" : 0, "date": 0}, "tema_54" : {"complete" : 0, "date": 0}, "tema_55" : {"complete" : 0, "date": 0}, "tema_56" : {"complete" : 0, "date": 0}, "tema_57" : {"complete" : 0, "date": 0}, "tema_58" : {"complete" : 0, "date": 0}, "tema_59" : {"complete" : 0, "date": 0}, "tema_60" : {"complete" : 0, "date": 0}, "tema_61" : {"complete" : 0, "date": 0}, "tema_62" : {"complete" : 0, "date": 0}, "tema_63" : {"complete" : 0, "date": 0}, "tema_64" : {"complete" : 0, "date": 0}, "tema_65" : {"complete" : 0, "date": 0}, "tema_66" : {"complete" : 0, "date": 0}, "tema_67" : {"complete" : 0, "date": 0}, "tema_68" : {"complete" : 0, "date": 0}, "tema_69" : {"complete" : 0, "date": 0}, "tema_70" : {"complete" : 0, "date": 0}, "tema_71" : {"complete" : 0, "date": 0}, "tema_72" : {"complete" : 0, "date": 0}, "tema_73" : {"complete" : 0, "date": 0}, "tema_74" : {"complete" : 0, "date": 0}, "tema_75" : {"complete" : 0, "date": 0}, "tema_76" : {"complete" : 0, "date": 0}, "tema_77" : {"complete" : 0, "date": 0}, "tema_78" : {"complete" : 0, "date": 0}, "tema_79" : {"complete" : 0, "date": 0}, "tema_80" : {"complete" : 0, "date": 0}, "tema_81" : {"complete" : 0, "date": 0}, "tema_82" : {"complete" : 0, "date": 0}, "tema_83" : {"complete" : 0, "date": 0}, "tema_84" : {"complete" : 0, "date": 0}, "tema_85" : {"complete" : 0, "date": 0}, "tema_86" : {"complete" : 0, "date": 0}, "tema_87" : {"complete" : 0, "date": 0}, "tema_88" : {"complete" : 0, "date": 0}, "tema_89" : {"complete" : 0, "date": 0}, "tema_90" : {"complete" : 0, "date": 0}, "tema_91" : {"complete" : 0, "date": 0}, "tema_92" : {"complete" : 0, "date": 0}, "tema_93" : {"complete" : 0, "date": 0}, "tema_94" : {"complete" : 0, "date": 0}, "tema_95" : {"complete" : 0, "date": 0}, "tema_96" : {"complete" : 0, "date": 0}, "tema_97" : {"complete" : 0, "date": 0}, "tema_98" : {"complete" : 0, "date": 0}, "tema_99" : {"complete" : 0, "date": 0}, "tema_100" : {"complete" : 0, "date": 0}, "tema_101" : {"complete" : 0, "date": 0}, "tema_102" : {"complete" : 0, "date": 0}, "tema_103" : {"complete" : 0, "date": 0}, "tema_104" : {"complete" : 0, "date": 0}, "tema_105" : {"complete" : 0, "date": 0}, "tema_106" : {"complete" : 0, "date": 0}, "tema_107" : {"complete" : 0, "date": 0}, "tema_108" : {"complete" : 0, "date": 0}, "tema_109" : {"complete" : 0, "date": 0}, "tema_110" : {"complete" : 0, "date": 0}, "tema_111" : {"complete" : 0, "date": 0}, "tema_112" : {"complete" : 0, "date": 0}, "tema_113" : {"complete" : 0, "date": 0}, "tema_114" : {"complete" : 0, "date": 0}, "tema_115" : {"complete" : 0, "date": 0}, "tema_116" : {"complete" : 0, "date": 0}, "tema_117" : {"complete" : 0, "date": 0}, "tema_118" : {"complete" : 0, "date": 0}, "tema_119" : {"complete" : 0, "date": 0}, "tema_120" : {"complete" : 0, "date": 0}, "tema_121" : {"complete" : 0, "date": 0}, "tema_122" : {"complete" : 0, "date": 0}, "tema_123" : {"complete" : 0, "date": 0}, "tema_124" : {"complete" : 0, "date": 0}, "tema_125" : {"complete" : 0, "date": 0}, "tema_126" : {"complete" : 0, "date": 0}, "tema_127" : {"complete" : 0, "date": 0}, "tema_128" : {"complete" : 0, "date": 0}, "tema_129" : {"complete" : 0, "date": 0}, "tema_130" : {"complete" : 0, "date": 0}, "tema_131" : {"complete" : 0, "date": 0}, "tema_132" : {"complete" : 0, "date": 0}, "tema_133" : {"complete" : 0, "date": 0}, "tema_134" : {"complete" : 0, "date": 0}, "tema_135" : {"complete" : 0, "date": 0}, "tema_136" : {"complete" : 0, "date": 0}, "tema_137" : {"complete" : 0, "date": 0}, "tema_138" : {"complete" : 0, "date": 0}, "tema_139" : {"complete" : 0, "date": 0}, "tema_140" : {"complete" : 0, "date": 0}, "tema_141" : {"complete" : 0, "date": 0}, "tema_142" : {"complete" : 0, "date": 0}, "tema_143" : {"complete" : 0, "date": 0}, "tema_144" : {"complete" : 0, "date": 0}, "tema_145" : {"complete" : 0, "date": 0}, "tema_146" : {"complete" : 0, "date": 0}, "tema_147" : {"complete" : 0, "date": 0}, "tema_148" : {"complete" : 0, "date": 0}, "tema_149" : {"complete" : 0, "date": 0}, "tema_150" : {"complete" : 0, "date": 0}}'




