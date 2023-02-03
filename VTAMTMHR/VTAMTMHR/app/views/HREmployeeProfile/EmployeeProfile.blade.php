@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        Employee Profile
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View Profile
                        </small>            
                    </h1>
                </div>
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->

    <div class="span10">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <form class="form-search" action="" method='GET' >
                           
<center>
                            <div class="controls" >
							 <label><b>Search By :- </b></label>
                                <label>
                                    <input type="radio" name="choice" value="nic"/>
                                    <span class="lbl"> NIC Number</span>
                                </label>
								
                                <label>
                                    <input type="radio" name="choice" value="tno"/>
                                    <span class="lbl"> EPF No</span>
                                </label>
                                <label>
                                    <input type="radio"  name="choice" value="name"/>
                                    <span class="lbl">Last Name </span>
                                </label></br></br>
                            </div>
</center>  
                            <center>
                                <input type="text" class="input-medium search-query" name="searchValue" id="searchValue" />
                                    <button type="button" onclick="ajaxViewProfile()" class="btn btn-purple btn-small">
                                        Search Employee
                                        <i class="icon-search icon-on-right bigger-110"></i>
                                    </button>
                            </center>                       
                        </form>
						<br/>
						<form class="form-search" action="ViewHREmployeeProfile" method='GET' >
                            <center>
                                <button type="submit" class="btn btn-primary btn-small">
                                    Refresh All
                                    <i class=" icon-bolt icon-on-right bigger-110"></i>
                                </button>
                            </center>                       
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

    <br><br>
      <center>   
    <span id="loding">
    </span>
	 </center>

    <div id="table" class="row-fluid span20" style="margin: 0px;" overflow="auto">
    </div>

</div><!--/.page-content-->



@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">

$('#sample-table-2').dataTable({
    "sScrollX": "100%",
    "bScrollCollapse": true,
    "bJQueryUI": true,
    "aoColumns": [
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false},
			{"bSortable": false},
			
    ]});

//*************************************************
function ajaxViewProfile()
    {
        var choice = $("input[name = choice]:checked").val();
        var searchVal = $("#searchValue").val();

        //alert(searchVal);

        var html ="";

        if(searchVal != "")
        {
            //$("#getoldNIC").val(searchVal);

                $.ajax
                ({
                    beforeSend: function() 
                    {
                        document.getElementById('loding').innerHTML = "<br><br><img  src=\"{{Url('assets/images/ajax-loader.gif')}}\"/>";

                        $('#table').hide();
                    },

                    type: "GET",
                    url: 'HREmployeeProfileajaxViewData',
                    data:{searchVal:searchVal,choice:choice},

                    success: function(result) 
                    {
                        //console.log(result);
                        
                        //document.getElementById('loding').innerHTML ="";

                        if(result!= 0)
                        {
                            //*********************************** All Select Data Table ******************

                            document.getElementById('loding').innerHTML ="";
                            document.getElementById('table').innerHTML = result;
                            $('#table').show();

                            //****************************************************************************
                        }

                        else
                        {
                            //document.getElementById('loding').innerHTML = "<font style='margin-left: 200px;' >----------<b>No Date Found</b>----------</font>";
                            
                            html +="<div class=\"alert alert-warning\">";
                            html +="<button type=\"button\" class=\"close\" data-dismiss=\"alert\">";
                            html +="<i class=\"icon-remove\"></i>";
                            html +="</button>";

                            html +="<strong>";
                            html +="<i class=\"icon-remove\"></i>";
                            html +="NOTE :-         ";
                            html +="</strong>";

                            html +="No Data Found";

                            html +="<br />";
                            html +="</div>";

                            $("#table").html(html);
                                          
                            $('#table').show();
                            
                        }
                    },
                });
        }

        else
        {
            html +="<div class=\"alert alert-error\">";
            html +="<button type=\"button\" class=\"close\" data-dismiss=\"alert\">";
            html +="<i class=\"icon-remove\"></i>";
            html +="</button>";

            html +="<strong>";
            html +="<i class=\"icon-remove\"></i>";
            html +="ERROR :-";
            html +="</strong>";

            html +="Search Value Cannot Be Null";

            html +="<br />";
            html +="</div>";

            $("#table").html(html);
                          
            $('#table').show();
        }
    }

//*************************************************

//*************************************************
function viewStudentProfile()
{
    document.getElementById("F_studentProfile").submit();
}
//*************************************************

</script>