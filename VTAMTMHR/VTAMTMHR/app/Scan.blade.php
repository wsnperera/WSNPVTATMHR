@include('includes.bar')
@if(isset($Issearch))
<a href={{url('applicantUnRegistered')}}> << Back to Unregistered Applicant </a> 
@endif
<div class="page-content">
   <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                   Applicant		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Un Registered List Of Applicant
                    </small>			
                </h1>
               
            </div><!--/.page-header-->
            <form class="form-horizontal" name='find' method='get' action="{{url('findScann')}}" >

                <div class="control-group">
                    <label class="control-label" for="form-field-7">Course Code</label>
                    <div class="controls">
                        <select name="CourseCode" id="CourseCode" required="required" >
                            <option>--Select--</option>
                            @foreach ($coursestarted as $cs)
                            <option value="{{$cs->CourseCode}}">{{$cs->CourseCode}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                 <div class="control-group" id="divQualified">
                    @if(isset($html1))
                    {{$html1}}
                    @endif
                </div>
                <div id="table">                    
                    @if(isset($html2))
                    <div>{{$html2}}</div>
                    @endif
                </div>
            </form>

                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    @include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
    <script type="text/javascript">
        
        function table() {
    var oTable1 = $('#sample-table-2').dataTable({
        "bPaginate": true,
        "aoColumns": [
            null, null, null,null,{"bSortable": false},{"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}
        ]});
    $('table th input:checkbox').on('click', function() {
        var that = this;
        $(this).closest('table').find('tr > td:nth-child(4) input:checkbox')
                .each(function() {
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
    });
}

$("#CourseCode").change(function() {
   var course_Code = document.getElementById('CourseCode').value;
    $.ajax({
        url: "{{url::to('getCourseListCodeApplicantQualify')}}",
        data: {CourseCode: course_Code},
        success: function(result)
        {
            $('#divQualified').html(result);
            $('#table').html("");
        }
    });
});

$("#divQualified").on("change", "#Qualified", function() {
    var AppQua = $('#Qualified').val();
    var course_Code = document.getElementById('CourseCode').value;
    if (AppQua !== '') {
        $.ajax({
            url: "{{url::to('viewApplicantListUnRegistered')}}",
            data: {Qualified: AppQua,CourseCode:course_Code},
            success: function(result) {
                $('#table').html(result);
                table();
            }
        });
    }
    
        $.ajax({
            url: "{{url::to('exceldownloadUnRegApp')}}",
            data: {Qualified: AppQua,CourseCode:course_Code},
            success: function(result){
            }
        });
    
});

    </script>
