@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployee')}}"> << Back to HR Employee </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->

            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    HR - Employee			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('CreateHREmployee')}}" method="POST" enctype="multipart/form-data"/>
            <h5 style="text-align: left"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h5>
            <input type="hidden" name="InstituteId" value="{{$in_id}}"/>
               

            <div class="page-header position-relative"></div>
            <b>Personal Details</b>
            <div class="control-group" >
                <label class="control-label" for="Photograph">Photograph</label>
                <div class="controls">
                    <img src="" height="500" width="200" alt="Photograph preview..." id="preview">
                    <span><input type="file" name="Photograph" id="Photograph"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="EPFNo">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPFNo" id="EPFNo"  value="{{Input::old('EPFNo')}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Initials">Initials</label>
                <div class="controls">
                    <input type="text" name="Initials" id="Initials" required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Name">Name</label>
                <div class="controls">
                    <input type="text" name="Name" id="Name" required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="LastName">Last Name</label>
                <div class="controls">
                    <input type="text" name="LastName" id="LastName" required /><b style="color: red">*</b>
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="NIC">NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="load_nic_val" required/><b style="color: red">*</b>
                    <span id="ajax_img2"></span>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Sex">Gender</label>
                <div class="controls">
                    <input type="text"name="Sex" id="Sex" readonly/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DOB">DOB</label>
                <div class="controls">
                    <input type="date" name="DOB" id="DOB" readonly/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="CivilStatus">Civil Status</label>
                <div class="controls">
                    <select  id="CivilStatus" name='CivilStatus' id="CivilStatus" onchange="change()" required>
                        <option value="">--Select--</option>
                        <option value="Married">Married</option>
                        <option value="Unmarried">Unmarried</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widow/Widower">Widow/Widower</option>
                        <option >Other</option>
                    </select>
                    <b style="color: red">*</b>
                    <span id="con_cs"></span>
                </div>

            </div>
            <div class="control-group">
                <label class="control-label" for="Race" >Race</label>
                <div class="controls">
                    <select id="Race" name="Race" onchange="race()" required>
                        <option value="">--Select--</option>
                        <option value="Sinhalese">Sinhalese</option>
                        <option value="Tamil">Tamil</option>
                        <option value="Muslim">Muslim</option>
                        <option value="Burger">Burger</option>
                        <option >Other</option>
                    </select>
                    <b style="color: red">*</b>
                    <span id="container"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Religion">Religion</label>
                <div class="controls">
                    <select  id="Religion" name="Religion" onchange="change3()"required>
                        <option value="">--Select--</option>
                        <option value="Buddhism">Buddhism</option>
                        <option value="Islam">Islam</option>
                        <option value="Hinduism">Hinduism</option>
                        <option value="Christianity">Christianity</option>
                        <option >Other</option>
                    </select>
                    <b style="color: red">*</b>
                    <span id="con_cs3"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="BloodGroup">Blood Group</label>
                <div class="controls">
                    <select name="BloodGroup" id="BloodGroup">
                        <option value="">--Select--</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="PassportNo">Passport No</label>
                <div class="controls">
                    <input type="text" name="PassportNo" id="PassportNo" onblur="passport()"/>
                    <span name="ExpiryDate" id="ExpiryDate"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="PAddress">Permanent Address</label>
                <div class="controls">
                    <textarea  name="PAddress" id="PAddress" required></textarea><b style="color: red">*</b>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="CAddress">Current Address</label>
                <div class="controls">
                    <textarea  name="CAddress" id="CAddress"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="District Name">District Name</label>
                <div class="controls">
                    <select name="DistrictName" id="DistrictName" required>
                        <option value="">--Select District--</option>
                        @foreach($holidaytypes as $i)
                        <option value="{{$i->DistrictCode}}">{{$i->DistrictName}}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                    <span id="ajax_img3"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DSDivision">DS Division</label>
                <div class="controls">
                    <select name="DSDivision"  id="DSDivision"> 
                        <option value="">--Select DS Division--</option>
						 @foreach($Electorate as $h)
                        <option value="{{$h->ElectorateCode}}">{{$h->ElectorateName}}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>
            
            <div class="page-header position-relative"></div>
            <b>Contact Details</b>
           <fieldset >
               <b><u>Personal</u></b>
               <div class="control-group">
                <label class="control-label" for="Contact">Land Line No </label>
                <div class="controls">
                    <input type="text" name="Contact" id="Contact"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Mobile">Mobile</label>
                <div class="controls">
                    <input type="text" name="Mobile" id="Mobile"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Email">Email</label>
                <div class="controls">
                    <input type="text" name="Email" id="Email" />
                </div>
            </div>
            </fieldset>
            
            <fieldset>
                <b><u>Official</u></b>
            <div class="control-group">
                <label class="control-label" for="Contact">Land Line</label>
                <div class="controls">
                    <input type="text" name="OContact" id="OContact"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Mobile">  Mobile</label>
                <div class="controls">
                    <input type="text" name="OMobile" id="OMobile"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Email">Email</label>
                <div class="controls">
                    <input type="text" name="OEmail" id="OEmail" />
                </div>
            </div>
            </fieldset>
            
            
            <div class="page-header position-relative"></div>
            <b>If any Emergency, Contact Person...</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Name</label>
                <div class="controls">
                    <input type="text" name="EmergencyName"  placeholder="Enter the Person Name"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Emergency"> Contact No</label>
                <div class="controls">
                    <input type="tel" name="Emergency"  placeholder="Enter the Contact No"/>
                </div>
            </div>
            <div class="page-header position-relative"></div>
            
            <div class="control-group">
                <label class="control-label" for="Trade">Trade</label>
                <div class="controls" id="TradeDiv">
                    <select name="Trade" id="Trade">
                        <option value="">--Select Trade--</option>
                       
                        @foreach ($trade as $t)
                        <option value="{{$t->TradeId}}">{{$t->TradeName}}</option>
                        @endforeach
                    </select><b style="color: red">* Only For Academic Staff</b>
                    <!--<input type="button"  value="New Trade" name="NewTrade" id="NewTrade" onclick="addTrade()">-->
                </div>
            </div>

            <div class="control-group" hidden="" id="addTrade" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">
                <h6 align="center" style="font-family: arialblack;font-size: 12pt" ><b>Create Trade</b></h6>
                <div class="control-group">
                    <label class="control-label">Trade Code</label>
                    <div class="controls">
                        <input id="TradeCode" placeholder="" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Trade Name</label>
                    <div class="controls">
                        <input id="TradeName" placeholder="" type="text"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Active</label>
                    <div class="controls">
                        <select id="Active"  >
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create New Trade" onclick="fillTrade()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>
			
			<div class="control-group">
                <label class="control-label" for="form-field-4">Course Name</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" >
                        <option value="">--Select CourseName--</option>
                        @foreach ($Courses as $qo)
                        <option  value="{{$qo->id}}">{{$qo->CourseName}}</option>
                        @endforeach
                    </select> <b style="color: red">* Only For Academic Staff</b>
                </div>
            </div>
			 
            
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>
            </form>

        </div><!--/.span-->

        <!--/span 4 for error handling -->

        <div class="span4">

            <!-- Error Handling --!>
                    @if($errors->has())
                          @foreach($errors->all() as $msg)
            <!-- Error Message --!>
              <div class="alert alert-error">
                 <button type="button" class="close" data-dismiss="alert">
                         <i class="icon-remove"></i>
                 </button>
                 <strong> <i class="icon-remove"></i>{{$msg}}</strong>
              </div>
            <!-- Error Message --!>
      @endforeach
    @endif
            <!-- Error Handling --!>
    </div>
            <!--/span 4-->
            <!--PAGE CONTENT ENDS-->

        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
    @include('includes.footer')  
	<script src="assets/js/chosen.jquery.min.js"></script>
    <script>

        @if (isset($done))

                $.gritter.add({title: "", text: "Employee Added Successfully", class_name: "gritter-info gritter-center"});

        @endif

                $("#DistrictName").change(function() {
            var epf = document.getElementById('DistrictName').value;

            $.ajax({
                url: "{{url::to('employeeajax')}}",
                data: {DistrictName: epf},
                beforeSend: function() {
                    document.getElementById('ajax_img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                },
                success: function(result)
                {
                    //                alert(result);
                    document.getElementById('DSDivision').innerHTML = result;
                },
                complete: function() {
                    document.getElementById('ajax_img3').innerHTML = "";
                }
            });
        });

        function race() {
            var racee = document.getElementById('Race').value;
            var divv = document.getElementById("container");
            if (racee === 'Other') {
                toAppend = "<input type='text'name='Race'placeholder='Please Specify...!' >";
                divv.innerHTML = toAppend;
                return;
            }
            else
            {
                divv.innerHTML = "<input type='hidden'  value='" + racee + "'/>";
            }
        }

        function change() {
            var civil = document.getElementById("CivilStatus").value;
            var divv = document.getElementById("con_cs");
            if (civil === 'Other') {
                toAppend = "<input type='text' name='CivilStatus' placeholder='Please Specify...!' >";
                divv.innerHTML = toAppend;
                return;
            }
            else
            {
                divv.innerHTML = "<input type='hidden'  value='" + civil + "'/>";
            }
        }
        function change3() {
            var religion = document.getElementById("Religion").value;
            var divv = document.getElementById("con_cs3");
            if (religion === 'Other') {
                toAppend = "<input type='text' name='Religion' placeholder='Please Specify...!' >";
                divv.innerHTML = toAppend;
                return;
            }
            else
            {
                divv.innerHTML = "<input type='hidden'  value='" + religion + "'/>";
            }

        }

        function passport()  {
            var p = document.getElementById("PassportNo").value;
            var pa = document.getElementById("ExpiryDate");
            if (p !== ' ') {
                b = " Expiry Date <input type='date' name='ExpiryDate' id='ExpiryDate' placeholder='Please Specify...!' >";
                pa.innerHTML = b;
                return;
            }
            else
            {
                pa.innerHTML = '';
            }

        }

        $("#Photograph").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }



            //    $.ajax({
            //                url: "{{url::to('abc')}}",
            //                //data: {DistrictName: epf},
            //                success: function(result)
            //                {
            //                   alert(result);
            //                }
            //            });

        });

        $("#load_nic_val").blur(function() {
            document.getElementById('DOB').value = "";
            document.getElementById('Sex').value = "";
            var s_nic = document.getElementById('load_nic_val').value;
            document.getElementById('load_nic_val').style.border = "";
            if (s_nic === " ") {
                document.getElementById('load_nic_val').style.border = "2px solid red";
            } else if (s_nic === "") {
                document.getElementById('load_nic_val').style.border = "";
            } else if (s_nic.length < 10) {
                if (isNaN(s_nic)) {
                    document.getElementById('load_nic_val').style.border = "2px solid red";
                }
            } else if (s_nic.length === 10) {
                var nic = s_nic;
                var myarray = new Array();
                myarray = nic.split("");
                if (myarray[9] === "V" || myarray[9] === "X") {

                    var y = myarray[0] + myarray[1];
                    var d = myarray[2] + myarray[3] + myarray[4];
                    dob_calculate(y, d);
                } else {
                    document.getElementById('load_nic_val').style.border = "2px solid red";
                }
            }else if (s_nic.length < 12) 
        {
            if (isNaN(s_nic)) 
            {
                document.getElementById('load_nic_val').style.border = "2px solid red";
            }
        } 

        else if (s_nic.length === 12) 
        {
            var nic = s_nic;
            var myarray = new Array();
            myarray = nic.split("");
            
            $("#updateBtn").show(); 
            var y = myarray[0] + myarray[1]+ myarray[2] + myarray[3];
            var d = myarray[4] + myarray[5] + myarray[6];

            //alert(y);

            dob_calculate_new(y, d);
        }    

        else if (s_nic.length > 12) 
        {
            document.getElementById('load_nic_val').style.border = "2px solid red";
        }

        });
		
		function dob_calculate_new(y, d) {
        var y = parseInt(y);
        var d = parseInt(d);
        var sex = '';
        var my_year = y;
        var my_month = '';
        var my_date = '';
        if (d < 500) {
            sex = 'Male';
            if (d <= 31) {
                my_month = '01';
                my_date = d;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 60) {
                my_month = '02';
                my_date = d - 31;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 91) {
                my_month = '03';
                my_date = d - 60;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 121) {
                my_month = '04';
                my_date = d - 91;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 152) {
                my_month = '05';
                my_date = d - 121;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 182) {
                my_month = '06';
                my_date = d - 152;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 213) {
                my_month = '07';
                my_date = d - 182;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 244) {
                my_month = '08';
                my_date = d - 213;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 274) {
                my_month = '09';
                my_date = d - 244;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 305) {
                my_month = '10';
                my_date = d - 274;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 335) {
                my_month = '11';
                my_date = d - 305;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else {
                my_month = '12';
                my_date = d - 335;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            }

            var dob = my_year + '-' + my_month + '-' + my_date;
            document.getElementById('DOB').value = dob;
            document.getElementById('Sex').value = sex;

        } else {
            sex = 'Female';
            if (d <= 531) {
                my_month = '01';
                my_date = d - 500;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 560) {
                my_month = '02';
                my_date = d - 531;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 591) {
                my_month = '03';
                my_date = d - 560;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 621) {
                my_month = '04';
                my_date = d - 591;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 652) {
                my_month = '05';
                my_date = d - 621;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 682) {
                my_month = '06';
                my_date = d - 652;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 713) {
                my_month = '07';
                my_date = d - 682;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 744) {
                my_month = '08';
                my_date = d - 713;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 774) {
                my_month = '09';
                my_date = d - 744;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 805) {
                my_month = '10';
                my_date = d - 774;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 835) {
                my_month = '11';
                my_date = d - 805;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else {
                my_month = '12';
                my_date = d - 835;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            }

            var dob = my_year + '-' + my_month + '-' + my_date;
            document.getElementById('DOB').value = dob;
            document.getElementById('Sex').value = sex;
        }
    }
    
        function dob_calculate(y, d) {
            var y = parseInt(y);
            var d = parseInt(d);
            var sex = '';
            var my_year = 1900 + y;
            var my_month = '';
            var my_date = '';
            if (d < 500) {
                sex = 'Male';
                if (d <= 31) {
                    my_month = '01';
                    my_date = d;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 60) {
                    my_month = '02';
                    my_date = d - 31;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 91) {
                    my_month = '03';
                    my_date = d - 60;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 121) {
                    my_month = '04';
                    my_date = d - 91;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 152) {
                    my_month = '05';
                    my_date = d - 121;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 182) {
                    my_month = '06';
                    my_date = d - 152;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 213) {
                    my_month = '07';
                    my_date = d - 182;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 244) {
                    my_month = '08';
                    my_date = d - 213;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 274) {
                    my_month = '09';
                    my_date = d - 244;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 305) {
                    my_month = '10';
                    my_date = d - 274;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 335) {
                    my_month = '11';
                    my_date = d - 305;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 366) {
                    my_month = '12';
                    my_date = d - 335;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else {
                    alert('This is not a valid NIC Number \n\ Enter a Valid NIC Number...!');
                }

                var dob = my_year + '-' + my_month + '-' + my_date;
                document.getElementById('DOB').value = dob;
                document.getElementById('Sex').value = sex;

            } else {
                sex = 'Female';
                if (d <= 531) {
                    my_month = '01';
                    my_date = d - 500;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 560) {
                    my_month = '02';
                    my_date = d - 531;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 591) {
                    my_month = '03';
                    my_date = d - 560;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 621) {
                    my_month = '04';
                    my_date = d - 591;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 652) {
                    my_month = '05';
                    my_date = d - 621;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 682) {
                    my_month = '06';
                    my_date = d - 652;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 713) {
                    my_month = '07';
                    my_date = d - 682;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 744) {
                    my_month = '08';
                    my_date = d - 713;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 774) {
                    my_month = '09';
                    my_date = d - 744;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 805) {
                    my_month = '10';
                    my_date = d - 774;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 835) {
                    my_month = '11';
                    my_date = d - 805;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 866) {
                    my_month = '12';
                    my_date = d - 835;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else {
                    alert('This is not a valid NIC Number \n\ Enter a Valid NIC Number...!');
                }

                var dob = my_year + '-' + my_month + '-' + my_date;
                document.getElementById('DOB').value = dob;
                document.getElementById('Sex').value = sex;
            }
            nic_data_load();
        }

        /* $(document).ready(function() {
            var epf = document.getElementById('DistrictName').value;

            $.ajax({
                url: "{{url::to('employeeajax')}}",
                data: {DistrictName: epf},
                beforeSend: function() {
                    document.getElementById('ajax_img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                },
                success: function(result) {
                    document.getElementById('DSDivision').innerHTML = result;
                },
                complete: function() {
                    document.getElementById('ajax_img3').innerHTML = "";
                }
            });
        }); */

        function fun_TravelMode_Other() {
            var travell = document.getElementById("TravelMode").value;
            var divv = document.getElementById("TravelMode_Other");
            if (travell === 'Other') {
                toAppend = "<input type='text' name='TravelMode' placeholder='Please Specify...!' >";
                divv.innerHTML = toAppend;
                return;
            } else {
                divv.innerHTML = "<input type='hidden'  value='" + travell + "'/>";
            }
        }

        function fun_Items_P_by_C() {
            var itemm = document.getElementById("Items_P_by_C").value;
            var divv = document.getElementById("Items_P_by_C_Other");
            if (itemm === 'Other') {
                toAppend = "<input type='text' name='Items_P_by_C' placeholder='Please Specify...!' >";
                divv.innerHTML = toAppend;
                return;
            } else {
                divv.innerHTML = "<input type='hidden'  value='" + itemm + "'/>";
            }
        }
        
         function addTrade() {
        $.ajax({
            url: "{{url::to('')}}",
            success: function(result) {
                if ($('#addTrade').is(':hidden')) {
                    $('#addTrade').show();
                } else {
                    $('#addTrade').hide();
                }
            }
        });
    }


    function fillTrade() {
        var TradeName = document.getElementById('TradeName').value;
        var TradeCode = document.getElementById('TradeCode').value;
        var Active = document.getElementById('Active').value;
        if (TradeName === '') {
            alert('Enter a Trade Name');
        } else {
            $.ajax
                    ({
                        url: "{{url::to('saveTrade')}}",
                        data: {TradeName: TradeName, TradeCode: TradeCode, Active: Active},
                        dataType: 'json',
                        success: function(result) {
                            if (result.Trade !== 0) {
                                $("#TradeDiv").html(result.html);
                                $('#addTrade').hide();
                                $('#ajaxerror').html(result.done);

                            } else {
                                $('#ajaxerror').html(result.html);
                                window.scrollTo(0, 0);
                            }
                        }
                    });
        }
    }


           function nic_data_load() {
                                    var s_nic = document.getElementById('load_nic_val').value;
                                  // alert(s_nic);
                                    document.getElementById('load_nic_val').style.border = "1px solid #777";
                                    $.ajax({
                                        url: "{{url::to('HRloadNicAjaxDetails')}}",
                                        data: {nic: s_nic},
                                        beforeSend: function() {
                                            document.getElementById('ajax_img2').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        success: function(result) {
                                            var d = result.split('|#|');
                                            var EPFNo = d[0];
                                            var LastName = d[1];
                                            var Initials = d[2];
                                            var Name = d[3];
                                            var DOB = d[4];
                                            var CivilStatus = d[5];
                                            var PAddress = d[6];
                                            var Mobile = d[7];
                                            var Race = d[8];
                                            var Religion = d[9];
                                            var BloodGroup = d[10];
                                            var PassportNo = d[11];
                                            var CAddress = d[12];
                                            var DistrictName = d[13];
                                            var DSDivision = d[14];
                                            var Contact = d[15];
                                            var Email = d[16];
                                            var OContact = d[17];
                                            var OMobile = d[18];
                                            var OEmail = d[19];
                                            var dale = d[20];
                                           //alert(Mobile);
                                            document.getElementById('EPFNo').value = EPFNo;
                                            $('#Initials').val(Initials);
                                            $('#Name').val(Name);
                                            $('#LastName').val(LastName);
                                            $('#DOB').val(DOB);
                                            $('#CivilStatus').val(CivilStatus);
                                            $('#PAddress').val(PAddress);
                                            $('#Mobile').val(Mobile);
                                            $('#Race').val(Race);
                                            $('#Religion').val(Religion);
                                            $('#BloodGroup').val(BloodGroup);
                                            $('#PassportNo').val(PassportNo);
                                            $('#CAddress').val(CAddress);
                                            $('#DistrictName').val(DistrictName);
                                            $('#DSDivision').val(DSDivision);
                                            $('#Contact').val(Contact);
                                            $('#Email').val(Email);
                                            $('#OContact').val(OContact);
                                            $('#OMobile').val(OMobile);
                                            $('#OEmail').val(OEmail);

                                           // document.getElementById('FullName').value = FullName;
                                           //document.getElementById('Address').innerHTML = Address;
                                           // document.getElementById('NameWithInitialsSinhala').value = name_sin_tam;
                                           // document.getElementById('address_sinhala_tamil').value = address_sin_tam;
                                          //  $('#Province option[value="' + province + '"]').attr('selected', 'selected');
                                          //  document.getElementById('District').innerHTML = '<option value=' + district + '>' + district + '</option>';
                                          //  document.getElementById('Electorate').innerHTML = '<option value=' + electro + '>' + electro + '</option>';
                                          //  document.getElementById('Grama_Sewa_Division').value = grama;
                                          //  document.getElementById('Tel').value = tel_h;
                                          //  document.getElementById('Tel_mob').value = tel_m;
                                           // document.getElementById('email').value = email;
                                           // $('#Medium option[value="' + medium + '"]').attr('selected', 'selected');
                                            if (dale === "dale") {
                                                document.getElementById('nic_records').innerHTML = '';
                                            } else {
                                                document.getElementById('nic_records').innerHTML = dale;
                                            }
                                        },
                                        complete: function() {
                                            document.getElementById('ajax_img2').innerHTML = "";
                                        }
                                    });
                                }
    </script>
<script type="text/javascript">
 $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
 </script>