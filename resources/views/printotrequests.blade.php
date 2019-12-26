<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Over Time</title>
</head>
<style>
    table {
        border-left: 0.01em solid #ccc;
        border-right: 0;
        border-top: 0.01em solid #ccc;
        border-bottom: 0;
        border-collapse: collapse;
        border: 1px solid #000;
    }
    table td,
    table th {
        border-left: 0;
        border-right: 0.01em solid #ccc;
        border-top: 0;
        border-bottom: 0.01em solid #ccc;
        border: 1px solid #000;
    }
</style>
<body>
<div style="background: #fff;  width: 700px; margin: 3px; font-size: 11px; font-family:sans-serif; border: 1px solid #000;">
<h2 style="margin-bottom: 5px; font-size: 25px; text-align: center">Weekly Overtime Form </h2>
    <div style="margin-left: 30px; width: 500px;">.
        <p style="margin-bottom: 8px; font-size: 12px;"><span>Employee Code:</span>
            <span style="width: 600px;margin-left: 20px;">-----------------------</span></p>

        <p style="margin-bottom: 8px;font-size: 12px;"><span>Employee Full Name:</span> &nbsp;
            <span style="width: 600px;margin-left: 20px; font-size: 13px;"><strong>{{$userDetails->name}}</strong></span></p>

        <p style="margin-bottom: 8px;font-size: 12px;"><span>HOD Manager Name:</span> &nbsp;
            <span style="width: 600px;margin-left: 20px;font-size: 13px;"><strong>{{$mgrDetails->name}}</strong></span></p>

        <p style="margin-bottom: 10px;font-size: 12px;"><span>Period Date:</span> &nbsp;
            <span style="width: 600px;margin-left: 65px;font-size: 13px;"><strong>{{$f_date}} &nbsp; To &nbsp;  {{$t_date}}</strong></span></p>
    </div>

    <table cellpadding="3" style="width: 680px; margin-left: 20px; font-size: 11px; margin-bottom: 5px;border: 1px solid #000;">
        <thead>
        <tr>
            <td colspan="3" >&nbsp;</td>
                <td colspan="2" style="text-align: center">Time</td>
            <td colspan="3" style="text-align: center">OVERTIME SCHEDULE</td>
        </tr>
        <tr>
            <th width="10%" style="text-align: center">Day</th>
            <th width="12%" style="text-align: center">Date</th>
            <th width="30%" style="text-align: center">Reason</th>
            <th width="9%" style="text-align: center">In</th>
            <th width="9%" style="text-align: center">Out</th>
            <th width="10%" style="text-align: center">6:00 PM<br />To<br />9:00 PM</th>
            <th width="10%" style="text-align: center">9:00 PM<br />To<br />4:00 AM</th>
            <th width="10%" style="text-align: center">Friday<br />&<br />Saturday</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $j= 0;
        $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $days = array();
        for ($i = 0; $i < 7; $i++) {
        $tempDay=0;
        $dayExists = false;
        if(isset($resArr)){
            foreach($resArr as $val)
            {
                if($weekdays[$i]==$val['day']) { $tempDay = $val; ?>
                <tr>
                    <td align="center">{{$val['day']}}</td>
                    <td >{{$val['date']}}</td>
                    <td > &nbsp;{{$val['reason']}}</td> <td align="center">{{$val['start_time']}}</td>
                    <td align="center">{{$val['end_time']}}</td>
                    <td align="center">{{number_format($val['initialHours'],2)}}</td>
                    <td align="center">
                        {{number_format($val['secondaryHours'],2)}}
                    </td>
                    <td ></td>
                </tr>
                <?php $dayExists = true;
                }
            }
        }
           if($dayExists==false)
            { ?>
                <tr>
                    <td align="center">{{$weekdays[$i]}}</td><td ></td>
                    <td ></td> <td ></td>
                    <td ></td> <td ></td>
                    <td ></td><td ></td>
                </tr>
    <?php   }
        } ?>

            <tr> <td colspan="8" style="height: 3px;"></td> </tr>

        <tr>
            <td colspan="5" style="text-align: right">Total Hours</td>
            <td style="text-align: center">{{number_format($initialsum,2)}}</td>
            <td style="text-align: center">{{number_format($secondarysum,2)}}</td>
            <td ></td>
        </tr>

        <tr>
            <td colspan="5" style="text-align: right">Total OverTime</td>
            <td ></td> <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Total Amount of Overtime To Pay (Dirhams)</td>
            <td ></td> <td ></td>
            <td ></td>
        </tr>
    </tbody>
    </table>

    <div style="margin-left: 30px; width: 600px; margin-top: 5px;">.
        <div style="margin-bottom: 8px; font-size: 12px;"><span>Employee Signature/Date:</span>
            <span style="width: 600px;margin-left: 36px;">
                <img src="emp_sign/{{$userDetails->emp_sign}}" id="emp_sign-tag" width="200" height="40" />
            </span></div>
       <h3 style="margin-left: 200px;">({{$userDetails->name." - ".$currdate}})</h3>
        <div style="margin-bottom: 8px;font-size: 12px;"><span>HOD Signature/Date:</span>
            @if($approvemgrsign)
            <span style="width: 600px;margin-left: 60px;">
                <img src="emp_sign/{{$mgrDetails->emp_sign}}" id="mgr_sign-tag" width="200" height="40" /></span>
            <h3 style="margin-left: 200px;">({{$mgrDetails->name." - ".$currdate}})</h3>
            @else
            <span style="width: 600px;margin-left: 60px;">--------------------------------------------------</span>
            @endif
        </div>
        <div style="margin-bottom: 8px;font-size: 12px;"><span>Approved By Executive:</span>
            @if($approvesign)
                <span style="width: 600px;margin-left: 43px;">
                        <img src="emp_sign/{{$resptUser->emp_sign}}" id="exec_sign-tag" width="200" height="40" /></span>
                <h3 style="margin-left: 200px;">({{$resptUser->name." - ".$currdate}})</h3>
            @else
                <span style="width: 600px;margin-left: 45px;">--------------------------------------------------</span><br />
                <span style="width: 600px;margin-left: 170px;"><b>Full Name / Signature / Date</b></span>
            @endif
        </div>
    </div>
    <div style="margin-left: 30px; margin-bottom: 3px; margin-top: 3px; font-size: 10px;">
        <p><strong>Formula:</strong></p>
        <p> = Basic Salary/Monthly Calendar Days/8 Hours*1.25 Overtime Rate* No. of Hours - From 6:00 PM To 9:00 PM</p>
        <p> = Basic Salary/Monthly Calendar Days/8 Hours*1.50 Overtime Rate* No. of Hours - From 9:00 PM To 4:00 AM</p>
        <p> = Basic Salary/Monthly Calendar Days/8 Hours*1.50 Overtime Rate* No. of Hours - Offdays From Friday & Saturday</p>
    </div>
    <div style="margin-left: 30px; color: #00a6b2;margin-bottom: 3px; font-size: 10px;">
        <p><strong>Reminder:</strong></p>
        <p> - Signed Overtime Forms should be place to the box located in HR department office.</p>
        <p>  - Overtime Forms need to submit weekly to HR department and cut-off is every Monday, if you fail to submit it, you cannot claim anymore your overtime on that week.</p>
        <p> - The overtime allowance will be calculated by 30 minutes and minimum overtime is 1 hour.</p>
        <p> - Fill out the form via computer, handwriting is not acceptable.</p>
    </div>
</div>
</body>
</html>
