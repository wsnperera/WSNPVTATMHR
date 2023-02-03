@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployee')}}"> << Back to HR Employee </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    HR - Employee		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->

            <!--Write your code here start-->
           <form class="form-horizontal"  enctype="multipart/form-data" method="POST" action="{{url('HRPhotoEdit')}}">
                <h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>

                <input type="hidden" name="id" value="{{$Employee->id}} "/>
                <div class="control-group" >
                    <label class="control-label" for="Photograph">Photograph</label>
                    <div class="controls">
                        <img src="{{$Employee->Photograph}}"  height="800" width="200" alt="Image preview..." id="Preview" > <br> 
                        <span><input type="file" name="Photograph" id="Photograph"></span><br>
                       
						<button type="submit" class="btn btn-small btn-success">Upload</button>
                    </div>
                </div>
            </form>

           
            <form class="form-horizontal" action="{{url('EditHREmployee')}}" method="POST" />
				<input type="hidden" name="id" value="{{$Employee->id}} "/>
				<input type="hidden" name="InstituteId" value="{{$in_id}}"/>
               


           
			
			
            <b>Personal Details</b>
             <div class="control-group">
                <label class="control-label" for="NIC">NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="load_nic_val" value="{{$Employee->NIC}}" required/><b style="color: red">*</b>
                    <span id="ajax_img2"></span>

                </div>
            </div>

           
            <div class="control-group">
                <label class="control-label" for="EPFNo">EPF No</label>
                <div class="controls">
                    <input type="text" name="EPFNo" value="{{$Employee->EPFNo}}"  required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Initials">Initials</label>
                <div class="controls">
                    <input type="text" name="Initials" value="{{$Employee->Initials}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Name">Name</label>
                <div class="controls">
                    <input type="text" name="Name" value="{{$Employee->Name}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="LastName">Last Name</label>
                <div class="controls">
                    <input type="text" name="LastName" value="{{$Employee->LastName}}" required/><b style="color: red">*</b>
                </div>
            </div>

        <div class="control-group">
                <label class="control-label" for="Sex">Gender</label>
                <div class="controls">
                    <input type="text"name="Sex" id="Sex" value="{{$Employee->Sex}}" readonly/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DOB">DOB</label>
                <div class="controls">
                    <input type="date" name="DOB" id="DOB" value="{{$Employee->DOB}}" readonly/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="CivilStatus">Civil Status</label>
                <div class="controls">
                   <select   name='CivilStatus' id="CivilStatus" onchange="change()" required>
				   <option value="">---Choose---</option>
                        <option value="Married" @if($Employee->CivilStatus == "Married") selected  @endif>Married</option>
                        <option value="Unmarried" @if($Employee->CivilStatus == "Unmarried") selected  @endif>Unmarried</option>
                        <option value="Divorced" @if($Employee->CivilStatus == "Divorced") selected  @endif>Divorced</option>
                        <option value="Widow/Widower" @if($Employee->CivilStatus == "Widow/Widower") selected  @endif>Widow/Widower</option>
                        <option value="Other">Other</option>
                        @if($Employee->CivilStatus !== "Unmarried" && $Employee->CivilStatus !== "Married" && $Employee->CivilStatus !== "Divorced" && $Employee->CivilStatus !== "Widow/Widower") 
                        <option selected value="{{$Employee->CivilStatus}}" >{{$Employee->CivilStatus}}</option>
                        @endif
                    </select>
                    <b style="color: red">*</b>
                    <span id="con_cs"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Race">Race</label>
                <div class="controls">
                    <select id="Race" name="Race" onchange="race()" required>
                        <option value="">---Choose---</option>
                        <option value="Sinhalese" @if($Employee->Race == "Sinhalese") selected  @endif>Sinhalese</option>
                        <option value="Tamil" @if($Employee->Race == "Tamil") selected  @endif>Tamil</option>
                        <option value="Muslim" @if($Employee->Race == "Muslim") selected  @endif>Muslim</option>
                        <option value="Burger" @if($Employee->Race == "Burger") selected  @endif>Burger</option>
                        <option value="Other">Other</option>
                        @if($Employee->Race !=="Sinhalese" && $Employee->Race !=="Tamil" && $Employee->Race !== "Muslim" && $Employee->Race !== "Burger") 
                        <option selected value="{{$Employee->Race}}" >{{$Employee->Race}}</option>
                        @endif
                    </select>
                    <b style="color: red">*</b>
                    <span id="container"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Religion">Religion</label>
                <div class="controls">
                   <select  id="Religion" name="Religion" onchange="change3()"required>
                        <option value="">---Choose---</option>
                        <option value="Buddhism" @if($Employee->Religion == "Buddhism") selected  @endif>Buddhism</option>
                        <option value="Islam" @if($Employee->Religion == "Islam") selected  @endif>Islam</option>
                        <option value="Hinduism" @if($Employee->Religion == "Hinduism") selected  @endif>Hinduism</option>
                        <option value="Christianity" @if($Employee->Religion == "Christianity") selected  @endif>Christianity</option>
                        <option value="Other">Other</option>
                        @if ($Employee->Religion !== "Hinduism" && $Employee->Religion !== "Christianity" && $Employee->Religion == "Buddhism" && $Employee->Religion == "Islam")
                        <option selected value="{{$Employee->Religion}}">{{$Employee->Religion}}</option>
                        @endif
                    </select>
                    <b style="color: red">*</b>
                    <span id="con_cs3"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="BloodGroup">Blood Group</label>
                <div class="controls">
                    <select  name="BloodGroup" id="BloodGroup" onchange="change()">
                        <option @if($Employee->BloodGroup == "") selected value=" " @endif></option>
                        <option @if($Employee->BloodGroup == "A+") selected value="{{$Employee->BloodGroup}}" @endif>A+</option>
                        <option @if($Employee->BloodGroup == "B-") selected value="{{$Employee->BloodGroup}}" @endif>B+</option>
                        <option @if($Employee->BloodGroup == "O+") selected value="{{$Employee->BloodGroup}}" @endif>O+</option>
                        <option @if($Employee->BloodGroup == "AB+") selected value="{{$Employee->BloodGroup}}" @endif>AB+</option>
                        <option @if($Employee->BloodGroup == "A-") selected value="{{$Employee->BloodGroup}}" @endif>A-</option>
                        <option @if($Employee->BloodGroup == "B-") selected value="{{$Employee->BloodGroup}}" @endif>B-</option>
                        <option @if($Employee->BloodGroup == "O-") selected value="{{$Employee->BloodGroup}}" @endif>O-</option>
                        <option @if($Employee->BloodGroup == "AB-") selected value="{{$Employee->BloodGroup}}" @endif>AB-</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="PassportNo">Passport No</label>
                <div class="controls">
                    <input type="text" name="PassportNo" value="{{$Employee->PassportNo}}"/>
                    <span>Expiry Date<input type="date" name="ExpiryDate" value="{{$Employee->ExpiryDate}}"/></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="PAddress">Permanent Address</label>
                <div class="controls">
                    <textarea rows="5" name="PAddress" required>{{$Employee->PAddress}}</textarea><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="CAddress">Current Address</label>
                <div class="controls">
                    <textarea rows="5" name="CAddress" value="">{{$Employee->CAddress}}</textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DistrictName">District Name</label>
                <div class="controls">
                    <select name="DistrictName" id="DistrictName" required>
                        @foreach ($holidaytypes as $i)
                        <option @if($i->DistrictCode==$Employee->DistrictName) selected @endif  value="{{$i->DistrictCode}}">{{$i->DistrictName}}</option>
                        @endforeach
                    </select><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DSDivision">DS Division</label>
                <div class="controls" id="dis_load">
                    <select name="DSDivision"  id="DSDivision" required> 
                        <option>--Select--</option>
                        @foreach($Electorate as $e)
                        <option @if($e->ElectorateCode == $Employee->DSDivision) selected @endif value="{{$e->ElectorateCode}}">{{$e->ElectorateName}}</option>
                        @endforeach
                    </select><b style="color: red">*</b>
                </div>

            </div>
            <div class="page-header position-relative"></div>
            <b>Contact Details</b>
            <fieldset>
                <b><u>Personal</u></b>
            <div class="control-group">
                <label class="control-label" for="Contact">Land Line</label>
                <div class="controls">
                    <input type="text" name="Contact" value="{{$Employee->Contact}}"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Mobile"> Mobile</label>
                <div class="controls">
                    <input type="text" name="Mobile" value="{{$Employee->Mobile}}"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Email"> Email</label>
                <div class="controls">
                    <input type="email" name="Email" value="{{$Employee->Email}}"/>
                </div>
            </div>
            </fieldset>
            
            <fieldset>
                <b><u>Official</u></b>
            <div class="control-group">
                <label class="control-label" for="Contact">Land Line</label>
                <div class="controls">
                    <input type="text" name="OContact" value="{{$Employee->OContact}}"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Mobile">Mobile</label>
                <div class="controls">
                    <input type="text" name="OMobile" value="{{$Employee->OMobile}}"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Email"> Email</label>
                <div class="controls">
                    <input type="email" name="OEmail" value="{{$Employee->OEmail}}"/>
                </div>
            </div>

            </fieldset>
            
              <div class="page-header position-relative"></div>
            <b>If any Emergency, Contact Person...</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Name</label>
                <div class="controls">
                    <input type="text" name="EmergencyName"  value="{{$Employee->EmergencyName}}"  />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Emergency"> Contact No</label>
                <div class="controls">
                    <input type="tel" name="Emergency"  value="{{$Employee->Emergency}}"/>
                </div>
            </div>
            
            <div class="page-header position-relative"></div>
            <div class="control-group">
                <label class="control-label" for="Trade">Trade</label>
                <div class="controls">
                    <select name="Trade" id="Trade">
                        <option value="">---Select Trade---</option>
                        @foreach ($trade as $t)
                        <option @if($t->TradeId==$Employee->Trade) selected @endif  value="{{$t->TradeId}}">{{$t->TradeName}}</option>
                        @endforeach
                    </select><b style="color: red">* Only For Academic Staff</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-4">Course Name</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" >
                        <option value="">--Select CourseName--</option>
                        @foreach ($Courses as $qo)
                        <option  @if($qo->id==$Employee->TradeCourseId) selected @endif value="{{$qo->id}}">{{$qo->CourseName}}</option>
                        @endforeach
                    </select> <b style="color: red">* Only For Academic Staff</b>
                </div>
            </div>

            <div class="page-header position-relative"></div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-pink">Update</button>
                </div>
            </div>
            </form>
        </div>
        <!--/span 4 for error handling -->

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
</div>

