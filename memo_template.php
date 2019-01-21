<?php

if(!function_exists("drawSem")) {
    function drawSem($sem, $year, $reset=false) {
        static $drawn = array();
        if($reset) {
            $drawn = array();
        }
        if(!isset($drawn[$sem])) {
            $drawn[$sem] = true;
            $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><i>$sem - $year</i></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">&nbsp;</TD></TR>";
        } else {
            $html .= "";
        }
        return $html;
    }
}

$andAdministrative = count($services) > 0 ? "and Administrative " : "";

$html .= "<P>$date</P><P>From: $dean, Associate Dean, Academic</P><P>To: $name</P></P>Re: $year Teaching ".$andAdministrative."Assignments</P>

<HR>";

list($firstYear,$secondYear) = explode("/",$year);
$activeYear = $firstYear;

// Altenrate opening paragraph for part time, removed July 25 2017
/*if($percent < 75) {
    $html .= "<P>Shown below are your teaching assignments for the academic year 2017/2018. These duties are based on your percent of appointment at the rank of Lecturer, and the corresponding teaching load of Full Course Equivalencies (FCEs).  The specifics of your percent of appointment and salary will be addressed in a forthcoming contract letter.</P>";
} else {*/
    $html .= "<P style=\"text-align:justify;\">Shown below are your teaching assignments for the academic year $year.  These duties are based on your $percent% appointment at the rank of $rank, and a teaching load of $targetLoad Full Course Equivalencies (FCEs).";    
//}

$html .= "</P><BR>

<TABLE cellpadding=\"10\">";

if(count($courses)>0 OR count($coordCourses)>0) {
    $html .= "<TR><TD style=\"border: 1px solid black;\" width=\"400\"><B>Teaching Assignments</B></TD><TD style=\"border: 1px solid black;\" width=\"100\"><B>FCE</B></TD></TR>";

    $totalTeaching = 0;
    
    foreach(array('Summer (July, August) - S',
    'Fall - F',
    'Fall-Winter - Y',
    'Winter/Spring - S',
    'Summer (May, June) - F',
    'Summer - Y') as $thisSem) {

        if($thisSem=="Winter/Spring - S") {
            $activeYear = $secondYear;
        }
    
        $semStart = true;
        
        if(!strstr($activeTerms, $thisSem) AND $activeTerms != "All" AND $activeTerms != "None" AND !strstr($thisSem, " - Y")) {
            $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><i>$thisSem - $activeYear</i></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">&nbsp;</TD></TR>";
            $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>On Leave</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">&nbsp;</TD></TR>";
        }
        
        foreach($courses as $course) {
            if($course['sem']==$thisSem) {
                $html .= drawSem($thisSem, $activeYear, $semStart);
                $semStart = false;
                $teachingLabel = "";
                if(isset($coordCourses[$thisSem][$course['code']])) {
                    $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>{$course['code']}: {$course['title']} (Coordinating)</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($coordCourses[$thisSem][$course['code']]['weighting'],3)."</TD></TR>";
                    $teachingLabel = " (Teaching)";
                    $totalTeaching = $totalTeaching + $coordCourses[$thisSem][$course['code']]['weighting'];
                    unset($coordCourses[$thisSem][$course['code']]);
                }
                $courseLabel = "{$course['code']}, {$course['section']}{$course['reserved']}: {$course['title']}";
                $timeAndRoom = "<BR>{$course['times']}, {$course['room']}";
                $coTeaching = is_array($course['coinst']) > 0 ? '<BR>Co-taught with: '.implode(', ',$course['coinst']) : '';
                $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$courseLabel$teachingLabel$timeAndRoom$coTeaching</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($course['weighting'],3)."</TD></TR>";
                $totalTeaching = $totalTeaching + $course['weighting'];
            }
        }
    
        foreach($coordCourses[$thisSem] as $code=>$course) {
            $html .= drawSem($thisSem, $activeYear, $semStart);
            $semStart = false;
            $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$code: {$course['title']} (Coordinating)</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($course['weighting'],3)."</TD></TR>";
            $totalTeaching = $totalTeaching + $course['weighting'];
        }
        
    }
    if(count($coordCourses)+count($courses) > 1) {
        $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Total Teaching Assignments:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($totalTeaching,3)."</B></TD></TR>";
    }

}

if(count($services)>0) {
    $totalService = 0;
    $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Administrative Assignments</B></TD><TD style=\"border: 1px solid black;\">&nbsp;</TD></TR>";
    foreach($services as $label=>$fce) {
        $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$label</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($fce,3)."</TD></TR>";
        $totalService = $totalService + $fce;
    }
    if(count($services)>1) {
        $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Total Administrative Assignments:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($totalService,3)."</B></TD></TR>";
    }
}

if($otherService) {
    $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Other Assignments</B></TD><TD style=\"border: 1px solid black;\">&nbsp;</TD></TR>";
    $html .= "<TR><TD style=\"border: 1px solid black;\"><ul><li>$otherService</ul></li></TD><TD style=\"border: 1px solid black;\">".number_format($otherWeight,3)."</TD></TR>";
}

if(floatval($priorYearAdj)!=0) {
    $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Total Assignments:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($usedLoad+$priorYearAdj,3)."</B></TD></TR>";
    $html .= "<TR><TD style=\"border: 1px solid black;\">Prior Year credit (+) or balance owing (-)</TD><TD style=\"border: 1px solid black;\">".number_format($priorYearAdj*-1,3)."</TD></TR>";
    $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Grand Total:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($usedLoad,3)."</B></TD></TR>";
} else {
    $html .= "<TR><TD style=\"border: 1px solid black;\"><B>Total Assignments:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($usedLoad,3)."</B></TD></TR>";    
}



$html .= "<TR><TD style=\"border: 1px solid black;\">Unassigned load (may be assigned at a future date if FCE is above 0.500, and will be applied as a credit next year if it is below zero)</TD><TD style=\"border: 1px solid black;\">".number_format($availLoad,3)."</TD></TR>";

$html .= "</TABLE><BR>";

// get final text from the form where it is stored
$finalText = getData('', 29);
$finalText = htmlspecialchars_decode(display($finalText[0], 'final_text_for_memos'), ENT_QUOTES);
$html .= "<P style='text-align:justify;'>".str_replace("\n\r\n", "</P><P style='text-align:justify;'>", $finalText)."</P>";

return array($html);

