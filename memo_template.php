<?php

$andAdministrative = count($services) > 0 ? "and Administrative " : "";

$html .= "<P>$date</P><P>From: $dean, Associate Dean, Academic</P><P>To: $name</P></P>Re: $year Teaching ".$andAdministrative."Assignments</P>

<HR>";

list($firstYear,$secondYear) = explode("/",$year);
$activeYear = $firstYear;

// Altenrate opening paragraph for part time, removed July 25 2017
/*if($percent < 75) {
    $html .= "<P>Shown below are your teaching assignments for the academic year 2017/2018. These duties are based on your percent of appointment at the rank of Lecturer, and the corresponding teaching load of Full Course Equivalencies (FCEs).  The specifics of your percent of appointment and salary will be addressed in a forthcoming contract letter.</P>";
} else {*/
    $html .= "<P>Shown below are your teaching assignments for the academic year $year.  These duties are based on your $percent% appointment at the rank of $rank, and a teaching load of $targetLoad Full Course Equivalencies (FCEs).";    
//}

$html .= "</P><BR>

<TABLE style=\"border: 1px solid black;\" cellpadding=\"10\">";

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
                if($semStart) {
                    $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><i>$thisSem - $activeYear</i></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">&nbsp;</TD></TR>";
                    $semStart = false;
                }
                $teachingLabel = "";
                if(isset($coordCourses[$thisSem][$course['code']])) {
                    $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>{$course['code']}: {$course['title']} (Coordinating)</ul></li></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($coordCourses[$thisSem][$course['code']]['weighting'],3)."</TD></TR>";
                    $teachingLabel = " (Teaching)";
                    $totalTeaching = $totalTeaching + $coordCourses[$thisSem][$course['code']]['weighting'];
                    unset($coordCourses[$thisSem][$course['code']]);
                }
                $courseLabel = "{$course['code']}, {$course['section']}: {$course['title']}";
                $timeAndRoom = "<BR>{$course['times']}, {$course['room']}";
                $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$courseLabel$teachingLabel$timeAndRoom</li></ul></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($course['weighting'],3)."</TD></TR>";
                $totalTeaching = $totalTeaching + $course['weighting'];
            }
        }
    
        foreach($coordCourses[$thisSem] as $code=>$course) {
            $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$code: {$course['title']} (Coordinating)</ul></li></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($course['weighting'],3)."</TD></TR>";
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
        $html .= "<TR><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\"><ul><li>$label</ul></li></TD><TD style=\"border-left: 1px solid black;border-right: 1px solid black;\">".number_format($fce,3)."</TD></TR>";
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

$html .= "<TR><TD style=\"border: 1px solid black;\"><B>Total Assignments:</B></TD><TD style=\"border: 1px solid black;\"><B>".number_format($usedLoad,3)."</B></TD></TR>";

$html .= "<TR><TD style=\"border: 1px solid black;\">Unassigned load (may be assigned at a future date if FCE is at or above 0.500, and will be applied as a credit next year if it is below zero)</TD><TD style=\"border: 1px solid black;\">".number_format($availLoad,3)."</TD></TR>";

$html .= "</TABLE><BR>";

$html .= "<P>In addition to the above assignments, the remainder of your appointment is available for research, creative professional activity and service to the University. Faculty are expected to be in residence in Toronto during all teaching sessions, and during the weeks of preparation prior to the sessions, and the weeks of marking and evaluation processes that follow. Faculty must adhere to all university guidelines and policies regarding changes to, or absences from scheduled courses.</P>  

<P>Core faculty with appointments at or above 50% are also expected to attend all scheduled core and program meetings, as well as faculty council meetings that do not coincide with teaching obligations. All Core design and visual studies faculty should be available to serve on undergraduate and graduate mid-term and final reviews. In addition, all core faculty are expected to attend DFALD Convocation/Awards Ceremonies typically held mid-June.</P>

<P>If for any reason you will not be available during the critical times and dates outlined above, please give the Dean's office advanced notice.</P>

<P>*Starting in 2017-2018 we are expressing teaching assignments in full course equivalent (FCE) rather than half course equivalent (HCE).  1 HCE = 0.5 FCE.  This to harmonize our nomenclature with the University's standards.";

return array($html);