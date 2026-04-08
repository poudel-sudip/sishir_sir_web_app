@extends('front.layouts.app')

@section('page_title', 'Child Nutrition Calculator')
@section('og-title', 'Child Nutrition Calculator')
@section('og-url', url('/child-nutrition-calculator'))
@section('og-image', asset('/images/logo.png'))

@section('content')

    <style>
        form label{
            color: #1374ba;
            font-weight: 600;
        }
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">Child Nutrition Calculator</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Child Nutrition Calculator</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-md-6 align-self-center">
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                        <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                </div>
            </div>
        </div>

        <div class="blogs-details-container bg-white  border border-success rounded">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('/child-nutrition-calculator') }}" method="get" class="d-flex flex-column justify-content-between" style="height: 100%;">
                        <div class="form-group my-1">
                            <label for="agegroup">Age Group of Child:</label>
                            <select class="form-control" id="agegroup" name="agegroup" required>
                                <option value="">Select Age Group</option>
                                <option value="0_23_months">0-23 Months</option>
                                <option value="24_59_months">24-59 Months</option>
                            </select>
                        </div>

                        <div class="form-group my-1">
                            <label for="gender">Gender of Child:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="form-group my-1">
                            <label for="edema">Nutritional Edema of Child:</label>
                            <select class="form-control" id="edema" name="edema" >
                                <option value="">Select Nutritional Edema</option>
                                <option value="p0">No Nutritional Edema</option>
                                <option value="p1">Nutritional edema on feet</option>
                                <option value="p2">Nutritional edema on feet, legs and hands</option>
                                <option value="p3">Nutritional edema involving face and whole body</option>
                            </select>
                        </div>

                        <div class="form-group my-1">
                            <label for="muac">MUAC of Child (mm):</label>
                            <input type="text" class="form-control" id="muac" name="muac" >
                        </div>
                        <div class="form-group my-1">
                            <label for="height">Height/Length of Child (cm):</label>
                            <input type="text" class="form-control" id="height" name="height" >
                        </div>
                        <div class="form-group my-1">
                            <label for="weight">Weight of Child (kg):</label>
                            <input type="text" class="form-control" id="weight" name="weight" >
                        </div>
                        
                        <button type="submit" class="mt-2 btn btn-primary">Calculate Nutrition Status</button>
                    </form>
                </div>
                <div class="col-md-6">
                    @if($zScoreHeightData || $zScoreMuacData)
                        <div class="">
                            <h4 style="color: #1374ba;">Child Nutrition Status Result:</h4>
                            <h5 class="mt-3" style="color: #1374ba;">Input:</h5>
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="mx-2"><strong>Gender:</strong> {{ $zScoreHeightData->input_gender ?? $zScoreMuacData->input_gender ?? ''}}</div>
                                <div class="mx-2"><strong>Age Group:</strong> {{ $zScoreHeightData->input_agegroup ?? $zScoreMuacData->input_agegroup ?? ''}}</div>
                                @if(isset($zScoreMuacData))
                                    <div class="mx-2"><strong>MUAC:</strong> {{ $zScoreMuacData->input_muac }} MM</div>
                                @endif
                                @if(isset($zScoreHeightData))
                                    <div class="mx-2"><strong>Height/Length:</strong> {{ $zScoreHeightData->input_height }} CM</div>
                                    <div class="mx-2"><strong>Weight:</strong> {{ $zScoreHeightData->input_median }} KG</div>
                                @endif
                            </div>

                            @if(isset($zScoreMuacData))
                                <div class="mt-3 alert {{ $zScoreMuacData->output_case == 'severe_abnormal' ? 'alert-red' : ($zScoreMuacData->output_case == 'moderate_abnormal' ? 'alert-yellow' : ($zScoreMuacData->output_case == 'normal' ? 'alert-green' :'')) }}">
                                    <h5 class="" >MUAC Result:</h5>
                                    <div>{!! ($zScoreMuacData->output_remarks) !!}</div>
                                </div>
                            @endif

                            @if(isset($zScoreEdemaData))
                                <div class="mt-3 alert {{ $zScoreEdemaData->output_case == 'abnormal' ? 'alert-red' : ($zScoreEdemaData->output_case == 'normal' ? 'alert-green' : '') }}">
                                    <h5 class="">Edema Result:</h5>
                                    <div>{!! $zScoreEdemaData->output_remarks !!}</div>
                                </div>
                            @endif

                            @if(isset($zScoreHeightData))
                                <div class="mt-3">
                                    <h5 class="" style="color: #1374ba;">Height/Length Standard:</h5>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div class="mx-2"><strong>Gender:</strong> {{ $zScoreHeightData->input_gender }}</div>
                                        <div class="mx-2"><strong>Age Group:</strong> {{ $zScoreHeightData->input_agegroup }}</div>
                                        <div class="mx-2"><strong>Height/Length:</strong> {{ $zScoreHeightData->Height }} CM</div>
                                        <div class="mx-2"><strong>M. Weight:</strong> {{ $zScoreHeightData->M }} KG</div>
                                        <div class="mx-2"><strong>-3SD:</strong> {{ $zScoreHeightData->SD3neg }} KG</div>
                                        <div class="mx-2"><strong>-2SD:</strong> {{ $zScoreHeightData->SD2neg }} KG</div>
                                        <div class="mx-2"><strong>-1SD:</strong> {{ $zScoreHeightData->SD1neg }} KG</div>
                                    </div>
                                </div>

                                <div class="mt-3 alert {{ $zScoreHeightData->output_case == 'severe_abnormal' ? 'alert-red' : ($zScoreHeightData->output_case == 'moderate_abnormal' ? 'alert-yellow' : ($zScoreHeightData->output_case == 'normal' ? 'alert-green' :'')) }}">
                                    <h5 class="">Height/Length Result:</h5>
                                    <div>{!! $zScoreHeightData->output_remarks !!}</div>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#agegroup').on('change', function() {
            var ageGroup = $(this).val();
            if (ageGroup === '0_23_months') {
                $('#height').attr('placeholder', 'Length in cm');
            } else if (ageGroup === '24_59_months') {
                $('#height').attr('placeholder', 'Height in cm');
            }
            else{
                $('#height').attr('placeholder', '');
            }
        });
    </script>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Child Nutrition Calculator',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>
@endsection
