@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href="{{url('NVQPackageUnit')}}"> << Back to View </a>
                <h1>NVQ  Packages Units<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            
            <form class="form-horizontal" id="fupForm" name="form1" action="CreateNVQUnits" method="post" />
			  <div class="control-group">
                   
                    <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                                Units Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div> 
			
				 <div class="control-group">
                    <label class="control-label" for="ModuleName">Trade:</label>
                        <div class="controls">
                               <select name="TradeId" id="TradeId" required>
							   <option value="">---Select Trade---</option>
							   @foreach($trades as $t)
							   <option value="{{$t->TradeId}}">{{$t->TradeName}}</option>
							   @endforeach
							   </select><span id="img1"></span>
                        </div>
                </div>  
				
                <div class="control-group">
                    <label class="control-label" for="ModuleName">Competency Standard Code:</label>
                        <div class="controls">
                                 <select name="CSCode" id="CSCode" required>
								 
							 
							    </select>
								
                        </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="ModuleName">Package Code:</label>
                        <div class="controls">
                        <select name="QualificationPackageId" id="QualificationPackageId" required >
                        
 
						</select>
								
                        </div>
                </div>   
                     
                     
				<div class="control-group">
                    <label class="control-label" for="modulecode">Unit:</label>
                        <div class="controls">
                        <select name="UnitID[]" id="UnitID"  multiple="multiple" class="chzn-select" data-placeholder="Choose Unit..." required >
                        <option value="">--- Select Unit ---</option>
								 
								 @foreach($Units as $u)
								 <option value="{{$u->UID}}">{{$u->UnitCode}} - {{$u->UnitName}} - {{$u->UnitVersion}}</option>
								@endforeach
						</select><font color="red">*</font>
                                  
                        </div>
                </div> 
				 	
                <div class="control-group">
                            <label class="control-label" for="ModuleName"> Unit Status:</label>
                                <div class="controls">
                                        <select name="Ustatus" id="Ustatus" required>
                                                <option  value="">---Select Status---</option>
                                                <option  value="C">Compulsory</option>
                                                <option  value="O">Optional</option>
                                          
                                        </select>
                                        
                                </div>
                        </div>
                
                <div class="control-group">
                    <div class="controls">
                        
                    <input type="submit" name="save" class="btn btn-primary" value="Save" id="butsave">
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

<script type="text/javascript">
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Package Added Successfully", class_name: "gritter-warning gritter-center" });

    @endif
	
	 $("#TradeId").change(function() {
        var TradeId = $("#TradeId").val();
        $("#CSCode").html('');
        
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
                                             $("#CSCode").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {

                                                    

                                                    $("#CSCode").append("<option value="  +item.code+ ">" +item.code + "-"+ item.name +  "</option>");



                                                });

                                        },
                                        complete: function() {
                                            document.getElementById('img1').innerHTML ="";

                                        }
                                });            

            
       
    });
//packge code

$("#CSCode").change(function()
{
var code = document.getElementById("CSCode").value;
var msg = '--- Select PackageCode ---';
$("#QualificationPackageId").html('');
$.ajax  ({
            url: "{{url::to('FindNVQUnits')}}",
            data: { code: code},
            dataType: "json", 
            success: function(result)
            
                {
                                             $("#QualificationPackageId").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {

                                              $("#QualificationPackageId").append("<option value=" + item.id + ">" +item.packagecode + "</option>");



                                                });
            
                
                }


            
        });




}); 
//dshg
/* 
$(document).ready(function(){
   var $form = $('form');
    
   $form.submit(function(){
      $.post($(this).attr('action'), $(this).serialize(),function(response){
            // clear this text box
            $(".msgbox.ajax").msgbox({
                type: 'ajax',
                title: 'Ajax'
            });

      },'json');
      
      return false;
   });
});
*/

//Data insert and Unit code and unit name clear ajax

 $(document).ready(function() {
$('#butsave').on('click', function() {
//$("#butsave").attr("disabled", "disabled");

var QualificationPackageId = $('#QualificationPackageId').val();
var UnitID = $('#UnitID').val();

var Ustatus = $('#Ustatus').val();
if(QualificationPackageId!="" && UnitID!="" && Ustatus!=""){
	$.ajax({
		url: "CreateNVQUnits",
		type: "POST",
		data: {
			QualificationPackageId: QualificationPackageId,
			UnitID: UnitID,
			Ustatus: Ustatus				
		},
		cache: false,
		success: function(dataResult){
			var dataResult = JSON.parse(dataResult);
			if(dataResult.statusCode==101){
				$('#UnitID').val('');
                
				
				bootbox.alert('Package Unit added successfully !');
									
			}
			
			
			
		}
	});
	}
	else
	{
		bootbox.alert("Please Enter All the required Data!!!!");
	}
	
});
});
 
</script>