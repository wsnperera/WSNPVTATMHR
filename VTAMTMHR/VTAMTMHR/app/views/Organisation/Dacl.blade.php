
@include('includes.bar') 
<a href={{url('organisation')}}><< Back to Organisation</a> 



<div class="page-content">

    <div class="row-fluid">





        <div class="span12">

            <!--PAGE CONTENT BEGINS-->




            <!--/.page-header-->

            <div class="page-header position-relative">

                <h1>
                    Center>>Edit			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Enter Date Closed
                    </small>			
                </h1>

            </div><!--/.page-header-->

            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
            @endif


            <form class="form-horizontal" action="{{url('dateclosedOrganisation')}}" method="POST"/>
			 <input type="hidden" name="id" id="id" value="{{Request::get('id')}}" /> 
			 
					 <div class="control-group">
								<label class="control-label" for="form-field-2">Date Closed</label>
								<div class="controls">
									<input type="date" name="DateClosed" id='DateClosed' required="true" />
									<!--onchange="DateCheck()" -->
								</div>
							</div>
							 <div class="control-group">
								<label class="control-label" for="form-field-2">Active</label>
								<div class="controls">
								 <input type="text" name="Active" value="Closed" readonly="readonly"/>
								</div>
							</div>
           
              
 <div class="control-group">
								<label class="control-label" for="form-field-2"></label>
								<div class="controls">
								     <input class="btn btn-small btn-primary" type="submit"  value="Date Closed Update" />
								</div>
							</div>

             

                 

            </form>




            <!--PAGE CONTENT ENDS-->


        </div><!--/.span-->



    </div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   



</form>
<script type="text/javascript">

    function DateCheck()
    {
        var d = new Date();
        var y1 = d.getFullYear();
        var m1 = d.getMonth() + 1;
        var d1 = d.getDate();
//var DateOpened= d1 + "/" + m1 + "/" + y1;
        var dc = document.getElementById("DateClosed").value;
        var a = dc.split('-');
        var d2 = a[2];
        var m2 = a[1];
        var y2 = a[0];
        if (y2 - y1 >= 0 && m2 - m1 >= 0 && d2 - d1 >= 0) {
            return true;
        } else if (y2 - y1 >= 0 && m2 - m1 > 0) {
            return true;
        } else if (y2 - y1 > 0) {
            return true;
        } else {
            alert('You cannot select a day earlier than today!');
        }
    }

</script>