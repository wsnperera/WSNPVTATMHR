@include('includes.bar')       





                


<div class="page-content">
                                    
	<div class="row-fluid">
                                            
                                           
                                        
                                            
                                            
                                    <div class="span12">
							
                                        <!--PAGE CONTENT BEGINS-->

                                        
                                        <!--/.page-header-->
                                        
                                        <div class="page-header position-relative">
                                            
				<h1>
				Qualification			
				<small>
					<i class="icon-double-angle-right"></i>
					Edit
				</small>			
				</h1>
		</div><!--/.page-header-->


                			  <!--Write your code here start-->
                
                				
                                                
                                           <form class="form-horizontal" action="{{url('editQualification')}}" method="POST"/>
                                           
                                           
                                                 <!-- Hold the primary key -->
                                                 
                                                 <input type="hidden" name="En_Id" value={{Request::get('En_Id')}} />
                                           
                                                <!-- Choose Institute -->

                                                    <div class="control-group">

                                                            <label class="control-label" for="InstituteId">Choose Institue</label>

                                                            <div class="controls">

                                                                <select name="InstituteId">
                                                                    
                                                                        
                                                                   @foreach($institutes as $c)
                                                                    
                                                                    
                                                                       <option @if($c->InstituteId == $course->InstituteId) selected  @endif value={{$c->InstituteId}}>{{$c->InstituteName}}</option>
                                                
                                                                   @endforeach
                                                                   


                                                                </select>

                                                            </div>
                                         
                                                <!-- Choose Institute -->
                                                
                                                <br/>


                                          

                                      <!-- Course Trade -->

                                                <div class="control-group">
                                                    
							<label class="control-label" for="OrganisationId">Trade</label>

                                                         <div class="controls">

                                                            <select name="OrganisationId">

                                                                 @foreach($trades as $t)
                                                                    
                                                                           <option @if($t->id == $course->id) selected  @endif value="{{$t->id}}">{{$t->OrgaName}}</option>     

                                                                 @endforeach

                                                            </select>

                                                         </div>
                                                        
						</div>

                                           <!-- Course Trade -->
                                           
                                           <div class="control-group">
                                                    
							<label class="control-label" for="Qualification">Qualification</label>

                                                         <div class="controls">

                                                            <input type="text" name="Qualification"  value="{{$course->Qualification}}"/>

                                                         </div>
                                                        
                                            </div>

                             <!-- Submit Button -->

                                             <div class="control-group">
                                                    
                                                     <div class="controls">

                                                         <button type="submit" class="btn btn-small btn-primary">Update</button>

                                                     </div>
                                             </div>
                                            

                                             <!-- Submit Button -->


                                           
                                            </form>
                                          
                                          
                                          


					 <!--Write your code here end-->
                
                                        
                                        <!--PAGE CONTENT ENDS-->
                                                                    
                                                                                                                                                
                                  </div><!--/.span-->

							
						
	</div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   


<script type="text/javascript">
    
  
         
         
        

    
</script>