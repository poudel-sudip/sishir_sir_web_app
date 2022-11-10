<div class="call-us-section" id="call-us-details">
    <div class="call-us-seen-btn" onclick="myCall()">
        <img src="{{ asset('images/phone.svg') }}" alt="">
        <span>CALL US</span> 
    </div>
    
    <div class="call-us-details">
        <ul>
            <li><a href="tel:+977-071590980"><span class="icon-phone"></span>+977-014242320</a></li>
            <li><a href="tel:+977-071590980"><span class="icon-phone"></span>+977-071590980</a></li>
            <li><a href="tel:+977-9857084808"><span class="icon-mobile"></span>+977-9801784805</a></li>
            <li><a href="tel:+977-9857084808"><span class="icon-mobile"></span>+977-9801784806</a></li>
        </ul>
    </div>
</div>
<script>
    function myCall() {
        var y = document.getElementById("call-us-details");
        if (y.style.right === "-180px") {
            y.style.right = "0";
        } else {
            y.style.right = "-180px";
        }
    }
</script>
