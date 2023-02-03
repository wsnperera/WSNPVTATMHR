@include('includes.bar')    

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
                        Training
                    </small>			
                </h1>

            </div><!--/.page-header-->
            <!-- body -->
            <form class="form-horizontal" method="POST" action="{{url('empTrainingCreate')}}" id="myform">
                <div class="control-group">
                    <label class="control-label">Employee ID</label>
                    <div class="controls">
                        <input type="text" name="empid"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Training Name</label>
                    <div class="controls">
                        <input type="text" name="trainingName" id="trainingName" autocomplete="off"/>
                    </div>
                    <div id="my_select">
                   
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Training Type</label>
                    <div class="controls">
                        <input type="text" name="typeName" id="typeName"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Duration(Days)</label>
                    <div class="controls">
                        <input type="text" name="duration" id="duration"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">From</label>
                    <div class="controls">
                        <input type="date" name="from" id="from"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">To</label>
                    <div class="controls">
                        <input type="date" name="to" id="to"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <input type="button" value="Save" class="btn btn-small btn-primary" onclick="mysubmit()"/>
                    </div>
                </div>
            </form>
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

    $("#trainingName").keyup(function() {
        
        var aaa = " <select id=\"dale_training\" multiple=\"multiple\" style=\"margin-left: 180px;\" onclick=\"my();\"></select>";
        
        
        var x = document.getElementById('trainingName').value;
        document.getElementById('typeName').value = '';
        document.getElementById('duration').value = '';
        document.getElementById('typeName').readOnly = false;
        document.getElementById('duration').readOnly = false;
        $.ajax({
            url: "{{url::to('empTrainingAjax')}}",
            data: {x: x},
            success: function(res) {
                if(res === "Dale"){
                    document.getElementById('my_select').innerHTML = '';
                }else{
                document.getElementById('my_select').innerHTML = aaa;
                document.getElementById('dale_training').innerHTML = res;
            }
            }

        });

    });

    $("#my_select").on('change','#dale_training',function() {

        var select = document.getElementById('dale_training').value;
        document.getElementById('trainingName').value = select;

        $.ajax({
            url: "{{url::to('empTrainingAjaxDale')}}",
            data: {select: select},
            success: function(res) {

                var a = res.split('|#|');
                var typeName = a[0];
                var dura = a[1];
                document.getElementById('typeName').value = typeName;
                document.getElementById('duration').value = dura;
                document.getElementById('typeName').readOnly = true;
                document.getElementById('duration').readOnly = true;
                document.getElementById('my_select').innerHTML = '';
            }

        });

    });

    function mysubmit(){
        var from = document.getElementById('from').value;
        var to = document.getElementById('to').value;
        
        if(from !== "" && to !== ""){
            if(to > from){
                $("#myform").submit();
            }else{
                alert('Date period is not valid!');
            }
        }else{
            alert('Complete All the field before Save!');
        }
        
        
    }

</script>