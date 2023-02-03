@include('includes.bar')
<html>
<head>
    <meta charset="UTF-8">
    </head>
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
               <a href={{url('ViewKPIForms')}}> << Back to View</a>
            <h1>KPI Self Satisfaction Form<small><i class="icon-double-angle-right"></i>View</small></h1>
                
            </div>
           
            <div class="control-group">
                   
                    
                   
                </div>
               @if(isset($Questions))
            <table>
                <tr>
                    <td>
                        <form> 
                            <button type="button" id="upload" class="btn btn-yellow">
                            <i class="icon-print bigger-150"></i>Print KPI Result Paper</button>
                            <span id='img4'></span>
                        </form> 
                        
                    </td>
                    
                    
                </tr>
            </table>
            @endif
            <form class="form-horizontal" action='' method="POST"  id='NewModule'>
			<input type="hidden" name="HOCMRId" id="HOCMRId" value="{{$HOCMRId}}" />
              
				
			<?php $i = 1;
			 $FTmatkC = 0;
			 $rec =  KPIEmployeeCriteriaResult::where('id','=',$HOCMRId)->first();
			 $supervisoLnam = HREmployee::where('id','=',$rec->SuperviserId)->first();

    $ATmarkC = 0;?>
            
            <div class="control-group">
            <div class="controls">
			<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
								      <th class='center'>No</th>
                                    <th class='center'>Criteria</th>
                                    <th class='center'>Total Mark (100%)</th>
									<th class='center'>Self Satisfaction Marks</th>
									<th class='center'>Supervisor Marks</th>
                                </tr>
							</thead>
               @foreach($Questions as $c)
                       
                        
                               
                               
                                <tr>
                                    <input type="hidden" name="QuestionsID[]" id="QuestionsID[]" value="{{$c->id}}">
									<td >{{$i++}}</td>
                                    <td >{{$c->Criteria}}</td>
									<td class='center'>{{$c->Fweight}}</td>
									<td class='center'>{{$c->SelfAchivedMark}}</td>
									<td class='center'>{{$c->AchivedMarkBySupervisor}}</td>
									
                                    
                                   

                                    
                                </tr>
                               @endforeach
							   <tr>
								    <th class='center'>*</th>
                                    <th class='center'><font color="blue">Total</font></th>
									<th class='center'><font color="blue">{{$rec->TotalWeight}}</font></th>
									<th class='center'><font color="blue">{{$rec->SelfAchivedWeight}}</font></th>
									<th class='center'><font color="blue">{{$rec->SupervisorAchivedWeight}}</font></th>

                                </tr>
								<tr>
								    <th class='center'>*</th>
									<th class='center'><font color="green">--</font></th>
                                    <th class='center'><font color="green">Percentage(%)</font></th>
									<th class='center'><font color="green">{{$rec->SelfPercentage}}%</font></th>
									<th class='center'><font color="green">{{$rec->SupervisorPercentage}}%</font></th>

                                </tr>
								<tr>
								    <th class='center'>*</th>
                                    <th class='center'><font color="red">--</font></th>
                                    <th class='center'><font color="red">Grade</font></th>
									<th class='center'><font color="red">{{$rec->GradeAchived}}</font></th>
									<th class='center'><font color="red">{{$rec->SupGradeAchived}}</font></th>

                                </tr>
                            
                        </table>
             
            </div>
        </div>
            
			 

       <div class="control-group">
		   <label class="control-label" >Comments By the Employee: </label>
            <div class="controls">
				 <textarea style="width:470px; height:170px;" placeholder="Enter Reason..............." id="Dreason" name="Dreason" readonly >{{$rec->CommentsByEmployee}}</textarea>
			</div>
		</div>
		<div class="control-group">
		   <label class="control-label" >Supervisor: </label>
            <div class="controls">
				 <textarea style="width:470px; height:10;" placeholder="Enter Reason..............." id="Dreason" name="Dreason" readonly >{{$supervisoLnam->Initials}} {{$supervisoLnam->LastName}}({{$supervisoLnam->EPFNo}})</textarea>
			</div>
		</div>
		<div class="control-group">
		   <label class="control-label" >Comments By the Supervisor: </label>
            <div class="controls">
				 <textarea style="width:470px; height:170px;" placeholder="Enter Reason..............." id="Dreason" name="Dreason" readonly >{{$rec->CommentsByTheSupervisor}}</textarea>
			</div>
		</div>
       

               
                
                
                

               
            
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
        <div class="span4" id="ajaxerror">
            
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif

        </div>
    </form>
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
</html>
@include('includes.footer')

<script src="assets/js/jquery-ui.custom.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="assets/js/jquery.easypiechart.min.js"></script>
<script src="assets/js/jquery.sparkline.index.min.js"></script>
<script src="assets/js/jquery.flot.min.js"></script>
<script src="assets/js/jquery.flot.pie.min.js"></script>
<script src="assets/js/jquery.flot.resize.min.js"></script>
<script src="assets/js/canvasjs.min.js"></script>

<script type="text/javascript">


  window.onload = function () {
    var m = "%";
  var chart = new CanvasJS.Chart("chartContainer",
  {
    title:{
      text: "Time Table Progress"
    },
    legend: {
      maxWidth: 350,
      itemWidth: 120
    },
    data: [
    {
      type: "pie",
      showInLegend: true,
      legendText: "{indexLabel}",
      dataPoints: [
        { y: document.getElementById("Fcompleteprecentage").value, indexLabel: "Completed %" },
        { y: document.getElementById("FNOTcompleteprecentage").value, indexLabel: "Not Completed %"} 
       
      ]
    }
    ]
  });
  chart.render();
}
</script>



<script>

    @if(isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


       $("#CalType").change(function() {

        var CalType = document.getElementById('CalType').value;
        //alert(CalType);
        $("#table").html('');
        
        //var msg = '--- Select Course ---';
        $.ajax({
            type: "GET",
            url: "{{url::to('GetCalClass')}}",
            data: {CalType: CalType},
            success: function(result) {

                $('#table').html(result);

            }
           
        });
    });

    
  
    
    $('#DatePlanned').change(function(){

        //alert('dg');
       var DatePlanned = document.getElementById('DatePlanned').value;
       var CenterID = document.getElementById('CenterID').value;
       var CourseYearPlanID = document.getElementById('CourseYearPlanID').value; 
      // var msg = '--- Select Working Place ---';
        //$("#WorkingPlace").html('');
       $.ajax  ({
                    url: "{{url::to('MOCMCheckPlanneddate')}}",
                    data: {DatePlanned: DatePlanned,CenterID: CenterID,CourseYearPlanID: CourseYearPlanID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        if(result.module == 1)
                        {
                             document.getElementById('DatePlanned').value = "";
                             $('#table1').html(result.html);
                             
                        }
                        else
                        {
                             $("#table1").html('');
                        }
                       
                        
                                        
                        
                        }


                    
                });
        


       
    });

  </script>
    <script type="text/javascript">
      $('#upload').click(function()
    {
      
        var HOCMRId = $("#HOCMRId").val(); 
      //alert(CenterMoniPlan);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintSeltKPIForm')}}",
                        data: {resID: HOCMRId},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
                                //location.reload();
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );

    </script>
    


