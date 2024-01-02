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
                
                <div id="inch-calculator-icw" data-ct="bmi" data-cw="100%" data-ch="1200" data-cv="MTE3MDE4MDY1NTM=">
                    <div id="inch-calculator-icwh">  BMI Calculator </div>
                    <div id="inch-calculator-icwf">
                        <a id="inch-calculator-icwi" href="javascript:void(0);">
                            <span id="inch-calculator-icwl" ></span>
                            <span id="inch-calculator-icwb"></span>
                        </a>
                    </div>

                    <div class="px-2">
                        <h5><strong>World Health Organization (WHO) recommendations for a healthy lifestyle </strong></h5>
                        <div style="font-size: 16px">
                            To ensure a healthy lifestyle, WHO recommends eating lots of fruits and vegetables, reducing fat, sugar and salt intake and exercising. Based on height and weight, people can check their body mass index (BMI) to see if they are overweight. WHO provides a series of publications to promote and support healthy lifestyles.
                        </div>
                        <h5 class="mt-4"><strong>12 steps to healthy eating </strong></h5>
                        <ol style="font-size: 16px">
                            <li>Eat a nutritious diet based on a variety of foods originating mainly from plants, rather than animals.</li>
                            <li>Eat bread, whole grains, pasta, rice or potatoes several times per day.</li>
                            <li>Eat a variety of vegetables and fruits, preferably fresh and local, several times per day (at least 400g per day).</li>
                            <li>Maintain body weight between the recommended limits (a BMI of 18.5–25) by taking moderate to vigorous levels of physical activity, preferably daily.</li>
                            <li>Control fat intake (not more than 30% of daily energy) and replace most saturated fats with unsaturated fats.</li>
                            <li>Replace fatty meat and meat products with beans, legumes, lentils, fish, poultry or lean meat.</li>
                            <li>Use milk and dairy products (kefir, sour milk, yoghurt and cheese) that are low in both fat and salt.</li>
                            <li>Select foods that are low in sugar, and eat free sugars sparingly, limiting the frequency of sugary drinks and sweets.</li>
                            <li>Choose a low-salt diet. Total salt intake should not be more than one teaspoon (5g) per day, including the salt in bread and processed, cured and preserved foods. (Salt iodization should be universal where iodine deficiency is a problem)</li>
                            <li>WHO does not set particular limits for alcohol consumption because the evidence shows that the ideal solution for health is not to drink at all, therefore less is better.</li>
                            <li>Prepare food in a safe and hygienic way. Steam, bake, boil or microwave to help reduce the amount of added fat.</li>
                            <li>Promote exclusive breastfeeding up to 6 months, and the introduction of safe and adequate complementary foods from the age of about 6 months. Promote the continuation of breastfeeding during the first 2 years of life.</li>
                        </ol>
                        <h5 class="mt-4"><em>Source of info: WHO </em></h5>
                    </div>
                </div>
                <script src="https://cdn.inchcalculator.com/e/widgets.min.js" async ></script>
                
                <div class="text-justify">
                    
                </div>

            </div>
        </div>
    </div>

@endsection
