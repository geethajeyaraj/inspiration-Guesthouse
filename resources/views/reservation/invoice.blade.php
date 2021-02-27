<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
</head>
<style>
    body {
        font-family: serif;
        font-size: 14px;
    }
  

    @page {
        margin: 30px 30px 40px 30px;
    }
    table {
        page-break-inside: auto;
        font-family: serif;font-size: 16px;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }

    .bgred {
        background: red;
        color: #fff;
    }

    @media print {
        table.border tr td {
            border: 1px solid #666;
            color: #000;
        }

        table.border tr th {
            border: 1px solid #888888;
            background-color: #f5bb7b;
        }

        .bottom-color {
            display: block;
            position: absolute;
            width: 100%;
            left: 0px;
            bottom: 10px;
            ;
            border-top: 2px solid #f2bc7a;
        }
    }
</style>

<body>
    <div class='pagecontainer' style='width:21cm;margin:0px auto;display:block;'>

     <table width="100%" border="0" cellspacing="0" cellpadding="4">
         <tr>
             
         <td>
             <h3 style="margin:0px;padding:0px;">Inspiration</h3>
             <b><i>Laico - Trainees Hostel</i></b><br>
             Plot No 4/44, Kuruvikaran Salai,<br>
             Gandhi Nagar, Madurai - 625020<br>
             Tamilnadu, India <br>
             Phone:- 0452-4356800

         </td>
         <td></td>
        <td style="text-align:right">

        <img src="{{ url('assets/media/laico_logo.png') }}" style="width:200px;" /><br>
        GST No: 33AAATG2522P1ZQ
        </td>
        
        </tr>
     </table>

     <div style="text-align:right;margin:20px 0px;"><b>Date:</b> {{ viewDate($booking->created_at) }}</div>

     <table width="100%" border="0" cellspacing="0" cellpadding="4">
         <tr><th colspan=5 style="font-size:20px;padding:20px;">Proforma Invoice</th></tr>
         <tr>
             <td style="width:20%;"><b>Name:</b></td><td  style="width:20%;">{{ $booking->display_name }}</td>
             <td style="width:10%;">&nbsp;</td>
             <td style="width:20%;"><b>Reserv. No:</b></td><td  style="width:20%;"> #laico{{ $booking->id }}</td>
        </tr>

        <tr>
             <td><b>Bill to:</b></td><td>&nbsp;</td>
             <td>&nbsp;</td>
             <td ><b>Expected Checkin:</b></td><td> {{ viewDatewithTime($booking->checkin_date) }}</td>
        </tr>

        <tr>
             <td><b>Course:</b></td><td>{{ $reservation->course_name }}</td>
             <td >&nbsp;</td>
             <td ><b>Expected Checkout:</b></td><td> {{ viewDatewithTime($booking->checkout_date) }}</td>
        </tr>

        <tr>
             <td><b>Contact at Aravind:</b></td><td>{{ $reservation->contact_person }}</td>
             <td >&nbsp;</td>
             <td><b>Room Type:</b></td><td> @if($period_master_id==3) Monthly @elseif($period_master_id==2) Weekly @else Daily @endif  {{ $room_type->room_type }}</td>
        </tr>


     </table>    <br><br>

     @php($total_amount=0)

     <table width="100%" border="1" cellspacing="0" cellpadding="6">
     <tr><th>Particulars</th><th>Tariff/day(Rs.)</th><th>No of Days</th><th>Amount(Rs)</th></tr>

     <tr><td>Rent</td><td align="right">{{ number_format($room_rent,2) }}</td><td align="center">{{ $no_of_days }}</td><td align="right">{{ number_format($room_rent*$no_of_days,2)  }}</td></tr>

     @php($total_amount=$total_amount + ($room_rent*$no_of_days))


    @if($food_no_of_days!=0)
     <tr><td>Food Amount</td><td align="right">{{ number_format($food_amount,2) }}</td><td align="center">{{ $food_no_of_days }}</td><td align="right">{{ number_format($food_amount*$food_no_of_days,2)  }}</td></tr>
   

     @php($total_amount=$total_amount + ($food_amount*$food_no_of_days))

      
     <tr><td>CGST @ {{ $food_tax/2 }} on Food</td><td align="right"></td><td align="center"></td><td align="right">{{ number_format( $food_amount*$food_no_of_days * $food_tax/200  ,2)  }}</td></tr>
     <tr><td>SGST @ {{ $food_tax/2 }} on Food</td><td align="right"></td><td align="center"></td><td align="right">{{ number_format( $food_amount*$food_no_of_days * $food_tax/200 ,2)  }}</td></tr>

     @php($total_amount=$total_amount + ($food_amount*$food_no_of_days * $food_tax/100))

     
     @endif 
    

    
     <tr><td>CGST @ {{ $room_tax/2 }} on Room</td><td align="right"></td><td align="center"></td><td align="right">{{ number_format( $room_rent*$no_of_days * $room_tax/200  ,2)  }}</td></tr>
     <tr><td>SGST @ {{ $room_tax/2 }} on Room</td><td align="right"></td><td align="center"></td><td align="right">{{ number_format( $room_rent*$no_of_days * $room_tax/200 ,2)  }}</td></tr>

     @php($total_amount=$total_amount + ($room_rent*$no_of_days * $room_tax/100))

    <tr><th colspan=3 align="right">Total Amount in Rs.</th><td align="right">{{ number_format( $total_amount ,2)  }}</td></tr>
    </table>

    
    @if(count($transaction_details)>0)

    @php($total_paid=0)

     <div style="margin-top:20px;width:100%;">
    <b>Transaction Details</b>

    <table width="100%" border="1" cellspacing="0" cellpadding="6">
     <tr><th>Transaction Date</th><th>Mode of Payment</th><th>Credit or Refund</th><th>Amount(Rs)</th></tr>

     @foreach($transaction_details as $t)
     <tr><td>{{ viewDatewithTime($t->transaction_date ) }}</td><td>@if($t->mode_of_payment==0) Cash @elseif($t->mode_of_payment==1) Online @elseif($t->mode_of_payment==2) Cheque @else DD @endif </td><td>@if($t->payment_type==1) Credit @else Refund @endif</td><td align="right">{{ number_format($t->amount,2) }}</td></tr>

     @if($t->payment_type==1)
     @php($total_paid=$total_paid + $t->amount)
     @else 
     @php($total_paid=$total_paid - $t->amount)
     @endif 
     @endforeach

     <tr><th colspan=3 align="right">Total Paid</th><td align="right">{{ number_format($total_paid,2) }}</td></tr>
     <tr><th colspan=3 align="right">Balance to be paid</th><td align="right">{{ number_format($total_amount-$total_paid,2) }}</td></tr>

    </table>
    </div>
    @endif 



     {{--
     <div style="margin-top:20px;width:100%;text-align:center">
    <b> Wire Transfer details for LAICO-Trainees Hostel </b>

    <table border="1" cellspacing="0" cellpadding="6" style="margin:0px auto;">
        <tr><td>Name of the Bank:</td><td>Indian Overseas Bank</td></tr>
        <tr><td>Name of the Account Holder:</td><td>LAICO Trainees Hostel</td></tr>
        <tr><td>Account No: </td><td>186801000005000</td></tr>
        <tr><td>Type of Account: </td><td>Savings Bank Account</td></tr>
        <tr><td>IFSC Code:</td><td>IOBA0001868</td></tr>
        <tr><td>MICR Code:</td><td>625020002</td></tr>
        <tr><td>Swift Code:</td><td>IOBAINBB651</td></tr>
        <tr><td>Branch Code: </td><td>0651</td></tr>
    </table>

  
</div>
 
 --}}
 
  
  
 





     <div style="margin-top:20px;width:100%;">
     <b>Note:</b><br/>
<ul><li>Lunch and Dinner will be served on all days Except Sundays.</li>
<li>Once you opt for meal plan ,you will be charged irrespective of whether you have the meals at inspiration or not .</li>
<li>Meal plan payment will not be refunded.</li>
<li>This is a system generated invoice</li>
</ul>
</div>

             

    </div>
</body>

</html>