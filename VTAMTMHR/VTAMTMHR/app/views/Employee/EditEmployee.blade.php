@include('includes.bar')
<a href="{{url('viewEmployee')}}"> << Back to Employee </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->

            <!--Write your code here start-->
            <form class="form-horizontal"  enctype="multipart/form-data" method="POST" action="{{url('Photo_Of_Employee')}}">
                <h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>

                <input type="hidden" name="id" value="{{$Employee->id}} "/>
               
            </form>

            <div class="page-header position-relative"></div>
            <form class="form-horizontal" action="{{url('editEmployee')}}" method="POST" />
            <input type="hidden" name="id" value="{{$Employee->id}} "/>
            <br/>

            <div class="control-group">
                <label class="control-label" for="InstituteId">Organisation Name</label>
                <div class="controls">
                    <input type="text"  disabled="true" value="{{$institute}}"/>
                    <input type="hidden" name="InstituteId" value="{{$in_id}}"/>
                </div>
            </div>


            <div class="page-header position-relative"></div>
            <b>Personal Details</b>
             <div class="control-group">
                <label class="control-label" for="NIC">NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="load_nic_val" value="{{$Employee->NIC}}" required/><b style="color: red">*</b>
                    <span id="ajax_img2"></span>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="EPFNo">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPFNo" value="{{$Employee->EPFNo}}" required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Initials">Initials</label>
                <div class="controls">
                    <input type="text" name="Initials" value="{{$Employee->Initials}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Name">Name</label>
                <div class="controls">
                    <input type="text" name="Name" value="{{$Employee->Name}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="LastName">Last Name</label>
                <div class="controls">
                    <input type="text" name="LastName" value="{{$Employee->LastName}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Sex">Sex</label>
                <div class="controls">
                    <select name="Sex">
                        <option @if($Employee->Sex == "Male") selected value="{{$Employee->Sex}}" @endif>Male</option>
                        <option @if($Employee->Sex == "Female") selected value="{{$Employee->Sex}}" @endif>Female</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DOB">DOB</label>
                <div class="controls">
                    <input type="date" name="DOB" value="{{$Employee->DOB}}" />
                </div>
            </div>

      

        
         
     
      
            
             <div class="page-header position-relative"></div>
            <b>Currently Working Centre</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Crenter name</label>
                <div class="controls">
                     <select name="ToOrganisation" id="ToOrganisation" required>
                            <option value="">--Select--</option>
                            @foreach($centers as $c)
                            <option @if($c->id == $Employee->CurrentOrgaID) selected @endif value="{{$c->id}}">{{$c->OrgaName}} - ({{$c->Type}})</option>
                            @endforeach
                           
                        </select>
                        <b style="color: red">*</b>
                </div>
            </div>
             <div class="page-header position-relative"></div>
            <b>Current Designation</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Designation</label>
                <div class="controls">
                     <select name="Designation" id="Designation" required>
                            <option value="">--Select--</option>
                            @foreach($designations as $d)
                            <option @if($d->id == $Employee->CurrentDesignation) selected @endif value="{{$d->id}}">{{$d->Designation}}</option>
                            @endforeach
                        </select>
                        <b style="color: red">*</b>
                </div>
            </div>
             <div class="control-group">
                <label class="control-label" >Active</label>
                <div class="controls">
                     <select name="Active" id="Active" required>
                            <option value="">--Select Active tatus--</option>
                             <option value="1" @if($Employee->Active == 1) selected="true" @endif>Yes</option>
							 <option value="0" @if($Employee->Active == 0) selected="true" @endif>No</option>
                        </select>
                        <b style="color: red">*</b>
                </div>
            </div>

            <div class="page-header position-relative"></div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
        <!--/span 4 for error handling -->

        <div class="span4">



            @if($errors->has())
            @foreach($errors->all() as $msg)

            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong> <i class="icon-remove"></i>{{$msg}}</strong>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
</div>

@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">




/*  $("#Photograph").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }



            //    $.ajax({
            //                url: "{{url::to('abc')}}",
            //                //data: {DistrictName: epf},
            //                success: function(result)
            //                {
            //                   alert(result);
            //                }
            //            });

        }); */
 

    
    

</script>
