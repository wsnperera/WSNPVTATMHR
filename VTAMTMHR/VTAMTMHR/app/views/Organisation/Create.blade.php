@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<a href={{url('organisation')}}> << Back to Center</a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
           <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                   Center			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create 
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createOrganisation')}}" method="POST" name="form1" />

            <div class="control-group">
                <label class="control-label" for="form-field-2">Institute Name</label>
                <div class="controls">
                    <input type="hidden" value="{{$user->instituteId}}" name="InstituteId" />
                    <input type="text" value="{{Institue::where('InstituteId', "=", $user->instituteId)->pluck('InstituteName');}}"  readonly="true"/>
                </div>
            </div>
           <div class="page-header position-relative">
 </div>            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Name </label>
                <div class="controls" >
                     <input type="text"  name="OrgaName" id="OrgaName"/><span style="color:red">*</span>
                </div>
            </div>
	    <div class="control-group">
                <label class="control-label" for="form-field-3">Center Name in Tamil </label>
                <div class="controls" >
                    <input type="text"  name="OrgaNameTamil" id="OrgaNameTamil" placeholder="Name in Tamil"/>
                </div>
            </div>
    
            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Name in Sinhala </label>
                <div class="controls" >
                    <input type="text"  name="OrgaNameSinhala" id="OrgaNameSinhala" placeholder="Name in Sinhala" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Code </label>
                <div class="controls" >
                     <input type="text"  name="CenterCode" id="CenterCode"/>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Type </label>
                <div class="controls" >
                    <select name="TypeId" id="TypeId" onchange="typeorg()">
                        <option></option>
                        @foreach ($orgtype as $ot)
                        <option value="{{$ot->OT_ID}}">{{$ot->Type}}</option>
                        @endforeach
                    </select><span style="color:red">*</span>
                </div>
            </div>
            
          
            
            <div class="control-group">
                <label class="control-label" for="form-field-3">Ownership</label>
                <div class="controls">
                    <select name="Ownership"  id="Ownership">
                        <option></option>
                        @foreach ($ownership as $o)
                        <option value="{{$o->id}}">{{$o->Type}}</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>
               <div class="control-group">
                <label class="control-label" for="form-field-3">Availability of Business Unit</label>
                <div class="controls">
                <div class="span3">
                    <label>
                    <input name="BusinessUnit" class="ace-switch ace-switch-5" type="checkbox" />
                    <span class="lbl"></span>
                    </label>
                </div>

                </div>
            </div>
            
            <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-4">Address</label>
                <div class="controls">
                    <textarea rows="4" cols="5" name="AddL1"  ></textarea><span style="color:red">*</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-5">Center Telephone No</label>
                <div class="controls">
                    <input type="tel" name="Tel"  /><span style="color:red">*</span>
                </div>
            </div>
             <div class="control-group">
                <label class="control-label" for="form-field-5">Fax No</label>
                <div class="controls">
                    <input type="tel" name="Fax"  />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">e-mail</label>
                <div class="controls">
                    <input type="email" name="email" required="required"/><span style="color:red">*</span>
                </div>
            </div>

            <input type="hidden" name="COT_Id" id="COT_ID"/>

             <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-5">Career Guidance Telephone No</label>
                <div class="controls">
                    <input type="tel" name="CaGuTel"  /><span style="color:red">*</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">Registration No</label>
                <div class="controls">
                    <input type="text" name="RegistrationNo"/>
                </div>
                </div>
             <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-8">District</label>
                <div class="controls">
                    <select name="DistrictCode" id="DistrictCode">
                        <option></option>
                        @foreach ($district as $d)
                        <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-7">Electorate</label>
                <div class="controls"  id="elec_code">
                    <select id="ElectorateCode"name="ElectorateCode">
                        <option></option>
                    </select><span style="color:red">*</span>
                </div>
            </div><div class="control-group">
                <label class="control-label" for="form-field-12" >OIC Name</label>
               <div class="controls">
                    <select class="chzn-select" name="OIC"  id="OIC" >
                        <option></option>
                        @foreach ($instructor as $o)
                        <option value="{{$o->id}}">{{$o->EPFNo}}-(EPFNo)-{{$o->Initials}}{{$o->LastName}}</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label" for="form-field-6">Latitude</label>
                <div class="controls">
                    <input type="text" name="Latitude"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">Longitude</label>
                <div class="controls">
                    <input type="text" name="Longitude"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-12">Active</label>
                <div class="controls">
                    <select name="Active" >
                        <option value="Not Started">Not Started</option>
                        <option value="Yes">Yes</option>
						  <option value="No">No</option>
						   <option value="Closed">Closed</option>
                    </select>
                </div>
            </div>
            

            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="DateEntered" id="DateEntered"/>
                    <script type="text/javascript">
                        var DateEntered = new Date();
                        var y1 = DateEntered.getFullYear();
                        var m1 = DateEntered.getMonth() + 1;
                        if (m1 < 10)
                            m1 = "0" + m1;
                        var dt1 = DateEntered.getDate();
                        if (dt1 < 10)
                            dt1 = "0" + dt1;
                        var d2 = y1 + "-" + m1 + "-" + dt1;
                        document.getElementById('DateEntered').value = d2;
                    </script>
                </div>
            </div>
             
            <div class="controls">
                <input type="submit" class="btn btn-small btn-primary"  value="Save" >
            </div>
             
            </form>
           <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
        <div class="span4">
            <!-- Error Handling -->
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <!-- Error Message -->
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong> <i class="icon-remove"></i>{{$msg}}</strong>
            </div>
            <!-- Error Message -->
            @endforeach
            @endif
            <!-- Error Handling -->
        </div>
    </div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer') 
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
$(".chzn-select").chosen(); 
</script>


<script type="text/javascript">

    $("#DistrictCode").change(function() {

        var d_code = document.getElementById('DistrictCode').value;

        $.ajax({
            url: "{{url::to('disLoadajax')}}",
            data: {d_code: d_code},
            success: function(result) {
                document.getElementById('elec_code').innerHTML = result;

            }

        });

    });

    function convert_case() {
        document.getElementById("OrgaName").value =
                document.getElementById("OrgaName").value.substr(0, 1).toUpperCase() +
                document.getElementById("OrgaName").value.substr(1).toLowerCase();
    }
    function typeorg(){
        var t1 = document.getElementById("TypeId").value;
       
        document.getElementById("COT_ID").value=t1;
     
    }
</script>


