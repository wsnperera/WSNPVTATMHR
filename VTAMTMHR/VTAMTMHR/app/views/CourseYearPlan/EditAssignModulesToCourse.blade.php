@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Assign Course Year Plan<small><i class="icon-double-angle-right"></i>Assign Modules</small></h1>
                <a href={{url('ConfirmCourseYearPlanFirstPage')}}> << Back to View </a>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <input type="hidden" name="cypID"   value="{{$courseYearPlan->id}}" required="true" readonly="true"/>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                    <div class="controls">
                        <input type="text" name="CourseListCode" id="CourseListCode"  value="{{$courseYearPlan->CourseListCode}}" required="true" />
                    </div>
                </div>
                
              
               
             
                
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Instructor :</label>
                    <div class="controls">
                        <table >
                            <tr>
                                <td>
                                    <table id="my_table"  >
                                        <tr>
                                            <th></th>
                                        </tr>
                                        {{$htmlTableRaw}}
                                    </table>
                                    <br>
                            <center><button style="margin: 0; height: 30px; border: 0" type="button" id="add_new_grade"><i class="icon-plus icon-2x icon-only"></i></button><button style="margin: 0; height: 30px; border: 0" type="button" id="remove_grade"><i class="icon-remove icon-2x icon-only"></i></button></center>
                            </td>
                            </tr>
                        </table>
                    </div></div>
                <div class="control-group">
                    <div class="controls">
                        <table class="table">
                            <tr>

                                <th>Module Code</th>
                                <th>Module Name</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                            <tr {{$Serial_no=1;}}>
                                @foreach($courseYearPlanModule as $m)
                            <tr id="{{$Serial_no}}">
<!--                                    <td><input name="Module_ids[]" value="' . $m->cmoduleid . '" type="checkbox"><span class="lbl"></span></td>-->
                                <td><input name="Module_ids[]" class="coursemodules2" type="hidden" value="{{$m['id']}}">
                                    <input id="mod_id-{{$Serial_no}}" class="coursemodules" type="hidden" value="{{$m['cmoduleid']}}">
                                    <span class="lbl">{{$m['modulecode']}}</span></td>
                                <td><span class="lbl">{{$m['modulename']}}</span></td>
                                <td><button type="button" value="{{$Serial_no++}}" onclick="removeRow(this);" class="btn btn-danger btn-mini">
                                        <i class="icon-trash bigger-200"></i>
                                    </button></td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                    <div class="controls">
                        <input type="button" value="Add Modules" onclick="addcompany()" class="btn btn-small btn-grey" >
<!--                        <input type="button" class="btn btn-small btn-grey" onclick="addnewmodules()" value="Add New Modules" id="checklistbtn"/>-->
                    </div>
                </div>



                <div class="control-group" hidden="" id="addcompany" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:600px">
                    <div class="control-group">
                    <label class="control-label" for="Name of Organization">TVEC Trade Name : </label>
                    <div class="controls">
                        <select  name="tvectrade" id="tvectrade" required>
                            <option value="0" selected>--Select TVEC Trade--</option>
                            
                            @foreach($tvecTrade as $d)
                            <option value="{{$d->TradeId}}">{{$d->TradeName}}</option>
                            @endforeach
                        </select>
                        <b style="color: red">*</b>      
                    </div>
                      </div>


                    <div class="control-group">
                        <label class="control-label">Competency Standards :</label>

                        <div class="controls" >
                            <select  name="type" multiple="" class="chzn-select" id="form-field-select-4" >
                                
                            </select>                           
    <!--                        <input type="button" id="comstandard" class="btn btn-small btn-purple" value="Create New Competency Standard"/>-->
                        </div>
                        <span id='table'>

                        </span>
                    </div>

                    <div class="control-group">

                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-small btn-primary" value="Save"/>
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
<script>
                            $('#add_new_grade').click(function()
                            {
                                $('#my_table').append('{{$htmlTableRaw}}');
                            });
                            $('#remove_grade').click(function() {
                                var rowCount = $('#my_table tr').length;
                                if (rowCount > 2) {
                                    $('#my_table tr:last').remove();
                                    var s = parseInt($('#mark_id').val());
                                    $('#mark_id').val(s - 1);
                                    var g = (s - 2) + 'g';
                                    var f = (s - 2) + 'f';
                                    document.getElementById(f).readOnly = false;
                                    document.getElementById(g).readOnly = false;
                                }
                            });
                            $('table th input:checkbox').on('click', function() {
                                var that = this;
                                $(this).closest('table').find('tr > td:first-child input:checkbox')
                                        .each(function() {
                                            this.checked = that.checked;
                                            $(this).closest('tr').toggleClass('selected');
                                        });
                            });
                            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                            function tooltip_placement(context, source) {
                                var $source = $(source);
                                var $parent = $source.closest('table')
                                var off1 = $parent.offset();
                                var w1 = $parent.width();
                                var off2 = $source.offset();
                                var w2 = $source.width();
                                if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                                    return 'right';
                                return 'left';
                            }
