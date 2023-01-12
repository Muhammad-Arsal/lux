<!DOCTYPE html>
<html>
    <head>
        <title>
            Product Preview
        </title>
    </head>
    <body style="background-color:#FFF;">
        <div style="width:703px;margin:0 auto;">  
            <div style="padding:5px;font-size:28px;font-family:Arial, Helvetica, sans-serif;text-align:center;font-weight:bold;">LIST OF PRODUCTS</div>
                <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;" bordercolor="#666666">
                    <tr>
                        @foreach ($products as $item)
                            <td width="33%" valign="top">
                                <table border="1px" cellpadding="2px" cellspacing="1px" width="100%" bordercolor="#666666" style="font-size:11px; border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;">
                                    <tr style="background-color:#000; color:white; font-weight:bold;font-size:12px;height:30px;" align="center">
                                        <td>SKU</td><td>Description</td><td width="35px">PRICE</td>
                                    </tr>  
                                </table>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>