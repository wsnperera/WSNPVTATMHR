
@include('includes.bar')       





                


<div class="page-content">
                                    
	<div class="row-fluid">
                                            
                                           
                                        
                                            
                                            
                                    <div class="span12">
							
                                        <!--PAGE CONTENT BEGINS-->

                                        
                                        <!--/.page-header-->
                                        
                                        <div class="page-header position-relative">
                                            
				<h1>
				Trades		
				<small>
					<i class="icon-double-angle-right"></i>
					Edit
				</small>			
				</h1>
		</div><!--/.page-header-->


                			  <!--Write your code here start-->
                
                				
                                                
                                           <form class="form-horizontal" action="{{url('editTrades')}}" method="POST"/>
                                           
                                            <input type="hidden" name="TradeID" value={{Request::get('cid')}} />
                                          
                                                 
                                               
						
                                               <div class="control-group">
                                                    
							<label class="control-label" for="TradeCode">Trade Code</label>

							<div class="controls">
								<input type="text" name="TradeCode" value={{$trades->TradeCode}}  />
							</div>
                                               </div>
                                                        
                                              
                                              <div class="control-group">
                                                    
							<label class="control-label" for="TradeName">Trade Name</label>

							<div class="controls">
								<input type="text" name="TradeName" value={{$trades->TradeName}}  />
							</div>
                                             
                                             
                                             
                                                  </div>
                                                 
                                                        
                                                        
                                                        
                                                        <div class="control-group">
                                                    
                                                     <div class="controls">

                                                         <button type="submit" class="btn btn-small btn-primary">Update</button>

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
