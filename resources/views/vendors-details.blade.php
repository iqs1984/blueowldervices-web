<?= view('layouts.header') ?>

<div class="col-md-10 col-sm-9">
    <div class="vendor-detail">
        <div class="row">
            <div class="col-md-4 col-sm-8">
                <div class="detail-box">
                    <img class="img-responsive" src="{{ asset('images/detail-img6.png') }}">
                    <img class="img-responsive dd" src="{{ asset('images/detail-img.png') }}">
                    <h3><span>{{@$service->companyname}}</span> {{@$service->services->name}}</h3>
                    <a href="tel:{{@$service->phone}}">Contact Vendor <i class="fa fa-chevron-right"></i></a>
                    <a class="sus-btn" href="#">Suspend Account</a>
                </div><!-- detail-box end here -->
            </div><!-- col end here -->

            <div class="col-md-8 col-sm-12">
                <ul class="nav nav-tabs js-example tab-txt" role="tablist">
                    <li class="active"><a href="#tab4" role="tab" data-toggle="tab">Vendor Information</a></li>
                    <li><a href="#tab5" role="tab" data-toggle="tab">Services</a></li>
                    <li><a href="#tab6" role="tab" data-toggle="tab">Employees</a></li>
                    <li><a href="#tab7" role="tab" data-toggle="tab">Transactions</a></li>
                </ul><!-- ul end here -->

                <div class="tab-content">
                    <div id="tab4" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-10 col-sm-9">
                                @if(@$service->about_service)
								<p>{{@$service->about_service}}</p>
                                @else
                                <div class="col-6 p-2">
                                    About Service empty
                                </div>
                                @endif
                            </div><!-- col end here -->

                            <div class="col-md-2 col-sm-3">
                                <img src="{{ asset('images/detail-img4.png') }}">
                                <img src="{{ asset('images/detail-img5.png') }}">
                            </div><!-- col end here -->
                        </div><!-- row end here -->
                        <h4>Licence No <span>{{@$service->licence_number}}</span></h4>
                        <h5>Gallery</h5>
                        @if(count(@$service->images) == 0)
                        <div class="col-6 p-2">
                            No Image found
                        </div>
                        @endif
                        @foreach(@$service->images as $service_images)
                        <img src="{{$service_images->image_url}}" style="max-width: 100px;">
                        @endforeach
                    </div><!-- tab4 end here -->

                    <div id="tab5" class="tab-pane">
                        @foreach(@$service->services->offers as $offered)
                        <h6>{{@$offered->name}}</h6>
                        @endforeach
                    </div><!-- tab5 end here -->

                    <div id="tab6" class="tab-pane">
                        <ul class="emp-box">
                            @if(count(@$service->employees) == 0)
                            <div class="col-6 p-2">
                                No Employee till yet
                            </div>
                            @endif
                            @foreach(@$service->employees as $employee)
                            <li><img src="{{ asset('images/emp-img.png') }}">
                                <p><span>{{@$employee->employee_name}}</span> {{@$employee->service}}</li>
                            @endforeach

                        </ul><!-- ul end here -->
                    </div><!-- tab6 end here -->

                    <div id="tab7" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="trans-box">
                                    <h5>Monthy Fee <span>$21</span></h5>
                                    <h4>Issue date <span>03/07/2019</span></h4>
                                    <h4>Due date <span>08/07/2019</span></h4>
                                    <span class="un-btn">Unpaid</span>
                                </div><!-- trans-box end here -->
                            </div><!-- col end here -->

                            <div class="col-md-6 col-sm-6">
                                <div class="trans-box">
                                    <h5>Monthy Fee <span>$21</span></h5>
                                    <h4>Issue date <span>03/07/2019</span></h4>
                                    <h4>Due date <span>08/07/2019</span></h4>
                                    <span class="paid-btn">Paid</span>
                                </div><!-- trans-box end here -->
                            </div><!-- col end here -->

                            <div class="col-md-6 col-sm-6">
                                <div class="trans-box">
                                    <h5>Monthy Fee <span>$21</span></h5>
                                    <h4>Issue date <span>03/07/2019</span></h4>
                                    <h4>Due date <span>08/07/2019</span></h4>
                                    <span class="paid-btn">Paid</span>
                                </div><!-- trans-box end here -->
                            </div><!-- col end here -->

                            <div class="col-md-6 col-sm-6">
                                <div class="trans-box">
                                    <h5>Monthy Fee <span>$21</span></h5>
                                    <h4>Issue date <span>03/07/2019</span></h4>
                                    <h4>Due date <span>08/07/2019</span></h4>
                                    <span class="paid-btn">Paid</span>
                                </div><!-- trans-box end here -->
                            </div><!-- col end here -->
                        </div><!-- row end here -->
                    </div><!-- tab7 end here -->
                </div><!-- tab-content end here -->
            </div><!-- col end here -->
        </div><!-- row end here -->
    </div><!-- vendor-detail end here -->
</div><!-- col end here -->
</div><!-- row end here -->
</div><!-- container end here -->
</div><!-- admin-section end here -->

<?= view('layouts.footer') ?>
