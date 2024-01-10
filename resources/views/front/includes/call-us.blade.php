<div class="container" style="overflow:hidden">
    <div class="call-us-section" id="call-us-details" style="left: -180px">        
        <div class="call-us-details">
            <ul>
                <li><a href="tel:+977-9812417639"><span class="icon-phone"></span>+977 9812417639</a></li>
            </ul>
        </div>
        <div class="call-us-seen-btn" onclick="myCall()">
            <img src="{{ asset('images/phone.svg') }}" alt="">
            <span>CALL US</span> 
        </div>
    </div>
</div>

<script>
    function myCall() {
        var y = document.getElementById("call-us-details");
        if (y.style.left == "-180px") {
            y.style.left = "0";
        } else {
            y.style.left = "-180px";
        }
    }
</script>

{{-- <script>
    function myCall() {
        var y = document.getElementById("call-us-details");
        if (y.style.left === "-180px") {
            y.style.left = "0";
        } else {
            y.style.left = "-180px";
        }
    }
</script> --}}
