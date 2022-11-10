<div class="inquiry-section" id="inquiry-section">
    <div class="inquiry-seen-btn" onclick="myEnquiry()">
        <img src="{{ asset('images/message.svg') }}" alt="">
        <span>ENQUIRY</span>
    </div>
    <div class="inquiry-details">
        <form action="/leads/enquiries/add" method="post" enctype="multipart/form-data">
            @csrf

            <input type="text" name="name" placeholder="full name" class="inquiry-input @error('name') is-invalid @enderror" value="{{old('name')}}" required>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input type="email" name="email" placeholder="email" class="inquiry-input inquiry-input @error('email') is-invalid @enderror" value="{{old('email')}}">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input type="text" name="contact" placeholder="mobile number" class="inquiry-input inquiry-input @error('contact') is-invalid @enderror" value="{{old('contact')}}">
            @error('contact')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            
            <select id="provience" name="provience" class="inquiry-input inquiry-input @error('provience') is-invalid @enderror" onchange="getCities()">
                <option value="">select your provience</option>
                @foreach($proviences as $pro)
                    <option value="{{$pro->name}}">{{$pro->name}}</option>
                @endforeach
            </select>
            @error('provience')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <select id="district" name="district" class="inquiry-input inquiry-input @error('district') is-invalid @enderror">
                <option value="">select your district</option>
            </select>
            @error('district')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <select name="course" class="inquiry-input inquiry-input @error('course') is-invalid @enderror">
                <option value="">select your course</option>
                @foreach($headercategories as $cat)
                    @foreach($cat->courses()->where('status','=','Active')->get() as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                @endforeach
            </select>
            @error('course')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <textarea name="message" rows="2" class="inquiry-input inquiry-input @error('message') is-invalid @enderror">{{old('message') ?? 'Message'}}</textarea>
            @error('message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <button type="submit">Submit</button>
        </form>
    </div>
</div>
<script>
    function myEnquiry() {
        var y = document.getElementById("inquiry-section");
        if (y.style.right === "-300px") {
            y.style.right = "0";
        } else {
            y.style.right = "-300px";
        }
    }
</script>

<script>
    var proviences = {
            @foreach($proviences as $pro)
            '{{$pro->name}}' : [
                @foreach($pro->cities as $city)
                "{{$city->name}}",
                @endforeach
            ],
            @endforeach
        };

        function getCities()
        {
            var provience = $('#provience').find(":selected").val();
            $("#district").html("");
            if(provience)
            {
                var cities = proviences[provience];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district").append(op);
            }
        }
</script>