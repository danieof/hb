<?php
function getWeekDays() {
    return array(
        0 => 'Nie',
        1 => 'Pon',
        2 => 'Wt',
        3 => 'Śr',
        4 => 'Czw',
        5 => 'Pt',
        6 => 'Sob',
    );
}

function getWeekDaysForList($arr) {
    $z = getWeekDays();
    $return = array();
    foreach ($arr as $val) {
        $return[] = $z[$val['week_day']];
    }
    return $return;
}