</script>
<script>
    function addcompany() {
        //alert();
        if ($('#addcompany').is(':hidden')) {
            $('#addcompany').show();
            $(".chzn-select").chosen();
        } else {
            $('#addcompany').hide();
        }
    }
    function getQualifications() {
        var selectedmodules = [];
//        var a = [];
//        var b = $('.coursemodules');
//        $.each(b, function(key, value) {
//            var x = value.value;
//            //return x;
//            a.push(x);
//        });

        selectedmodules = $('input[name="Module_ids[]"]').serializeArray();
        $.ajax
                ({
                    type: "GET",
                    url: "{{Url('ajaxgetQualifications')}}",
                    data: {selectedmodules: selectedmodules},
                    success: function(result)
                    {
                        $('#qualification_package').html(result);
                    }
                });
    }
    function removeRow(x) {
        var rowID = x.value;
        var mod_id = $('#mod_id-' + rowID).val();
        var clc = $('#CourseListCode').val();
        var yearPalnID = '{{$yearPalnID}}';
        //alert(yearPalnID);
        $.ajax
                ({
                    type: "GET",
                    url: "{{Url('ajaxdeletemodules')}}",
                    data: {mod_id: mod_id, clc: clc, yearPalnID: yearPalnID},
                    success: function(result)
                    {
                        if (result == "1") {
                            alert("Please check again.");
                        }
                        else {
                            $('#' + rowID).html('');
                        }
                    }
                });
    }

</script>
<script>
    $('#form-field-select-4').change(function()
    {
        var values = $("#form-field-select-4").val();
        var a = [];
        var b = $('.coursemodules2');
        $.each(b, function(key, value) {
            var x = value.value;
            a.push(x);
        });
        if (values != null) {
            $.ajax
                    ({
                        type: "GET",
                        url: "{{Url('getNVQmoduleProgramedit')}}",
                        data: {module: values, selectedmodules: a},
                        success: function(result)
                        {
                            $('#table').html(result);
                        }
                    });
        }
        else {
            $('#table').html('');
        }
    });


</script>
<script type="text/javascript">
     $('#tvectrade').change(function()
    {
        var values = $("#tvectrade").val();
      // alert(values);
      
            $.ajax
                    ({
                        type: "GET",
                        url: "{{Url('getNVQCompetencyStandardNew')}}",
                        data: {values: values},
                        success: function(result)
                        {
                          $("#form-field-select-4").html("<option value=\"0\" selected></option>");
                            $.each(result, function(i, item)
                            {
                                //  alert('dis');
                                $("#form-field-select-4").append("<option value=" + item.code + ">"  + item.name + "</option>");

                            });
                            $("#form-field-select-4.chzn-select").trigger("liszt:updated");
                        }
                    });
        
        
    });
</script>










