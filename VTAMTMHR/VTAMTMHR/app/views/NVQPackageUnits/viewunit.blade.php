@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href="{{url('NVQPackageUnit')}}"> << Back to View </a>
                <h1>NVQ  Packages Units<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
           
			<form class="form-horizontal" action='UpdateEdit' method="POST"/>
			@foreach($module as $module)
			 <input type="hidden" name="id"  value="{{$module->id}}" />
				 <div class="control-group">
                    <label class="control-label" for="ModuleName">Trade:</label>
                        <div class="controls">
                        
                               <select name="TradeId" id="TradeId" required>
							   <option value="">---Select Trade---</option>
							   @foreach($trades as $t)
							   <option @if ($t->TradeId == $module->tradeid) selected @endif value="{{$t->TradeId}}">{{$t->TradeName}}</option>
							   @endforeach
							   </select><span id="img1"></span>
                        
                        </div>
                </div>

               <div class="control-group">
                    <label class="control-label" for="ModuleName">Competency Standard Code:</label>
                        <div class="controls">
                                 <select name="Code" id="Code" required>
                                 @foreach($Competency as $c)
								 <option @if($module->CompetecyID == $c->id ) selected @endif value="{{$c->code}}">{{$c->code}}-{{$c->name}}</option>
								 @endforeach
							   </select>
								
                        </div>
                </div> 
                
                <div class="control-group">
                    <label class="control-label" for="ModuleName">Package Code:</label>
                        <div class="controls">
                                 <select name="PCode" id="PCode" required>
                                 @foreach($packgecode as $p)
                                 <option @if($module->QualificationPackageId == $p->id ) selected @endif value="{{$p->id}}">{{$p->packagecode}}</option>
                                 @endforeach
							 
							   </select><span id="img1"></span>
								
                        </div>
                </div> 

				<div class="control-group">
                    <label class="control-label" for="modulecode">Unit Code:</label>
                        <div class="controls">
                                <input type="text" name="UnitCode"  value="{{$module->UnitCode}}" required/>
                        </div>
                </div> 
				<div class="control-group">
                    <label class="control-label" for="modulecode">Unit Name:</label>
                        <div class="controls">
                                <input type="text" name="UnitName"  value="{{$module->UnitName}}" required/>
                        </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="ModuleName"> Unit Status:</label>
                        <div class="controls">
                                 <select name="Ustatus" id="Ustatus" required>
                                        <option @if($module->UnitStatus == "")selected="true" @endif value="{{$module->UnitStatus}}">---Select Status---</option>
                                        <option @if($module->UnitStatus == "C")selected="true" @endif value="{{$module->UnitStatus}}">Compulsory</option>
                                        <option @if($module->UnitStatus == "O")selected="true" @endif value="{{$module->UnitStatus}}">Optional</option>
                                     
							 
							    </select>
								
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="modulecode">Active Status:</label>
                        <div class="controls">
                        <select name="AStatus" id="AStatus" required>
                                        <option @if($module->Active == "")selected="true" @endif value="">---Select Status---</option>
                                        <option @if($module->Active == "1")selected="true" @endif value="1">Active</option>
                                        <option @if($module->Active == "O")selected="true" @endif value="0">Deactive</option>
                                     
							 
							    </select>
                        </div>
                </div>
			@endforeach
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-small btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
<script>
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Competency Standard Edited Successfully", class_name: "gritter-warning gritter-center" });

    @endif
    $("#TradeId").change(function() {
        var TradeId = $("#TradeId").val();
        $("#Code").html('');
        
        var msg = '--- Select Competency Standard ---';
      
            
                          $.ajax({

                                       beforeSend: function()
                                        {
                                            
                                            document.getElementById('img1').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        type: "GET",
                                        url: "{{url::to('FindIDNVQUnits')}}",
                                        data: {TradeId: TradeId},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#Code").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {

                                                    

                                                    $("#Code").append("<option value="  +item.id + ">" +item.code + "-"+ item.name +  "</option>");



                                                });

                                        },
                                        complete: function() {
                                            document.getElementById('img1').innerHTML ="";

                                        }
                                });            

            
       
    });
//packge code

$("#Code").change(function()
{
var code = document.getElementById("Code").value;
var msg = '--- Select PackageCode ---';
$("#PCode").html('');
$.ajax  ({
            url: "{{url::to('FindNVQUnits')}}",
            data: { code: code},
            dataType: "json", 
            success: function(result)
            
                {
                                             $("#PCode").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {

                                              $("#PCode").append("<option value=" + item.id + ">" +item.packagecode + "</option>");



                                                });
            
                
                }


            
        });




});
</script>