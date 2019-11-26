<?= view('layouts.header') ?>

<div class="col-md-10 col-sm-9">
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <div class="vendor-box">
                <h3>Vendors</h3>
                @foreach($vendors as $vendor)
                <div class="ven-txt">
                    <div class="row">
                        <div class="col-md-4 col-sm-5">
                            <img width="100%" class="img-responsive" src="{{@$vendor->image_url}}">
                        </div>
                        <div class="col-md-6 col-sm-7">
                            <h4>{{@$vendor->companyname}}</h4>
                            <h5>{{@$vendor->services->name}}</h5>
                            @foreach(@$vendor->services->offers as $offered)
                            <h6>{{@$offered->name}}</h6>
                            @endforeach
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <a href="vendors-details/{{@$vendor->id}}">View Details <i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                {{$vendors->links()}}


            </div><!-- vendor-box end here -->
        </div><!-- tab1 end here -->

        <div id="tab2" class="tab-pane">
            <div class="vendor-box">
                <h3>Transaction</h3>
                <div class="inter" style="overflow-x:auto;">
                    <table>
                        <tr>
                            <th>Company Name</th>
                            <th>Due Date</th>
                            <th>Issue Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr><!-- tr end here -->

                        <tr>
                            <td>Fast Service Nevada</td>
                            <td>08/07/2019</td>
                            <td>03/07/2019</td>
                            <td>$21</td>
                            <td><span class="un-btn">Unpaid</span></td>
                            <td><a href="#">View</a></td>
                        </tr><!-- tr end here -->

                        <tr>
                            <td>Fast Service Nevada</td>
                            <td>08/07/2019</td>
                            <td>03/07/2019</td>
                            <td>$21</td>
                            <td><span>Paid</span></td>
                            <td><a href="#">View</a></td>
                        </tr><!-- tr end here -->

                        <tr>
                            <td>Fast Service Nevada</td>
                            <td>08/07/2019</td>
                            <td>03/07/2019</td>
                            <td>$21</td>
                            <td><span>Paid</span></td>
                            <td><a href="#">View</a></td>
                        </tr><!-- tr end here -->

                        <tr>
                            <td>Fast Service Nevada</td>
                            <td>08/07/2019</td>
                            <td>03/07/2019</td>
                            <td>$21</td>
                            <td><span class="un-btn">Unpaid</span></td>
                            <td><a href="#">View</a></td>
                        </tr>

                        <tr>
                            <td colspan="3">Total Paid</td>
                            <td colspan="3">$84</td>
                        </tr><!-- tr end here -->
                    </table><!-- table end here -->
                </div><!-- inter end here -->
            </div><!-- vendor-box end here -->
        </div><!-- tab2 end here -->

        <div id="tab3" class="tab-pane">
            <div class="vendor-box sett-txt">
                <h3>Settings</h3>
                <div class="row">
                 

                    <div class="col-md-8 col-sm-7">
                        <h4>About Company</h4>
                        <p>numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut
                            enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi
                            ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea
                            voluptate velit</p>
                        <a href="#">Edit Info <i class="fa fa-chevron-right"></i></a>
                    </div><!-- col end here -->
                </div><!-- row end here -->
            </div><!-- vendor-box end here -->
        </div><!-- tab3 end here -->
    </div><!-- tab-content end here -->
</div><!-- col end here -->
</div><!-- row end here -->
</div><!-- container end here -->
</div><!-- admin-section end here -->
<?= view('layouts.footer') ?>
