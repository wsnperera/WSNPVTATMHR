$(function () {
    var ReportData = null;
    var filterData = [];
    var allColumn = [];
    var allGroupingColumn = [];
    var allOrderingColumn = [];
    var allFilteringColumn = [];
    var selectedColumn = [];
    var selectedGroupingColumn = [];
    var selectedGroupingColumnNames = [];
    var selectedOrderingColumn = [];
    var selectedFilteringColumn = [];

//wizard box
    $('#fuelux-wizard').ace_wizard().on('change', function (e, info) {
        if (info.step === 1 && info.direction === "next") {
            if (!$('#validation-form').valid())
                return false;
        }
        if (info.step === 2 && info.direction === "next") {
            setSelectedColumnList();
            if (selectedColumn.length === 0) {
                bootbox.alert("You Shoud Select at least One Column");
                return false;
            }
            getGroupingColumnList();
        }
        if (info.step === 3 && info.direction === "next") {
            setGroupingColumnList();
            getOrderingColumnList();
        }
        if (info.step === 4 && info.direction === "next") {
            setOrderingColumnList();
            getFilteringColumnList();
            clearFilterForm();
            $("#clearfilterbutton").css("display", "none");
            $("#filterresultdiv").html("");
        }
    }).on('finished', function (e) {
        bootbox.dialog("<h1 class=\"center\">WARNING</h1><br/><h4>This is your filtering criteria</h4><br/>\n\
                            " + ($("#filterresultdiv").html()).slice(0, -23) + "</span></strong><br/>", [{
                "label": "Proceed",
                "class": "btn btn-small btn-warning",
                "callback": function () {
                    setOrderingColumnList();
                    var userSelectedColumn = selectedColumn;
                    var userSelectedGroupingColumn = selectedGroupingColumn;
                    var userSelectedGroupingColumnNames = selectedGroupingColumnNames;
                    var userSelectedOrderingColumn = selectedOrderingColumn;
                    var userSelectedFilteringColumn = selectedFilteringColumn;
                    var reportId = $("#ReportName").val();
                    $.ajax({
                        url: "generateReport",
                        data: {selectedColumns: userSelectedColumn, selectedGroupingColumns: userSelectedGroupingColumn, selectedGroupingColumnNames: userSelectedGroupingColumnNames, selectedOrderingColumns: userSelectedOrderingColumn, selectedFilteringColumn: userSelectedFilteringColumn, reportId: reportId},
                        beforeSend: function () {
                            $('body').css('cursor', 'wait');
                        },
                        success: function (result) {
                            var win = window.open();
                            win.document.write(result);
                            location.reload();
                        },
                        complete: function () {
                            $('body').css('cursor', '');
                        }
                    });
                }
            }, {
                "label": "cancel",
                "class": "btn btn-small btn-danger",
                "callback": function () {
                }
            }]);
        return false;
    }).on('stepclick', function (e) {
        return false; //prevent clicking on steps
    });

//step 1 start
//step 1 form validation
    $('#validation-form').validate({
        errorElement: 'span',
        errorClass: 'help-inline',
        focusInvalid: false,
        rules: {
            ReportType: {
                required: true
            },
            ReportName: {
                required: true
            }
        },
        messages: {
            ReportType: {
                required: "Please specify a Report Type."
            }, ReportName: {
                required: "Please specify a Report Name."
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-error', $('.login-form')).show();
        },
        highlight: function (e) {
            $(e).closest('.control-group').removeClass('info').addClass('error');
        },
        success: function (e) {
            $(e).closest('.control-group').removeClass('error').addClass('info');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if (element.is(':checkbox') || element.is(':radio')) {
                var controls = element.closest('.controls');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if (element.is('.chzn-select')) {
                error.insertAfter(element.siblings('[class*="chzn-container"]:eq(0)'));
            }
            else
                error.insertAfter(element);
        }
    });

//step1 get report names
    $("#ReportType").change(function () {
        var ReportType = $("#ReportType").val();
        $.ajax({
            url: "getReportNames",
            data: {ReportType: ReportType},
            dataType: "json",
            beforeSend: function () {
                $('body').css('cursor', 'wait');
            },
            success: function (result) {
                $("#ReportName.chzn-select").html($("<option>").val("").text(""));
                $.each(result, function (key, value) {
                    var option = $("<option>").val(value.id).text(value.ReportName);
                    $("#ReportName.chzn-select").append(option);
                });
                $("#ReportName.chzn-select").trigger("liszt:updated");
            },
            complete: function () {
                $('body').css('cursor', '');
            }
        });
    });

//step1 get report data
    $("#reportnamediv").on("change", "#ReportName", function () {
        var id = $("#ReportName").val();
        $.ajax({
            url: "getReportData",
            data: {id: id},
            dataType: "json",
            beforeSend: function () {
                $('body').css('cursor', 'wait');
            },
            success: function (result) {
                ReportData = result;
                $('#validation-form').valid()
                $("#definition").text(result.ReportDescription);
                getColumnList();
                $(".wizard-actions").css("visibility", "");
            },
            complete: function () {
                $('body').css('cursor', '');
            }

        });
    });
//step 1 end

//step 2 start
//step 2 set selecting column list
    function getColumnList() {
        var id = $("#ReportName").val();
        if (id !== "") {
            allColumn = [];
            var SelectingList = $.parseJSON(ReportData.SelectList);
            $.each(SelectingList, function (key, value) {
                allColumn.push(value);
            });
            var html = "";
            $.each(allColumn, function (key, value) {
                html += "<tr id=\"" + value + "\">\n\
                            <td>" + value + "</td>\n\
                    </tr>";
            });
            $("#listTableBody").html(html);
            $("#selectedListTableBody").html("");
        }
    }

//step 2 set selected column to selected list
    $("#listTable").on("click", "tbody tr", function () {
        var checkedValue = $(this).find("td:first").text();
        $("#list #" + checkedValue).remove();
        var html = "<tr id=\"tr" + checkedValue + "\">\n\
                            <td>" + checkedValue + " <input type=\"hidden\" class=\"selectedValue\" name=\"selectedValue[]\" value=\"" + checkedValue + "\" />\n\
                             <button type=\"button\" class=\"close\" id=\"button" + checkedValue + "\" style=\"float:right\">\n\
                            <i class=\"icon-remove\"></i>\n\
                                </button>\n\                         </td>\n\
                    </tr>";
        $("#selectedlist table tbody").append(html);
    });

//step 2 remove removed column from selected list and set in column list.
    $("#selectedListTableBody").on("click", "[id^=button]", function () {
        var id = this.id;
        var buttonVal = id.split("button");
        var checkedValue = buttonVal[1];
        $("#selectedListTableBody #tr" + checkedValue).remove();
        var html = "<tr id=\"" + checkedValue + "\">\n\
                            <td>" + checkedValue + "</td>\n\         </tr>";
        $("#list table tbody").append(html);
    });

//step 2 get user selected columns
    function setSelectedColumnList() {
        selectedColumn = [];
        $("#step3SelectedColumn").html("");
        $.each($(".selectedValue").serializeArray(), function (key, value) {
            selectedColumn.push(value.value);
            $("#step3SelectedColumn").append("<span class=\"btn btn-success btn-minier\" style=\"margin:2px  \">" + value.value + "</span>");
        });
    }
//step 2 end

//step 3 start
//step 3 set grouping column list
    function getGroupingColumnList() {
        $("#groupingListTableBody").html("");
        $("#selectedGroupingListTableBody").html("");
        allGroupingColumn = [];
        var GroupinList = $.parseJSON(ReportData.GroupingList);
        if (GroupinList != null) {
            $.each(GroupinList, function (key, value) {
                var groupColumns = value.split(".");
                if (groupColumns.length !== 0) {
                    $.each(groupColumns, function (key1, value1) {
                        if (key1 != 0) {
                            allGroupingColumn.push(groupColumns[0] + "-" + value1);
                        }
                    });
                    allGroupingColumn.push(groupColumns[0]);
                } else {
                    allGroupingColumn.push(groupColumns[0]);
                }
            });
            var html = "";
            $.each(allGroupingColumn, function (key, value) {
                html += "<tr id=\"" + value + "\">\n\
								<td>" + value + "</td>\n\
						</tr>";
            });
        }
        if (allGroupingColumn.length !== 0) {
            $("#step3ViewError").css("display", "none");
            $("#groupingListTableBody").html(html);
            $("#selectedGroupingListTableBody").html("");
            $("#step3View").css("display", "");
        } else {
            $("#step3View").css("display", "none");
            $("#step3ViewError").html("<strong><span style=\"text-align:center;color:red\">No Column to Select</span></strong>");
            $("#step3ViewError").css("display", "");
        }
    }

//step 3 set selected grouping column to selected list and get name for grouping column
    $("#groupingListTable").on("click", "tbody tr", function () {
        var checkedValue = $(this).find("td:first").text();
        if ("1" in checkedValue.split("-")) {
            bootbox.dialog("<form class=\"form-horizontal\">\r\n\
                            <div class=\"control-group\">\r\n\
                                <label class=\"control-label\">Group Column Name<\/label>\r\n\
                                <div class=\"controls\">\r\n\
                                    <input type=\"text\" name=\"groupname\" id=\"groupname\"\/>\r\n\
                                <\/div>\r\n\
                            <\/div>\r\n\
                        <\/form>",
                    [{
                            "label": "OK",
                            "class": "btn btn-small btn-success",
                            "callback": function () {
                                if ($.trim($("#groupname").val()) !== "") {
                                    $("#groupingList #" + checkedValue).remove();
                                    var html = "<tr id=\"tr" + checkedValue + "\">\n\             \n\
                                        <td>" + checkedValue + " <input type=\"hidden\" class=\"selectedGroupingValue\" name=\"selectedGroupingValue[]\" value=\"" + checkedValue + "\" />\n\
                                             <button type=\"button\" class=\"close\" id=\"button" + checkedValue + "\" style=\"float:right\">\n\
                                                <i class=\"icon-remove\"></i>\n\     \n\
                                             </button>\n\
                                        </td>\n\
                                    </tr>";
                                    $("#selectedGroupingList table tbody").append(html);
                                    $("#step3SelectedColumn").append("<span class=\"btn btn-danger btn-minier\" style=\"margin:2px \" id=\"span" + checkedValue + "\"> <input type=\"hidden\" class=\"groupNameValue\" name=\"groupNameValue[]\" value=\"" + checkedValue + "*" + $("#groupname").val() + "\" />" + $("#groupname").val() + "</span>");
                                } else {
                                    alert("Please Enter Name For Column");
                                    return false;
                                }
                            }
                        }, {
                            "label": "Cancel",
                            "class": "btn btn-small btn-danger",
                            "callback": function () {
                            }
                        }]);
        } else {
            $("#groupingList #" + checkedValue).remove();
            var html = "<tr id=\"tr" + checkedValue + "\">\n\             \n\
                                        <td>" + checkedValue + " <input type=\"hidden\" class=\"selectedGroupingValue\" name=\"selectedGroupingValue[]\" value=\"" + checkedValue + "\" />\n\
                                             <button type=\"button\" class=\"close\" id=\"button" + checkedValue + "\" style=\"float:right\">\n\
                                                <i class=\"icon-remove\"></i>\n\     \n\
                                             </button>\n\
                                        </td>\n\
                                    </tr>";
            $("#selectedGroupingList table tbody").append(html);
        }
    });

//step 3 remove removed grouping column from selected list and set in grouping column list.
    $("#selectedGroupingListTableBody").on("click", "[id^=button]", function () {
        var id = this.id;
        var buttonVal = id.split("button");
        var checkedValue = buttonVal[1];
        $("#selectedGroupingListTableBody #tr" + checkedValue).remove();
        $("#span" + checkedValue).remove();
        var html = "<tr id=\"" + checkedValue + "\">\n\
                            <td>" + checkedValue + "</td>\n\         </tr>";
        $("#groupingList table tbody").append(html);
    });

//step 3 get user selected grouping columns
    function setGroupingColumnList() {
        selectedGroupingColumn = [];
        selectedGroupingColumnNames = [];
        $.each($(".selectedGroupingValue").serializeArray(), function (key, value) {
            selectedGroupingColumn.push(value.value);
        });
        $.each($(".groupNameValue").serializeArray(), function (key, value) {
            selectedGroupingColumnNames.push(value.value);
        });
    }
//step 3 end

//step 4 start
//step 4 set ordering column list
    function getOrderingColumnList() {
        $("#orderingListTableBody").html("");
        $("#selectedOrderingListTableBody").html("");
        allOrderingColumn = [];
        var OrderingList = $.parseJSON(ReportData.OrderingList);
        if (OrderingList !== null) {
            $.each(selectedColumn, function (key, value) {
                if (jQuery.inArray(value, OrderingList) !== -1) {
                    allOrderingColumn.push(value);
                }
            });
            var html = "";
            $.each(allOrderingColumn, function (key, value) {
                html += "<tr id=\"" + value + "\">\n\
						<td>" + value + "</td>\n\
						</tr>";
            });
        }
        if (allOrderingColumn.length !== 0) {
            $("#step4ViewError").css("display", "none");
            $("#orderingListTableBody").html(html);
            $("#selectedOrderingListTableBody").html("");
            $("#step4View").css("display", "");
        } else {
            $("#step4View").css("display", "none");
            $("#step4ViewError").html("<strong><span style=\"text-align:center;color:red\">No Column to Select</span></strong>");
            $("#step4ViewError").css("display", "");
        }
    }

//step 4 set selected ordering column to selected list
    $("#orderingListTable").on("click", "tbody tr", function () {
        var checkedValue = $(this).find("td:first").text();
        $("#orderingList #" + checkedValue).remove();
        var html = "<tr id=\"tr" + checkedValue + "\">\n\
                            <td>" + checkedValue + " <input type=\"hidden\" class=\"selectedOrderingValue\" name=\"selectedOrderingValue[]\" value=\"" + checkedValue + "\" />\n\     <button type=\"button\" class=\"close\" id=\"button" + checkedValue + "\" style=\"float:right\">\n\
                                    <i class=\"icon-remove\"></i>\n\
                                    </button>\n\
                            </td>\n\
                    </tr>";
        $("#selectedOrderingList table tbody").append(html);
    });

//step 4 remove removed ordering column from selected list and set in ordering column list.
    $("#selectedOrderingListTableBody").on("click", "[id^=button]", function () {
        var id = this.id;
        var buttonVal = id.split("button");
        var checkedValue = buttonVal[1];
        $("#selectedOrderingListTableBody #tr" + checkedValue).remove();
        var html = "<tr id=\"" + checkedValue + "\">\n\
                            <td>" + checkedValue + "</td>\n\
                    </tr>";
        $("#orderingList table tbody").append(html);
    });

//step 4 get user selected ordering columns
    function setOrderingColumnList() {
        selectedOrderingColumn = [];
        $.each($(".selectedOrderingValue").serializeArray(), function (key, value) {
            selectedOrderingColumn.push(value.value);
        });
    }
//step 4 ends

//step 5 starts
    function getFilteringColumnList() {
        $("#filterresultdiv").html("<tr><td id=\"filterCriteria1\"></td></tr>");
        allFilteringColumn = [];
        var FilteringList = $.parseJSON(ReportData.FilteringList);
        $.each(FilteringList, function (key, value) {
            allFilteringColumn.push(value);
        });
        $("#filteringColumn").html($("<option></option>").attr("value", "").text(""));
        $.each(allFilteringColumn, function (key, value) {
            $("#filteringColumn").append($("<option></option>").attr("value", value).text(value));
        });
    }

//step 5 change columnlist get criteria
    /*
     $("#filterColumnListDiv").on("change", "#filteringColumn", function () {
     var selectedFilter = $("#filteringColumn").val();
     $("#filteringMode").html($("<option></option>").attr("value", "").text(""));
     if ($.inArray(selectedFilter + ".BETWEEN", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "BETWEEN").text("BETWEEN"));
     }
     if ($.inArray(selectedFilter + ".NOT BETWEEN", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "NOT BETWEEN").text("NOT BETWEEN"));
     }
     if ($.inArray(selectedFilter + ".EQUAL", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "=").text("EQUAL"));
     }
     if ($.inArray(selectedFilter + ".NOT EQUAL", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "!=").text("NOT EQUAL"));
     }
     if ($.inArray(selectedFilter + ".GREATER THAN", filterData) === -1 && $.inArray(selectedFilter + ".GREATER THAN OR EQUAL", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "<").text("GREATER THAN"));
     }
     if ($.inArray(selectedFilter + ".LESS THAN", filterData) === -1 && $.inArray(selectedFilter + ".LESS THAN OR EQUAL", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", ">").text("LESS THAN"));
     }
     if ($.inArray(selectedFilter + ".GREATER THAN OR EQUAL", filterData) === -1 && $.inArray(selectedFilter + ".GREATER THAN", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", "<=").text("GREATER THAN OR EQUAL"));
     }
     if ($.inArray(selectedFilter + ".LESS THAN OR EQUAL", filterData) === -1 && $.inArray(selectedFilter + ".LESS THAN", filterData) === -1) {
     $("#filteringMode").append($("<option></option>").attr("value", ">=").text("LESS THAN OR EQUAL"));
     }
     $("#filterformelement2").css("display", "");
     $("#otherFilterFormElement").css("display", "none");
     $("#filterFormButton").css("display", "none");
     });
     */

    $("#filterColumnListDiv").on("change", "#filteringColumn", function () {
        var selectedColumnForFilter = $("#filteringColumn").val();
        $.ajax({
            url: "getSelectedColumnType",
            data: {column: selectedColumnForFilter, table: ReportData.ReportView},
            dataType: "json",
            beforeSend: function () {
                $('body').css('cursor', 'wait');
            },
            success: function (result) {
                $("#filteringMode").html($("<option></option>").attr("value", "").text(""));
                if ($.inArray(selectedColumnForFilter + ".BETWEEN", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", "BETWEEN").text("BETWEEN"));
                }
                if ($.inArray(selectedColumnForFilter + ".NOT BETWEEN", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", "NOT BETWEEN").text("NOT BETWEEN"));
                }
                if ($.inArray(selectedColumnForFilter + ".EQUAL", filterData) === -1) {
                    $("#filteringMode").append($("<option></option>").attr("value", "=").text("EQUAL"));
                }
                if ($.inArray(selectedColumnForFilter + ".NOT EQUAL", filterData) === -1) {
                    $("#filteringMode").append($("<option></option>").attr("value", "!=").text("NOT EQUAL"));
                }
                if ($.inArray(selectedColumnForFilter + ".GREATER THAN", filterData) === -1 && $.inArray(selectedColumnForFilter + ".GREATER THAN OR EQUAL", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", "<").text("GREATER THAN"));
                }
                if ($.inArray(selectedColumnForFilter + ".LESS THAN", filterData) === -1 && $.inArray(selectedColumnForFilter + ".LESS THAN OR EQUAL", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", ">").text("LESS THAN"));
                }
                if ($.inArray(selectedColumnForFilter + ".GREATER THAN OR EQUAL", filterData) === -1 && $.inArray(selectedColumnForFilter + ".GREATER THAN", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", "<=").text("GREATER THAN OR EQUAL"));
                }
                if ($.inArray(selectedColumnForFilter + ".LESS THAN OR EQUAL", filterData) === -1 && $.inArray(selectedColumnForFilter + ".LESS THAN", filterData) === -1 && result[0].DATA_TYPE !== "varchar") {
                    $("#filteringMode").append($("<option></option>").attr("value", ">=").text("LESS THAN OR EQUAL"));
                }
                $("#columnType").val(result[0].DATA_TYPE);
                $("#filterformelement2").css("display", "");
                $("#otherFilterFormElement").css("display", "none");
                $("#filterFormButton").css("display", "none");
            },
            complete: function () {
                $('body').css('cursor', '');
            }
        });
    });
//step 5 change criteria get input form elements
    $("#filterformelement2").on("change", "#filteringMode", function () {
        var selectedColumnForFilter = $("#filteringColumn").val();
        var selectedCriteriaForFilter = $("#filteringMode").val();
        var selectedColumnType = $("#columnType").val();
        if (selectedColumnType === "date" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            $("#betweendate").css("display", "");
            $("#betweenint").css("display", "none");
            $("#singledate").css("display", "none");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "none");
        }
        if (selectedColumnType === "timestamp" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            $("#betweendate").css("display", "");
            $("#betweenint").css("display", "none");
            $("#singledate").css("display", "none");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "none");
        }
        if (selectedColumnType === "int" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            $("#betweendate").css("display", "none");
            $("#betweenint").css("display", "");
            $("#singledate").css("display", "none");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "none");
        }
        if (selectedColumnType === "date" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            $("#betweendate").css("display", "none");
            $("#betweenint").css("display", "none");
            $("#betweenvarchar").css("display", "none");
            $("#singledate").css("display", "");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "none");
        }
        if (selectedColumnType === "timestamp" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            $("#betweendate").css("display", "none");
            $("#betweenint").css("display", "none");
            $("#singledate").css("display", "");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "none");
        }
        if (selectedColumnType === "varchar" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            $("#betweendate").css("display", "none");
            $("#betweenint").css("display", "none");
            $("#singledate").css("display", "none");
            $("#singleint").css("display", "none");
            $("#singlevarchar").css("display", "");
        }
        if (selectedColumnType === "int" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            $("#betweendate").css("display", "none");
            $("#betweenint").css("display", "none");
            $("#singledate").css("display", "none");
            $("#singleint").css("display", "");
            $("#singlevarchar").css("display", "none");
        }
        $("#otherFilterFormElement").css("display", "");
        $("#filterFormButton").css("display", "");
        getColumnValues(selectedColumnForFilter, selectedColumnType);
    });

//step 5 validate filter form
    $("#AND, #OR").click(function () {
        var btnVal = $("#" + this.id).val();
        var selectedColumnForFilter = $("#filteringColumn").val();
        var selectedCriteriaForFilter = $("#filteringMode").val();
        var columnType = $("#columnType").val();
        if (columnType === "date" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            if ($("#fromdate").val() !== "" && $("#todate").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#fromdate").val(), input2: $("#todate").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "timestamp" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            if ($("#fromdate").val() !== "" && $("#todate").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#fromdate").val(), input2: $("#todate").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "varchar" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            if ($("#text1").val() !== "" && $("#text2").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#text1").val(), input2: $("#text2").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "int" && (selectedCriteriaForFilter === "BETWEEN" || selectedCriteriaForFilter === "NOT BETWEEN")) {
            if ($("#number1").val() !== "" && $("#number2").val() !== "" && $.isNumeric($("#number1").val()) && $.isNumeric($("#number2").val())) {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#number1").val(), input2: $("#number2").val()});
            } else {
                alert("You must fill all the data and inputs should be numeric value before continue.");
            }
        }
        if (columnType === "date" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            if ($("#dateinput").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#dateinput").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "timestamp" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            if ($("#dateinput").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#dateinput").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "varchar" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            if ($("#textinput").val() !== "") {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#textinput").val()});
            } else {
                alert("You must fill all the data before continue.");
            }
        }
        if (columnType === "int" && (selectedCriteriaForFilter === "=" || selectedCriteriaForFilter === "!=" || selectedCriteriaForFilter === "<" || selectedCriteriaForFilter === "<=" || selectedCriteriaForFilter === ">" || selectedCriteriaForFilter === ">=")) {
            if ($("#numberinput").val() !== "" && $.isNumeric($("#numberinput").val())) {
                setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, {input1: $("#numberinput").val()});
            } else {
                alert("You must fill all the data and inputs should be numeric value before continue.");
            }
        }
        clearFilterForm();
    });

//step 5 clearfilter criteria
    $("#clearfilterbutton").click(function () {
        clearFilterForm();
        $("#filterresultdiv").html("");
        $("#clearfilterbutton").css("display", "none");
        selectedFilteringColumn = [];
        filterData = [];
    });
//step 5 ends

//page specific javascripts other
    function setFilterValue(selectedColumnForFilter, selectedCriteriaForFilter, btnVal, columnType, value) {
        if (value.input2 !== undefined) {
            var operatorName = getOperatorName(selectedCriteriaForFilter);
            var displayString = "<strong>" + selectedColumnForFilter + " <span style=\"color:green\">" + operatorName + "</span> " + value.input1 + " <span style=\"color:green\">AND</span> " + value.input2 + " <span style=\"color:red\"> " + btnVal + "</span></strong>";
            var saveString = selectedColumnForFilter + "$$" + selectedCriteriaForFilter + "$$" + columnType + "$$" + value.input1 + "$$" + value.input2 + "$$" + btnVal;
            filterData.push(selectedColumnForFilter + "." + operatorName);
            selectedFilteringColumn.push(saveString);
            $("#filterresultdiv").append(displayString + "<br/>");
            $("#clearfilterbutton").css("display", "");
        } else {
            var operatorName = getOperatorName(selectedCriteriaForFilter);
            displayString = "<strong>" + selectedColumnForFilter + " <span style=\"color:green\">" + operatorName + "</span> " + value.input1 + " <span style=\"color:red\"> " + btnVal + "</span></strong>";
            saveString = selectedColumnForFilter + "$$" + selectedCriteriaForFilter + "$$" + columnType + "$$" + value.input1 + "$$" + btnVal;
            filterData.push(selectedColumnForFilter + "." + operatorName);
            selectedFilteringColumn.push(saveString);
            $("#filterresultdiv").append(displayString + "<br/>");
            $("#clearfilterbutton").css("display", "");
        }
    }
    function getOperatorName(input) {
        var Oname = "";
        if (input === "=") {
            Oname = "EQUAL";
        } else if (input === "!=") {
            Oname = "NOT EQUAL";
        } else if (input === "<") {
            Oname = "GREATER THAN";
        } else if (input === "<=") {
            Oname = "GREATER THAN OR EQUAL";
        } else if (input === ">") {
            Oname = "LESS THAN";
        } else if (input === ">=") {
            Oname = "LESS THAN OR EQUAL";
        } else if (input === "BETWEEN") {
            Oname = "BETWEEN";
        } else if (input === "NOT BETWEEN") {
            Oname = "NOT BETWEEN";
        }
        return Oname;
    }
    function getColumnValues(column, columnType) {
        var reportView = ReportData.ReportView;
        var filterdData = JSON.stringify(selectedFilteringColumn);
        if (columnType === "varchar") {
            $.ajax({
                url: "getColumnDistinctValues",
                data: {reportView: reportView, column: column, filterdData: filterdData},
                dataType: "json",
                beforeSend: function () {
                    $('body').css('cursor', 'wait');
                },
                success: function (result) {
                    var html = "<select name=\"textinput\" id=\"textinput\" class=\"chzn-select\"><option value=\"\"></option>";
                    $.each(result, function (key, value1) {
                        $.each(value1, function (key, value) {
                            html += "<option value=\"" + (value) + "\">" + (value) + "</option>";
                        });
                    });
                    html += "</select>";
                    $("#textinputdiv").html(html);
                    $(".chzn-select").chosen();
                },
                complete: function () {
                    $('body').css('cursor', '');
                }
            });
        }
    }
    function clearFilterForm() {
        $('#filterformdiv input[type="text"]').val('');
        $('#filterformdiv input[type="number"]').val('');
        $('#filterformdiv select').val('');
        $("#otherFilterFormElement").css("display", "none");
        $("#filterFormButton").css("display", "none");
        $("#filterformelement2").css("display", "none");
    }
    $(".chzn-select").chosen();
    $('.date-picker').datepicker({autoclose: true});
});
