<?php
chdir(dirname(__FILE__));
include '../security.php';
chdir(dirname(__FILE__));

                $isBannerHidden = false;
                if ($row["publicLevel"] == 0){}
                else if ($row["publicLevel"] == 1){if($row["schoolSID"] === getData("schoolSID")){}else{$isBannerHidden = true;}}
                else if ($row["publicLevel"] == 2){if($row["schoolSID"] === getData("schoolSID") and $row["schoolGrade"] === getData("schoolGrade")){if($row["schoolClass"] === getData("schoolClass")){}else{$isBannerHidden = true;}}else{$isBannerHidden = true;}}
    
?>