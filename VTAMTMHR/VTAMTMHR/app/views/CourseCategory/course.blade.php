

@include('includes.bar')       

@if(isset($Issearch))

<a href={{url('courses')}}> << Back to Courses </a> 

@endif






<div class="page-content">

    <div class="row-fluid">

        <!--PAGE CONTENT BEGINS-->


        <!--/.page-header-->

        <div class="page-header position-relative">

            <h1>
                Course Category/Occupations	
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
   <a href="{{url('CreateCourseCatogory')}}"><button type="button" class="btn btn-primary">Create</button></a>
   </div>
    </div>
  </form>
		 
            <!--PAGE CONTENT BEGINS-->




             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
 <thead>

                <tr>

                    <th>No</th>
                    <th>Course</th>
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
              
                   <td>{{$c->Category}}</td>
					
					 <td><a href="{{url('EditCourseCatogory?cid='.$c->id)}}"><i class="icon-pencil icon-2x icon-only"></i></a></td>	
                    <td>
					
					
                        <form id="deleteform"  action="{{url('DeletedCourseCatogory')}}" method="POST" onsubmit="return doConfirm('{{$c->Category}}', this)">
							
                            <input type="hidden" name='cid' value="{{$c->id}}" />
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
              null, 
              
           
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