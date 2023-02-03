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
                    <h1>
                        Course Year Plan			
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Assigned(Page 2)
                        </small>
                    </h1>
                    <a href="ConfirmCourseYearPlanFirstPage"><< BACK </a>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <div class="table-header">
                </div>
                <table  id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Institute</th>
                            <th>Organization</th>
                            <th>Course Name</th>
                            <th>Batch</th>
                            <th>Medium</th>
                            <th>Fee</th>
                            <th>Aptitude Test</th>
                            <th>Start Date</th>
                            <th>States</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($CourseYearPlan))
                        @foreach($CourseYearPlan as $yp)
                        <tr>
                            <td>{{$yp->Year}}</td>
                            <td>{{$yp->getInstitution->InstituteName}}</td>
                            <td>{{CourseYearPlan::getOrganizatinName($yp->OrgId)}}</td>
                            <td>{{Course::getCourseName($yp->CourseListCode)}}</td>
                            <td>{{$yp->batch}}</td>
                            <td>{{$yp->medium}}</td>
                            <td>{{$yp->Fee}}</td>
                            <td>{{$yp->AptitudeTest}}</td>
                            <td>{{$yp->startDate}}</td>
                            <td>
                                <div class="span3">
                                    <label>
                                        @if($yp->confirm==1)
                                        <form action="viewModulesToCourse" method="GET">
                                            <input type="hidden" name="yearPalnID" value="{{$yp->id}}" />
                                            <input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="btn btn-pink " />
                                        </form>
                                        @elseif($yp->confirm==2)
                                        <form action="assignModulesToCourse" method="GET">
                                            <input type="hidden" name="yearPalnID" value="{{$yp->id}}" />
                                            <input type="submit" value="Assign Module" class="btn btn-primary" />
                                        </form>
                                        @elseif($yp->confirm==0)
                                        <form action="assignModulesToCourse" method="GET">
                                            <input type="hidden" name="yearPalnID" value="{{$yp->id}}" />
                                            <input type="submit" value="Assign Module" class="btn btn-primary" />
                                        </form>
                                        @endif
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </td>
                        </tr> 
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
$('#sample-table-2').dataTable({
    "aoColumns": [
        null,
        null,
        {"bSortable": false},
        null,
        null,
        null,
        {"bSortable": false},
        null,
        null,
        {"bSortable": false}
    ]});
</script>
