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
                    <h1>Employment Details<small><i class="icon-double-angle-right"></i>View</small></h1>
                    <a href="loadApplicantView"> << Back To Main </a>
                </div>
            </div>
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <form action="" method="POST">
                    <table>
                        <input type="hidden" value="{{$emplymentDetails->id}}" name="emplymentDetailsPK"/>
                        <tr>
                            <td style="width: 40%" valign="top"><label>Company Name </label></td>
                            <td valign="top">
                                <input type="text" name="Emp_Place" required="true" value="{{$emplymentDetails->Emp_Place}}"/>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Employment Type </label></td>
                            <td valign="top">
                                <select name="Emp_Type" required="true">
                                    <option @if($emplymentDetails->Emp_Type=='Public') selected @endif>Public</option>
                                    <option @if($emplymentDetails->Emp_Type=='Government') selected @endif>Government</option>
                                    <option @if($emplymentDetails->Emp_Type=='Self') selected @endif>Self</option>
                                </select>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Start Date </label></td>
                            <td valign="top">
                                <input type="date" name="Emp_Start_Date" required="true" max="{{date('Y-m-d')}}" value="{{$emplymentDetails->Emp_Start_Date}}"/>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Company Address </label></td>
                            <td valign="top">
                                <textarea name="Emp_Address" rows="4" required="true">{{$emplymentDetails->Emp_Address}}</textarea>
                                <span style="color: red"><b>*</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>Employer Name </label></td>
                            <td valign="top">
                                <Input type="text" name="EmployerName" value="{{$emplymentDetails->EmployerName}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>EPF Number </label></td>
                            <td valign="top">
                                <Input type="text" name="EPF" value="{{$emplymentDetails->EPF}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label>ETF Number </label></td>
                            <td valign="top">
                                <Input type="text" name="ETF" value="{{$emplymentDetails->ETF}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="btn btn-block" type="submit" value="Edit" /></td>
                        </tr>
                    </table>
                </form>
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