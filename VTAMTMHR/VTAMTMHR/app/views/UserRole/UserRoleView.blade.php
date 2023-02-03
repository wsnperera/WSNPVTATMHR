@include('includes.bar')

<!--page specific plugin styles-->

<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<!--ace styles-->

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
                    User Role			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Assign User Privileges
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <!--Write your code here start-->
            <form class="form-horizontal" name="attendance" action="{{url('assignPrevilage')}}" method="post" onkeypress="return event.keyCode != 13;">
                <div class="control-group">
                    <label class="control-label">username</label>

                    <div class="controls">
                        <input type="text" name="username" id="username1">
                        <input type="button" name="assign" id="assign" value="Assign Previlages" class="btn btn-primary btn-small">
                    </div>
                </div>
                <br/>
                <hr/>
                <div class="control-group" id="activitylist">

                </div>
            </form>

            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
        <div class="span4" id="error">
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
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">
                $("#activitylist").on("click", "#activityid", function() {
                    var roleid = $(this).val();
                    var username = $("#username").val();
                    if ($(this).is(':checked')) {
                        $.ajax
                                ({
                                    url: "{{url::to('addUserRoleAJAX')}}",
                                    data: {id: roleid, username: username},
                                    beforeSend: function() {
                                        $("body").css("cursor", "progress");
                                        $("body input").css("cursor", "progress");
                                    },
                                    success: function(result)
                                    {
                                    },
                                    complete: function() {
                                        $("body").css("cursor", "default");
                                        $("body input").css("cursor", "default");
                                    }
                                });
                    } else {
                        $.ajax
                                ({
                                    url: "{{url::to('removeUserRoleAJAX')}}",
                                    data: {id: roleid, username: username},
                                    beforeSend: function() {
                                        $("body").css("cursor", "progress");
                                        $("body input").css("cursor", "progress");
                                    },
                                    success: function(result)
                                    {
                                    },
                                    complete: function() {
                                        $("body").css("cursor", "default");
                                        $("body input").css("cursor", "default");
                                    }
                                });
                    }
                });
                $("#activitylist").on("click", "#actall", function() {
                    var username = $("#username").val();
                    var allactid = [];
                    $("input[name='activityid[]']").each(function() {
                        allactid.push($(this).val());
                    });
                    if ($(this).is(":checked")) {
                        $.ajax
                                ({
                                    url: "{{url::to('addUserRoleAllAJAX')}}",
                                    type: "POST",
                                    data: {id: allactid, username: username},
                                    beforeSend: function() {
                                        $("body").css("cursor", "progress");
                                        $("body input").css("cursor", "progress");
                                    },
                                    success: function(result)
                                    {
                                    },
                                    complete: function() {
                                        $("body").css("cursor", "default");
                                        $("body input").css("cursor", "default");
                                    }
                                });
                    } else {
                        $.ajax
                                ({
                                    url: "{{url::to('removeUserRoleAllAJAX')}}",
                                    type: "POST",
                                    data: {id: allactid, username: username},
                                    beforeSend: function() {
                                        $("body").css("cursor", "progress");
                                        $("body input").css("cursor", "progress");
                                    },
                                    success: function(result)
                                    {
                                    },
                                    complete: function() {
                                        $("body").css("cursor", "default");
                                        $("body input").css("cursor", "default");
                                    }
                                });
                    }
                });
                $("#assign").click(function() {
                    var username = document.getElementById('username1').value;
                    $.ajax
                            ({
                                url: "{{url::to('getActivityList')}}",
                                data: {username: username},
                                dataType: 'json',
                                success: function(result)
                                {
                                    if (result.error === '') {
                                        document.getElementById('activitylist').innerHTML = result.html;
                                        table();
                                    } else {
                                        document.getElementById('error').innerHTML = result.html;
                                    }
                                }
                            });
                });
                $("#username1").keypress(function(e) {
                    var username = document.getElementById('username1').value;
                    if (e.keyCode === 13 || e.which === 13) {
                        $.ajax
                                ({
                                    url: "{{url::to('getActivityList')}}",
                                    data: {username: username},
                                    dataType: 'json',
                                    success: function(result)
                                    {
                                        if (result.error === '') {
                                            document.getElementById('activitylist').innerHTML = result.html;
                                            table();
                                        } else {
                                            document.getElementById('error').innerHTML = result.html;
                                        }
                                    }
                                });
                    }
                });
                function table() {
                    var oTable1 = $('#sample-table-2').dataTable({
                        "bPaginate": false,
                        "aoColumns": [
                            null, null
                        ]});
                    $('table th input:checkbox').on('click', function() {
                        var that = this;
                        $(this).closest('table').find('tr > td:first-child input:checkbox')
                                .each(function() {
                                    this.checked = that.checked;
                                    $(this).closest('tr').toggleClass('selected');
                                });
                    });

                }
</script>