
@include('includes.bar')       

    <link rel="stylesheet" href="assets/css/chosen.min.css" />






<div class="page-content">

    <div class="row-fluid">





        <div class="span12">

            <!--PAGE CONTENT BEGINS-->


            <!--/.page-header-->

            <div class="page-header position-relative">

                <h1>
                    Course			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->


            <!--Write your code here start-->



            <form class="form-horizontal" action="{{url('editCourse')}}" method="POST"/>




            <input type="hidden" name="CD_ID" value={{Request::get('cid')}} />



            <div class="control-group">

                <label class="control-label" for="InstituteId">Choose Institute</label>

                <div class="controls">

                    <input type="text" name="CourseListCode" value="{{$course->Institue->InstituteName}}" readonly/>



                </div>



                <br/>


              

                     <div class="control-group">
                         
                             <label class="control-label" for="CourseListCode">ListCode</label>

                             <div class="controls">
                                     <input type="text" name="CourseListCode" value="{{$course->CourseListCode}}"  />
                             </div>
                             
                     </div>

               

                 


             

                     <div class="control-group">
                         
                             <label class="control-label" for="CourseName">Course</label>

                             <div class="controls">
                                     <input type="text" name="CourseName" style="width: 600px;" value="{{$course->CourseName}}" />
                             </div>
                             
                     </div>

               
    
                    <div class="control-group">
                        <label class="control-label" for="CourseName">Course(Sinhala)</label>
                        <div class="controls">
                            <input type="text" name="coursenamesinhala" value="{{$course->coursenamesinhala}}" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="CourseName">Course(Tamil)</label>
                        <div class="controls">
                            <input type="text" name="coursenametamil" value="{{$course->coursenametamil}}" />
                        </div>
                    </div>
                
                

              

                     <div class="control-group">
                         
                             <label class="control-label" for="CourseType">Course Type</label>

                              <div class="controls">

                                 <select name="CourseType">
									   <option select value={{$course->CourseType}}>{{$course->CourseType}} Time</option>
									   <option>-----</option>
                                       <option value="Full">Full Time</option>
                                       <option value="Part">Part Time</option>

                                 </select>

                              </div>
                             
                     </div>


                

               

                    <div class="control-group">
                        
                            <label class="control-label" for="Duration">Duration</label>

                            <div class="controls">
                                    <input type="text" name="Duration" value="{{$course->Duration}}" required />    	<span class="label label-important arrowed-in">Example : 2 Year  (24-M) / 24 Hours (100-H)</span>
                            </div>

                            
                            
                    </div>

              
                 <div class="control-group">
                        
                            <label class="control-label" for="DurationHours">Duration in Hours(Not Required For Full Time Courses)</label>

                            <div class="controls">
                                    <input type="text" name="DurationHours" value="{{$course->DurationHours}}"/>     <span class="label label-important arrowed-in">Example : 2 Year  (24-M) / 24 Hours (100-H)</span>
                            </div>

                            
                            
                    </div>


             

                     

             




              

                    
                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Trade</label>

                             <div class="controls">

                                <select name="TradeId" id="TradeId" required="true">

                                     <option selected value={{$tradesel->TradeId}}>{{$tradesel->TradeName}}</option>
                                <option>-----Select Tarde-----</option>
                                     @foreach($trades as $t)
                                        
                                               <option @if($t->TradeId == $course->TradeId) selected  @endif value="{{$t->TradeId}}">{{$t->TradeName}}</option>     

                                     @endforeach


                                </select>

                             </div>
                            
                    </div>
                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Competency Standard</label>

                             <div class="controls">

                                <select name="ComStand" id="ComStand">

                                <option>-----Select Competency Standard-----</option>
                                     @foreach($CompyS as $t)
                                        
                                               <option @if($t->code == $course->ComStand) selected  @endif value="{{$t->code}}">{{$t->code}}-{{$t->name}}</option>     

                                     @endforeach



                                    

                                </select>

                             </div>
                            
                    </div>
                     <div class="control-group">
                        
                            <label class="control-label" for="Medium">Qualification Packages</label>
                                <div id="table_instructor" class="controls">

                                   <select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Qualification Packages...">
                                    @foreach($packages as $t)
                                                                <option value="{{$t->id}}" selected="true">{{$t->packagecode}}</option>
                                                               
                                    @endforeach
                                     </select>
                                
                            </div>
                    </div>

                
                

        
				
				
				
				 

                     <div class="control-group">
                         
                             <label class="control-label" for="Nvq">Is NVQ</label>

                              <div class="controls">

                                 <select name="Nvq" id="Nvq">
                                <option value="">---- Select---</option> 
                                                                           
                                    @if($course->Nvq == 'NVQ')
                                     <option value="NVQ" selected>Yes</option>
                                     <option value="NON-NVQ">No</option>
                                     @else
                                      <option value="NVQ" >Yes</option>
                                     <option value="NON-NVQ" selected>No</option>
                                     @endif


                                 </select>

                              </div>
                             
                     </div>
                     
               

				
				
				

                
                

                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Course Level</label>

                             <div class="controls">

                                
                                     <select name="CourseLevel" id="CourseLevel"> 
                                <option value='1' @if($course->CourseLevel == 1) selected  @endif >Level 1</option>
                                <option value='2' @if($course->CourseLevel == 2) selected  @endif >Level 2</option>
                                <option value='3' @if($course->CourseLevel == 3) selected  @endif >Level 3</option>                              
                                <option value='4' @if($course->CourseLevel == 4) selected  @endif >Level 4</option>
                                <option value='5' @if($course->CourseLevel == 5) selected  @endif >Level 5</option>
                                 <option value='6' @if($course->CourseLevel == 6) selected  @endif >Level 6</option>
                                  <option value='7' @if($course->CourseLevel == 7) selected  @endif >Level 7</option>
                                </select>
                                    


                               

                             </div>
                            
                    </div>
                    
               

                
              


               

                     <div class="control-group">
                         
                             <label class="control-label" for="ProgramType">Program Type</label>

                              <div class="controls">

                                 <select name="ProgramType">
			
					 
                                     <option value="Special" @if($course->ProgramType == "Special") selected  @endif>Special</option>
                                     <option value="General" @if($course->ProgramType == "General") selected  @endif>General</option>


                                 </select>

                              </div>
                             
                     </div>
                     <div class="control-group">
                        
                            <label class="control-label" for="Medium">Occupation/Category</label>

                             <div class="controls">

                                <select name="CourseCategoryID" id="CourseCategoryID" required="true">
								  <option value="">--- Select ---</option>     

                                     @foreach($CategoryL as $t)
                                        
                                               <option value="{{$t->id}}" @if($course->CourseCategoryId == $t->id) selected  @endif>{{$t->Category}}</option>     

                                     @endforeach

                                </select>

                             </div>
                            
                    </div>
               
                     <div class="control-group">
                         
                             <label class="control-label" for="ProgramType">Active Status</label>

                              <div class="controls">

                                 <select name="Active" required>
			
									<option value="">---- Select---</option>
                                    <option value="Yes" @if($course->Active == "Yes") selected  @endif>Yes</option>
                                    <option value="No" @if($course->Active == "No") selected  @endif>No</option>


                                 </select>

                              </div>
                             
                     </div>


               

                   
                    
               
                

               

                 <div class="control-group">
                        
                         <div class="controls">

                             <button type="submit" class="btn btn-small btn-primary">Update</button>

                         </div>
                 </div>
                

              


              
               </form>
             
             
             


                <!--Write your code here end-->


                <!--PAGE CONTENT ENDS-->


            </div><!--/.span-->



        </div><!--/.row-fluid-->
    </div><!--/.page-content-->


    @include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/chosen.jquery.min.js"></script>

    <script type="text/javascript">

    jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
});



