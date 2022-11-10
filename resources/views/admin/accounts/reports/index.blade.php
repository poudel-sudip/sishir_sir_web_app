@extends('admin.layouts.app')
@section('admin-title')
    Account Reports Index
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Account Reports</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card report-container">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card mb-3 mb-sm-0">
                                    <div class="card-body py-3 px-4">
                                        <i class="mdi mdi-book-open-page-variant report-icon"></i>
                                        <div class=" flot-bar-wrapper">
                                            <h3 class="m-0 survey-value">Income Report</h3>
                                            <a href="/admin/accounts/reports/incomes" class="text-success m-0">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card mb-3 mb-sm-0">
                                    <div class="card-body py-3 px-4">
                                        <i class="mdi mdi-book-open-page-variant report-icon"></i>
                                        <div class=" flot-bar-wrapper">
                                            <h3 class="m-0 survey-value">Expense Report</h3>
                                            <a href="/admin/accounts/reports/expenses" class="text-success m-0">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card mb-3 mb-sm-0">
                                    <div class="card-body py-3 px-4">
                                        <i class="mdi mdi-book-open-page-variant report-icon"></i>
                                        <div class=" flot-bar-wrapper">
                                            <h3 class="m-0 survey-value">Gross Report</h3>
                                            <a href="/admin/accounts/reports/gross" class="text-success m-0">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
          <div class="card collections-container">
            <div class="card-body">
              <h4>Accounts Collections</h4>
              <div class="row">
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Cash</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($collection->cash->income - $collection->cash->expense) }}</span> </h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Connect IPS</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($collection->connectips->income - $collection->connectips->expense) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">E-Sewa Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($collection->esewa->income - $collection->esewa->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">IME Pay</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($collection->imepay->income - $collection->imepay->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Khalti</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($collection->khalti->income - $collection->khalti->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Mega Bank</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{ number_format($collection->megabank->income - $collection->megabank->expense) }}</span></h2>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                  <div class="card mb-3 mb-sm-0">
                    <div class="card-body py-3 px-4">
                      <p class="m-0 survey-head text-dark">Global Bank</p>
                      <h2 class="text-center">Rs. <span class="text-primary">{{number_format($collection->globalbank->income - $collection->globalbank->expense)}}</span></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
