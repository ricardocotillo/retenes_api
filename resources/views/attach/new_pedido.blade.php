<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            @page {
                size: 21cm 29.7cm;
                margin: 1cm;
            }
            body {
                font-family: 'Open Sans', sans-serif;
                margin: 0;
                padding: 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            /* ── Header banner ── */
            .order-num {
                text-align: center;
                color: #fefdfe;
                font-size: 16.3px;
                background-color: #0766ab;
                padding: 10px;
                padding-top: 16px;
                border-bottom: 1px solid #ffffff;
            }
            .order-type {
                text-align: center;
                color: #fefdfe;
                font-size: 29px;
                background-color: #0766ab;
                padding: 10px;
                padding-bottom: 16px;
            }
            /* ── Company info ── */
            #logo          { height: 90px; width: 90px; }
            .company-name  { margin: 0; font-size: 16.8px; }
            .company-ruc   { margin: 0; font-size: 12.9px; }
            .company-info  { margin: 0; font-size: 8.3px; }
            /* ── Section separators ── */
            .sep    { padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 16px; }
            .sep-sm { padding-bottom: 4px; border-bottom: 1px solid #0766ab; margin-top: 4px; }
            /* ── Section titles ── */
            .stitle    { margin: 0; font-size: 11px;  color: #0766ab; font-weight: bold; }
            .stitle-sm { margin: 0; font-size: 10px;  color: #0766ab; font-weight: bold; }
            .sdate     { margin: 0; font-size: 7px; }
            /* ── Data-field rows (cliente / adicionales tables) ── */
            .fl { font-size: 9px; color: #0766ab; }
            .fv { font-size: 9px; }
            /* ── Vendor heading ── */
            .vendor-h { color: #000000; font-size: 10px; margin-bottom: 0; }
            /* ── Product table ── */
            .ptable       { table-layout: fixed; }
            .phead        { color: #ffffff; background-color: #0766ab; font-weight: 600; font-size: 8px; }
            .pbody        { font-size: 8px; }
            .pc           { padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word; }
            .pc-c         { padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word; text-align: center; }
            .pc-l         { padding: 10px; border: 1px solid #e8e8e8; word-break: break-word; overflow-wrap: break-word; text-align: left; }
            .st-label     { padding: 10px; border: 1px solid #e8e8e8; border-right: none; text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; font-size: 8.5px; }
            .st-value     { padding: 10px; border: 1px solid #e8e8e8; border-left: none;  text-align: center; background-color: #0766ab; font-weight: bold; color: #ffffff; font-size: 8.5px; }
            /* ── Conditions list ── */
            .cond-list { font-size: 8.5px; padding-left: 12px; }
            .accent    { color: #0766ab; }
            /* ── Totals table ── */
            .ttable { border: 1px solid #e8e8e8; }
            .tl     { font-size: 9px; font-weight: bold; text-align: left;  padding: 4px; border: 1px solid #e8e8e8; }
            .tv     { font-size: 9px;                    text-align: right; padding: 4px; border: 1px solid #e8e8e8; }
            .tf     { background-color: #0766ab; }
            /* ── Instalments ── */
            .inst-cell { padding: 4px; text-align: center; font-size: 8px; }
        </style>
    </head>
    <body>
        <div style="width: 190mm; max-width: 190mm; margin: 0 auto;">

            {{-- ── Header: order number banner + logo / company info ── --}}
            <table>
                <tr>
                    <td style="width: 58%; vertical-align: bottom; padding-right: 24px;">
                        <div class="order-num">{{ $mnroped }}</div>
                        <div class="order-type">COTIZACIÓN</div>
                    </td>
                    <td style="width: 42%; vertical-align: bottom;">
                        <table>
                            <tr>
                                <td style="vertical-align: middle; width: 90px;">
                                    @if ($flavor == 'filtros')
                                        <img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/filtros_logo.png'))) }}" width="90" height="90" id="logo">
                                    @else
                                        <img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/retenes_logo.png'))) }}" width="90" height="90" id="logo">
                                    @endif
                                </td>
                                <td style="vertical-align: middle; padding-left: 8px;">
                                    <h1 class="company-name">@if ($flavor == 'filtros') INDUSTRIAS @endif WILLY BUSCH</h1>
                                    <h2 class="company-ruc">
                                        @if ($flavor == 'filtros') 20100675537 @else 20100674301 @endif
                                    </h2>
                                    <p class="company-info">@if ($flavor == 'filtros') Av. Santa Maria 135 Urb. Industrial - Ate - Lima- Perú @else CALLE SANTA LUCIA 170 Ate - Lima - Perú @endif</p>
                                    <p class="company-info">@if ($flavor == 'filtros') filtros@filtroswillybusch.com.pe @else retenes@willybusch.com.pe @endif</p>
                                    <p class="company-info">@if ($flavor == 'filtros') www.filtroswillybusch.com.pe @else www.willybusch.com.pe @endif</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- ── DATOS DEL CLIENTE ── --}}
            <table style="border-bottom: 1px solid #0766ab; margin-top: 16px;">
                <tr>
                    <td style="padding-bottom: 4px; vertical-align: middle;">
                        <h1 class="stitle">DATOS DEL CLIENTE</h1>
                    </td>
                    <td style="padding-bottom: 4px; vertical-align: middle; text-align: right;">
                        <p class="sdate">FECHA DE PEDIDO: {{ $fecha }}</p>
                    </td>
                </tr>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td class="fl">RUC:</td>
                        <td class="fv">{{ $ruc }}</td>
                    </tr>
                    <tr>
                        <td class="fl">CLIENTE:</td>
                        <td class="fv">{{ $cliente }}</td>
                    </tr>
                    <tr>
                        <td class="fl">DIRECCIÓN:</td>
                        <td class="fv">{{ $direccion }} - {{ $localidad }}</td>
                    </tr>
                    <tr>
                        <td class="fl">CORREO:</td>
                        <td class="fv">{{ $email }}</td>
                    </tr>
                    <tr>
                        <td class="fl">CORREO 2:</td>
                        <td class="fv">{{ $email }}</td>
                    </tr>
                    <tr>
                        <td class="fl">TELEFONO:</td>
                        <td class="fv">{{ $telefono_1 }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- ── DATOS ADICIONALES ── --}}
            <div class="sep-sm">
                <h1 class="stitle">DATOS ADICIONALES</h1>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td class="fl">COND. PAGO:</td>
                        <td class="fv">{{ $condicion }}</td>
                    </tr>
                    <tr>
                        <td class="fl">TRANSPORTE:</td>
                        <td class="fv">{{ $transporte }} - {{ $nametrans }}</td>
                    </tr>
                    <tr>
                        <td class="fl">OBSERVACIÓN:</td>
                        <td class="fv">{{ $observaciones }}</td>
                    </tr>
                    <tr>
                        <td class="fl">FECHA DESP.:</td>
                        <td class="fv"></td>
                    </tr>
                </tbody>
            </table>

            {{-- ── Products per vendor ── --}}
            @foreach ($articulos as $key => $value)
                <h1 class="vendor-h">COD. VENDEDOR: {{ $key }}</h1>
                <table class="ptable">
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
                    <thead class="phead">
                        <tr>
                            <th class="pc">CÓDIGO</th>
                            <th class="pc">CANTIDAD</th>
                            <th class="pc">DESCRIPCIÓN</th>
                            <th class="pc">MEDIDAS INT-EXT-ALT</th>
                            <th class="pc">ESTADO</th>
                            <th class="pc">PRECIO UNITARIO</th>
                            <th class="pc">DESCUENTO</th>
                            <th class="pc">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="pbody">
                        @foreach ($value as $v)
                            @if ($v['MCODDFA'] != 'Bono')
                                <tr>
                                    <td class="pc-c">{{ $v['MCODART'] }}</td>
                                    <td class="pc-c">{{ $v['MCANTIDAD'] }}</td>
                                    <td class="pc-l">{{ $v['MDESCRI01'] }}</td>
                                    <td class="pc-c">{{ $v['articulo']['MDIM_INT1'] }}-{{ $v['articulo']['MDIM_EXT1'] }}-{{ $v['articulo']['MDIM_ALT1'] }}</td>
                                    <td class="pc-c">{{ $v['item_state'] }}</td>
                                    <td class="pc-c">{{ number_format($v['MPRECIO'], 2, '.', '') }}</td>
                                    <td class="pc-c">{{ $v['descrip'] }}</td>
                                    <td class="pc-c">{{ number_format($v['precio_neto'], 2, '.', '') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="pc-c">{{ $v['MCODART'] }}</td>
                                    <td class="pc-c">{{ $v['MCANTIDAD'] }}</td>
                                    <td class="pc-l">{{ $v['MDESCRI01'] }}</td>
                                    <td class="pc-c">{{ $v['articulo']['MDIM_INT1'] }}-{{ $v['articulo']['MDIM_EXT1'] }}-{{ $v['articulo']['MDIM_ALT1'] }}</td>
                                    <td class="pc-c">{{ $v['item_state'] }}</td>
                                    <td class="pc-c">0.00</td>
                                    <td class="pc-c"></td>
                                    <td class="pc-c">0.00</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="5"></td>
                            <td class="st-label" colspan="2">SUBTOTAL</td>
                            <td class="st-value">@if ($flavor == 'filtros') S/ @else $ @endif {{ number_format( array_reduce( $value, function($carry, $p) { return $carry + $p['precio_neto']; }), 2, '.', '' ) }}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach

            {{-- ── Conditions + Totals ── --}}
            <table>
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <div class="sep">
                            <h1 class="stitle-sm">CONDICIONES DE VENTA</h1>
                        </div>
                        <ul class="cond-list">
                            <li><span class="accent">Moneda:</span> @if ($flavor == 'filtros') PEN @else USD (Dólares estadounidenses) @endif</li>
                            <li><span class="accent">Precios:</span> Los precios indicados incluyen IGV</li>
                            <li><span class="accent">Entrega:</span> Según fecha coordinada</li>
                            <li><span class="accent">Tiempo de validez:</span> 15 días después de la fecha de emisión o fin de campaña</li>
                        </ul>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-top: 16px;">
                        <table class="ttable">
                            <tbody>
                                <tr>
                                    <td class="tl">TOTAL ATENDIDOS:</td>
                                    <td class="tv">@if ($flavor == 'filtros') S/ @else $ @endif {{ number_format($total_atendido, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="tl">TOTAL PENDIENTES:</td>
                                    <td class="tv">@if ($flavor == 'filtros') S/ @else $ @endif {{ number_format($total_pendiente, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="tl">TOTAL ANULADO:</td>
                                    <td class="tv">@if ($flavor == 'filtros') S/ @else $ @endif {{ number_format($total_anulado, 2, '.', '') }}</td>
                                </tr>
                                <tr class="tf">
                                    <td class="tl" style="color: #ffffff;">TOTAL A PAGAR:</td>
                                    <td class="tv" style="color: #ffffff;">
                                        @if ($flavor == 'filtros') S/ @else $ @endif
                                        @if ($total_atendido + $total_pendiente + $total_anulado == 0)
                                            {{ number_format($total, 2, '.', '') }}
                                        @else
                                            {{ number_format($total_atendido, 2, '.', '') }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- ── Instalments ── --}}
            @if ($total_instalments > 0)
                <div style="width: 50%;" class="sep">
                    <h1 class="stitle-sm">VENCIMIENTO: {{ $total_instalments }} CUOTA(S)</h1>
                </div>
                <table>
                    <tbody>
                        <tr>
                            @foreach ($instalments as $inst)
                                <td class="inst-cell">
                                    @foreach ($inst as $i)
                                        <p>{{ $i->date }}: @if ($flavor == 'filtros') S/ @else $ @endif {{ $i->amount }}</p>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @endif

        </div>
    </body>
</html>