$('#Nvq').focus(function()
				{
				
					
					

					
					if($(this).val() == 'NVQ')
					{
						
						$("#CourseLevel").html('');
						
						for(var i=1;i<=7;i++)
						{
							$("#CourseLevel").append('<option value='+i+'>Level '+i+'</option>');
						}
						
						
					}
					if($(this).val() == 'NON-NVQ')
					{
						$("#CourseLevel").html('');
					
						$("#CourseLevel").append('<option value="Diploma">Diploma</option><option value="Certificate">Certificate</option>');
						
						
					}
				
				});
				
				
                                   
$('#Nvq').change(function()
				{
				
					
					

					
					if($(this).val() == 'NVQ')
					{
						
						$("#CourseLevel").html('');
						
						for(var i=1;i<=7;i++)
						{
							$("#CourseLevel").append('<option value='+i+'>Level '+i+'</option>');
						}
						
						
					}
					if($(this).val() == 'NON-NVQ')
					{
						$("#CourseLevel").html('');
					
						$("#CourseLevel").append('<option value="Diploma">Diploma</option><option value="Certificate">Certificate</option>');
						
						
					}
				
				});

  $("#TradeId").change(function() {
        var TradeId = $("#TradeId").val();
        $("#ComStand").html('');
        
        var msg = '--- Select Competency Standard ---';
      
            
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadCompetencyCourseCreate')}}",
                                        data: {TradeId: TradeId},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#ComStand").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#ComStand").append("<option value=" + item.code + ">" +item.code + "-"+ item.name +  "</option>");



                                                });

                                        } 
                                });            

            
       
    });
        
                 $("#ComStand").change(function() {
        var ComStand = $("#ComStand").val();
        $("#table_instructor").html('');
        
        var msg = '--- Select Competency Standard ---';
      
            
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadNVQCourseComPackage')}}",
                                        data: {ComStand: ComStand},
                                        //dataType: "json", 
                                         success: function(result)
                                        {
                                        var html='<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Qualification Packages..." >'+result+'</select>';
                                            
                                            
                                            $("#table_instructor").append(html);
                                            $("#NVQPackage.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen(); 
                                            
                                        }
                                });            

            
       
    });    
				
				


    </script>
