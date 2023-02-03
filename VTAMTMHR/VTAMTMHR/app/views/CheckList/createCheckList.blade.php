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
                    <h1>Check List<small><i class="icon-double-angle-right"></i>Create</small></h1>
                    <a href="viewCheckList"><< Back To Main</a>
                </div>
            </div>
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <table  id='sample-table-2' class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Check(**)</th>
                            <th>Organzation</th>
                            <th>Applicant Full Name</th>
                            <th>NIC</th>
                            <th>Date Of Birth</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Tel</th>
                            <th>Tel 2</th>
                            <th>Course List Code</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <?php
                    $organizaton = User::getCurrentPromotion();
                    if (isset($organizaton->ToOrganisation)) {
                        $orgId = $organizaton->ToOrganisation;
                    } else {
                        $orgId = User::getSysUser()->organisationId;
                    }
                    $organization = Organisation::where('id', '=', $orgId)
                            ->pluck('OrgaName');
                    ?>
                    <tbody>
                        @if(isset ($applicant))
                        @foreach($applicant as $a)
                        <?php
                        $note = ApplicantDocumentList::getNote($a['NIC'],$a['CourseListCode']);
                        ?>
                        @if($note['clc'] != 'true')
                        <tr>
                            <td>
                            <form  method="GET" action="createCheckListPage2">
                                    <input type="hidden" name='appPK' value='{{$a['id']}}' />
                                    <input type="hidden" name='courseListCode' value='{{$a['CourseListCode']}}' />
                                    <input type="hidden" name='courseYearPlanID' value='{{$a['cypID']}}' />
                                    <button type="submit" class="btn btn-grey btn-small"><i class="icon-check icon-2x icon-only"></i></button>
                                </form>
								 @if($note['note'] == '')
								 <!--<form  method="GET" action="createCheckListPage2">
                                    <input type="hidden" name='appPK' value='{{$a['id']}}' />
                                    <input type="hidden" name='courseListCode' value='{{$a['CourseListCode']}}' />
                                    <input type="hidden" name='courseYearPlanID' value='{{$a['cypID']}}' />
                                    <button type="submit" class="btn btn-grey btn-small"><i class="icon-check icon-2x icon-only"></i></button>
                                </form>-->
                                @endif
                            </td>
                            <td>{{$organization}}</td>
                            <td>{{$a['FullName']}}</td>
                            <td>{{$a['NIC']}}</td>
                            <td>{{$a['DOB']}}</td>
                            <td>{{$a['Age']}}</td>
                            <td>{{$a['Gender']}}</td>
                            <td>{{$a['Tel']}}</td>
                            <td>{{$a['Tel_mob']}}</td>
                            <td>{{$a['CourseListCode']}}</td>
                            <td><font style="color: red">{{$note['note']}}</font></td>
                        </tr>
                        @endif
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
