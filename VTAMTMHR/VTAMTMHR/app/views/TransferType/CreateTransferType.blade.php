@include('includes.bar')       
<a href="{{url('viewTransferType')}}"> << Back to Appointment Type</a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Appointment Type			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createTransferType')}}" method="POST" name="form1" />
            <h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>

            <div class="control-group">
                <label class="control-label" for="form-field-2">Institute Name</label>
                <div class="controls">
                    <input type="hidden" value="{{$user->instituteId}}" name="institutionId" />
                    <input type="text" value="{{Institue::where('InstituteId', "=", $user->instituteId)->pluck('InstituteName');}}"  readonly="true"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Appointment Type </label>
                <div class="controls" >
                    <input type="text"  name="TransferType" id="TransferType" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Availability </label>
                <div class="controls" >
                    <select type="text"  name="Available" id="Available" required>
                        <option value="">---Select---</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select><b style="color: red">*</b>&nbsp;&nbsp;&nbsp;
                    <span class="label label-important arrowed-in label-yellow">
                        <u> Available for future process</u></br>
                        &nbsp;&nbsp;&nbsp;For Example :
                        <table><tr><th>Appointment Type</th><th>Availability</th></tr>
                            <tr><td>Promotion</td><td>Yes</td></tr>
                            <tr><td>Termination</td><td>No</td></tr></table></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">Priority </label>
                <div class="controls" >
                    <select type="text"  name="Priority" id="Priority" required> 
                        <option value="">---Select---</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select> <b style="color: red">*</b>&nbsp;&nbsp;&nbsp;
                    <span class="label label-important arrowed-in label-yellow">
                        <u>Primary & Secondary Positions </u></br>
                        &nbsp;&nbsp;&nbsp;For Example : 
                       <table><tr><th>Appointment Type</th><th>Priority</th></tr>
                            <tr><td>Promotion</td><td>1</td></tr>
                            <tr><td>Cover Up</td><td>2</td></tr> </table></span>
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
<style>
    table,td {
        border: 1px solid black;
        text-align: center
    }
    th {
        border: 1px solid black;
        background-color: orange;
        color: white;
        text-align: center;
    }
</style>
<script type="text/javascript">
//    $('#TransferType').keydown(function(){
//        var TT = document.getElementById('TransferType').value;
//        $.ajax({
//            url: "{{url::to('CheckTransferTypeNameUnique')}}",
//            data: {TransferType:TT},
//            beforeSend:function(){
//                    document.getElementById('img_1').innerHTML = "<img src='{{Url('assets/images/abc.gif')}}'/>";
//                },
//            success: function(results) {
//                if(TT !== ''){
//                document.getElementById('TransferTypeMsg').innerHTML = results;
//               }  else{
//                document.getElementById('TransferTypeMsg').innerHTML = '';
//            }
//                },
//            complete:function(){
//                document.getElementById('img_1').innerHTML = "";
//            }
//        });
//    });

    function convert_case() {
        document.getElementById("OrgaName").value =
                document.getElementById("OrgaName").value.substr(0, 1).toUpperCase() +
                document.getElementById("OrgaName").value.substr(1).toLowerCase();
    }
</script>


