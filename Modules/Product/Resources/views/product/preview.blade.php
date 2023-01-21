<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script language="javascript">
        function print_this_page() {
            document.getElementById('print_button').style.display = 'none';
            window.print();
        }
    </script>
</head>

<body>

    <body style="background-color:#FFF;">
        <!--<input type="button" value="Print" onkeydown="this.style.display='none'">-->
        <div style="width:703px;margin:0 auto;">
            <?php
            $how_many_products = count($products);
            $limit = intval($how_many_products / 3);
            
            ?>
            <div
                style="padding:5px;font-size:28px;font-family:Arial, Helvetica, sans-serif;text-align:center;font-weight:bold;">
                LIST OF PRODUCTS</div>
            <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;"
                bordercolor="#666666">
                <tr>
                    <td width="33%" valign="top">
                        <table border="1px" cellpadding="2px" cellspacing="1px" width="100%" bordercolor="#666666"
                            style="font-size:11px; border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;">
                            <tr style="background-color:#000; color:white; font-weight:bold;font-size:12px;height:30px;"
                                align="center">
                                <td>SKU</td>
                                <td>Description</td>
                                <td width="35px">PRICE</td>
                            </tr>
                            <?php
                            $limit_from_1 = 0;
                            $limit_end = $limit;
                            $collected_data = \DB::table('product_variants')
                                ->take($limit)
                                ->get();
                                foreach($collected_data as $raw_data){
                            ?>
                            <tr>
                                <td>{{ $raw_data->id }}</td>
                                <td>{{ $raw_data->name }}<span
                                        style="font-size:9px;margin-left:1px;">{{ substr(strip_tags($raw_data->description), 0, 12) }}</span>
                                </td>
                                <td align="center">${{ $raw_data->price }}</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </td>
                    <td width="34%" valign="top">
                        <table border="1px" cellpadding="2px" cellspacing="1px" width="100%" bordercolor="#666666"
                            style="font-size:11px; border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;">
                            <tr style="background-color:#000; color:white; font-weight:bold;font-size:12px;height:30px;"
                                align="center">
                                <td>SKU</td>
                                <td>Description</td>
                                <td width="35px">PRICE</td>
                            </tr>
                            <?php
                            $limit_from_2 = $limit;
                            $limit_to_2 = $limit;
                            $collected_data = \DB::table('product_variants')
                                ->skip($limit_from_2)
                                ->take($limit_to_2)
                                ->get();
                            foreach($collected_data as $raw_data){
                            ?>
                            <tr>
                                <td>{{ $raw_data->id }}
                                </td>
                                <td>{{ $raw_data->name }}<span
                                        style="font-size:9px;margin-left:1px;">{{ substr(strip_tags($raw_data->description), 0, 12) }}</span>
                                </td>
                                <td align="center">${{ number_format($raw_data->price) }}</td>
                            </tr>
                            <?php
                                }?>
                        </table>
                    </td>
                    <td width="33%" valign="top">
                        <table border="1px" cellpadding="2px" cellspacing="1px" width="100%" bordercolor="#666666"
                            style="font-size:11px; border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;">
                            <tr style="background-color:#000; color:white; font-weight:bold;font-size:12px;height:30px;"
                                align="center">
                                <td>SKU</td>
                                <td>Description</td>
                                <td width="35px">PRICE</td>
                            </tr>
                            <?php
                            $limit_from_3 = $limit * 2;
                            $limit_to_3 = $limit + 2;
                            $collected_data = \DB::table('product_variants')
                                ->skip($limit_from_3)
                                ->take($limit_to_3)
                                ->get();
                            foreach($collected_data as $raw_data){    
                            ?>
                            <tr>
                                <td>{{ $raw_data->id }}</td>
                                <td>{{ $raw_data->name }}<span
                                        style="font-size:9px;margin-left:1px;">{{ substr(strip_tags($raw_data->description), 0, 12) }}</span>
                                </td>
                                <td align="center">${{ number_format($raw_data->price, 2) }}</td>
                            </tr>
                            <?php
                                }?>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <div align="center" id="print_button"><input type="button" value="Print"
                    style="padding:18px 100px;font-weight:bold;" onclick="print_this_page();" /></div>
        </div>
        </div>
    </body>
