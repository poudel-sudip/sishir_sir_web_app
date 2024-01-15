<div class="container" style="overflow:hidden">
    <div class="call-us-section" id="call-us-details" style="left: -205px">        
        <div class="call-us-details">
            <ul>
                <li><a href="tel:+977-9858043441"><span class="icon-phone"></span>+977 9858043441</a></li>
                <li><a href="mailto:info@shisiradhikari.com"><span class="icon-mail2"></span>info@shisiradhikari.com</a></li>
                <li><a href="mailto:shisiradhikari@gmail.com"><span class="icon-mail2"></span>shisiradhikari@gmail.com</a></li>
            </ul>
        </div>
        <div class="call-us-seen-btn" onclick="myCall()">
            <img src="{{ asset('images/phone.svg') }}" alt="">
            <span>CALL US</span> 
        </div>
    </div>

    <div class="inquiry-section" id="inquiry-section" style="left: 0">
        <div class="inquiry-seen-btn" onclick="myEnquiry()">
            <img src="{{ asset('images/message.svg') }}" alt="">
            <span>SUBSCRIBE</span>
        </div>
    </div>

</div>



<script>
    function myCall() {
        var y = document.getElementById("call-us-details");
        if (y.style.left == "-205px") {
            y.style.left = "0";
        } else {
            y.style.left = "-205px";
        }
    }
</script>

<script>
    function myEnquiry() {
        window.location.replace("/register");
    }
</script>
