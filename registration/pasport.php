<?php
require_once '../vendor/connect.php';

session_start();

if ($_SESSION['loggedin'] == false || !isset($_SESSION['id'])) {
    header('Location: ../index.php');
}

if(isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 4800) {
        header('Location: ../logout.php');
    }
}

if (!isset($_SESSION['none_disc'])) {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}

$data = $_POST;

$_SESSION['last_activity'] = time();

$nameTeacher = $_SESSION['name_teacher'];

$data = $_POST;
if (isset($data['do_create_pasport'])) {
    $stringuxa = '{"tema_1" : {"complete" : 0, "date": 0}, "tema_2" : {"complete" : 0, "date": 0}, "tema_3" : {"complete" : 0, "date": 0}, "tema_4" : {"complete" : 0, "date": 0}, "tema_5" : {"complete" : 0, "date": 0}, "tema_6" : {"complete" : 0, "date": 0}, "tema_7" : {"complete" : 0, "date": 0}, "tema_8" : {"complete" : 0, "date": 0}, "tema_9" : {"complete" : 0, "date": 0}, "tema_10" : {"complete" : 0, "date": 0}, "tema_11" : {"complete" : 0, "date": 0}, "tema_12" : {"complete" : 0, "date": 0}, "tema_13" : {"complete" : 0, "date": 0}, "tema_14" : {"complete" : 0, "date": 0}, "tema_15" : {"complete" : 0, "date": 0}, "tema_16" : {"complete" : 0, "date": 0}, "tema_17" : {"complete" : 0, "date": 0}, "tema_18" : {"complete" : 0, "date": 0}, "tema_19" : {"complete" : 0, "date": 0}, "tema_20" : {"complete" : 0, "date": 0}, "tema_21" : {"complete" : 0, "date": 0}, "tema_22" : {"complete" : 0, "date": 0}, "tema_23" : {"complete" : 0, "date": 0}, "tema_24" : {"complete" : 0, "date": 0}, "tema_25" : {"complete" : 0, "date": 0}, "tema_26" : {"complete" : 0, "date": 0}, "tema_27" : {"complete" : 0, "date": 0}, "tema_28" : {"complete" : 0, "date": 0}, "tema_29" : {"complete" : 0, "date": 0}, "tema_30" : {"complete" : 0, "date": 0}, "tema_31" : {"complete" : 0, "date": 0}, "tema_32" : {"complete" : 0, "date": 0}, "tema_33" : {"complete" : 0, "date": 0}, "tema_34" : {"complete" : 0, "date": 0}, "tema_35" : {"complete" : 0, "date": 0}, "tema_36" : {"complete" : 0, "date": 0}, "tema_37" : {"complete" : 0, "date": 0}, "tema_38" : {"complete" : 0, "date": 0}, "tema_39" : {"complete" : 0, "date": 0}, "tema_40" : {"complete" : 0, "date": 0}, "tema_41" : {"complete" : 0, "date": 0}, "tema_42" : {"complete" : 0, "date": 0}, "tema_43" : {"complete" : 0, "date": 0}, "tema_44" : {"complete" : 0, "date": 0}, "tema_45" : {"complete" : 0, "date": 0}, "tema_46" : {"complete" : 0, "date": 0}, "tema_47" : {"complete" : 0, "date": 0}, "tema_48" : {"complete" : 0, "date": 0}, "tema_49" : {"complete" : 0, "date": 0}, "tema_50" : {"complete" : 0, "date": 0}, "tema_51" : {"complete" : 0, "date": 0}, "tema_52" : {"complete" : 0, "date": 0}, "tema_53" : {"complete" : 0, "date": 0}, "tema_54" : {"complete" : 0, "date": 0}, "tema_55" : {"complete" : 0, "date": 0}, "tema_56" : {"complete" : 0, "date": 0}, "tema_57" : {"complete" : 0, "date": 0}, "tema_58" : {"complete" : 0, "date": 0}, "tema_59" : {"complete" : 0, "date": 0}, "tema_60" : {"complete" : 0, "date": 0}, "tema_61" : {"complete" : 0, "date": 0}, "tema_62" : {"complete" : 0, "date": 0}, "tema_63" : {"complete" : 0, "date": 0}, "tema_64" : {"complete" : 0, "date": 0}, "tema_65" : {"complete" : 0, "date": 0}, "tema_66" : {"complete" : 0, "date": 0}, "tema_67" : {"complete" : 0, "date": 0}, "tema_68" : {"complete" : 0, "date": 0}, "tema_69" : {"complete" : 0, "date": 0}, "tema_70" : {"complete" : 0, "date": 0}, "tema_71" : {"complete" : 0, "date": 0}, "tema_72" : {"complete" : 0, "date": 0}, "tema_73" : {"complete" : 0, "date": 0}, "tema_74" : {"complete" : 0, "date": 0}, "tema_75" : {"complete" : 0, "date": 0}, "tema_76" : {"complete" : 0, "date": 0}, "tema_77" : {"complete" : 0, "date": 0}, "tema_78" : {"complete" : 0, "date": 0}, "tema_79" : {"complete" : 0, "date": 0}, "tema_80" : {"complete" : 0, "date": 0}, "tema_81" : {"complete" : 0, "date": 0}, "tema_82" : {"complete" : 0, "date": 0}, "tema_83" : {"complete" : 0, "date": 0}, "tema_84" : {"complete" : 0, "date": 0}, "tema_85" : {"complete" : 0, "date": 0}, "tema_86" : {"complete" : 0, "date": 0}, "tema_87" : {"complete" : 0, "date": 0}, "tema_88" : {"complete" : 0, "date": 0}, "tema_89" : {"complete" : 0, "date": 0}, "tema_90" : {"complete" : 0, "date": 0}, "tema_91" : {"complete" : 0, "date": 0}, "tema_92" : {"complete" : 0, "date": 0}, "tema_93" : {"complete" : 0, "date": 0}, "tema_94" : {"complete" : 0, "date": 0}, "tema_95" : {"complete" : 0, "date": 0}, "tema_96" : {"complete" : 0, "date": 0}, "tema_97" : {"complete" : 0, "date": 0}, "tema_98" : {"complete" : 0, "date": 0}, "tema_99" : {"complete" : 0, "date": 0}, "tema_100" : {"complete" : 0, "date": 0}, "tema_101" : {"complete" : 0, "date": 0}, "tema_102" : {"complete" : 0, "date": 0}, "tema_103" : {"complete" : 0, "date": 0}, "tema_104" : {"complete" : 0, "date": 0}, "tema_105" : {"complete" : 0, "date": 0}, "tema_106" : {"complete" : 0, "date": 0}, "tema_107" : {"complete" : 0, "date": 0}, "tema_108" : {"complete" : 0, "date": 0}, "tema_109" : {"complete" : 0, "date": 0}, "tema_110" : {"complete" : 0, "date": 0}, "tema_111" : {"complete" : 0, "date": 0}, "tema_112" : {"complete" : 0, "date": 0}, "tema_113" : {"complete" : 0, "date": 0}, "tema_114" : {"complete" : 0, "date": 0}, "tema_115" : {"complete" : 0, "date": 0}, "tema_116" : {"complete" : 0, "date": 0}, "tema_117" : {"complete" : 0, "date": 0}, "tema_118" : {"complete" : 0, "date": 0}, "tema_119" : {"complete" : 0, "date": 0}, "tema_120" : {"complete" : 0, "date": 0}, "tema_121" : {"complete" : 0, "date": 0}, "tema_122" : {"complete" : 0, "date": 0}, "tema_123" : {"complete" : 0, "date": 0}, "tema_124" : {"complete" : 0, "date": 0}, "tema_125" : {"complete" : 0, "date": 0}, "tema_126" : {"complete" : 0, "date": 0}, "tema_127" : {"complete" : 0, "date": 0}, "tema_128" : {"complete" : 0, "date": 0}, "tema_129" : {"complete" : 0, "date": 0}, "tema_130" : {"complete" : 0, "date": 0}, "tema_131" : {"complete" : 0, "date": 0}, "tema_132" : {"complete" : 0, "date": 0}, "tema_133" : {"complete" : 0, "date": 0}, "tema_134" : {"complete" : 0, "date": 0}, "tema_135" : {"complete" : 0, "date": 0}, "tema_136" : {"complete" : 0, "date": 0}, "tema_137" : {"complete" : 0, "date": 0}, "tema_138" : {"complete" : 0, "date": 0}, "tema_139" : {"complete" : 0, "date": 0}, "tema_140" : {"complete" : 0, "date": 0}, "tema_141" : {"complete" : 0, "date": 0}, "tema_142" : {"complete" : 0, "date": 0}, "tema_143" : {"complete" : 0, "date": 0}, "tema_144" : {"complete" : 0, "date": 0}, "tema_145" : {"complete" : 0, "date": 0}, "tema_146" : {"complete" : 0, "date": 0}, "tema_147" : {"complete" : 0, "date": 0}, "tema_148" : {"complete" : 0, "date": 0}, "tema_149" : {"complete" : 0, "date": 0}, "tema_150" : {"complete" : 0, "date": 0}}';

    $json4ik = json_decode($data['jsondisc']);
    $json4ik = (array) $json4ik;

    $idTeacher = intval($_SESSION['id']);

    $query = "SELECT MAX(table_number) FROM lessons_hours;";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($stmt);
    $list = mysqli_stmt_get_result($stmt);
    $list = mysqli_fetch_all($list);

    $number_table = $list[0][0] + 1;

    $count_hours = intval($data['count_hours']);

    $disc = $_SESSION['disciplina'];

    foreach ($json4ik as $group) {
        $query2 = "INSERT INTO `lessons_hours` (`discName`, `group_number`, `exam`, `diff_exam`, `zachet`, `other_attestation`, `total`,
        `samost_work`, `theoretical_lesson`, `laboratory_lesson`, `coursovie`, `practice`, `consultation`, `promezhutAttest`,
        `semestr1`, `semestr2`, `semestr3`, `semestr4`, `semestr5`, `semestr6`, `semestr7`, `semestr8`, `table_number`, `completed_state`, `id_teacher`)
        VALUES (?, ?, 0, 0, 0, 0, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query2);
        mysqli_stmt_bind_param($stmt,"ssiisi", $disc,$group, $count_hours, $number_table, $stringuxa, $idTeacher);
        mysqli_stmt_execute($stmt);
    }

    mysqli_query($connect,"CREATE TABLE disciplina_$number_table (`id` int NOT NULL,`tema_1` varchar(1) DEFAULT NULL,`tema_2` varchar(1) DEFAULT NULL,`tema_3` varchar(1) DEFAULT NULL,`tema_4` varchar(1) DEFAULT NULL,`tema_5` varchar(1) DEFAULT NULL,`tema_6` varchar(1) DEFAULT NULL,`tema_7` varchar(1) DEFAULT NULL,`tema_8` varchar(1) DEFAULT NULL,`tema_9` varchar(1) DEFAULT NULL,`tema_10` varchar(1) DEFAULT NULL,`tema_11` varchar(1) DEFAULT NULL,`tema_12` varchar(1) DEFAULT NULL,`tema_13` varchar(1) DEFAULT NULL,`tema_14` varchar(1) DEFAULT NULL,`tema_15` varchar(1) DEFAULT NULL,`tema_16` varchar(1) DEFAULT NULL,`tema_17` varchar(1) DEFAULT NULL,`tema_18` varchar(1) DEFAULT NULL,`tema_19` varchar(1) DEFAULT NULL,`tema_20` varchar(1) DEFAULT NULL,`tema_21` varchar(1) DEFAULT NULL,`tema_22` varchar(1) DEFAULT NULL,`tema_23` varchar(1) DEFAULT NULL,`tema_24` varchar(1) DEFAULT NULL,`tema_25` varchar(1) DEFAULT NULL,`tema_26` varchar(1) DEFAULT NULL,`tema_27` varchar(1) DEFAULT NULL,`tema_28` varchar(1) DEFAULT NULL,`tema_29` varchar(1) DEFAULT NULL,`tema_30` varchar(1) DEFAULT NULL,`tema_31` varchar(1) DEFAULT NULL,`tema_32` varchar(1) DEFAULT NULL,`tema_33` varchar(1) DEFAULT NULL,`tema_34` varchar(1) DEFAULT NULL,`tema_35` varchar(1) DEFAULT NULL,`tema_36` varchar(1) DEFAULT NULL,`tema_37` varchar(1) DEFAULT NULL,`tema_38` varchar(1) DEFAULT NULL,`tema_39` varchar(1) DEFAULT NULL,`tema_40` varchar(1) DEFAULT NULL,`tema_41` varchar(1) DEFAULT NULL,`tema_42` varchar(1) DEFAULT NULL,`tema_43` varchar(1) DEFAULT NULL,`tema_44` varchar(1) DEFAULT NULL,`tema_45` varchar(1) DEFAULT NULL,`tema_46` varchar(1) DEFAULT NULL,`tema_47` varchar(1) DEFAULT NULL,`tema_48` varchar(1) DEFAULT NULL,`tema_49` varchar(1) DEFAULT NULL,`tema_50` varchar(1) DEFAULT NULL,`tema_51` varchar(1) DEFAULT NULL,`tema_52` varchar(1) DEFAULT NULL,`tema_53` varchar(1) DEFAULT NULL,`tema_54` varchar(1) DEFAULT NULL,`tema_55` varchar(1) DEFAULT NULL,`tema_56` varchar(1) DEFAULT NULL,`tema_57` varchar(1) DEFAULT NULL,`tema_58` varchar(1) DEFAULT NULL,`tema_59` varchar(1) DEFAULT NULL,`tema_60` varchar(1) DEFAULT NULL,`tema_61` varchar(1) DEFAULT NULL,`tema_62` varchar(1) DEFAULT NULL,`tema_63` varchar(1) DEFAULT NULL,`tema_64` varchar(1) DEFAULT NULL,`tema_65` varchar(1) DEFAULT NULL,`tema_66` varchar(1) DEFAULT NULL,`tema_67` varchar(1) DEFAULT NULL,`tema_68` varchar(1) DEFAULT NULL,`tema_69` varchar(1) DEFAULT NULL,`tema_70` varchar(1) DEFAULT NULL,`tema_71` varchar(1) DEFAULT NULL,`tema_72` varchar(1) DEFAULT NULL,`tema_73` varchar(1) DEFAULT NULL,`tema_74` varchar(1) DEFAULT NULL,`tema_75` varchar(1) DEFAULT NULL,`tema_76` varchar(1) DEFAULT NULL,`tema_77` varchar(1) DEFAULT NULL,`tema_78` varchar(1) DEFAULT NULL,`tema_79` varchar(1) DEFAULT NULL,`tema_80` varchar(1) DEFAULT NULL,`tema_81` varchar(1) DEFAULT NULL,`tema_82` varchar(1) DEFAULT NULL,`tema_83` varchar(1) DEFAULT NULL,`tema_84` varchar(1) DEFAULT NULL,`tema_85` varchar(1) DEFAULT NULL,`tema_86` varchar(1) DEFAULT NULL,`tema_87` varchar(1) DEFAULT NULL,`tema_88` varchar(1) DEFAULT NULL,`tema_89` varchar(1) DEFAULT NULL,`tema_90` varchar(1) DEFAULT NULL,`tema_91` varchar(1) DEFAULT NULL,`tema_92` varchar(1) DEFAULT NULL,`tema_93` varchar(1) DEFAULT NULL,`tema_94` varchar(1) DEFAULT NULL,`tema_95` varchar(1) DEFAULT NULL,`tema_96` varchar(1) DEFAULT NULL,`tema_97` varchar(1) DEFAULT NULL,`tema_98` varchar(1) DEFAULT NULL,`tema_99` varchar(1) DEFAULT NULL,`tema_100` varchar(1) DEFAULT NULL,`tema_101` varchar(1) DEFAULT NULL,`tema_102` varchar(1) DEFAULT NULL,`tema_103` varchar(1) DEFAULT NULL,`tema_104` varchar(1) DEFAULT NULL,`tema_105` varchar(1) DEFAULT NULL,`tema_106` varchar(1) DEFAULT NULL,`tema_107` varchar(1) DEFAULT NULL,`tema_108` varchar(1) DEFAULT NULL,`tema_109` varchar(1) DEFAULT NULL,`tema_110` varchar(1) DEFAULT NULL,`tema_111` varchar(1) DEFAULT NULL,`tema_112` varchar(1) DEFAULT NULL,`tema_113` varchar(1) DEFAULT NULL,`tema_114` varchar(1) DEFAULT NULL,`tema_115` varchar(1) DEFAULT NULL,`tema_116` varchar(1) DEFAULT NULL,`tema_117` varchar(1) DEFAULT NULL,`tema_118` varchar(1) DEFAULT NULL,`tema_119` varchar(1) DEFAULT NULL,`tema_120` varchar(1) DEFAULT NULL,`tema_121` varchar(1) DEFAULT NULL,`tema_122` varchar(1) DEFAULT NULL,`tema_123` varchar(1) DEFAULT NULL,`tema_124` varchar(1) DEFAULT NULL,`tema_125` varchar(1) DEFAULT NULL,`tema_126` varchar(1) DEFAULT NULL,`tema_127` varchar(1) DEFAULT NULL,`tema_128` varchar(1) DEFAULT NULL,`tema_129` varchar(1) DEFAULT NULL,`tema_130` varchar(1) DEFAULT NULL,`tema_131` varchar(1) DEFAULT NULL,`tema_132` varchar(1) DEFAULT NULL,`tema_133` varchar(1) DEFAULT NULL,`tema_134` varchar(1) DEFAULT NULL,`tema_135` varchar(1) DEFAULT NULL,`tema_136` varchar(1) DEFAULT NULL,`tema_137` varchar(1) DEFAULT NULL,`tema_138` varchar(1) DEFAULT NULL,`tema_139` varchar(1) DEFAULT NULL,`tema_140` varchar(1) DEFAULT NULL,`tema_141` varchar(1) DEFAULT NULL,`tema_142` varchar(1) DEFAULT NULL,`tema_143` varchar(1) DEFAULT NULL,`tema_144` varchar(1) DEFAULT NULL,`tema_145` varchar(1) DEFAULT NULL,`tema_146` varchar(1) DEFAULT NULL,`tema_147` varchar(1) DEFAULT NULL,`tema_148` varchar(1) DEFAULT NULL,`tema_149` varchar(1) DEFAULT NULL,`tema_150` varchar(1) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
    $stmt->close();

    // echo "INSERT INTO `lessons_hours` (`discName`, `group_number`, `exam`, `diff_exam`, `zachet`, `other_attestation`, `total`,
        // `samost_work`, `theoretical_lesson`, `laboratory_lesson`, `coursovie`, `practice`, `consultation`, `promezhutAttest`,
        // `semestr1`, `semestr2`, `semestr3`, `semestr4`, `semestr5`, `semestr6`, `semestr7`, `semestr8`, `table_number`, `completed_state`, `id_teacher`)
        // VALUES ($disc, $group, 0, 0, 0, 0, $count_hours, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $number_table, $stringuxa, $idTeacher)";

    $_SESSION['pasport_created'] = true;
    unset($_SESSION['none_disc']);
    header('Location: ../select_disciplina/select_disciplina.php');
}

