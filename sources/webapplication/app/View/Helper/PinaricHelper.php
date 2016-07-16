<?php
class PinaricHelper extends AppHelper {
    protected $day_nests = 42;

    public function renderMonth($month, $year) {
        $days = cal_days_in_month(CAL_JULIAN,$month,$year);
        $days_offset = jddayofweek(gregoriantojd($month,1,$year)) - 1;
        // Потому что у этих уродов в всяких этих пиндостанах неделя начинается в воскресенье
        $days_offset = $days_offset == -1 ? 6 : $days_offset;

        return $this->monthWrapper($days,$days_offset,$month,$year);
    }

    protected function monthWrapper($days,$days_offset, $month, $year) {
        $init = '<div class="content2"><div class="calnder"><div class="column_right_grid calender"><div class="cal1"><div class="clndr">';
        $month_title = '<div class="clndr-controls ' .$this->getSeasonClass($month). '"><div class="month">' .jdmonthname(gregoriantojd($month,1,$year),1). '</div></div>';
        $table = '<table class="clndr-table"><thead>';
        $day_names = '<tr class="header-days"><td class="header-day">MON</td><td class="header-day">TUE</td><td class="header-day">WED</td>
        <td class="header-day">THU</td><td class="header-day">FRI</td><td class="header-day">SAT</td><td class="header-day">SUN</td></tr></thead>';

        $days_block = '<tbody><tr>';
        // Days from previous month
        for($day = 1; $day <= $days_offset; $day++) {
            $days_block .= '<td class="day past adjacent-month last-month"><div class="day-contents empty-day"></div></td>';
        }
        // Days from this month
        for($day = 1; $day <= $days; $day++) {
            $days_block .= '<td class="day past y-' .$year. '-m-' .$month. '"><div class="day-contents d-' .$day. '">' .$day. '</div></td>';
            if(($days_offset + $day) % 7 == 0){ $days_block.= '</tr><tr>'; }
        }
        // The rest of the month
        for($day = 1; $day <= $this->day_nests - $days_offset - $days; $day++) {
            $days_block .= '<td class="day past adjacent-month last-month"><div class="day-contents empty-day"></div></td>';
            if(($days + $days_offset + $day == $this->day_nests)){ break; }
            if(($days + $days_offset + $day) % 7 == 0){ $days_block .= '</tr><tr>'; }
        }
        $days_block .= '</tr></tbody>';

        $end = '</table></div></div></div></div></div>';

        return $init . $month_title . $table . $day_names . $days_block . $end;
    }

    protected function getSeasonClass($month) {
        switch($month){
            case 1:case 2:case 12:
                return 'winter';
            case 3:case 4:case 5:
                return 'spring';
            case 6:case 7:case 8:
                return 'summer';
            case 9:case 10:case 11:
                return 'autumn';
        }
    }
}