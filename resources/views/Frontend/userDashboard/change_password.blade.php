<div class="tab-pane fade" id="account-ChangePassword" role="tabpanel" aria-labelledby="account-ChangePassword-tab">
    <div class="card">
        <div class="card-header">
            <h5>Change Password</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.update.password') }}" enctype="multipart/form-data">
                @csrf
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-md-10">
                        <label>Old password <span class="required">*</span></label>
                        <input required="" class="form-control @error('old_password') is-invalid @enderror"
                            name="old_password" type="password" placeholder="Enter your old password" />
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-10">
                        <label>New password <span class="required">*</span></label>
                        <input required="" class="form-control @error('new_password') is-invalid @enderror"
                            name="new_password" type="password" placeholder="Enter your new password" />
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-10">
                        <label>Confirm password <span class="required">*</span></label>
                        <input required="" class="form-control @error('new_password_confirm') is-invalid @enderror"
                            name="new_password_confirm" type="password" placeholder="Enter your confirm password" />
                        @error('new_password_confirm')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" value="Submit">Save
                            Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
