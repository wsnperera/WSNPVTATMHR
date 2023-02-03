@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span14">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>Check List
                        <small><i class="icon-double-angle-right"></i>Create</small>
                    </h1>
                </div>
                <a href="createCheckList"><button class="btn btn-primary">Add Check List</button></a><br><br>
            </div>
            <div class="row-fluid span20" style="margin: 0px;" overflow="auto">
                <table  id='sample-table-2'  class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Course List Code</th>
                            <th>Name With Initials</th>
                            <th>NIC</th>
                            <th>Application</th>
                            <th>Interview Letter</th>
                            <th>Selected Letter</th>
                            <th>Birth Certificate</th>
                            <th>Education Certificate</th>
                            <th>Service Letter</th>
                            <th>Pictures</th>
                            <th>Society Receipt</th>
                            <th>Fee Receipt</th>
                            <th>Gramaseva Certificate</th>
                            <th>Character Certificate</th>
                            <th>Medical Certificate</th>
                            <th>Service Certificate</th>
                            <th><i class="icon-edit bigger-120"></i></th>
                            <th><i class="icon-trash bigger-120"></i></th>
                        </tr>
                    </thead>
                    <tbody >
                        @if(isset ($applicantdocumentlist))
                            @foreach($applicantdocumentlist as $a)
                                <tr>
                                    <td>@if(isset($a->getApplicantDeails->CourseListCode)) {{$a->getApplicantDeails->CourseListCode}} @endif</td>
                                    <td>@if(isset($a->getApplicantDeails->NameWithInitials)) {{$a->getApplicantDeails->NameWithInitials}} @endif</td>
                                    <td>@if(isset($a->getApplicantDeails->NIC)) {{$a->getApplicantDeails->NIC}} @endif</td>
                                    <td>@if($a->originalApplication==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->interviewLetter==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->selectedLetter==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->birthCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->eduCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->serviceLetter==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->picture==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->studentSocietyReceipt==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->courseFeeReceipt==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->gramasevaCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->characterCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->medicalCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>@if($a->serviceCertificate==1) <i class="icon-ok bigger-120"></i> @else <font style="color: red"><b>X</b></font> @endif</td>
                                    <td>
                                        <form action="editCheckList" method="GET">
                                            <input type="hidden" name="applicantDocumentListPK" value="{{$a->id}}"/>
                                            <div class="hidden-phone visible-desktop btn-group">
                                                <button class="btn btn-mini btn-info">
                                                        <i class="icon-edit bigger-120"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="deleteCheckList" onsubmit="return doConfirm(this)" method="POST">
                                            <input type="hidden" name="applicantDocumentListPK" value="{{$a->id}}"/>
                                            <div class="hidden-phone visible-desktop btn-group">
                                                    <button class="btn btn-mini btn-danger">
                                                            <i class="icon-trash bigger-120"></i>
                                                    </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(formobj)
    {
        bootbox.confirm("Are you sure you want to remove ", function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
    }
    $('#sample-table-2').dataTable({
       "sScrollX": "100%",
           "bScrollCollapse": true,
           "bJQueryUI": true,
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
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
    ]});
</script>
