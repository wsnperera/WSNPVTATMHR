@include('includes.bar') 
@if($get)
    <div class="page-content">
        <div class="row-fluid">
            <div class="page-header position-relative">
                <h1>Course Year Plan<small><i class="icon-double-angle-right"></i>Import</small></h1>
            </div>
            <a href={{url('viewCourseYearPlan')}}> << Back to View </a>
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <table class="table">
                    <tr>
                        <th>Check/Un-Check</th>
                        <th>Institute</th>
                        <th>Organization</th>
                        <th>Course List Code</th>
                        <th>Batch</th>
                        <th>Medium </th>
                        <th>Fee</th>
                        <th>Aptitude Test</th>
                        <th>Start Date</th>
                    </tr>
                    @if(isset ($BeforeYearPlan))
                        @foreach($BeforeYearPlan as $yp)
                        <form method='post'>
                            <tr>
                                <td><div class="control-group"><div class="controls"><lable><input class='checkVP' name='id[]' type="checkbox"  value="{{$yp->id}}" checked /><span class="lbl"></span></lable></div></div></td>
                                <td>{{$yp->getInstitution->InstituteName}}</td>
                                <td>{{$yp->getOrganisation->OrgaName}}</td>
                                <td>{{$yp->CourseListCode}}</td>
                                <td id='batch'>{{$yp->batch}}</td>
                                <td>{{$yp->medium}}</td>
                                <td>{{$yp->Fee}}</td>
                                <td>{{$yp->AptitudeTest}}</td>
                                <td id='dateOfStart'>{{$yp->startDate}}</td>
                            </tr>
                            @endforeach
                            @if($BeforeYearPlan=='[]')
                                </table><center>Data Not Found</center>
                            @else
                            <tr>
                                <td colspan="9"><input type='submit' value="NEXT" class="btn btn-block"/></td>
                            </tr>
                            @endif
                        </form>
                    @endif
                </table>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
@else
    <div class="page-content">
        <div class="row-fluid">
            <div class="page-header position-relative">
                <h1>Course Year Plan<small><i class="icon-double-angle-right"></i>Import 2</small></h1>
                <a href={{url('viewCourseYearPlan')}}> << Back to View </a>
            </div>
            <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
            <div class="span12">
                <form method='post' action='CreateCourseYearPlan2'>
                    <table class="table" style="width: 100%">
                        <tr>
                            <th>Check/Un-Check</th>
                            <th>Institute</th>
                            <th>Organization</th>
                            <th>Course List Code</th>
                            <th>Batch</th>
                        </tr>
                    @if(isset ($BeforeYearPlan))
                        @foreach($BeforeYearPlan as $yp)
                            @if(CourseYearPlan::checkExist($yp->instId,$yp->OrgId,$yp->CourseListCode))
                                <tr>
                                    <td><div class="control-group"><div class="controls"><lable><input class='checkVP' name='id[]' type="checkbox"  value="{{$yp->id}}" checked/><span class="lbl"></span></lable></div></div></td>
                                    <td>{{$yp->getInstitution->InstituteName}}</td>
                                    <td>{{$yp->getOrganisation->OrgaName}}</td>
                                    <td><input type='text' name='CourseListCode{{$yp->id}}' value='{{$yp->CourseListCode}}' readonly /></td>
                                    <td>
                                        <input type="text" value='{{$yp->batch}}' name='batch{{$yp->id}}' readonly/>
                                    </td>
                                    <input type="hidden" value='{{$yp->medium}}' name='medium{{$yp->id}}' readonly/>
                                    <input type="hidden" value='{{$yp->Fee}}' name='Fee{{$yp->id}}' readonly/>
                                    <input type="hidden" value='{{$yp->AptitudeTest}}' name='AptitudeTest{{$yp->id}}' readonly/>
                                    <input type="hidden" value='{{$yp->parallelGroups}}' name='parallelGroups{{$yp->id}}' readonly/>
                                </tr>
                            @endif
                            @endforeach
                            @if(count($BeforeYearPlan)<=0)
                                <center>Data Not Found</center>
                            @else
                            <tr>
                                <td>Start Date</td>
                                <td><input type='date'  name='startDate' id="strdate" min="{{date('Y-m-d')}}"/>	</td>
                                <td colspan="3"><input id='sub' type='submit' value='Finish' class="btn btn-block"/></td>
                            </tr>
                            @endif
                        @endif
                    </table>
                </form>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
@endif
@include('includes.footer')
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#sub').hide();
    });
    
    $("#strdate").bind('change',function(){
        if($(this).val()==''){
            $('#sub').hide();
        }else{
            $('#sub').show();
        }
    })
    
</script>