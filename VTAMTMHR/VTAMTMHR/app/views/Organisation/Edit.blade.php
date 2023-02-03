@include('includes.bar')    
<a href={{url('organisation')}}> << Back to Center </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Center			
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

            <form class="form-horizontal" action="{{url('editOrganisation')}}" method="POST"/>
            
            @if($user->userType == '2')
            <div class="control-group">
                <label class="control-label" for="form-field-1">Center ID</label>
                <div class="controls">
                    <a href="{{url('dateclosedOrganisation?id='.Request::get('id'))}}"><input type="text" style="color:red" name="id" value="{{Request::get('id')}}" readonly="readonly"/> </a>
                    <h4 style="color:red;font-family:Arialblack" >Press the Center ID Text Box to Enter the Closed Date...!</h4>
                </div>
            </div>
            @endif
            <input type="hidden" name="id" value="{{$organisation->id}}">
            <div class="control-group">
                <label class="control-label" for="form-field-2">Institute Name</label>
                <div class="controls">
                    <input type="text" value="{{Institute::where('InstituteId', "=", $organisation->InstituteId)->pluck('InstituteName');}}"  readonly="true"/>
                    <input type="hidden" value="{{$organisation->InstituteId}}" name="InstituteId"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Name</label>
                <div class="controls">
                    <input type="text" name="OrgaName" value="{{$organisation->OrgaName}}" />
                </div>
            </div>
	   <div class="control-group">
                <label class="control-label" for="form-field-3">College Name in Tamil </label>
                <div class="controls" >
                    <input type="text" value="{{$organisation->OrgaNameTamil}}" name="OrgaNameTamil" id="OrgaNameTamil" placeholder="Name in Tamil"/>
                </div>
            </div>
    
            <div class="control-group">
                <label class="control-label" for="form-field-3">College Name in Sinhala </label>
                <div class="controls" >
                    <input type="text"  value="{{$organisation->OrgaNameSinhala}}" name="OrgaNameSinhala" id="OrgaNameSinhala" placeholder="Name in Sinhala" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Type </label>
                <div class="controls">
                    <select name="TypeId" id="TypeId" >
                        @foreach ($orgtype as $ot)
                        <option @if($ot->OT_ID == $organisation->TypeId) selected   @endif value={{$ot->OT_ID}}>{{$ot->Type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Center Code</label>
                @if($userType=='HO')
                <div class="controls">
                    <input type="text" name="CenterCode" value="{{$organisation->CenterCode}}"/>
                </div>
                @else
                <div class="controls">
                    <input type="text" name="CenterCode" value="{{$organisation->CenterCode}}" readonly />
                </div>
                @endif

            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">Ownership</label>
                <div class="controls">
                    <select name="Ownership"  id="Ownership">
                        <option></option>
                        @foreach ($ownership as $o)
                        <option @if($o->id == $organisation->Ownership) selected   @endif value={{$o->id}}>{{$o->Type}}</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Availability of Business Unit</label>
                <div class="controls">
                <div class="span3">
                    <label>
                    <input name="BusinessUnit" class="ace-switch ace-switch-5" type="checkbox" value="yes" />
                    <span class="lbl"></span>
                    </label>
                </div>

                </div>
            </div>
<!--
            <div class="control-group">
                <label class="control-label" for="form-field-3">College Of Technology</label>
                <div class="controls">
                    <select name="COT_Id" id="COT_Id">
                        <option></option>
                        @foreach ($ortype as $ogt)
                        <option @if($ogt->id == $organisation->COT_Id) selected   @endif value={{$ogt->id}}>{{$ogt->OrgaName}}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->

            <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-4">Address</label>
                <div class="controls">
                    <textarea rows="5"  name="AddL1">{{$organisation->AddL1}}</textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-5">Telephone No</label>
                <div class="controls">
                    <input type="tel" name="Tel" value="{{$organisation->Tel}}" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-6">Fax No</label>
                <div class="controls">
                    <input type="tel" name="Fax" value="{{$organisation->Fax}}"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-6">e-mail</label>
                <div class="controls">
                    <input type="email" name="Email" value="{{$organisation->Email}}"/>
                </div>
            </div>

            <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">Career Guidance Telephone No</label>
                <div class="controls">
                    <input type="tel" name="CaGuTel" value="{{$organisation->CaGuTel}}"/>
                </div>
            </div>
              <div class="control-group">
                <label class="control-label" for="form-field-6">Registration No</label>
                <div class="controls">
                    <input type="text" name="RegistrationNo" value="{{$organisation->RegistrationNo}}"/>
                </div>
            </div>
            <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="form-field-8">District</label>
                <div class="controls">
                    <select name="DistrictCode" id='DistrictCode'>
                        @foreach($district as $d)
                        <option @if($d->DistrictCode == $organisation->DistrictCode) selected   @endif value={{$d->DistrictCode}}>{{$d->DistrictName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-7">Electorate</label>
                <div class="controls" id="elec_code">
                    <select name="ElectorateCode" id='ElectorateCode'>
                        @foreach($electorate as $e)
                        <option @if($e->ElectorateCode == $organisation->ElectorateCode) selected   @endif value={{$e->ElectorateCode}}>{{$e->ElectorateName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">OIC </label>
               
                <div class="controls">
                    <select name="OIC"  id="OIC">
                        <option></option>
                        @foreach ($instructor as $o)
                       
                         <option @if($o->id == $organisation->OIC) selected   @endif value={{$o->id}}>{{$o->Initials}}{{$o->LastName}} (EPFNo:{{$o->EPFNo}})</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>
               <div class="control-group">
                <label class="control-label" for="form-field-6">Latitude</label>
                <div class="controls">
                    <input type="text" name="Latitude" value="{{$organisation->Latitude}}"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">Longitude</label>
                <div class="controls">
                    <input type="text" name="Longitude" value="{{$organisation->Longitude}}"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-10">Active</label>
                <div class="controls">
                    <select name="Active"  id="Active" onclick="No()">

                        <option @if($organisation->Active=="Not Started" ) selected   @endif value="Not Started">Not Started</option>
                        <option @if($organisation->Active=="Yes" ) selected   @endif value="Yes">Yes</option>
                        <option @if($organisation->Active=="No" ) selected   @endif value="No" >No</option>
						<option @if($organisation->Active=="Closed" ) selected   @endif value="Closed" >Closed</option>

                    </select>
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
</script>
