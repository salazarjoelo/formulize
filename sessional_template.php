<?php

$html = "

<P>$date</P>

<P>$name<BR>$address<BR>$city, $province<BR>$pc, $country</P>

<P>$email</P>

<P>Re: $year Academic Year Sessional Lecturer Appointment</P>

<P>Dear $name:</P>

<P>On behalf of the John H. Daniels Faculty of Architecture, Landscape, and Design, I am pleased to offer you a $positionBlurb for the period beginning $startdate and ending $enddate.";

if($immigration) {
    $html .= " This offer is conditional on you being legally entitled to work in Canada, in this position.";
}

$html .= "</P>";

if(strstr($rank, 'Writing')) {
    $html .= "<P>You will be paid $salary per hour plus 4 % vacation pay for a total of $totalSalary. Your salary will be paid by direct deposit.</P>";
} else {
    $html .= "<P>You will be paid $salary per half course, inclusive of vacation pay. Your salary will be paid by direct deposit.</P>";
}

$html .= "<P>Your payroll documentation will be available online through the University's Employee Self-Service (ESS) at <A HREF='http://www.hrandequity.utoronto.ca/resources/ess.htm'>http://www.hrandequity.utoronto.ca/resources/ess.htm</A>. This includes electronic delivery of your pay statement, tax documentation, and other payroll documentation as made available from time to time. You are able to print copies of these documents directly from ESS.  By signing this Employment Agreement, you authorize the University to provide your T4 slips electronically and not in a paper format. If you wish to discuss an alternative format, please contact Central Payroll Services at <A HREF='mailto:payroll.hr@utoronto.ca'>payroll.hr@utoronto.ca</A>.</P>";

if(strstr($rank, 'Writing')) {
    $html .= "<P>As a Writing Instructor, you will be a member of the Canadian Union of Public Employees (CUPE) Local 3902, Unit 3 Bargaining unit.</P>";
} else {
    $html .= "<P>Your duties, as governed by Article 7:03 of the Collective Agreement between the Governing Council of the University of Toronto and the Canadian Union of Public Employees (CUPE) 3902, Unit 3 will include teaching in the $program:<UL>";
foreach($courses as $course) {
	$html .= "<LI>{$course['code']} - {$course['title']}, Section {$course['section']}<BR>{$course['times']}<BR>{$course['room']}</LI>";
}
$html .= "</UL>Any additional work required that arises out of this appointment (e.g. deferred exams) and which is required to take place following the normal ending date of this appointment will be compensated in accordance with Article 29: Remuneration for Teaching-Related Service.</P>";
}

$html .= "<P>Your terms and conditions of employment will be governed by the collective agreement between the University of Toronto and the CUPE Local 3902 Unit 3, which is available on the web at: <A HREF='http://agreements.hrandequity.utoronto.ca/#CUPE3902_Unit3'>http://agreements.hrandequity.utoronto.ca/#CUPE3902_Unit3</A>. Once you accept this offer of employment, a copy of the agreement will be provided to you if you do not already have one.</P>";

if($travelAllowance) {
    $html .= "<P>Upon production of original receipts, you will be eligible for reimbursement for your travel and accommodation expenses, up to a maximum of CAD $travelAllowance.</P>";
}

$html .= "<P>You will also be subject to and bound by University policies of general application and their related guidelines. The policies are listed on the Governing Council website at <A HREF='http://www.governingcouncil.utoronto.ca/Governing_Council/Policies.htm'>http://www.governingcouncil.utoronto.ca/Governing_Council/Policies.htm</A>. For convenience, a partial list of policies, those applicable to all employees, and related guidelines can be found on the Human Resources and Equity website at <A HREF='http://www.hrandequity.utoronto.ca/about-hr-equity/policies-guidelines-agreements.htm'>http://www.hrandequity.utoronto.ca/about-hr-equity/policies-guidelines-agreements.htm</A>. Printed versions will be provided, upon request, through Human Resources.</P>

<P>You should pay particular attention to those policies which confirm the University's commitment to, and your obligation to support, a workplace that is free from discrimination and harassment as set out in the Human Rights Code, is safe as set out in the Occupational Health and Safety Act, and that respects the University's commitment to equity and to workplace civility.</P>

<P>All of the applicable policies may be amended and/or new policies may be introduced from time to time. When this happens, if notice is required you will be given notice as the University deems necessary and the amendments will become binding terms of your employment contract with the University.</P> 
 
