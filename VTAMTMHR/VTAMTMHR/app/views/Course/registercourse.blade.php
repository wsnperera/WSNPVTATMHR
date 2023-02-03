

@include('includes.bar')




<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->



            <div class="center">


                <div class="row-fluid">




                    <div class="span8">


                        Hello {{$user->firstName}} {{$user->lastName}} Select a Course to Register

                        <br/><br/>

                        <select id="courseDropdown">

                            @foreach ($courses as $c)

                            <option value={{$c->courseID}}>{{$c->course}}</option>

                            @endforeach



                        </select>

                        <br/><br/>

                        <input type="button" id="registerbtn" value="Register"/>



                    </div>

                    <div class="span1">







                    </div>
                </div>

            </div>















            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

</div><!--/.main-content-->
</div><!--/.main-container-->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

<!--basic scripts-->

<!--[if !IE]>-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<!--<![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if ("ontouchend" in document)
        document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<!--ace scripts-->

<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>

<!--inline scripts related to this page-->
</body>
</html>


<script>


                    $("#registerbtn").click(function()
                    {

                        var cid = $("#courseDropdown").val();


                        $.ajax
                                ({
                                    type: "GET",
                                    url: "http://localhost:9999/laravel/public/regCourse",
                                    data: {courseID: cid},
                                    dataType: "json",
                                    success: function(data)
                                    {


                                        alert(data.message);


                                    }

                                }
                                );



                    });






</script>