<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Order confirmation </title>
{{--    <meta name="robots" content="noindex,nofollow" />--}}
{{--    <meta name="viewport" content="width=device-width; initial-scale=1.0;" />--}}

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
        body { margin: 0; padding: 0; background: white; }
        div, p, a, li, td { -webkit-text-size-adjust: none; }
        .ReadMsgBody { width: 100%; background-color: #ffffff; }
        .ExternalClass { width: 100%; background-color: #ffffff; }
        body { width: 100%; height: 100%; background-color: white; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        html { width: 100%; }
        p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
        .visibleMobile { display: none; }
        /*.hiddenMobile { display: block; }*/

        @media only screen and (max-width: 600px) {
            body { width: auto !important; }
            table[class=fullTable] { width: 96% !important; clear: both; }
            table[class=fullPadding] { width: 85% !important; clear: both; }
            table[class=col] { width: 45% !important; }
            .erase { display: none; }
        }

        @media only screen and (max-width: 420px) {
            table[class=fullTable] { width: 100% !important; clear: both; }
            table[class=fullPadding] { width: 85% !important; clear: both; }
            table[class=col] { width: 100% !important; clear: both; }
            table[class=col] td { text-align: left !important; }
            .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
            .visibleMobile { display: block !important; }
            .hiddenMobile { display: none !important; }
        }
    </style>
</head>
<body>
<!-- Header -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
    <!--
    <tr>
        <td height="20"></td>
    </tr>
    -->
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                <tr class="hiddenMobile">
                    <td height="40"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="30"></td>
                </tr>

                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                        <tbody>
                                        <!--
                                        <tr>
                                            <td align="left"> <img src="http://www.supah.it/dribbble/017/logo.png" width="32" height="32" alt="logo" border="0" /></td>
                                        </tr>
                                        <tr class="hiddenMobile">
                                            <td height="40"></td>
                                        </tr>
                                        -->
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                Hallo, {{ $order->first_name }} {{ $order->last_name }}
                                                <br> Vielen Dank für Ihre Bestellung!
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td height="5"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 21px; color: #e2a900; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right; font-weight:500;">
                                                Rechnung
                                            </td>
                                        </tr>
                                        <tr>
                                        <!--
                                        <tr class="hiddenMobile">
                                            <td height="50"></td>
                                        </tr>
                                        -->
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                <small>Bestellung</small> #{{ $order->id }}<br />
                                                @if(! in_array($order->order_status, ['new', 'succeeded']))
                                                    <small style="color: red;">Status: Abgebrochen</small><br />
                                                @endif
                                                <small>{{ \Carbon\Carbon::parse($order->order_date)->format('F jS Y') }}</small>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- /Header -->
<!-- Information -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                <tbody>
                <tr>
                    <!--
                    <tr class="hiddenMobile">
                        <td height="60"></td>
                    </tr>
                    -->
                <tr class="visibleMobile">
                    <td height="40"></td>
                </tr>
                <tr>
                    <td>
                        <table style="padding-top: 40px; padding-bottom: 40px;" width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">

                                        <tbody>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                <strong>RECHNUNGSADRESSE</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                {{ $order->first_name }} {{ $order->last_name }}<br> {{ $order->address }}<br> {{ $order->city }}, {{ $order->zip_code }}<br> T: {{ $order->phone }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                <strong>ZAHLUNGSART</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                Zahlungsart: Unbekannt<br>
                                                {{--                                                Worldpay Transaction ID: <a href="#" style="color: #e2a900; text-decoration:underline;">4185939336</a><br>--}}
                                                {{--                                                <a href="#" style="color:#b0b0b0;">Right of Withdrawal</a>--}}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                {{--                <tr>--}}
                {{--                    <td>--}}
                {{--                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">--}}
                {{--                            <tbody>--}}
                {{--                            <tr>--}}
                {{--                                <td>--}}
                {{--                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">--}}
                {{--                                        <tbody>--}}
                <!--
                                        <tr class="hiddenMobile">
                                            <td height="35"></td>
                                        </tr>
                                        -->
                {{--                                        <tr class="visibleMobile">--}}
                {{--                                            <td height="20"></td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">--}}
                {{--                                                <strong>SHIPPING INFORMATION</strong>--}}
                {{--                                            </td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td width="100%" height="10"></td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">--}}
                {{--                                                Sup Inc<br> Another Place, Somewhere<br> New York NY<br> 4468, United States<br> T: 202-555-0171--}}
                {{--                                            </td>--}}
                {{--                                        </tr>--}}
                {{--                                        </tbody>--}}
                {{--                                    </table>--}}


                {{--                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">--}}
                {{--                                        <tbody>--}}
                <!--
                                        <tr class="hiddenMobile">
                                            <td height="35"></td>
                                        </tr>
                                        -->
                {{--                                        <tr class="visibleMobile">--}}
                {{--                                            <td height="20"></td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">--}}
                {{--                                                <strong>SHIPPING METHOD</strong>--}}
                {{--                                            </td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td width="100%" height="10"></td>--}}
                {{--                                        </tr>--}}
                {{--                                        <tr>--}}
                {{--                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">--}}
                {{--                                                UPS: U.S. Shipping Services--}}
                {{--                                            </td>--}}
                {{--                                        </tr>--}}
                {{--                                        </tbody>--}}
                {{--                                    </table>--}}
                {{--                                </td>--}}
                {{--                            </tr>--}}
                {{--                            </tbody>--}}
                {{--                        </table>--}}
                {{--                    </td>--}}
                {{--                </tr>--}}
                <!--
                <tr class="hiddenMobile">
                    <td height="60"></td>
                </tr>
                -->
                <tr class="visibleMobile">
                    <td height="30"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Information -->
<!-- Order Details -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                <tbody>
                <tr>
                <!--
                <tr class="hiddenMobile">
                    <td height="60"></td>
                </tr>
                -->
                <tr class="visibleMobile">
                    <td height="40"></td>
                </tr>
                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                            <tbody>
                            <tr>
                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" width="52%" align="left">
                                    Event
                                </th>
{{--                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="left">--}}
{{--                                    <small>SKU</small>--}}
{{--                                </th>--}}
                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                                    Menge
                                </th>
                                <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="right">
                                    Summe
                                </th>
                            </tr>
                            <tr>
                                <td height="1" style="background: #bebebe;" colspan="3"></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="4"></td>
                            </tr>
                            @foreach($order->tickets as $ticket)
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000000;  line-height: 18px;  vertical-align: top; padding:10px 0; font-weight:600" class="article">
                                        {{ $ticket->eventSeatPlanCategory->event->name }} |
                                        {{ $ticket->category_name }} |
                                        {{ $ticket->name }}
                                        @if($ticket->row) | Reihe {{ $ticket->row }} @endif
                                        @if($ticket->seat) | Sitzplatz: {{ $ticket->seat }} @endif
                                    </td>
{{--                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"><small>MH792AM/A</small></td>--}}
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">1</td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="right">{{ \App\Helpers\PriceHelper::fromFloatToStr($ticket->price) }}</td>
                                </tr>
                                <tr>
                                    <td height="1" colspan="3" style="border-bottom:1px solid #e4e4e4"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Order Details -->
<!-- Total -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                <tbody>
                <tr>
                    <td>

                        <!-- Table Total -->
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                            <tbody>
                            <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Zwischensumme
                                </td>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
                                    {{ \App\Helpers\PriceHelper::fromFloatToStr($order->subtotal) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Versand
                                </td>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    {{ \App\Helpers\PriceHelper::fromFloatToStr(0.0) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; "><small>13% MwSt.</small></td>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <small>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->vat) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>Gesamt (inkl MwSt.)</strong>
                                </td>
                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->total) }}</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /Table Total -->

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Total -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="white">
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                            <tbody>
                            <tr>
                                <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="spacer">
                    <td height="50"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="20"></td>
    </tr>
</table>
<script>
    // Function to open print popup
    function openPrintPopup() {
        window.print(); // Open print dialog
    }

    // Call the function when the document is ready
    document.addEventListener('DOMContentLoaded', openPrintPopup);
</script>

</body>
</html>
