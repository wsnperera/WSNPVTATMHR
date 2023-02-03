@include('includes.bar')       



<div class="page-content">

    <div class="row-fluid">

        <!--PAGE CONTENT BEGINS-->


        <!--/.page-header-->

        <div class="page-header position-relative">

            <h1>
                NVQ Units
                <small>
                    <i class="icon-double-angle-right"></i>
                    view
                </small>			
            </h1>
        </div><!--/.page-header-->
  

        <div class="span12">
		<form name='search'>
   <div class="control-group">
    <div class="controls">
   <a href="{{url('CreateUnits')}}"><button type="button" class="btn btn-primary">Create Units</button></a>
   </div>
    </div>
  </form>
		 
            <!--PAGE CONTENT BEGINS-->




             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
 <thead>

                <tr>

                    <th>No</th>
                    <th>Unit Code</th>
					<th>Unit Name</th>
					<th>Unit Version</th>
						
					<th>Edit</th>
				    <th>Remove</th>
					

                </tr>
            </thead>
            <tbody>
                @if(isset ($courses))
<?php $i =1; ?>
                @foreach ($courses as $c)

                <tr>



                   
                    <td>{{$i++}}</td>
              
                   <td>{{$c->UnitCode}}</td>				   
				   <td>{{$c->UnitName}}</td>
				      <td>{{$c->UnitVersion}}</td>
					    
					
					 <td><a href="{{url('EditUnits?cid='.$c->UID)}}"><i class="icon-pencil icon-2x icon-only"></i></a></td>	
                    <td>
					
					
                        <form id="deleteform"  action="{{url('DeletedUnits')}}" method="POST" onsubmit="return doConfirm('{{$c->UnitName}}', this)">
							
                            <input type="hidden" name='cid' value="{{$c->UID}}" />
                            <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>

                        </form>
						
                    </td>
					


                </tr>


                @endforeach

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
            null, 
             null, 
              null, null,
 null			  
              
           
    ]});


            function doConfirm(course, formobj)
            {


            bootbox.confirm("Are you sure you want to remove " + course, function(result)
            {
            if (result)
            {
            formobj.submit();
            }


            });
                    return false; // by default do nothing hack :D
            }







</script>