

@include('includes.bar')       

@if(isset($Issearch))

<a href={{url('institute')}}> << Back to Institute </a> 

@endif
<div class="page-content">
<div class="page-header position-relative">
                <h1>Institute<small><i class="icon-double-angle-right"></i>View</small></h1>
            </div>
                <div class="row-fluid">


<!--
                    <form name='search' action="{{url('findInstitute')}}" method='get'>

                     Search Institute <input type='text' name="key"/>   <input type='submit' value='Search'/>

                     <a href={{url('createInstitute')}}><input type='button' value='Create Institute' /></a>



                    </form>-->
                    <div class="span12">
                                <!--PAGE CONTENT BEGINS-->




                                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
<thead>

                                                        <tr>
                                                            <th>Institute</th>
                                                            <th>Head</th>
                                                            <th>Designation</th>
                                                            <th>Address</th>
                                                            <th>District</th>
                                                            <th>Country</th>
                                                            <th>Web Site</th>
                                                            <th>Tele1</th>
                                                            <th>Tele2</th>
                                                            <th>Fax</th>
                                                            <th>Email</th>
                                                        </tr>
														</thead>
														  <tbody>
                                                        @if(isset ($institute))
                                                            @foreach($institute as $c)

                                                                <tr>
                                                                    <td><b><u><a href="{{url('editInstitute?id='.$c->InstituteId)}}">{{$c->InstituteName}}</a></u><b></td>
                                                                    <td>{{$c->HeadName}}</td>
                                                                    <td>{{$c->designation}}</td>
                                                                    <td>{{$c->InstituteAddress}}</td>
                                                                    <td>{{$c->InstituteDistrict}}</td>
                                                                    <td>{{$c->InstituteCountry}}</td>
                                                                    <td>{{$c->webSite}}</td>
                                                                    <td>{{$c->InstituteTele1}}</td>
                                                                    <td>{{$c->InstituteTele2}}</td>
                                                                    <td>{{$c->Fax}}</td>
                                                                    <td>{{$c->InstituteEmail}}</td>
                                                                </tr>
                                                            @endforeach
                                                            @if($institute=='[]')
                                                                </table><center>Data Not Found</center>
                                                            @endif
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
            {"bSortable": false},
              {"bSortable": false},
             {"bSortable": false},
			 {"bSortable": false}, 
            {"bSortable": false},
              {"bSortable": false},
             {"bSortable": false},
			 {"bSortable": false}, 
            {"bSortable": false},
              {"bSortable": false},
       
             
            
    ]});
  
        function doConfirm(course,formobj)
        {
            
            
            bootbox.confirm("Are you sure you want to remove "+course, function(result) 
            {
                   if(result) 
                   {
                        formobj.submit();
							
                    }
                    
                    
            });
            
         
            return false;  // by default do nothing hack :D
        }
          
   
         
         
        

    
</script>