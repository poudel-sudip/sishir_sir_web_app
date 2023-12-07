@extends('front.layouts.app')

@section('page_title', 'BMI Calculator')
@section('og-title', 'BMI Calculator')
@section('og-url', url('/bmi-calculator'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>BMI Calculator</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">BMI Calculator</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-white">
            <div class="text-justify">
                <div class="yz-widget" 
                    data-calculator-type="bmi" 
                    data-language="en" 
                    data-unit-system="metric" 
                    data-background-color="#EEEEEE" 
                    data-text-color="#212121" 
                    data-primary-color="#03A9F4" 
                    data-alternate-background-color="#FFFFFF" 
                    data-alternate-text-color="#FFFFFF" 
                    data-secondary-color="#03A9F4">
                    <span class="yz-copyright">Powered by <a href="https://www.yazio.com/en/bmi-calculator">YAZIO</a></span>
                </div>
                
                <script src="https://widget.yazio.com/calculator.js" async></script>

            </div>
        </div>
    </div>

@endsection