@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
    $("#DistrictName").change(function() {
        var epf = document.getElementById('DistrictName').value;
        $.ajax({
            url: "{{url::to('employeeajax')}}",
            data: {DistrictName: epf},
            success: function(result)
            {
                document.getElementById('dis_load').innerHTML = result;
            }
        });
    });

    $("#Photograph").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#Preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
/*  $("#Photograph").change(function() {
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

        }); */
    function race() {
        var a = document.getElementById('Race').value;
        var divv = document.getElementById("container");
        if (a === 'Other') {
            toAppend = "<input type='text'name='Race'placeholder='Please Specify...!' >";
            divv.innerHTML = toAppend;
            return;
        } else {
            divv.innerHTML = "<input type='hidden' name='Race' value='" + a + "'/>";
        }
    }

    function change() {
        var civil = document.getElementById("CivilStatus").value;
        var divv = document.getElementById("con_cs");
        if (civil === 'Other') {
            toAppend = "<input type='text' name='CivilStatus' placeholder='Please Specify...!' >";
            divv.innerHTML = toAppend;
            return;
        } else {
            divv.innerHTML = "<input type='hidden' name='CivilStatus' value='" + civil + "'/>";
        }
    }

    function change3() {
        var religion = document.getElementById("Religion").value;
        var divv = document.getElementById("con_cs3");
        if (religion === 'Other') {
            toAppend = "<input type='text' name='Religion' placeholder='Please Specify...!' >";
            divv.innerHTML = toAppend;
            return;
        } else {
            divv.innerHTML = "<input type='hidden' name='Religion' value='" + religion + "'/>";
        }
    }
	
	
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

</script>
