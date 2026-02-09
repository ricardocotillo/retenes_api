<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  </head>
  <body style="font-family: 'Open Sans', sans-serif; margin: 0; padding: 0;">
    <div style="width: 190mm; max-width: 190mm; margin: 0 auto; box-sizing: border-box;">
      <div style="display: flex">
        <div style="width: 50%;">
            <div style="text-align: center; color: #fefdfe; font-size: 16.3px; background-color: #0766ab; padding: 10px; border-bottom: 1px solid #ffffff;">R250-035238</div>
            <div style="text-align: center; color: #fefdfe; font-size: 29px; background-color: #0766ab; padding: 10px">COTIZACIÓN</div>
        </div>
        <div style="width: 50%;">
            @if ($flavor == 'filtros')
				<img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents('http://filtroswillybusch.com.pe/logo/filtros_logo.png')) }}" width="100" height="100" id="logo">
			@else
				<img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents('http://willybusch.com.pe/logos/retenes_logo.png')) }}" width="100" height="100" id="logo">
			@endif
        </div>
      </div>
      <h1 style="color: #000000; font-size: 10px; margin-bottom: 0;">COD. VENDEDOR: 0001</h1>
      <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">
        <colgroup>
          <col style="width: 9%;">
          <col style="width: 9%;">
          <col style="width: 31%;">
          <col style="width: 16%;">
          <col style="width: 8%;">
          <col style="width: 10%;">
          <col style="width: 10%;">
          <col style="width: 7%;">
        </colgroup>
      <thead style="color: #ffffff; background-color: #0766ab; font-weight: 600; font-size: 8px;">
        <tr>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">CÓDIGO</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">CANTIDAD</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">DESCRIPCIÓN</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">MEDIDAS INT-EXT-ALT</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">ESTADO</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">PRECIO UNITARIO</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">DESCUENTO</th>
          <th style="padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word;">TOTAL</th>
        </tr>
      </thead>
      <tbody style="font-size: 8px;">
        <!-- start loop -->
        <tr>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">066620KN</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">20</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: left; word-break: break-word; overflow-wrap: break-word;">RETEN WB KIT TAPA BUJIA TOYOTA 5A/4A/5S/4S(4 PZAS)</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">10.50-20.30-3.50</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">Espera</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">3.10</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">15+20+4%</td>
          <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">62.00</td>
        </tr>
        <!-- end loop -->
        <!-- sub total -->
        <tr>
          <td colspan="5"></td>
          <td colspan="2" style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; border-right: none; font-size: 8.5px;">SUBTOTAL</td>
          <td colspan="1" style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; border-left: none; font-size: 8.5px;">$ 62.00</td>
        </tr>
        <!-- end sub total -->
      </tbody>
      </table>
    </div>
  </body>
</html>