//INSERT INTO `lessons_hours` (`discName`, `group_number`, `exam`, `diff_exam`, `zachet`, `other_attestation`, `total`,
// `samost_work`, `theoretical_lesson`, `laboratory_lesson`, `coursovie`, `practice`, `consultation`, `promezhutAttest`,
// `semestr1`, `semestr2`, `semestr3`, `semestr4`, `semestr5`, `semestr6`, `semestr7`, `semestr8`, `table_number`, `completed_state`)
// VALUES ('Предмет 1', '9КС-22', '0', '0', '0', '0', '70', '0', '40', '30', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '')

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main_content/css.css">
    <title>Добавить группу</title>
</head>
<body>
<a href="../select_disciplina/select_disciplina.php" class="back-to-login link-nav logoutBtn">
    Назад
</a>
<div class="container-add-group-main">
    <div class="modal-win" style="width: 580px;font-family: sans-serif">
        <form action="pasport.php" method="post" class="pasport_form">
                <h2 align="left">Паспорт предмета</h2>
                <p align='left' style="margin: 5px 0 25px 0;max-width: 580px">
                    Паспорт нужен для работы с предметом и содержит данные, такие как количество лекционных часов, прикреплённые группы.
                </p>
                <p align='left' style="margin: 5px 0 25px 0;max-width: 580px">

                </p>
                <div class="form-group">
                    <input type="text" id="inputHours" class="form-input" style="margin-bottom: 10px" name="count_hours" placeholder=" ">
                    <label class="form-label">Количество лекционных часов*</label>
                </div>
                <div class="form-group add_disc_header">
                    <input type="text" class="form-input" id="inputGroup" style="" placeholder=" ">
                    <label class="form-label">Название группы</label>
                    <span class="form-button addDiscBtn" onclick="addGroup()" style="max-width: 130px">Добавить</span>
                </div>
                <div style="display: flex; justify-content: left; margin-bottom: 7px">
                    <span align="left" style="text-decoration: underline; font-family: Calibri; font-weight: 600; font-size: 21px">Группы</span>
                </div>
                <ol class="disciplins-ul" id="ulGroup" style="margin-left: 30px; margin-bottom: 10px" id="ulDisc">
                </ol>
                <input type="text" class="invisible" name="jsondisc" id="jsoninput" value="">
            <button name="do_create_pasport" name="do_pasport" id="create_pasport" class="form-button">Создать паспорт</button>
        </form>
    </div>
</div>

<script src="registration.js"></script>
</body>
</html>
