<body>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
        }

        .container {
            width: 100%;
            border: 5px solid #0C2B64;
            padding: 20px;
            color: #0C2B64;
        }

        table {
            width: 100%;
        }

        .title {
            text-align: center;
            font-size: 34px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .subtitle {
            text-align: center;
            font-size: 16px;
        }

        .student-name {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #000;
            margin: 20px 0;
        }

        .description {
            text-align: center;
            color: #000;
            font-size: 15px;
            line-height: 1.8;
        }

        .line {
            border-top: 1px dashed #000;
        }

        .footer {
            margin-top: 50px;
        }

        .sign {
            text-align: center;
        }

        .small {
            font-size: 11px;
            color: #444;
        }
    </style>

    <div class="container">

        <table>
            <tr>
                <td width="20%">
                    <img src="{{$certificate->logo}}"
                         style="height:80px; width:auto;">
                </td>

                <td width="60%" style="text-align:center;">
                    <div style="font-size:22px;font-weight:bold;">
                        E. Health Network Pvt. Ltd.
                    </div>

                    <div style="font-size:14px;">
                        Birendranagar - 3 Surkhet, Nepal
                    </div>
                </td>

                <td width="20%" style="text-align:right;">
                    <img src="{{$certificate->logo}}"
                         style="height:80px; width:auto;">
                </td>
            </tr>
        </table>

        <br>

        <div class="title">
            CERTIFICATE
        </div>

        <div class="subtitle">
            OF COMPLETION
        </div>

        <br><br>

        <div class="description">
            This certificate is proudly presented to
        </div>

        <br>

        <div class="student-name">
            {{$certificate->student_name}}
        </div>

        <br>

        <div class="description">
            for successfully completing the course
        </div>

        <br>

        <div style="text-align:center;font-size:22px;font-weight:bold;">
            {{$certificate->course}}
        </div>

        <br>

        <div class="description">
            with outstanding dedication and commitment.
            We appreciate your hard work and wish you
            continued success in your future endeavors.
        </div>

        <br><br>

        <table>
            <tr>
                <td>
                    <strong>Date Issued:</strong> {{$certificate->date}}
                </td>               
            </tr>
            <tr>
                <td>
                    <strong>Certificate No:</strong> {{$certificate->certificate_no}}
                </td>               
            </tr>

            <tr>
                <td>
                    <strong>Student ID:</strong> {{$certificate->student_id}}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Duration:</strong> {{$certificate->duration}}
                </td>
            </tr>
        </table>

        <br><br>

        
        <div class="footer">

            <table>

                <tr>

                    <td class="sign">
                        _______________________<br>
                        <strong>Course Instructor</strong>
                    </td>

                   
                    <td class="sign">
                        _______________________<br>
                        <strong>Authorized Signature</strong>
                    </td>

                </tr>

            </table>

        </div>

    </div>

    <p class="small" style="text-align:center;" style="text-align: center; line-height: 0.5;">
        <strong>Customer Support: </strong> +977-9702844270, 
        <strong>Email: </strong> ehealthehn@gmail.com
    </p>

</body>