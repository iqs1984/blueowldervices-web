<?= view('layouts.header') ?>

<div class="col-md-10 col-sm-9">
    <div class="vendor-box sett-txt">
        <h3>Settings</h3>

        <div class="row">

            <div class="col-12 p-0 m-0 align-items-center">
                @if (Session::has('success'))
                <div class="alert alert-success" style="width: 100%;">{{Session::get('success')}}</div>
                @endif
                @if (Session::has('error'))
                <div class="alert alert-danger" style="width: 100%;">{{Session::get('error')}}</div>
                @endif
            </div>

            <div class="col-md-4 col-sm-5">
                <h4>Notification Settings</h4>
                <p>Alow to Notify vendor Payments , etc <input type="checkbox" name="" value=""></p>
                <a data-toggle="modal" data-target="#myModal" href="#">Change Password <i
                        class="fa fa-chevron-right"></i></a>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4>Change Password</h4>
                            </div>
                            <div class="modal-body">
                                <form action="<?= route('change_password') ?>" method="post">
                                    @csrf()
                                <input class="form-control box" type="password" name="old_password" placeholder="Old Password" required>
                                <input class="form-control box" type="password" id="newpass" name="new_password" placeholder="New Password" required>
                                <input class="form-control box" type="password" id="confirmpass" onchange="checkpass();" name="confirm_password" placeholder="Confirm Password" required>
                                    <p id="checkpassword"></p>
                                <button id="passbutton" class="login-button">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- modal end here -->

            </div><!-- col end here -->

            <div class="col-md-8 col-sm-7">
                <h4>About Company</h4>
                <p>numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut
                    enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi
                    ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea
                    voluptate velit</p>
                <a data-toggle="modal" data-target="#myModals" href="#">Edit Info <i class="fa fa-chevron-right"></i></a>

                <div class="modal fade" id="myModals" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4>About Company</h4>
                            </div>
                            <div class="modal-body">
                                <form action="<?= route('change_password') ?>" method="post">
                                    @csrf()
                                    <textarea id="about" rows="6" class="form-control box" type="text" name="about" placeholder="About Company" required></textarea>
                                    <button class="login-button">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- modal end here -->


            </div><!-- col end here -->
        </div><!-- row end here -->
    </div><!-- vendor-box end here -->
</div><!-- col end here -->
<script>
    function checkpass(){
        var newpass = $("#newpass").val();
        var confirmpass = $("#confirmpass").val();
        if (newpass == confirmpass) {
            var msg = '<span class="passwordmatch">Password Match</span>';
            var res = '0';
        } else {
            var msg = '<span class="passwordnotmatch">Confirm Password does not Match</span>';
            var res = '1';
        }
        $("#checkpassword").html(msg);
        if (res == 1) {
            $("#passbutton").attr("disabled", true);
        } else {
            $("#passbutton").attr("disabled", false);
        }
    }
</script>
<?= view('layouts.footer') ?>
