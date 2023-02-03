@include('includes.bar')    
<a href="{{url('viewTransferType')}}"> << Back to Appointment Type </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Appointment Type			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->
            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }} </div>
            @endforeach
            @endif

            <form class="form-horizontal" action="{{url('editTransferType')}}" method="POST"/>
            <h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>
            
            <div class="control-group">
                <div class="controls">
                    <input type="hidden" style="color:red" name="T_ID" value="{{Request::get('id')}}" readonly="readonly"/> 
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-2">Institute Name</label>
                <div class="controls">
                    <input type="text" value="{{Institute::where('InstituteId', "=", $TransferType->institutionId)->pluck('InstituteName');}}"  readonly="true"/>
                    <input type="hidden" value="{{$TransferType->institutionId}}" name="institutionId"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Appointment Type</label>
                <div class="controls">
                    <input type="text" name="TransferType" value="{{$TransferType->TransferType}}" required/><b style="color: red">*</b>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label" for="form-field-3">Availability </label>
                <div class="controls" >
                    <select type="text"  name="Available" id="Available" required>
                         <option @if($TransferType->Available == '') selected @endif value="">---Select---</option>
                         <option @if($TransferType->Available == '1') selected @endif value="1">Yes</option>
                         <option @if($TransferType->Available == '0') selected @endif value="0">No</option>
                     </select><b style="color: red">*</b>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-3">Priority </label>
                <div class="controls" >
                     
                     <select type="text"  name="Priority" id="Priority" required>
                         <option @if($TransferType->Priority == '') selected @endif value="">---Select---</option>
                         <option @if($TransferType->Priority == '1') selected @endif value="1">1</option>
                         <option @if($TransferType->Priority == '2') selected @endif value="2">2</option>
                     </select><b style="color: red">*</b>
                </div>
            </div>

            <div class="controls">
                <input class="btn btn-small btn-primary" type="submit"  value="Update" />
            </div>

            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript">

</script>
