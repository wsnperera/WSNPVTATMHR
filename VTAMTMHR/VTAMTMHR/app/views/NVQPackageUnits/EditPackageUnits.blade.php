@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href="{{url('NVQPackageUnit')}}"> << Back to View </a>
                <h1>NVQ  Packages Units<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
           
			<form class="form-horizontal" action='UpdateEdit' method="POST"/>
			
                
                    <input type="hidden" name="id"  value="{{$Rec->id}}" />
                        <div class="control-group">
                            <label class="control-label" for="ModuleName">Trade:</label>
                                <div class="controls">
                                
                                    <select name="TradeId" id="TradeId" required>
                                    <option value="">--- select Trade ---</option>
                                    @foreach($TCode as $t)
                                    <option @if($t->TradeId == $OriginalTradeID) selected @endif value="{{$t->TradeId}}">{{$t->TradeName}}</option>
                                    @endforeach
                                    </select><span id="img1"></span>
                                
                                </div>
                        </div>

                    <div class="control-group">
                            <label class="control-label" for="ModuleName">Competency Standard Code:</label>
                                <div class="controls">
                                        <select name="Code" id="Code" required>
										<option value="">--- select Competency ---</option>
                                       @foreach($CCode as $y)
                                        <option @if($OriginalCompetencyID == $y->code) selected @endif value="{{$y->code}}">{{$y->code}}-{{$y->name}}</option>
                                        @endforeach
                                    </select>
                                        
                                </div>
                        </div> 
                        
                        <div class="control-group">
                            <label class="control-label" for="ModuleName">Package Code:</label>
                                <div class="controls">
                                        <select name="PCode" id="PCode" required>
										<option value="">--- select PackageCode ---</option>
                                        @foreach($CompentencyCode as $p)
                                        <option @if($module->QualificationPackageId == $p->id) selected @endif value="{{$p->id}}">
                                        {{$p->packagecode}}</option>
                                        @endforeach
                                    
                                    </select><span id="img1"></span>
                                        
                                </div>
                        </div> 
               
		
             	<div class="control-group">
                    <label class="control-label" for="modulecode">Unit:</label>
                        <div class="controls">
                        <select name="UnitID" id="UnitID" class="chzn-select" data-placeholder="Choose Unit..." required >
                        <option value="">--- Select Unit ---</option>
								 
								 @foreach($Units as $u)
								 <option @if($u->UID == $module->UnitID) selected="true" @endif value="{{$u->UID}}">{{$u->UnitCode}} - {{$u->UnitName}} - {{$u->UnitVersion}}</option>
								@endforeach
						</select><font color="red">*</font>
                                  
                        </div>
                </div>
                        
						  <div class="control-group">
                            <label class="control-label" for="ModuleName"> Unit Status:</label>
                                <div class="controls">
                                        <select name="Ustatus" id="Ustatus" required>
                                                <option @if($Rec->UnitStatus == "")selected="true" @endif value="">---Select Status---</option>
                                                <option @if($Rec->UnitStatus == "C")selected="true" @endif value="C">Compulsory</option>
                                                <option @if($Rec->UnitStatus == "O")selected="true" @endif value="O">Optional</option>
                                          
                                        </select>
                                        
                                </div>
                        </div>
                       
                        <div class="control-group">
                            <label class="control-label" for="modulecode">Active Status:</label>
                                <div class="controls">
                                <select name="AStatus" id="AStatus" required>
                                                <option @if($Rec->Active == "")selected="true" @endif value="">---Select Status---</option>
                                                <option @if($Rec->Active == "1")selected="true" @endif value="1">Active</option>
                                                <option @if($Rec->Active == "O")selected="true" @endif value="0">Deactive</option>
                                            
                                    
                                        </select>
                                </div>
                        </div>
                
		
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
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
   jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
});

   
    
</script>
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