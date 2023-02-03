@include('includes.bar')       

@if(isset($Issearch))

<a href={{url('viewTrades')}}> << Back to Trades </a> 

@endif


    
                


				<div class="page-content">
                                    
					<div class="row-fluid">
                          <div class="page-header position-relative">

                <h1>
                    Trade 			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        View Trades
                    </small>			
                </h1>
            </div>
    <div>                  
                                           
                                            
                                            <form name='search' action="{{url('findTrade1')}}" method='get'>
                                                
                                             Search Trade By Trade Name<input type='text' name="key"/>   
                                            <button type="submit"  class="btn btn-primary">
                                <i class="icon-eye-open bigger-100"></i>Search</button>
                                             
                                             
                                             <a href={{url('createTrade1')}}><button type="button"  class="btn btn-primary">Create</button></a>
                                              
                                            
                                             
                                            </form>
                                            
                                           
                                            
                                            
                                            
						<div class="span10">
							<!--PAGE CONTENT BEGINS-->




								   <table id="sample-table-2" class="table table-striped table-bordered table-hover">
   <thead>

										<tr>

 											<th>Trade ID</th>
                                            <th>Trade Code</th>
											
                                            <th>Trade Name</th>
                                               <th>Remove</th>
                                                                                     
                                                                                        
                                                                                             

										</tr>
                                        </thead>
            <tbody>
@if(isset ($trades))

            @foreach ($trades as $c)

                <tr>
               
				<td><a href="{{url('editTrades?cid='.$c->TradeId)}}">   
                  
                   <i class="icon-pencil icon-2x icon-only"></i></a></td>
                   
                  
             
              
                            <td>{{$c->TradeCode}}</td>
                          
                             <td>{{$c->TradeName}}</td>

                                 <td>
                                     <form id="deleteform"  action={{url('deleteTrade1')}} method="POST" onsubmit="return doConfirm('{{$c->TradeId}}',this)">

                                         <input type="hidden" name='cid' value= "{{$c->TradeName}}" />
                                       
                                         
                                         
                                          <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>

                                     </form>

                                 </td>

                </tr>


            @endforeach

    @endif

								</table>

								
								
                                                                                                                                                


							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

			@include('includes.footer')   
                        
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    
  
        function doConfirm(holiday,formobj)
        {
            
            
            bootbox.confirm("Are you sure you want to remove "+holiday, function(result) 
            {
                   if(result) 
                   {
                        formobj.submit();
							
                    }
                    
                    
            });
            
         
            return false;  // by default do nothing hack :D
        }
          
   
         
        $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            null, 
             null,  null,  
           
    ]});   
        

    
</script>
