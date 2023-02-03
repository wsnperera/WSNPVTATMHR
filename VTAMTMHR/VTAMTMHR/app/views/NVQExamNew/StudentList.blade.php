@include('includes.bar')       
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header position-relative">
                <h1>
                    View Course wise Students			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        View
                    </small>			
                </h1>
            </div>
            <div class="form-horizontal" >              
               
            
                <div class="control-group">
                    <div class="controls">
                        <!--<button type="button" onclick="getTableCourseDetails()" class="btn btn-primary"">
                                <i class="icon-eye-open bigger-200"></i>View</button>
                                <span id='upld' hidden>-->
                                <input type="hidden" value="{{$CS_ID}}" name="CS_ID" id="CS_ID"/>
                                <button type="submit" id="upload" class="btn btn-pink">
                                <i class="icon-eye-open bigger-200"></i>Download Assessment Approval</button>
                                <span id='img4'></span>
                                <!--<button type="button" id='webservice' class="btn btn-blue btn-small">
                                <i class="icon-eye-open bigger-200"></i>Upload to WebService</button>
                                <span id='img5'></span>
                                </span>-->
                    </div>
                </div>
                <div id="table"> 
                
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class='center'>No</th>
                        <th class='center'>Name</th>
                        <th class='center'>NIC</th>
                        <th class='center'>Training No</th>
                        <th class='center'>TVEC Send</th>
                         
                         <th class='center'>
                                  <label>(Select All)
                                    <input name='select_all[]' value='' type='checkbox'>
                                    <span class='lbl'> &nbsp;</span>
                                    </label></th>
                        </th>
                        
                        
                </tr>
                </thead>
                    <tbody>

                  <?php $SerialNo=1
                  ?>
                @if(isset($Trainees))
                @foreach($Trainees as $t)
                <tr>
                     <td class="center">{{$SerialNo++}}</td>
                    <td class="center">{{$t->NameWithInitials}}</td>
                    <td class="center">{{$t->NIC}}</td> 
                    <td>{{$t->training_no}}</td>
                    <td class="center">{{$t->TVECSend}}</td>
                    @if($t->TVECSend == 0)
                    <td class="center"><label>
                        <input name="trainee_ids[]" class="abc" value="{{$t->id}}" type="checkbox" />
                        <span class="lbl"> &nbsp;</span>
                        </label>
                    </td>
                    @else
                    <td class="center"><label>
                        <input name="trainee_ids[]" class="abc" value="{{$t->id}}" type="checkbox" checked/>
                        <span class="lbl"> &nbsp;</span>
                        </label>
                    </td>
                    @endif
                    
                    
                </tr>
                @endforeach

               
                @endif
            </tbody>
            </table>                
                </div>

               
               
                
                <br/>
				 <div id="loading">                  
                </div>
              
            </div>
        </div>
    </div>
</div>
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">

                                function tableModify() {
                                    $('#sample-table-2').dataTable({
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
</script>

<script type="text/javascript">


         

    $('#sample-table-2 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(6) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });

    function getTableCourseDetails() {
        var center = $("#center").val(); 
        //alert(center);		
        $('#table').val('');
        if (center != '')
        {
            $.ajax
                    ({
                        beforeSend: function ()
                        {
                            $("#loading").html('<br><br><img height="50%" width="25%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                        },
                        type: "GET",
                        url: "{{Url('view_courses')}}",
                        data: {center: center},
                        success: function (result)
                        {   if(result!=1){
                            $('#table').html(result);
                            $('#sample-table-2 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(6) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });
                            tableModify();
                            $('#upld').show();
                            }
                            else
                            {
                                bootbox.alert('NoResults Found');
                            }
                        },
                        complete: function () {

                            $("#loading").html('');
                        },
                    });

        }
    }
$('#upload').click(function()
    {var ifOneSelected = false;
        var selectedmodules = [];
        selectedmodules = $('input[name="trainee_ids[]"]').serializeArray();
        var CS_ID = $("#CS_ID").val(); 
       // alert(CS_ID);
      

        if (selectedmodules.length > 0) {
            ifOneSelected = true;
        }
        else {
            bootbox.alert('Please Select At Least One Course!');
        }
        // alert(selectedmodules);
        if (ifOneSelected) {
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('EUviewStudentsCourseWise')}}",
                        data: {selectedmodules: selectedmodules,CS_ID: CS_ID},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                          //alert(result);
                             /* if (result != 1) {
                               // alert(2);
                                //bootbox.alert('Download error occured !!');
                                //$('#table').css("display", "");
                                //$('#sendselected').css("display", "");
                                //$('#search').css("display", "");
                                //$("#loding").html('');
                               // $('#table').css("display", "");
                              //  $('#sendselected').css("display", "");
                               // $('#search').css("display", "none");
                            }
                            else {
                               // alert(3);
                               // bootbox.alert('Sucessfully Downloaded !!');
                                //$("#loding").html('<br><br><img height="40%" width="20%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                                //location.reload();
                            }*/

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        }
    }
    );

 /*    
    function viewStudentDetails(CourseCode)
    {
        
    $.ajax({
         url: "{{url::to('viewStudentsCourseWise')}}",
        data: {CourseCode:CourseCode},
        success: function (result)
                        {
                            $('#table').html(result);
                            tableModify();
                        },
                        complete: function () {

                            $("#loading").html('');
                        },
        
         });
    }*/

    $('#webservice').click(function()
    {
            window.location.href ='RunWebService';
        //$(location).attr('RunWebService');
    }
    );
    

</script>


