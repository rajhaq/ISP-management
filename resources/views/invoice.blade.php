<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    
    <style>
    .invoice-box {
        font-size: 12px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #000;
    }    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    

    

    

    

    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    

    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    

    </style>
</head>

<body onload="window.print()">
    <div class="invoice-box">
    <table>
                        <tr>
                            <td class="title">
                            <img src="{{$setting->image}}" style="max-width:100px;width:100%">
                                <h3>Invoice</h3>
                            </td>
                            
                            <td>
                                Invoice #: {{ $data->id }}<br>
                                Created: {{ $data->created_at }}<br>
                                Collector: {{ $data->admin->name }}<br>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                From:<br>
                                {{$setting->name}}<br>
                                {{$setting->number}}<br>
                                {{$setting->address}}
                            </td>
                            
                            <td>
                                To:<br>
                                {{ $data->customer->name }}( {{$data->customer->customer_id}} )<br>
                                {{ $data->customer->contact }}<br>
                                {{ $data->customer->address }}
                            </td>
                        </tr>
                    </table>
        <table >
            
            <tr class="heading">
                <td>
                    ID
                </td>
                <td>
                    Month
                </td>
                <td>
                    Year
                </td>
                
                <td>
                    Package
                </td>
                <td>
                    Price
                </td>
            </tr>
            @foreach($data->bill as $bill)
            <tr class="item">
                <td>
                    {{$bill->bill->id}}
                </td>
                <td>
                  {{date('F', mktime(0, 0, 0, $bill->bill->month, 10))}}
                </td>
                <td>
                    {{$bill->bill->year}}
                </td>
                <td>
                    {{$bill->bill->package_data->name}}
                </td>
                
                <td>
                    {{$bill->bill->price}} {{$setting->currency}}
                </td>

            </tr>
            @endforeach
            
           </tr>
        </table>
        <p style="font-size: 14px;">Total Item: <b>{{ $data->total_bill}}</b>
        <br>
        Total Amount: <b>{{ $data->total_amount}} {{$setting->currency}}</b>
        </p>
        <br/>
    <p style="font-size: 14px;text-align:center;">{{$setting->invoice_message}}</p>
    </div>
</body>
</html>