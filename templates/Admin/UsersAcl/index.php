<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\UsersAcl> $usersAcl
 */
?>
<?= $this->Html->css('admin-style') ?>
<div class="role-mgmt">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>User Role Managment</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="search-bar mb-2">
                            <input type="search" placeholder="Search all users" class="form-control search-box">
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xl">Set Permissions</button>
                        </div>
                    </div>
                    <div class="user-list-tbl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input class="" type="checkbox" value="" id="all">
                                    </th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="checkbox-1">
                                        </div>
                                    </td>
                                    <td>Snehal</td>
                                    <td>Buyer</td>
                                    <td>Active</td>
                                    <td><a href="users-acl/edit/1">
                                            <i class="fas fa-edit"></i>
                                        </a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="checkbox-1">
                                        </div>
                                    </td>
                                    <td>Abhishek</td>
                                    <td>Buyer</td>
                                    <td>Active</td>
                                    <td><a href="#">
                                            <i class="fas fa-edit"></i>
                                        </a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="checkbox-1">
                                        </div>
                                    </td>
                                    <td>Dipak</td>
                                    <td>Buyer</td>
                                    <td>Active</td>
                                    <td><a href="" data-toggle="tooltip" data-placement="bottom" title="Edit user"><i
                                                class="fas fa-edit"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="modal-xl" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title p-2">Role Management</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-12">
                            <div class="top-head">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="uname" placeholder="Enter name">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="uname" placeholder="Enter role">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="main-tbl-grid">
                               
                                    <table class="table table-bordered mb-0 tbl-head"
                                        style="background-color:#527195;color:#fff">
                                        <tbody>
                                            <tr>
                                                <!--Top level heading row-->
                                                <td style="width:20%"> </td>
                                                <!-- <td style="width:20%"><input type="checkbox" id="" title="Select All">
                                                </td> -->
                                                <td style="width:20%"><input type="checkbox" id=""> View</td>
                                                <td style="width:20%"><input type="checkbox" id=""> Create</td>
                                                <td style="width:20%"><input type="checkbox" id=""> Update</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <span class="tbl-date">
                                        <table class="table table-bordered bg-light mb-0">
                                            <!----------------Module lavel heading------------------------------------->
                                            <tbody>
                                                <tr>
                                                    <td style="width:20%;cursor: pointer;" id="showDiv"> <span class="accordion" ><i
                                                                class="fas fa-plus" ></i> Vendor</span></td>
                                                    
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="view-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="create-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="update-chk"></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </span>
                                    <div class="panel" id="tbl-data-accordon">
                                        <table class="table ">
                                            <tbody>
                                                <tr>
                                                    <td style="width:20%"><span> PO</span></td>
                                                    
                                                     
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="view-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="create-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="update-chk"></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:20%"><span>Transit</span></td>
                                                    
                                                     
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="view-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="create-chk"></td>
                                                    <td style="width:20%"><input type="checkbox"
                                                            class="update-chk"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    
                               
                            </div>
                           
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>

    </div>
    <!-- end modal -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#showDiv").click(function() {
            $("#tbl-data-accordon").toggle();
            $(this).find("i").toggleClass("fas fa-plus fas fa-minus");
        });
        $(".view-chk").click(function() {
            $(".view-chk").not(this).prop('checked', this.checked);
        });
        $("#tbl-data-accordon").hide(); // Hide the "vendor-tab" div initially
    });
</script>