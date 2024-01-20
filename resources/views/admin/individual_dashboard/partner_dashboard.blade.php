<div class="unauthoraisation">
    <div class="card"  style="background-color: #CEECEE; border-radius: 15px;">
        <div class="card-body">
            <div class="row p-5"  style="border: 1px solid grey; height: 190px; width: 100%; border-radius: 25px;">
                <div class="col-md-2">
                    <img src="{{asset('assets/images/logos/images.png')}}" alt="">
                </div>
                <div class="col-md-6 ml-5 notReject">
                    <h3 class="text-danger">Your request is pending for</h3>
                    <ul class="posAcountDashboard" style="list-style-type:none;">

                    </ul>
                </div>
                <div class="col-md-6 ml-5 isReject">
                    <h3 class="text-danger">Your request is rejected, Please</h3>
                    <ol>
                        <li>Check your profile and update correctly</li>
                        <li>Check your Document and upload correctly</li>
                    </ol>
                </div>

            </div>

            <h5 class="mt-5">Click here to complete your profile information <a href="{{route('user.profile')}}" class="btn btn-info">Go profile</a></h5>
        </div>
    </div>
</div>
<div class="authorized">
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-primary img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font activeUsers">23,536</h2>
                            <p class="text-white mb-0">Active Users </p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-users text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-secondary img-card box-secondary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font suspendUsers">45,789</h2>
                            <p class="text-white mb-0">Suspended Users</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-user-times text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card  bg-success img-card box-success-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font monthlyRev">89,786</h2>
                            <p class="text-white mb-0">This month Revenue</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-dollar text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-info img-card box-info-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font totalRev">43,336</h2>
                            <p class="text-white mb-0">Total Revenue</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-dollar text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- ROW-1 CLOSED -->

</div>
