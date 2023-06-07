<div class="inquiry-section" id="inquiry-section">
    <div class="inquiry-seen-btn" onclick="myEnquiry()">
        <img src="{{ asset('images/message.svg') }}" alt="">
        <span>ENQUIRY</span>
    </div>
</div>
<script>
    function myEnquiry() {
        window.location.replace("/enquiry");
        // var y = document.getElementById("inquiry-section");
        // if (y.style.right === "-300px") {
        //     y.style.right = "0";
        // } else {
        //     y.style.right = "-300px";
        // }
    }
</script>
