<div class="content2">
    <div class="calnder">
        <div class="column_right_grid calender">
            <div class="cal1">
                <div class="clndr">
                    <div class="clndr-controls <?= $this->Pinaric->getSeasonClass($month) ?>">
                        <div class="month">
                            <?= jdmonthname(gregoriantojd($month,1,$year),1) ?>
                        </div>
                    </div>

                    <table class="clndr-table">
                        <thead>
                            <tr class="header-days">
                                <td class="header-day">MON</td>
                                <td class="header-day">TUE</td>
                                <td class="header-day">WED</td>
                                <td class="header-day">THU</td>
                                <td class="header-day">FRI</td>
                                <td class="header-day">SAT</td>
                                <td class="header-day">SUN</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php for($day = 1; $day <= $days_offset; $day++): ?>
                                <td class="day past adjacent-month last-month"><div class="day-contents empty-day"></div></td>
                            <?php endfor; ?>

                            <?php
                                $count = 1;
                                foreach($days as $day) {
                                    echo '<td class="day past '.$day->date. ' '. $this->Pinaric->getMoodClass($day->rating) .'"><div class="day-contents">'.date('j', strtotime($day->date)).'</div></td>';
                                    echo ($days_offset + $count) % 7 == 0 ? '</tr><tr>' : '';
                                    $count++;
                                }
                                $count--;
                            ?>

                            <?php for($day = 1; $day <= $this->Pinaric->day_nests - $days_offset - $count; $day++): ?>
                                <td class="day past adjacent-month last-month"><div class="day-contents empty-day"></div></td>
                                <?php if(($count + $days_offset + $day == $this->Pinaric->day_nests)){ break; } ?>
                                <?= ($count + $days_offset + $day) % 7 == 0 ? '</tr><tr>' : '' ?>
                            <?php endfor; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
