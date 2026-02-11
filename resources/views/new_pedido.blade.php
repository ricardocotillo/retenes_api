<html>
    <head>
        <meta charset="UTF-8">>
    </head>
    <body style="font-family: 'Open Sans', sans-serif; margin: 0; padding: 0;">
        <div style="width: 190mm; max-width: 190mm; margin: 0 auto; box-sizing: border-box;">
            <div style="display: flex; gap: 24px; align-items: flex-end;">
                <div style="width: 60%;">
                    <div style="text-align: center; color: #fefdfe; font-size: 16.3px; background-color: #0766ab; padding: 10px; border-bottom: 1px solid #ffffff; padding-top: 16px;">{{ $mnroped }}</div>
                    <div style="text-align: center; color: #fefdfe; font-size: 29px; background-color: #0766ab; padding: 10px; padding-bottom: 16px;">COTIZACIÓN</div>
                </div>
                <div style="width: 40%; display: flex; justify-content: space-between; align-items: center;">
                    @if ($flavor == 'filtros')
                        <img style="height: 90px; width: 90px;" src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents('http://filtroswillybusch.com.pe/logo/filtros_logo.png')) }}" width="100" height="100" id="logo">
                    @else
                        <img style="height: 90px; width: 90px;" src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents('http://willybusch.com.pe/logos/retenes_logo.png')) }}" width="100" height="100" id="logo">
                    @endif
                    <div>
                        <h1 style="margin: 0; font-size: 16.8px;">WILLY BUSCH</h1>
                        <h2 style="margin: 0; font-size: 12.9px;">
                            @if ($flavor == 'filtros')
                                20100675537
                            @else
                                20100674301
                            @endif
                        </h2>
                        <p style="margin: 0; font-size: 8.3px;">@if ($flavor == 'filtros') Av. Santa Maria 135 Urb. Industrial - Ate - Lima- Perú @else CALLE SANTA LUCIA 170 Ate - Lima - Perú @endif</p>
                        <p style="margin: 0; font-size: 8.3px;">@if ($flavor == 'filtros') filtros@filtroswillybusch.com.pe @else retenes@willybusch.com.pe @endif</p>
                        <p style="margin: 0; font-size: 8.3px;">@if ($flavor == 'filtros') www.filtroswillybusch.com.pe @else www.willybusch.com.pe @endif</p>
                    </div>
                </div>
            </div>
            <div style="padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                <h1 style="margin: 0; font-size: 11px; color: #0766ab; font-weight: bold;">DATOS DEL CLIENTE</h1>
                <p style="margin: 0; font-size: 7px;">FECHA DE PEDIDO: {{ $fecha }}</p>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">RUC:</td>
                        <td style="font-size: 9px;">{{ $ruc }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">CLIENTE:</td>
                        <td style="font-size: 9px;">{{ $cliente }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">DIRECCIÓN:</td>
                        <td style="font-size: 9px;">{{ $direccion }} - {{ $localidad }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">CORREO:</td>
                        <td style="font-size: 9px;">{{ $email }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">CORREO 2:</td>
                        <td style="font-size: 9px;">{{ $email }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">TELEFONO:</td>
                        <td style="font-size: 9px;"></td>
                    </tr>
                </tbody>
            </table>
            <div style="padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                <h1 style="margin: 0; font-size: 11px; color: #0766ab; font-weight: bold;">DATOS ADICIONALES</h1>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">COND. PAGO:</td>
                        <td style="font-size: 9px;">{{ $condicion }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">TRANSPORTE:</td>
                        <td style="font-size: 9px;">{{ $transporte }} - {{ $nametrans }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">OBSERVACIÓN:</td>
                        <td style="font-size: 9px;">{{ $observaciones }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px; color: #0766ab">FECHA DESP.:</td>
                        <td style="font-size: 9px;"></td>
                    </tr>
                </tbody>
            </table>
            @foreach ($articulos as $key => $value)
                <h1 style="color: #000000; font-size: 10px; margin-bottom: 0;">COD. VENDEDOR: {{ $key }}</h1>
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
                        @foreach ($value as $v)
                            @if ($v['MCODDFA'] != 'Bono')
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['MCODART'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['MCANTIDAD'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: left; word-break: break-word; overflow-wrap: break-word;">{{ $v['MDESCRI01'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">10.50-20.30-3.50</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['item_state'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ number_format($v['MPRECIO'], 2, '.', '') }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['descrip'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ number_format($v['precio_neto'], 2, '.', '') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['MCODART'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['MCANTIDAD'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: left; word-break: break-word; overflow-wrap: break-word;">{{ $v['MDESCRI01'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">10.50-20.30-3.50</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">{{ $v['item_state'] }}</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">0.00</td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;"></td>
                                    <td style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; word-break: break-word; overflow-wrap: break-word;">0.00</td>
                                </tr>
                            @endif
                        @endforeach
                        <!-- end loop -->
                        <!-- sub total -->
                        <tr>
                            <td colspan="5"></td>
                            <td colspan="2" style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; border-right: none; font-size: 8.5px;">SUBTOTAL</td>
                            <td colspan="1" style="padding: 10px; border: 1px solid #e8e8e8; text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; border-left: none; font-size: 8.5px;">@if ($flavor == 'filtros') S/ @else $ @endif {{ number_format( array_reduce( $value, function($carry, $p) { return $carry + $p['precio_neto']; }), 2, '.', '' ) }}</td>
                        </tr>
                        <!-- end sub total -->
                    </tbody>
                </table>
            @endforeach
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="width: 40%;">
                    <div style="padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <h1 style="margin: 0; font-size: 10px; color: #0766ab; font-weight: bold;">CONDICIONES DE VENTA</h1>
                    </div>
                    <ul style="font-size: 8.5px; padding-left: 12px;">
                        <li><span style="color: #0766ab;">Moneda:</span> USD (Dólares estadounidenses)</li>
                        <li><span style="color: #0766ab;">Precios:</span> Los precios indicados incluyen IGV</li>
                        <li><span style="color: #0766ab;">Entrega:</span> Según fecha coordinada</li>
                        <li><span style="color: #0766ab;">Tiempo de validez:</span> 15 días después de la fecha de emisión o fin de campaña</li>
                    </ul>
                </div>
                <div style="width: 40%; display: flex; justify-content: flex-end;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #e8e8e8;">
                        <tbody>
                            <tr>
                                <td style="font-size: 9px; font-weight: bold; text-align: left; padding: 4px; border: 1px solid #e8e8e8;">TOTAL ATENDIDOS:</td>
                                <td style="font-size: 9px; padding: 4px; text-align: right; border: 1px solid #e8e8e8;">$ 62.00</td>
                            </tr>
                            <tr>
                                <td style="font-size: 9px; font-weight: bold; text-align: left; padding: 4px; border: 1px solid #e8e8e8;">TOTAL PENDIENTES:</td>
                                <td style="font-size: 9px; padding: 4px; text-align: right; border: 1px solid #e8e8e8;">$ 62.00</td>
                            </tr>
                            <tr>
                                <td style="font-size: 9px; font-weight: bold; text-align: left; padding: 4px; border: 1px solid #e8e8e8;">TOTAL ANULADO:</td>
                                <td style="font-size: 9px; padding: 4px; text-align: right; border: 1px solid #e8e8e8;">$ 62.00</td>
                            </tr>
                            <tr style="background-color: #0766ab;">
                                <td style="font-size: 9px; font-weight: bold; text-align: left; color: #ffffff; padding: 4px; border: 1px solid #e8e8e8;">TOTAL A PAGAR:</td>
                                <td style="font-size: 9px; color: #ffffff; padding: 4px; text-align: right; border: 1px solid #e8e8e8;">$ 62.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div style="width: 50%; padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <h1 style="margin: 0; font-size: 10px; color: #0766ab; font-weight: bold;">VENCIMIENTO: 20 CUOTA(S)</h1>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <tr style="font-size: 8px;">
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                    </tr>
                    <tr style="font-size: 8px;">
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                    </tr>
                    <tr style="font-size: 8px;">
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                    </tr>
                    <tr style="font-size: 8px;">
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                        <td style="padding: 4px; text-align: center;">2026-01-09: $ 1187.2000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
