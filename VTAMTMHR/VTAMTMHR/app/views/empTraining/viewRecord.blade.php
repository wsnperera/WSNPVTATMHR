@include('includes.bar')    
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">

    <div class="row-fluid">

        <div class="span8">

            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->

            <div class="page-header position-relative">

                <h1>
                    Employee			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Training View
                    </small>			
                </h1>

            </div><!--/.page-header-->
            <!-- body -->
            <div>
                <form name='search' action="{{url('empTrainingSearch')}}" method='post'>
                    <table>
                        <tr>
                            <td>Employee ID:&nbsp;&nbsp;<input type="text" name="empid" placeholder="Emp ID" style="width: 100px; margin: 0"/></td>
                            <td>&nbsp;&nbsp;Training Name :&nbsp;&nbsp;
                                <select class="chzn-select" style="margin: 0" name="triningname" placeholder="Training Name">
                                    <option value=""></option>
                                    @if(isset($ipName))
                                    @foreach ($ipName as $ipn)
                                    <option value="{{$ipn->trainingName}}">{{$ipn->trainingName}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td style="text-align: center;"><input type='submit' value='Search' style="height: 30px;"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            
            <table class="table">
                <tr>
                    <th>EMP ID</th>
                    <th>TP ID</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
                @if(isset($empresults))
                @foreach($empresults as $er)
                <tr>
                    <td>{{$er->empid}}</td>
                    <td>{{$er->Emptrainingprograme->trainingName}}</td>
                    <td>{{$er->from}}</td>
                    <td>{{$er->to}}</td>
                </tr>
                @endforeach
                @endif
            </table>
            <!-- /body -->
        </div>

        <div class="span4">

            @if($errors->has())

            @foreach($errors->all() as $msg)



            <div class="alert alert-error">

                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>

                <strong> <i class="icon-remove"></i>{{$msg}}</strong>

            </div>



            @endforeach

            @endif



        </div>

    </div>
</div>


@include('includes.footer')   


<script type="text/javascript">

   
</script>
<script src="assets/js/chosen.jquery.min.js"></script>

<script type="text/javascript">
$(function() {
     $(".chzn-select").chosen();
});
</script>