
@include('includes.bar')       








<div class="page-content">







    <div class="row-fluid">





        <div class="span8">

            <!--PAGE CONTENT BEGINS-->




            <!--/.page-header-->

            <div class="page-header position-relative">

                <h1>
                    Course			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->




            <form class="form-horizontal" action="{{url('createCourse')}}" method="POST"/>






            <div class="control-group">

                <label class="control-label" for="InstituteId"> Institue Name</label>

                <div class="controls">




                    <input type="text" name="InstituteId"   value="{{$institutes}}" readonly />



                </div>




                <br/>  








                      <div class="control-group">
                          
                              <label class="control-label" for="CourseListCode">ListCode</label>

                              <div class="controls">
                                      <input type="text" name="CourseListCode"  />
                              </div>
                              
                      </div>

                

                


                

                     <div class="control-group">
                         
                             <label class="control-label" for="CourseName">Course</label>

                             <div class="controls">
                                     <input type="text" name="CourseName"  />
                             </div>
                             
                     </div>
			<div class="control-group">
                        <label class="control-label" for="CourseName">Course(Sinhala)</label>
                        <div class="controls">
                            <input type="text" name="coursenamesinhala"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="CourseName">Course(Tamil)</label>
                        <div class="controls">
                            <input type="text" name="coursenametamil"  />
                        </div>
                    </div>
                





              

                    <div class="control-group">
                        
                            <label class="control-label" for="CourseType">Course Type</label>

                             <div class="controls">

                                <select name="CourseType">

                                      <option value="Full">Full Time</option>
                                      <option value="Part">Part Time</option>
                                      

                                </select>

                             </div>
                            
                    </div>

               

               


                

                    <div class="control-group">
                        
                            <label class="control-label" for="Duration">Duration in Month</label>

                            <div class="controls">
                                    <input type="text" name="Duration" required/>    	<span class="label label-important arrowed-in">Example : 2 Year  (24-M) / 24 Hours (100-H)</span>
                            </div>

                            
                            
                    </div>

                     <div class="control-group">
                        
                            <label class="control-label" for="DurationHours">Duration in Hours(Not Required For Full Time Courses)</label>

                            <div class="controls">
                                    <input type="text" name="DurationHours" />     <span class="label label-important arrowed-in">Example : 2 Year  (24-M) / 24 Hours (100-H)</span>
                            </div>

                            
                            
                    </div>



                

                     

              

                

              

                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Trade</label>

                             <div class="controls">

                                <select name="TradeId" id="TradeId" required="true">

                                     @foreach($trades as $t)
                                        
                                               <option value="{{$t->TradeId}}">{{$t->TradeName}}</option>     

                                     @endforeach

                                </select>

                             </div>
                            
                    </div>
                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Competency Standard</label>

                             <div class="controls">

                                <select name="ComStand" id="ComStand">

                                    

                                </select>

                             </div>
                            
                    </div>
                     <div class="control-group">
                        
                            <label class="control-label" for="Medium">Qualification Packages</label>
                                <div id="table_instructor" class="controls">
                                
                            </div>
                    </div>

				
				
				 

                     <div class="control-group">
                         
                             <label class="control-label" for="Nvq">Is NVQ</label>

                              <div class="controls">

                                 <select name="Nvq" id="Nvq">

                                     <option value="NVQ">Yes</option>
                                     <option value="NON-NVQ">No</option>


                                 </select>

                              </div>
                             
                     </div>
             
				
				
				
                


                

                    <div class="control-group">
                        
                            <label class="control-label" for="Medium">Course Level</label>

                             <div class="controls">

                                <select name="CourseLevel" id="CourseLevel"> 
								<option value='1'>Level 1</option>
                                <option value='2'>Level 2</option>
								<option value='3'>Level 3</option>								
								<option value='4'>Level 4</option>
								<option value='5'>Level 5</option>
								<option value='6'>Level 6</option>
                                </select>

                             </div>

                              <div class="controls">

                                    <input type="text" id="courseLevelStatus" name="courseLevelStatus" value="Certificate"  readonly />

                              </div>


                            
                    </div>
                    
              

                

                    <div class="control-group">
                        
                            <label class="control-label" for="ProgramType">Program Type</label>

                             <div class="controls">

                                <select name="ProgramType">

                                    <option value="Special">Special</option>
                                    <option value="General">General</option>


                                </select>

                             </div>
                            
                    </div>
					 <div class="control-group">
                        
                            <label class="control-label" for="Medium">Occupation/Category</label>

                             <div class="controls">

                                <select name="CourseCategoryID" id="CourseCategoryID" required="true">
								  <option value="">--- Select ---</option>     

                                     @foreach($CategoryL as $t)
                                        
                                               <option value="{{$t->id}}">{{$t->Category}}</option>     

                                     @endforeach

                                </select>

                             </div>
                            
                    </div>
                    
               <div class="control-group">
                        
                            <label class="control-label" for="ProgramType">Active Status</label>

                             <div class="controls">

                                <select name="Active" required>
									<option value="">---- Select---</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>


                                </select>

                             </div>
                            
                </div>



               

                   
                



                 
             

                 <div class="control-group">
                        
                         <div class="controls">

                             <button type="submit" class="btn btn-small btn-primary">Save</button>

                         </div>
						 
						 
                 </div>
                

                



           </div>

   </form>



           
          
                                       
                                                                                                                   
     </div><!--/.span-->




                <!--/span 4 for error handling -->

                <div class="span4">

                    <!-- Error Handling --!>

                            @if($errors->has())
                            
                                  @foreach($errors->all() as $msg)

                    <!-- Error Message --!>

                      <div class="alert alert-error">

                         <button type="button" class="close" data-dismiss="alert">
                                 <i class="icon-remove"></i>
                         </button>

                         <strong> <i class="icon-remove"></i>{{$msg}}</strong>

                      </div>

                    <!-- Error Message --!>

              @endforeach

          @endif

                    <!-- Error Handling --!>
                      
                    



            
        </div>
                    <!--/span 4-->





                    <!--PAGE CONTENT ENDS-->

                </div><!--/.row-fluid-->
            </div><!--/.page-content-->


            @include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

            <script>
            


                @if (isset($done))

                        $.gritter.add({title: "", text: "Course Added Successfully", class_name: "gritter-info gritter-center"});

                @endif
				
               

				
				
				
				$('#Nvq').change(function()
				{
				


					
					if($(this).val() == 'NVQ')
					{
						
						$("#CourseLevel").html('');
                         $("#courseLevelStatus").show();

						
						for(var i=1;i<=7;i++)
						{
							$("#CourseLevel").append('<option  value='+i+'>Level '+i+'</option>');
						}

                        setLevel();

						
						
					}
					if($(this).val() == 'NON-NVQ')
					{
						$("#CourseLevel").html('');
                        $("#courseLevelStatus").val('');
                        $("#courseLevelStatus").hide();
					
						$("#CourseLevel").append('<option  value="Diploma">Diploma</option><option value="Certificate">Certificate</option>');
						
						
					}
				
				});
				
					$('#Nvq').focus(function()
				{
				


					
					if($(this).val() == 'NVQ')
					{
						
						$("#CourseLevel").html('');
                         $("#courseLevelStatus").show();

						
						for(var i=1;i<=7;i++)
						{
							$("#CourseLevel").append('<option  value='+i+'>Level '+i+'</option>');
						}

                        setLevel();

						
						
					}
					if($(this).val() == 'NON-NVQ')
					{
						$("#CourseLevel").html('');
                        $("#courseLevelStatus").val('');
                        $("#courseLevelStatus").hide();
					
						$("#CourseLevel").append('<option  value="Diploma">Diploma</option><option value="Certificate">Certificate</option>');
						
						
					}
				
				});
                                   
                function setLevel(){

                       if(1 <= $("#CourseLevel").val() <= 4){

                           $("#courseLevelStatus").val('Certificate')

                        }
                        if( $("#CourseLevel").val() == 5 || $("#CourseLevel").val() == 6){

                           $("#courseLevelStatus").val('Diploma')

                        }
                        if( $("#CourseLevel").val() == 7){

                             $("#courseLevelStatus").val('Degree')

                        }
                      
                }

                $("#CourseLevel").change(function(){

                    if($("#Nvq").val() == 'NVQ')
                    {
                        
                        setLevel()

                    }

                })


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




			





