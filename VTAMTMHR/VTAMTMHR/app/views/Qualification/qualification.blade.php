@include('includes.bar') 

@if(isset($Issearch))

<a href={{url('searchQualification')}}> << Back to Qualification </a> 

@endif

<div class="page-content">
                                    
    <div class="row-fluid">
        <form name='search' action="{{url('findQualification')}}" method='get'>
                                                
                                             Search Qualification <input type='text' name="serachkey"/>   <input type='submit' value='Search'/>
                                             
                                             <a href={{url('createQualification')}}><input type='button' value='Create Qualification' /></a>
                                              
                                             
                                             
                                            </form>
        
        <div class="span12">
		<!--PAGE CONTENT BEGINS-->




		<table class="table">


		<tr>
                    <th>EntryId</th>
		<th>InstituteId</th>
                <th>Organisation</th>
		<th>Qualification</th>
                
                                                                                         

		</tr>
                @if(isset ($courses))

		@foreach ($courses as $c)

		<tr>
                                                                                                
                                                                                            
                                                                                            
                    <td><a href="{{url('editQualification?En_Id='.$c->En_Id)}}">{{$c->En_Id}}</a></td>
                <td>{{$c->Institue->InstituteName}}</td>
		<td>{{$c->Organisation->OrgaName}}</td>
                <td>{{$c->Qualification}}</td>
                
                <td>
              <form id="deleteform"  action={{url('deleteQualification')}} method="POST" onsubmit="return doConfirm('{{$c->Qualification}}',this)">
                                                                                                                     
                                                                                                                     
                 <input type="hidden" name='En_Id' value={{$c->En_Id}} />
                                                                                                                      
                 <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                                                                                                                      
                                                                                                                 
               
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

<script type="text/javascript">
    
  
        function doConfirm(qualification,formobj)
        {
            
            
            bootbox.confirm("Are you sure you want to remove "+qualification, function(result) 
            {
                   if(result) 
                   {
                        formobj.submit();
							
                    }
                    
                    
            });
            
         
            return false;  // by default do nothing hack :D
        }
          
   
         
         
        

    
</script> 
