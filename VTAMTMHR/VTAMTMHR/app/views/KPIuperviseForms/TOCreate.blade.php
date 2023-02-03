@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
               <a href={{url('ViewKPISuperviseForms')}}> << Back to View</a>
            <h1>KPI Supervisor Satisfaction Form<small><i class="icon-double-angle-right"></i>Edit</small></h1>
                
            </div>
            <div class="control-group">
                   
                    <div class="controls">

                    @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                                 KPI Form Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'>
			<input type="hidden" name="HOCMRId" id="HOCMRId" value="{{$HOCMRId}}" />
			
              
				<div class="controls" id='table'>
                </div> 
			<?php $i = 1;?>
            
            <div class="control-group">
            <div class="controls">
			<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
								    <th class='center'>No</th>
                                    <th class='center'>Criteria</th>
                                    <th class='center'>Total Mark (100%)</th>
									<th class='center'>Self Satisfaction Mark</th>
							        <th class='center'>Supervisor Satisfaction Mark</th>

                                </tr>
               
               @foreach($Questions as $c)
                       
                        
                               
                               
                                <tr>
                                    <input type="hidden" name="QuestionsID[]" id="QuestionsID[]" value="{{$c->id}}">
									<td >{{$i++}}</td>
                                    <td >{{$c->Criteria}}</td>
									<td class='center'>{{$c->Fweight}}</td>
									<?php

$Selfweight = KPIEmployeeCriteriaResultTrans::where('Deleted','=',0)->where('CriteriaId','=',$c->id)->where('KPIECId','=',$HOCMRId)->pluck('SelfAchivedMark');
$supervisorfweight = KPIEmployeeCriteriaResultTrans::where('Deleted','=',0)->where('CriteriaId','=',$c->id)->where('KPIECId','=',$HOCMRId)->pluck('AchivedMarkBySupervisor');

?>
																		<td class='center'>{{$Selfweight}}</td>

									
<td class='center'>
<input  style="width:50px"  type="number" max="{{$c->Fweight}}" min ="0" name="AnswerID[]" id="AnswerID[]" value="{{$supervisorfweight}}" required="true" />
                                            
                                            
                                        
                                    </td>
                                    
                                </tr>
                               @endforeach
                            </thead>
                        </table>
             
            </div>
        </div>
            
		 <div class="control-group">
		   <label class="control-label" >Comments By the Employee: </label>
            <div class="controls">
				 <textarea style="width:470px; height:170px;" placeholder="Enter Reason..............." id="Dreason" readonly="true" name="Dreason">{{$KPIResult->CommentsByEmployee}}</textarea>
			</div>
		</div>
		 <div class="control-group">
		   <label class="control-label" >Comments By the Supervisor: </label>
            <div class="controls">
				 <textarea style="width:470px; height:170px;" placeholder="Enter Reason..............." id="CommentsByTheSupervisor"  name="CommentsByTheSupervisor" required="true">{{$KPIResult->CommentsByTheSupervisor}}</textarea>
			</div>
		</div>
		 
		

               
                
                
                

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-block btn-success">Save</button>
                </div>
            </div>         
            </form>
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
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>

<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
	
	  $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });


    </script>
    <script type="text/javascript">


                                function tableModify() {
                                    $('#sample-table-3').dataTable({
                                        "bPaginate": false,
                                        "aaSorting": [],
                                        "aoColumns": [
                                            {"bSortable": false},
                                            null,                                           
                                            null,
                                            null,
                                            null,
                                            {"bSortable": false}
                                        ]});
                                }


                                 $('#sample-table-3 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(6) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });
</script>


