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
                            View 
                        </small>			
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <div class="table-header">
                </div>

<!--@if($user->hasPermission('importLastYearCourseYearPlan'))
 <a href={{url('CreateCourseYearPlan')}}><input type='button' value='Import Last Year Course Plans' class="btn"/></a>
               @endif -->
               <br><br>
              
				<form class="form-horizontal" action="" method="POST" name="form1"  >
				<table>
					<tr>
					<td>
					  <div class="control-group">
							<label class="control-label" for="form-field-1"></label>
								<div class="controls">
								<select id="year" name="year" required="true">
								<option value="">---Select Year---</option>
								<option value="All">All</option>
								@foreach($YearList as $yl)
								<option value="{{$yl}}">{{$yl}}</option>
								 @endforeach
								</select>
								
								<input type="submit"  value="Search Year Plans" class="btn btn-small btn-warning"/>
				@if($user->hasPermission('CreateCourseYearPlanOne'))
                <a href="{{url('CreateCourseYearPlanOne')}}"><input type='button' value='Create Course Year PLan' class="btn btn-small btn-success" /></a>
				@endif
								
								</div>
					  </div>
					</td>
						
				   
							
				   
						
					</tr>
				</table>
				<hr/>
			</form>
				<div id="loding">
				<br><center><img height="20%" width="20%" src="assets/redballs.gif"/></center>
				</div>
				<div style="display: none" id="hidden_area">
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                           <!-- <th>Status</th>-->
                            <th>Year</th>
                            
                            <th>Organization</th>
                            <th>Course List Code</th>
							 <th>Course Name</th>
                            <th>Duration</th>
							<th>Course Level</th>
							<!--<th>Parallel Groups</th>-->
                            <th>Batch</th>
                            <th>Medium </th>
                            
                            <th>Max Capacity</th>
                            
                           
                            <th>Instructors</th>
							 <th>Real Start Date</th>
							 <th>Real End Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($YearPlan))
                        @foreach($YearPlan as $yp)
                        <tr>
                            <!--<td>
                                @if($yp->confirm==0)
                                <b>Pending..</b> 
                                @elseif($yp->confirm==1 || $yp->confirm==2)
                                <b style="color: blue;">Confirmed And Started</b>
                                @endif
                            </td>-->
                            <td>{{$yp->Year}}</td>
                            
                            <td>{{CourseYearPlan::getOrganizatinName($yp->OrgId)}}</td>
                            <td>{{$yp->CourseListCode}}</td>
							 <td>{{$yp->getCName($yp->CD_ID)}}</td>
                            <td>{{$yp->getDuration($yp->CD_ID)}}</td>
							<?php  $CL = Course::where('CD_ID','=',$yp->CD_ID)->pluck('CourseLevel');  ?>
							<td>{{$CL}}</td>
							<!--<td>{{$yp->parallelGroups}}</td>-->
                            <td>{{$yp->batch}}</td>
                            <td>{{$yp->medium}}</td>
                           
                            <td>{{$yp->maxCapacity}}</td>
                           
                          
						
						   
							
							<?php
							 $ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$yp->id."'
						  and moinstructorcourse.Active='Yes'";
                          $Ins=DB::select(DB::raw($ppp));
							?>
                          <td class="left">
						@foreach($Ins as $i)
						<span>{{$i->Name}}({{$i->EPFNo}})</br></span>
						@endforeach
						</td>
						<td>{{$yp->RealstartDate}}</td>
						<td>{{$yp->RealEndDate}}</td>
							
                             <td>
                               @if($user->hasPermission('editCourseYearPlan'))
                                <form id="editform"  action='editCourseYearPlan' method="GET" >
                                    <input type="hidden" name='edit_id' value='{{$yp->id}}' />
                                    <button type="Submit" class="btn btn-info btn-mini"><i class="icon-edit icon-2x icon-only"></i></button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if($user->hasPermission('deleteCourseYearPlan'))
                                <form id="deleteform"  action='deleteCourseYearPlan' method="POST" onsubmit="return doConfirm('{{$yp->CourseListCode}}', this)">
                                    <input type="hidden" name='id' value='{{$yp->id}}' />
                                    <button type="submit" class="btn btn-danger btn-mini"><i class="icon-trash icon-2x icon-only"></i></button>
                                </form>
								 @endif
                            </td>
                           
                        </tr> 
                        @endforeach
                        @endif
                    </tbody>
                </table>
				</div>
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
                                            function doConfirm(course, formobj)
                                            {
                                            bootbox.confirm("Are you sure you want to remove Course Year Plan with Course List Code : " + course, function(result)
                                            {
                                            if (result)
                                            {
                                            formobj.submit();
                                            }
                                            });
                                                    return false; // by default do nothing hack :D
                                            }

                                    $('#sample-table-2').dataTable({
                                    "aoColumns": [
                                          
                                    {"bSortable": false, "asSorting": [ "asc" ]},
                                    {"bSortable": false},
                                    {"bSortable": false},
									{"bSortable": false},
                                            null,
											null,
									//{"bSortable": false},
											null,
											null,
											null,
										
                                    {"bSortable": false},
                                            null,
                                   // {"bSortable": false},
                                  
                                        //    null,
                                    {"bSortable": false},
                                    {"bSortable": false},
                                    {"bSortable": false}
                                    ]});
                                            $('table th input:checkbox').on('click', function() {
                                    var that = this;
                                            $(this).closest('table').find('tr > td:first-child input:checkbox')
                                            .each(function() {
                                            this.checked = that.checked;
                                                    $(this).closest('tr').toggleClass('selected');
                                            });
                                    });
                                            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                                            function tooltip_placement(context, source) {
                                            var $source = $(source);
                                                    var $parent = $source.closest('table')
                                                    var off1 = $parent.offset();
                                                    var w1 = $parent.width();
                                                    var off2 = $source.offset();
                                                    var w2 = $source.width();
                                                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                                                    return 'right';
                                                    return 'left';
                                            }


</script>
<script>
     $(document).ready(function() {
                                  $("#hidden_area").css("display", "");
								  $("#loding").css("display", "none");
                                });
</script>
