

@include('includes.bar')       

@if(isset($Issearch))

<a href={{url('courses')}}> << Back to Courses </a> 

@endif






<div class="page-content">

    <div class="row-fluid">

        <!--PAGE CONTENT BEGINS-->


        <!--/.page-header-->

        <div class="page-header position-relative">

            <h1>
                Course			
                <small>
                    <i class="icon-double-angle-right"></i>
                    view
                </small>			
            </h1>
        </div><!--/.page-header-->




        <form name='search' action="{{url('findCourse')}}" method='get'>
            Trade :&nbsp;&nbsp;
            <select style="width: 200px;" name="order_by" style="margin: 0" required="true">
                <option value="">---Select Trade ---</option>
                @foreach($Trade as $t)
                <option value="{{$t->TradeId}}">{{$t->TradeName}}</option>
                @endforeach
				 
            </select>&nbsp;&nbsp;
			Course Type
			<select style="width: 150px;" name="CourseType" style="margin: 0" required="true">
				<option value="Full" selected>---Select Course Type---</option>    
                <option value="Full">Full Time</option>              
                <option value="Part">Part Time</option>
               
                
            </select>
			
			
           
            
             <button type="submit"  class="btn btn-primary">
                                <i class="icon-eye-open bigger-100"></i>Search</button>

          
            <a href={{url('createCourse')}}><button type="button" class="btn btn-primary">Create</button></a>
            <a href={{url('downloadExcelCourseDetails')}}><input type='button' value='Download via Excel' class="btn btn-warning" /></a>
            


        </form>





        <div class="span12">
            <!--PAGE CONTENT BEGINS-->




             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
 <thead>

                <tr>

                    <th>CourseID</th>
                    <th>Institute</th>
                    <th>Course</th>
					<th>Course Type</th>
                    <th>Course List Code</th>
                    <th>Duration In Month</th>
                   
                    <th>Trade</th>
                    <th>Nvq</th>
                    <th>CourseLevel</th>
                    <th>ProgramType</th>
                    <th>Qualification Packages</th>
					 <th>Occupation/Category</th>
                   
					<th>Active</th>
					
                    <th>Remove</th>
					

                </tr>
            </thead>
            <tbody>
                @if(isset ($courses))

                @foreach ($courses as $c)

                <tr>



                    <td><a href="{{url('editCourse?cid='.$c->CD_ID)}}"><i class="icon-pencil icon-2x icon-only">{{$c->CD_ID}}</i></a></td>
                    <td>{{$c->InstituteName}}</td>
                    <td>{{$c->CourseName}}</td>
					<td>{{$c->CourseType}}</td>
                    <td>{{$c->CourseListCode}}</td>
                    <td>{{$c->Duration}}</td>
                  
                    <td>@if(!is_null($c->TradeName)) {{$c->TradeName}} @endif</td>
                    <td>{{$c->Nvq}}</td>
                    <td>{{$c->CourseLevel}}</td>
                    <td>{{$c->ProgramType}}</td>
                    <?php
                    $pack = CourseDetailQualificationPackages::GegQPacks($c->CD_ID);
                    ?>
                    <td>
                        @foreach($pack as $p)
                        <span>{{$p->packagecode}}</span><br/>
                        @endforeach
                    </td>
                   <td>{{$c->Category}}</td>
					<td>{{$c->Active}}</td>
						
                    <td>
					
					
                        <form id="deleteform"  action={{url('deleteCourse')}} method="POST" onsubmit="return doConfirm('{{$c->CourseName}}', this)">
							
                            <input type="hidden" name='cid' value={{$c->CD_ID}} />
                            <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>

                        </form>
						
                    </td>
					


                </tr>


                @endforeach

                @endif
            </tbody>

            </table>






            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>



<script type="text/javascript">

    $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            null, 
             null, 
              null, 
               null, 
                null, 
                 null, 
                  null, 
                   null, 
                    null, 
                     null, 
                      null, null, 
                      null, 
                      
           
    ]});


            function doConfirm(course, formobj)
            {


            bootbox.confirm("Are you sure you want to remove " + course, function(result)
            {
            if (result)
            {
            formobj.submit();
            }


            });
                    return false; // by default do nothing hack :D
            }







</script>