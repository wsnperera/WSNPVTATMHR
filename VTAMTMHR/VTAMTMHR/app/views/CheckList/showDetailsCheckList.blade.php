@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>Trainee Details<small><i class="icon-double-angle-right"></i>View</small></h1>
                </div>
            </div>
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <table  id='' class="table table-striped table-bordered table-hover">
                    <tbody>
                        @if($createTrainee)
                            <tr>
                                <td><b>Course Code : </b></td>
                                <td>{{$createTrainee->CourseCode}}</td>
                            </tr>
                            <tr>
                                <td><b>Trainee Number : </b></td>
                                <td>{{$createTrainee->training_no}}</td>
                            </tr>
                            @if(!$checkPartTime)
                            <tr>
                                <td><b>Trainee Number : </b></td>
                                <td><a href="createCheckList"> <button class="btn btn-block">OK</button></a></td>
                            </tr>
                            @endif
                        @else
                            <tr>
                                <td><b>Error :</b></td>
                                <td>You are currently registered</td>
                            </tr>
                            <tr>
                                <td><b></b></td>
                                <td><a href="createCheckList"> <button class="btn btn-block">OK</button></a></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if($checkPartTime)
                <form action="createTraineeEmployment" method="POST">
                    <table>
                        <input type="hidden" value="{{$createTrainee->id}}" name="traineeID"/>
                        <tr>
                            <td style="width: 40%" valign="top"><label>Company Name </label></td>
                            <td valign="top"><input type="text" name="Emp_Place" required="true"/><span style="color: red"><b>*</b></span></td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Employment Type </label></td>
                            <td valign="top">
                                <select name="Emp_Type" required="true">
                                    <option></option>
                                    <option>Public</option>
                                    <option>Government</option>
                                    <option>Self</option>
                                </select>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Start Date </label></td>
                            <td valign="top"><input type="date" name="Emp_Start_Date" required="true" max="{{date('Y-m-d')}}"/><span style="color: red"><b>*</b></span></td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Company Address </label></td>
                            <td valign="top">
                                <textarea name="Emp_Address" rows="4" required="true"></textarea>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Employer Name </label></td>
                            <td valign="top">
                                <Input type="text" name="EmployerName" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>EPF Number </label></td>
                            <td valign="top">
                                <Input type="text" name="EPF" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>ETF Number </label></td>
                            <td valign="top">
                                <Input type="text" name="ETF" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"><input class="btn btn-block" type="submit" value="Save" /></td>
                             <td colspan="1"><input class="btn btn-block" type="button" value="Skip" onclick="window.location.href='createCheckList'"/></td>
                        </tr>
                    </table>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": true},
            {"bSortable": false},
    ]});
</script>
