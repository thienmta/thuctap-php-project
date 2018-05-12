<?php
/**
 * Created by DEHA VIETNAM JSC. All Rights Reserved.
 * User: trunghpb
 * Date: 2018/03/09
 * Time: 16:26
 */

class DateTimeFormat {
    private $format_date = 'Y/m/d';

    public function date($date =  null){
        if (is_string($date)) {
            return date($this->format_date, strtotime($date));
        }

        return date($this->format_date);
    }
}

function du(){
    return new DateTimeFormat();
}