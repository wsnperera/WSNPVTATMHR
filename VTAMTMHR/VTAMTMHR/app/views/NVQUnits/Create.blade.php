@include('includes.bar')       

<div class="page-content">

 <div class="row-fluid">
   <div class="span8">

            <!--PAGE CONTENT BEGINS-->

            <!--/.page-header-->

            <div class="page-header position-relative">
<a href={{url('viewUnits')}}> << Back to Units View</a> 
                <h1>
                   NVQ Units		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->




            <form class="form-horizontal" action="{{url('CreateUnits')}}" method="POST"/>

            <div class="control-group">
                          
                              <label class="control-label" for="Category">Unit Code</label>

                              <div class="controls">
                                      <input type="text" name="UnitCode"  id="UnitCode" required/>
                              </div>
                              
                      </div>
					    <div class="control-group">
                          
                              <label class="control-label" for="Category">Unit Name</label>

                              <div class="controls">
                                      <input type="text" name="UnitName"  id="UnitName" required/>
                              </div>
                              
                      </div>
 <div class="control-group">
                          
                              <label class="control-label" for="Category">Unit Version</label>

                              <div class="controls">
                                      <input type="text" name="UnitVersion"  id="UnitVersion" required/>
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

                        $.gritter.add({title: "", text: "Course Added Successfully", class_name: "gritter-warning gritter-center"});

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
                                        var html='<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Qualification Packages..." required="true">'+result+'</select>';
                                            
                                            
                                            $("#table_instructor").append(html);
                                            $("#NVQPackage.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen(); 
                                            
                                        }
                                });            

            
       
    });    

            </script>




			





