@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
              <!--  <a href={{url('')}}> << Back to Assessor View</a>-->
                <h1>Assessor<small><i class="icon-double-angle-right"></i>Schedule Final-Assessment</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'/>
            <div id="table1">
              <div class="control-group">
                 <div class="controls">
              <pre><h6><center>Assigned Dates For Final Assessments</b></center></h6></pre>  
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                    <th class="center">No</th>
                    <th>Scheduled Date</th>                          
                    <th>Type</th> 
                    <th>Completed</th> 
                    </tr>
                    </thead>
                    <?php $i =1; ?>
                    <tbody>
                      @if(isset($dates))
                      @foreach($dates as $c)
                      <tr>
                              <td class="center" ><font color="blue">{{$i}}</font></td>
                              <td><font color="blue">{{$c->DateScheduled}}</font></td>
                              <td><font color="blue">{{$c->Type}}</font></td>
                              @if($c->ActualHeldStatus == 0 )

                              <td><font color="blue">No</font></td>
                              @else
                               <td><font color="red">Yes</font></td>
                              @endif
                              
                      </tr>
                      <?php $i = $i +1; ?>
                      @endforeach
                      @endif
                    </tbody>
                  </table>

              </div>
            </div>
          </div>

              <div id="ncc_id1">
                    <div class="control-group">
                        <label class="control-label" for="CourseCode">Date</label>
                        <div class="controls">
                           
                               
                               <input  type="Date" name="ScheduleDates[]" onclick="dale_ncc(1)" id="CourseListCode1" required/>
                               <button  class="btn btn-warning" style="margin: 0; height: 30px; border: 0; visibility: hidden" type="button" id="add_ncc"><i class="icon-plus bigger-100"></i>Add Another Date</button>
                               <button class="btn btn-danger" style="margin: 0; height: 30px; border: 0; visibility: hidden" type="button" id="remove_ncc"><i class="icon-remove bigger-100"></i>Remove Last Date</button>
                            
                        </div>
                    </div>
                </div>
                <div id="ncc_id2" style="visibility: hidden">
                   <div class="control-group">
                        <label class="control-label" for="CourseCode">Date</label>
                         <div class="controls">
                           
                            <input  type="Date" name="ScheduleDates[]"  id="CourseListCode2"/>
                         </div>
                     </div>
                </div>
                <div id="ncc_id3" style="visibility: hidden">
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Date</label>
                         <div class="controls">
                           
                            <input  type="Date" name="ScheduleDates[]"  id="CourseListCode3"/>
                         </div>
                     </div>
                </div>
                <div id="ncc_id4" style="visibility: hidden">
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Date</label>
                         <div class="controls">
                           
                            <input  type="Date" name="ScheduleDates[]"  id="CourseListCode4"/>
                         </div>
                     </div> 
                </div>
                <div id="ncc_id5" style="visibility: hidden">
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Date</label>
                         <div class="controls">
                           
                            <input  type="Date" name="ScheduleDates[]"  id="CourseListCode5"/>
                         </div>
                     </div> 
                </div>
                <div id="ncc_id6" style="visibility: hidden">
                    <div class="control-group">
                       <label class="control-label" for="CourseCode">Date</label>
                       <div class="controls">
                           
                            <input  type="Date" name="ScheduleDates[]"  id="CourseListCode6"/>
                         </div>
                    </div>
                </div>
                <input type="hidden" id="dale_ncc_id" value="1"/>
                 <input type="hidden" id="CSID"  name="CSID" value="{{$CSID}}"/>
                <div class="control-group">
                    <div class="controls">
                        
                    </div>
                </div>     
           

           
            
            

            <div class="control-group" id="savebtn">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>             

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
        <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
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
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Assessor Renominated Successfully", class_name: "gritter-info gritter-center"});

    @endif


      
function dale_ncc(x) 
{
    var a = parseInt(x);
                                  
    document.getElementById('add_ncc').style.visibility = 'visible';


}

 $('#add_ncc').click(function() {
                                    var s = parseInt($('#dale_ncc_id').val());
                                    //alert(s);
                                    if(s == 1)
                                    {
                                      document.getElementById('ncc_id2').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 2;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 2)
                                    {
                                      document.getElementById('ncc_id3').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 3;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 3)
                                    {
                                      document.getElementById('ncc_id4').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 4;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 4)
                                    {
                                      document.getElementById('ncc_id5').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 5;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 5)
                                    {
                                      document.getElementById('ncc_id6').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 6;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                  
                                });
  $('#remove_ncc').click(function() {
                                    var s = parseInt($('#dale_ncc_id').val());
                                    if(s == 1)
                                    {
                                      
                                    }
                                     else if(s == 2)
                                    {
                                      document.getElementById('ncc_id2').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 1;
                                      document.getElementById('remove_ncc').style.visibility = 'hidden';
                                    }
                                     else if(s == 3)
                                    {
                                      document.getElementById('ncc_id3').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 2;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 4)
                                    {
                                      document.getElementById('ncc_id4').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 3;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 5)
                                    {
                                      document.getElementById('ncc_id5').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 4;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 6)
                                    {
                                      document.getElementById('ncc_id6').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 5;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }

                                    
                                });

    </script>


