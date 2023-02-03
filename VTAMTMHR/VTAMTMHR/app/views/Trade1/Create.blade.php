
@include('includes.bar')       





                


<div class="page-content">
    
    
    
   


                                    
	<div class="row-fluid">
                                            
                                           
                                        
                                            
                                            
                                    <div class="span8">
							
                                        <!--PAGE CONTENT BEGINS-->

                                        
                                        
                                        
                                        <!--/.page-header-->
                                        
                                        <div class="page-header position-relative">
                                            
                                            <h1>
                                      Trade			
                                            <small>
                                                    <i class="icon-double-angle-right"></i>
                                                    Create
                                            </small>			
                                            </h1>
                                            
		</div><!--/.page-header-->


                
                
                                    <form class="form-horizontal" action="{{url('createTrade1')}}" method="POST"/>

                             <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
                                    
                                  
                            
                          
                          
                                    
                                    
                                
                                      <div class="control-group">
                                                    
							<label class="control-label" for="TradeCode">Trade Code</label>

							<div class="controls">
								<input type="text" name="TradeCode"  />
							</div>
                                                        
						</div> 
                                     
                                      <div class="control-group">
                                                    
							<label class="control-label" for="Letter">Letter</label>

							<div class="controls">
								<input type="text" name="Letter"  />
							</div>
                                                        
						</div> 
                                        <div class="control-group">
                                                    
							<label class="control-label" for="TradeName">Trade Name</label>

							<div class="controls">
								<input type="text" name="TradeName"  />
							</div>
                                                        
						</div> 
                             
                                     
                         
                
                                 <div class="control-group">
                                                    
                                                     <div class="controls">

                                                         <button type="submit" class="btn btn-small btn-primary">Save</button>

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


<script>
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Course Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>
      
<script type="text/javascript">
      
    
     $(document).ready(function()
    {
            $("#selector").change(function()
            {

            

                    if('FT'== $(this).val())
                    {
                        $("#CourseCode").val(20);
                    }
                    if('PT'== $(this).val())
                    {
                        $("#CourseCode").val('');
                    }
                   

            });
        
    });
    
    
 </script>
         
<!-- <script type="text/javascript">
    
     
    $(document).ready(function()
    {
        
        
        $('#type').change(function() 
        {  
            var myval = $(this).val();
            
            
           
            
            if(myval == 'FT')
            {
            
            $("#Coursestarted_CourseCode").hide();
              alert("Full Time");     

            }
            
          
            
        });
       
    });
                  
   <script type="text/javascript">
    
    $(document).ready(function()
    {
        alert("loaded");
    });
    
 </script>            
               
      
        
        -->
<script type="text\javascript">
  
  
  
  
    
   
</script>
    


