<?php
class PinaricHelper extends AppHelper {
    public $day_nests = 42;

    public function renderYear($year, $days) {
        $response = '';

        $month = 1;
        $day_counter = 0;

        while($day_counter < count($days)) {
            $response .= $this->renderMonth($year, $month, array_slice($days, $day_counter, cal_days_in_month(CAL_JULIAN, $month, $year)));
            $day_counter += cal_days_in_month(CAL_JULIAN, $month, $year);
            $response .= $month % 4 == 0 ? '<div class="clearflix"></div>' : '';
            $month++;
        }

        return $response;
    }

    public function renderMonth($year, $month, $days) {
        $days_offset = jddayofweek(gregoriantojd($month,1,$year)) - 1;
        $days_offset = $days_offset == -1 ? 6 : $days_offset;

        return $this->_View->element('pinaric', ['year' => $year, 'month' => $month, 'days' => $days, 'days_offset' => $days_offset]);
    }

    public function getSeasonClass($month) {
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

    public function getMoodClass($rating) {
        return [
            -3 => 'black-day',
            -2 => 'awful-day',
            -1 => 'bad-day',
             0 => 'normal-day',
             1 => 'not-bad-day',
             2 => 'successful-day',
             3 => 'perfect-day'
        ][$rating];
    }
}