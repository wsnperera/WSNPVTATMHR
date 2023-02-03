
@include('includes.bar')       





                


<div class="page-content">
                                    
	<div class="row-fluid">
                                            
                                           
                                        
                                            
                                            
                                    <div class="span12">
							
                                        <!--PAGE CONTENT BEGINS-->

                                        
                                        <!--/.page-header-->
                                        
                                        <div class="page-header position-relative">
                                            
				<h1>
				Activity		
				<small>
					<i class="icon-double-angle-right"></i>
					Edit
				</small>			
				</h1>
				<a href='viewActivity'> << Back </a>
		</div><!--/.page-header-->


                			  <!--Write your code here start-->
                
                				
                                                
                                           <form class="form-horizontal" action="{{url('editactivity')}}" method="POST"/>
                                           
                                            <input type="hidden" name="activityid" value={{Request::get('cid')}} />
                                          
                                                 
                                               
						
                                               <div class="control-group">
                                                    
							<label class="control-label" for="routename">Route Name</label>

							<div class="controls">
								<input type="text" name="routename" value={{$trades->routename}}  readonly='true'/>
							</div>
                                               </div>
                                                        
                                               
                                               <div class="control-group">
                                                    
							<label class="control-label" for="activityname">Activity Name</label>

							<div class="controls">
								<input type="text" name="activityname" value={{$trades->activityname}}  />
							</div>
                                               </div>
                                                 
                                                        
                                                        
                                                        
                                                        <div class="control-group">
                                                    
                                                     <div class="controls">

                                                         <button type="submit" class="btn btn-small btn-primary">Edit</button>

                                                     </div>
                                             </div>
                                            

                                             <!-- Submit Button --!>


                                           
                                            </form>
                                          
                                          
                                          


					 <!--Write your code here end-->
                
                                        
                                        <!--PAGE CONTENT ENDS-->
                                                                    
                                                                                                                                                
                                  </div><!--/.span-->

							
						
	</div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   


<script type="text/javascript">
    
  
         
         
        

    
</script>