<P>Information regarding the Health Care Spending Account and the enrollment form may be found at <A HREF='http://benefits.hrandequity.utoronto.ca/cupe-local-3902-unit-3-health-care-spending-account/'>http://benefits.hrandequity.utoronto.ca/cupe-local-3902-unit-3-health-care-spending-account/</A></P>";

if(strstr($rank, 'Sessional')) {
    $html .= "<P>As part of your terms of employment, you are eligible to participate in a Group Registered Retirement Savings Plan (GRRSP). If you join the Plan, you will contribute $percentText percent ($percentNumber%) of eligible income and a matching amount will be contributed by the University. For further information about the Plan, visit <A HREF='http://benefits.hrandequity.utoronto.ca/cupe-local-3902-unit-3-group-registered-retirement-savings-plan/'>http://benefits.hrandequity.utoronto.ca/cupe-local-3902-unit-3-group-registered-retirement-savings-plan/</A>. To enroll, please complete the enclosed form and send it to Central Benefits at 215 Huron Street, 8th floor.</P>";
}

$html .= "<P>The University has a number of programs and services available to employees who have need of accommodation due to disability through its Health & Well-being Programs and Services (<A HREF='http://www.hrandequity.utoronto.ca/about-hr-equity/health.htm'>http://www.hrandequity.utoronto.ca/about-hr-equity/health.htm</A>). A description of the accommodation process is available in the Accommodation for Employees with Disabilities: U of T Guidelines, which may be found at: <A HREF='http://well-being.hrandequity.utoronto.ca/services/#accommodation'>http://well-being.hrandequity.utoronto.ca/services/#accommodation</A></P>

<P>In the event that you have a disability that would impact upon how you would respond to an emergency in the workplace (e.g., situations requiring evacuation), you should contact Health & Well-being Programs & Services at 416-978-2149 as soon as possible so that you can be provided with information regarding an individualized emergency response plan.</P>

<P>The law requires the Employment Standards Act Poster to be provided to all employees; it is available on <A HREF='http://www.labour.gov.on.ca/english/es/pubs/poster.php'>http://www.labour.gov.on.ca/english/es/pubs/poster.php</A>. This poster describes the minimum rights and obligations contained in the <I>Employment Standards Act</I>. Please note that in many respects this offer of employment exceeds the minimum requirements set out in the Act.</P>";

if($rank == 'Sessional Lecturer I') {
	$html .= "<P>You could be eligible for consideration for advancement to the next rank if with this appointment you will have taught in four (4) of the last six (6) years and at least eight (8) half courses.</P>";
}
if($rank == 'Sessional Lecturer II') {
	$html .= "<P>You could be eligible for consideration for advancement to the next rank if with this appointment you are beginning your fourth year at the rank of Sessional Lecturer II, and have taught an average of four (4) half courses per year in the preceding three (3) years.</P>";
}
if($rank == 'Writing Instructor I') {
    $html .= "<P>You could be eligible for consideration for advancement to the next rank if with this appointment you will have worked four (4) of the last six (6) years and a minimum of six hundred (600) hours.</P>";
}
if($rank == 'Sessional Lecturer I' OR $rank == 'Sessional Lecturer II' OR $rank == 'Writing Instructor I') {
	$html .= "<P>Complete eligibility criteria may be found in the Collective Agreement.  Please contact CUPE 3902 or visit <A HREF='http://www.cupe3902.org'>www.cupe3902.org</A> for more information. The deadline to initiate the advancement process is either September 30 or January 31. I encourage you to apply for advancement when you meet the criteria.</P>";
}


$html .= "

<P>Before you are able to begin work, you are required to provide your Social Insurance Number, and a valid work permit if applicable, to $bo, Business Officer.</P> 

<P>If you accept this offer, I would appreciate you signing a copy of this letter together with the attached tax forms and a void cheque (unless your banking information remains unchanged) and returning it to $bo, Business Officer (via email <A HREF='mailto:$boemail'>$boemail</A>) no later than $signbackDate. Should you have any questions regarding this offer, please do not hesitate to contact $programDirector, Program Director, $pdProgram <A HREF='mailto:$programDirectorEmail'>$programDirectorEmail</A></P> 

<P>Yours sincerely,</P><BR><BR><P>$cao<BR>Chief Administrative Officer</P>

<P>cc: $programDirector, Program Director, $pdProgram</P>";

$html2 = "<P><B><I>I have read this letter, the attachments, and the items referred to in the attachments, and accept employment on the basis of all these provisions.</I></B></P>

<BR>
<BR>
<BR>
	
<P>___________________________<BR>
$name</P>	

<BR>
<BR>
<BR>

<P>___________________________<BR>
Date</P>";

return array($html, $html2);






