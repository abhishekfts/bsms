$(document).ready(function () {
    setTimeout(function () {
        $(".success").fadeOut("slow");
    }, 2000); // <-- time in milliseconds
    $("#example1").DataTable({
        responsive: false,
        lengthChange: false,
        autoWidth: true,
        searching: false,
        ordering: false,
    });
    $("#example1").on("click", "tbody tr", function () {
        window.location = $(this).closest("tr").attr("redirect");
    });

    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    $(".notify").click(function (e) {
        e.preventDefault();

        var $id = $(this).attr("data-id");

        // alert($username);

        $.ajax({
            type: "GET",
            url: userView + "/" + $id,
            dataType: "json",
            success: function (response) {
                if (response.status == "1") {
                    Toast.fire({
                        icon: "success",
                        title: response.message,
                    });

                    //$(".statusVendor span").text("Approved");
                    $(".notify").hide();
                    $(".sapImport").text("Approved");
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.message,
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle error case if needed
            },
        });
    });

    //vendorId=
    $.ajax({
        type: "GET",
        url: vendorView + "/" + $("#vendor_id").val(),
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: "json",
        async: false,
        success: function (response) {
            if (response.status == "1") {
                console.log(response["message"]["name"]);
                $("#primaryDetailsName").text(response.message[0]["name"]);
                $("#primaryDetailsMobileNo").text(
                    response.message[0]["mobile"]
                );
                $("#primaryDetailsEmailId").text(response.message[0]["email"]);
                $("#primaryDetailsVendorCode").text(
                    response.message[0]["sap_vendor_code"]
                );
                $("#primaryDetailsStatus").text(response.message[0]["status"]);
                $("#contactPersonName").text(
                    response.message[0]["contact_person"]
                );
                $("#contactPersonEmail").text(
                    response.message[0]["contact_email"]
                );
                $("#contactPersonMobile").text(
                    response.message[0]["contact_mobile"]
                );
                $("#contactPersonDepart").text(
                    response.message[0]["contact_department"]
                );
                $("#contactPersonDesig").text(
                    response.message[0]["contact_designation"]
                );

                $("#primaryDetailsAddress").text(
                    response.message[0]["address"]
                );
                $("#primaryDetailsAddress2").text(
                    response.message[0]["address_2"]
                );
                $("#primaryDetailsCity").text(response.message[0]["city"]);
                $("#primaryDetailsState").text(response.message[0]["state_id"]);
                $("#primaryDetailsCountry").text(
                    response.message[0]["country_id"]
                );
                $("#primaryDetailsPincode").text(
                    response.message[0]["pincode"]
                );

                $("#otherDetailsCompanyCode").text(
                    response.message[0]["company_code_id"]
                );
                $("#otherDetailsPurchaseOrga").text(
                    response.message[0]["purchasing_organization_id"]
                );

                $("#otherDetailsAccountGroup").text(
                    response.message[0]["account_group_id"]
                );

                $("#otherDetailsSchema").text(
                    response.message[0]["schema_group_id"]
                );

                $("#otherDetailsReconcili").text(
                    response.message[0]["reconciliation_account_id"]
                );

                $("#otherDetailsPaymentTemrs").text(
                    response.message[0]["payment_term_id"]
                );

                $.each(
                    response.message[0].registered_office,
                    function (index, office) {
                        console.log(office.address);
                        $("#permanentAddress").text(office.address);
                        $("#permanentAddress1").text(office.address_2);
                        $("#permanentAddressCity").text(office.city);
                        $("#permanentAddressState").text(office.state);
                        $("#permanentAddressCountry").text(office.country);
                        $("#permanentAddressPincode").text(office.pincode);
                    }
                );

                $.each(
                    response.message[0].branch_office,
                    function (index, val) {
                        var newRow =
                            `<div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped">
                                <tbody><tr>
                                    <td>Address</td>
                                    <th>` +
                            val.address +
                            `</th>
                                </tr>
                                <tr>
                                    <td>Address 1</td>
                                    <th>` +
                            val.address_2 +
                            `</th>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <th>` +
                            val.city +
                            `</th>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <th>` +
                            val.state +
                            `</th>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <th>` +
                            val.country +
                            `</th>
                                </tr>
                                <tr>
                                    <td>Pincode</td>
                                    <th>` +
                            val.state +
                            `</th>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                 </div>`;

                        $("#branchOffice").append(newRow);

                        $("#smallScaleYear").text(val.registration_year);
                        $("#smallScaleRegist").text(val.registration_no);
                        $("#smallScaleFile")
                            .attr("href", baseurl+val.registration_certificate)
                            .text(
                                val.registration_certificate.split("/")[
                                    val.registration_certificate.split("/")
                                        .length - 1
                                ]
                            );
                    }
                );

                $.each(response.message[0].facility, function (index, val) {
                    $("#laboratoryFile").attr("href", baseurl+val.lab_facility_file);

                    $("#isiRegistration").attr("href", baseurl+val.lab_facility_file);
                    $("#testFacility").attr("href", baseurl+val.lab_facility_file);
                    $("#facilitiesForSales").attr(
                        "href",
baseurl+                        val.lab_facility_file
                    );
                    $("#qualityControl").attr("href", baseurl+val.lab_facility_file);
                });

                $.each(response.message[0].turnover, function (index, val) {
                    $("#turnover1").text(val.first_year_turnover);
                    $("#turnover2").text(val.second_year_turnover);
                    $("#turnover3").text(val.third_year_turnover);
                });

                $.each(response.message[0].income_tax, function (index, val) {
                    $("#incomeTexCertificate").text(val.certificate_no);
                    $("#incomeTexCertificateDate").text(val.certificate_date);
                    $("#incomeTexCertificateDocu").attr(
                        "href",
baseurl+                        val.certificate_file
                    );
                });

                $.each(response.message[0].factory, function (index, val) {



                    var factoryView =`<div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Factory Code : <span id="factoryCode">`+val.factory_code+`</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <table class="table table-hover table-striped" id="commOfProduction">
                                       
                                    </table>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td>Address</td>
                                                    <th><span id="commAddress">`+val.address+`</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>Address 1</td>
                                                     <th><span id="commAddress2">`+val.address_2+`</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>City</td>
                                                     <th><span id="commCity">`+val.city+`</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>State</td>
                                                     <th><span id="commState">`+val.state+`</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                     <th><span id="commCountry">`+val.country+`</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>Pincode</td>
                                                     <th><span id="commPincode">`+val.pincode+`</span>
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a class="btn btn-app btn-block" target="_blank" href="`+val.installed_capacity_file+`">
                                                        <b>Installed Capcity</b><br>
                                                        `+val.installed_capacity+`
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a class="btn btn-app btn-block" target="_blank" href="`+val.power_available_file+`">
                                                        <b>Power Available</b><br>
                                                        `+val.power_available+`
                                                      </a>
                                                </div>
                                                <div class="col-6">
                                                    <a class="btn btn-app btn-block" target="_blank" href="`+val.raw_material_file+`">
                                                        <b>Raw Material Avi. and Source</b><br>
                                                        `+val.raw_material+`
                                                      </a>
                                                </div>
                                                <div class="col-6">
                                                    <a class="btn btn-app btn-block" target="_blank" href="`+val.machinery_available_file+`">
                                                        <b>Machinery Available</b><br>
                                                        `+val.machinery_available+`
                                                      </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                $("#factoryCodeView").append(factoryView);
                    // $("#factoryCode").text(val.factory_code);



                    // $("#commAddress").text(val.address);
                    // $("#commAddress2").text(val.address_2);
                    // $("#commCity").text(val.city);
                    // $("#commState").text(val.state);
                    // $("#commCountry").text(val.country);
                    // $("#commPincode").text(val.pincode);
                });

                var factoryMaterialList = `<thead>
                <tr>
                    <th>Material</th>
                    <th>Year Of Commencement Of Production</th>
                    <th>` +
                    response.message[0].commencement[0].first_year +
                    `</th>
                    <th>` +
                    response.message[0].commencement[0].second_year +
                    `</th>
                    <th>` +
                    response.message[0].commencement[0].third_year +
                    `</th>
                </tr>
                </thead><tbody>`;

            

                $.each(response.message[0].commencement, function (index, val) {
                    factoryMaterialList +=
                        `<tr>
                        <th>` +
                        val.commencement_material +
                        `</th>
                        <td>` +
                        val.commencement_year +
                        `</td>
                        <td>` +
                        val.first_year_qty +
                        `</td>
                        <th>` +
                        val.second_year_qty +
                        `</th>
                        <th>` +
                        val.commencement_material +
                        `</th>
                    </tr>`;

                });


                $("#commOfProduction").append(factoryMaterialList+`</tbody>`);

                $.each(response.message[0].partner_address, function (index, val) {
                    partenerView = `<div class="col-4">
                        <div class="card">
                            <div class="card-header">Partner : Jones Thayil</div>
                            <div class="card-body p-0">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td>Address</td>
                                        <th>`+val.address+`</th>
                                    </tr>
                                    <tr>
                                        <td>Address 1</td>
                                        <th>`+val.address_2+`</th>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <th>`+val.city+`</th>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <th>`+val.state+`</th>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <th>`+val.country+`</th>
                                    </tr>
                                    <tr>
                                        <td>Pincode</td>
                                        <th>`+val.pincode+`</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>`;

                    $("#contactPartner").append(partenerView);


                });


                $("#bankName").text(
                    response.message[0]["bank_name"]
                );

                $("#bankBranch").text(
                    response.message[0]["bank_branch"]
                );

                $("#bankNumber").text(
                    response.message[0]["bank_number"]
                );

                $("#bankIfsc").text(
                    response.message[0]["bank_ifsc"]
                );

                $("#bankKey").text(
                    response.message[0]["bank_key"]
                );

                $("#bankCountry").text(
                    response.message[0]["bank_country"]
                );

                $("#bankCity").text(
                    response.message[0]["bank_city"]
                );

                $("#bankCurrency").text(
                    response.message[0]["order_currency"]
                );

                $("#bankSwift").text(
                    response.message[0]["bank_swift"]
                );

                $("#bankTan").text(
                    response.message[0]["tan_no"]
                );

                $("#bankCin").text(
                    response.message[0]["cin_no"]
                );

                $("#gstNo").text(
                    response.message[0]["gst_no"]
                );

                $("#panNo").text(
                    response.message[0]["pan_no"]
                );
                
                $("#gstNoFile").attr("href", baseurl+response.message[0]["gst_file"]);
                $("#panNoFile").attr("href", baseurl+response.message[0]["pan_file"]);
                $("#cancelledCheque").attr("href", baseurl+response.message[0]["bank_file"]);

               

                $("#sixSigma").text(
                    response.message[0].other_details[0].six_sigma
                );
                $("#isoRegi").text(
                    response.message[0].other_details[0].iso
                );
                $("#sixSigmaFile").attr("href", baseurl+response.message[0].other_details[0].six_sigma_file);
                $("#isoRegiFile").attr("href", baseurl+response.message[0].other_details[0].iso_file);
                $("#hakaRegiFile").attr("href", baseurl+response.message[0].other_details[0].halal_file);
                $("#isoDecleration").attr("href", baseurl+response.message[0].other_details[0].declaration_file);

                $("#suppliersName").text(
                    response.message[0].other_details[0].suppliers_name
                );


                $.each(response.message[0].questionnaire, function (index, val) {
                   // var vendorId = $('#vendor_id').val();
                     
                          otherDeatails = `<div class="col-12 mb-4">
                            <h5 class="text-info">`+val.question+`</h5>
                            <p><i>`+val.answer+`</i></p>
                            </div>`;
                     
                    

                        $('#questionnaireAll').append(otherDeatails);

                });


        $.each(response.message[0].reputed_customer, function (index, val) {
                       var reputedCustomer = `<div class="col-4">
                                        <div class="card">
                                            <div class="card-header">
                                                Customer `+index+`
                                            </div>
                                            <div class="card-body p-0">
                                            <table class="table table-hover table-striped table-bordered">
                                                    <tr>
                                                        <td>Customer Name</td>
                                                        <th>`+val.customer_name+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <th>`+val.address+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Pincode</td>
                                                        <th>`+val.pincode+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>City</td>
                                                        <th>`+val.city+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Country</td>
                                                        <th>`+val.country+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <th>`+val.state+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Telephone</td>
                                                        <th>`+val.telephone+`</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Fax No.</td>
                                                        <th>`+val.fax_no+`</th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>`; 

                                    $('#reputedCustomer').append(reputedCustomer);
                                
                             });

            } else {
            }
        },
    });
    // $('.row').attr('style','width:110vw;')
});
