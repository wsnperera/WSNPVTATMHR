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
                            Assigned(Page 1)
                        </small>			
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <div class="table-header">
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Institute</th>
                            <th>Organization</th>
                            <th>No Of Pending Request</th>
                            <th>No Of Conformed Request On {{date('Y')-1}} - {{date('Y')+1}}</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($CourseYearPlan))
                            @foreach($CourseYearPlan as $yp)
                                <tr>
                                    <td>VTA</td>
                                    <td>{{CourseYearPlan::getOrganizatinName($yp->OrgId)}}</td>
                                    <td><font style="color: blue;"><h4>{{CourseYearPlan::getNOConfirmFirstPage($yp->OrgId)}}</h4></font></td>
                                    <td><font style="color: blue;"><h4>{{CourseYearPlan::getNOConfirmedRequest($yp->OrgId)}}</h4></font></td>
                                    <td>
                                        <form method="GET" action="ConfirmCourseYearPlan">
                                            <input type="hidden" name='OrgId' value='{{$yp->OrgId}}' />
                                            <button type="submit" class="btn btn-grey btn-small"><i class="icon-edit icon-2x icon-only"></i></button>
                                        </form>
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
    $('.confirm').change(function(){
        var id = $(this).val();
        var val;
        if($(this).prop('checked'))
        {
            val=1;
        }
        else
        {
            val=0;
        }
        $.ajax
        ({
            type: "POST",
            url: 'ConfirmCourseYearPlan',
            data:{id : id,confirm : val},
            success: function(result)
            {
            }
        });
    })
</script>
