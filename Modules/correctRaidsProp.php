<?php
    require "../Database/Mysql.php";
    $keyData = new KeyData();
    $db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $idea = $db->query('SELECT * FROM `v-raids` WHERE id = 2587')->fetch();

    $offlimits = array();
    $offlimits[1] = explode(",", $idea->casts);
    $offlimits[2] = explode(",", $idea->deaths);
    $offlimits[3] = explode(",", $idea->dispels);
    $offlimits[4] = explode(",", $idea->graphdmg);
    $offlimits[5] = explode(",", $idea->graphdmgt);
    $offlimits[6] = explode(",", $idea->graphheal);
    $offlimits[7] = explode(",", $idea->inddeath);
    $offlimits[8] = explode(",", $idea->inddbp);
    $offlimits[9] = explode(",", $idea->indddba);
    $offlimits[10] = explode(",", $idea->indddte);
    $offlimits[11] = explode(",", $idea->inddtbp);
    $offlimits[12] = explode(",", $idea->inddtfa);
    $offlimits[13] = explode(",", $idea->inddtfs);
    $offlimits[14] = explode(",", $idea->indhba);
    $offlimits[15] = explode(",", $idea->indhtf);
    $offlimits[16] = explode(",", $idea->indint);
    $offlimits[17] = explode(",", $idea->indprocs);
    $offlimits[18] = explode(",", $idea->indintm);
    $offlimits[19] = explode(",", $idea->newbuffs);
    $offlimits[20] = explode(",", $idea->newdebuffs);
    $offlimits[21] = explode(",", $idea->indrecords);
    $offlimits[22] = explode(",", $idea->loot);
    $offlimits[23] = explode(",", $idea->graphff);

    $db->query('UPDATE `v-raids` SET rdy = "1",
        casts = "'.(intval($offlimits[1][0])).','.(intval($offlimits[1][0])+20000000).'",
        deaths = "'.(intval($offlimits[2][0])).','.(intval($offlimits[2][0])+20000000).'",
        dispels = "'.(intval($offlimits[3][0])).','.(intval($offlimits[3][0])+20000000).'",
        graphdmg = "'.(intval($offlimits[4][0])).','.(intval($offlimits[4][0])+20000000).'",
        graphdmgt = "'.(intval($offlimits[5][0])).','.(intval($offlimits[5][0])+20000000).'",
        inddbp = "'.(intval($offlimits[6][0])).','.(intval($offlimits[6][0])+20000000).'",
        graphheal = "'.(intval($offlimits[7][0])).','.(intval($offlimits[7][0])+20000000).'",
        inddeath = "'.(intval($offlimits[8][0])).','.(intval($offlimits[8][0])+20000000).'",
        inddtbp = "'.(intval($offlimits[9][0])).','.(intval($offlimits[9][0])+20000000).'",
        indddba = "'.(intval($offlimits[10][0])).','.(intval($offlimits[10][0])+20000000).'",
        indddte = "'.(intval($offlimits[11][0])).','.(intval($offlimits[11][0])+20000000).'",
        inddtfa = "'.(intval($offlimits[12][0])).','.(intval($offlimits[12][0])+20000000).'",
        inddtfs = "'.(intval($offlimits[13][0])).','.(intval($offlimits[13][0])+20000000).'",
        indhba = "'.(intval($offlimits[14][0])).','.(intval($offlimits[14][0])+20000000).'",
        indhtf = "'.(intval($offlimits[15][0])).','.(intval($offlimits[15][0])+20000000).'",
        indint = "'.(intval($offlimits[16][0])).','.(intval($offlimits[16][0])+20000000).'",
        indprocs = "'.(intval($offlimits[17][0])).','.(intval($offlimits[17][0])+20000000).'",
        indintm = "'.(intval($offlimits[18][0])).','.(intval($offlimits[18][0])+20000000).'",
        newbuffs = "'.(intval($offlimits[19][0])).','.(intval($offlimits[19][0])+20000000).'",
        newdebuffs = "'.(intval($offlimits[20][0])).','.(intval($offlimits[20][0])+20000000).'",
        indrecords = "'.(intval($offlimits[21][0])).','.(intval($offlimits[21][0])+20000000).'",
        loot = "'.(intval($offlimits[22][0])).','.(intval($offlimits[22][0])+20000000).'",
        graphff = "'.(intval($offlimits[23][0])).','.(intval($offlimits[23][0])+20000000).'" 
    WHERE id>2587 AND id <2604');
?>