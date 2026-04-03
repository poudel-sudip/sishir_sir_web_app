<body>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .container {
            width: 100%;
            border: 2px solid red;
            color: #0C2B64;
        }
        .header {
            text-align: center;
            font-weight: bold;
            line-height: 1;
        }
        .line {
            border-top: 1px dashed #000;
        }
        table {
            width: 100%;
        }
        .product{
            font-family: FreeSans, Arial, Helvetica, sans-serif;
        }
    </style>

    <div class="container">
        <br>
        <table>
            <tr>
                <td colspan="3" style="text-align: center; color:red; font-size:15px;"><strong>E. Health Network Pvt. Ltd.</strong></td>
            </tr>
            <tr>
                <td><img src="{{ $invoice->logo }}" alt="" style="height: 75px; width:auto; max-width: 100%;"> </td>
                <td class="header">
                    <div style="font-size: 14px;">Online Payment Receipt</div>
                    <div style="font-size: 12px;">Invoice ID: {{ $invoice['id'] }}</div>
                </td>
                <td style="text-align: right; font-size:20px; font-weight:bold; color:{{$invoice->paid ? 'green' : 'red'}};">
                    <br><br>{{$invoice->paid ? 'PAID' : 'NOT PAID'}}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td><strong>Student ID:</strong> {{ optional($invoice->user)->id }}<br><strong>Name:</strong> {{ optional($invoice->user)->name }}<br><strong>Contact:</strong> {{ optional($invoice->user)->contact }}<br></td>
                <td style="text-align: right;">
                    <strong style="font-size: 15px;">E. Health Network</strong> <br>
                    <strong>PAN: </strong>621123751 <br>
                </td>
            </tr>
        </table>
        <table>
            <tr><td class="line"></td></tr>
        </table>

        <table style="color: #000;">
            <tr>
                <td><strong>Date:</strong> {{ $invoice->created_at->format('Y-m-d h:i A') }} <br><strong>Booking ID:</strong> {{ $invoice->booking_id }} <br><strong>Product Type:</strong> {{ ucwords($invoice->type) }} <br><strong>Expiry Date:</strong> {{ $invoice->expiry_date }} <br></td>
                <td style="text-align: right;">
                    <strong>Payment Mode:</strong> {{ ucwords($invoice->payment_mode) }} <br>
                    <strong>Reference Code:</strong> {{ $invoice->reference_code }} <br>
                    <strong>Payment Amount:</strong> Rs. {{ number_format($invoice->payment_amount, 2) }} <br>
                    <strong>Discount Amount:</strong> Rs. {{ number_format($invoice->discount_amount, 2) }} <br>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Product Detail:</strong> <br><span class="product">{{ $invoice->payment_remarks }}</span> <br>
                </td>
            </tr>
            
        </table>
        <table>
            <tr><td class="line"></td></tr>
        </table>

        <table>
            <tr>
                <td style="text-align: right;">
                    <strong>Total Paid: Rs. {{ number_format($invoice['payment_amount'], 2) }} </strong>
                </td>
            </tr>
            <tr>
                <td><strong>In Words: </strong>{{ ucfirst($invoice['payment_in_words'] ?? '') }}</td>
            </tr>
        </table>
        
        <br><br>
        <div style="text-align: right;">
            ----------------------<br>
            Signature
        </div>

    </div>
    <p style="text-align: center; line-height: 0.5;"><strong>Customer Support: </strong> +977-9702844270, <strong>Email: </strong> ehealthehn@gmail.com</p>
</body>