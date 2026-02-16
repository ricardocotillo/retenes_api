<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-size:x-small; }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  }
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  }
		comment { display:none;  }
		@page {
			size: 21cm 29.7cm;
			margin: 1cm;
		}
        body {
            padding: 0;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td {
            padding: 3px 5px;
        }
		.bc { border: 1px solid #000000; }
		.bb { border: 2px solid #000000; }
		.bt2 { border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; }
		.bh { border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; }
		.bm { border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; }
		.hl { background: #FFFF00; }
	</style>

</head>

<body>
  {{-- <img src="http://willybusch.com.pe/logos/retenes_logo.png" width="121" height="97" id="logo"> --}}
  {{-- <img src="http://localhost:8080/img/wb.png" width="121" height="97" id="logo"> --}}
<table cellspacing="0" border="0">
	<tr>
		<td colspan="2" rowspan=6 height="10" align="center" valign=bottom>
			@if ($flavor == 'filtros')
				<img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/filtros_logo.png'))) }}" width="100" height="100" id="logo">
			@else
				<img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/retenes_logo.png'))) }}" width="100" height="100" id="logo">
			@endif
		</td>
		<td colspan="7" align="center" valign=bottom>
      <b>
        <font size="4">NOTA DE PEDIDO</font>
      </b>
    </td>
    <td class="bh" colspan="5" align="center" valign=bottom>
      <b>
		@if ($flavor == 'filtros')
			<font size=4>20100675537</font>
		@else
			<font size=4>20100674301</font>
		@endif
      </b>
    </td>
	</tr>
	<tr>
		<td height="10" colspan="7" align="left" valign="bottom"><b>ESTABLECIMIENTO</b></td>
		<td class="bm" colspan="3" align="center" valign="bottom"><b>Número Pedido :</b></td>
		<td class="bt2" colspan="2" align="right" valign="bottom"><b>{{$mnroped}}</b></td>
	</tr>
	<tr>
		@if ($flavor == 'filtros')
			<td height="10" colspan="7" align="left" valign="bottom"><font color="#3B3838">Av. Santa Maria 135 Urb. Industrial - Ate - Lima- Perú</font></td>
		@else
			<td height="10" colspan="7" align="left" valign="bottom"><font color="#3B3838">CALLE SANTA LUCIA 170 Ate - Lima - Perú</font></td>
		@endif
		<td class="bt2" colspan="3" align="center" valign="bottom"><b>Fecha Pedido     :</b></td>
		<td class="bt2" colspan="2" align="right" valign="bottom"><b>{{$fecha}}</b></td>
	</tr>
	<tr>
		@if ($flavor == 'filtros')
			<td height="10" colspan=7 align="left" valign=bottom>E-mail: filtros@filtroswillybusch.com.pe</td>
		@else
			<td height="10" colspan=7 align="left" valign=bottom>E-mail: retenes@willybusch.com.pe</td>
		@endif
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="10" align="center" valign=bottom><br></td>
		<td align="center" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b>R.U.C.</b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="2" width="5" valign=middle align="left" valign=bottom><b><font color="#0070C0">{{$ruc}}</font></b></td>
		<td colspan="2" align="center" valign=middle><b>Telef.:</b></td>
		<td align="left" valign=bottom><b></b></td>
		<td align="left" valign=bottom></td>
		<td align="left" valign=bottom></td>
    <td align="left" valign=bottom><b></b></td>
    <td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Cliente</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="left" valign=middle><b><font color="#2E75B6">{{$cliente}}</font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Dirección</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="left" valign=middle><b><font color="#2E75B6">{{$direccion}} - {{$localidad}}</font></b></td> {{-- JEANS 11-12-2020 --}}
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Entregar en</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="center" valign=middle><b><font color="#2E75B6"><br></font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">E-mail</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="left" valign=middle><b><font color="#2E75B6">{{$email}}</font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#FF0000">Correo  Nuevo</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="left" valign=middle><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Agencia de transp.</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="8" align="left" valign=middle><b><font color="#2E75B6">{{$transporte}} - {{$nametrans}}</font></b></td> {{-- JEANS CUBA 11-12-2020 --}}
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Condición de Pago</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="10" align="left" valign=middle><b><font color="#2E75B6">{{$condicion}}</font></b></td>
	</tr>
	<!-- <tr>
		<td colspan="2" height="10" align="left" valign=top><b><font color="#000000">Condiciones de venta</font></b></td>
		<td colspan="1" height="10" align="left" valign=top><b>:</b></td>
		<td colspan="10" align="left" valign=middle>
			@if ($flavor == 'filtros')
				<b><font color="#2E75B6">Los precios están expresado en soles S/</font></b><br>
			@else
				<b><font color="#2E75B6">Los precios están expresado en dólares americanos $</font></b><br>
			@endif
			<b><font color="#2E75B6">Validez de la Cotización: 07 días.</font></b><br>
			<b><font color="#2E75B6">Los precios incluyen IGV.</font></b>
		</td>
	</tr> -->
	@foreach ($values as $value)
		<tr>
			<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">{{ $value->label }}</font></b></td>
			<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
			<td colspan="10" align="left" valign=middle><b><font color="#2E75B6">{{ $value->value }}</font></b></td>
		</tr>
	@endforeach
	<tr>
		<td colspan="2" height="10" align="left" valign=middle><b><font color="#000000">Observaciones</font></b></td>
		<td colspan="1" height="10" align="left" valign=middle><b>:</b></td>
		<td colspan="10" align="left" valign=middle><b><font color="#2E75B6">{{$observaciones}}</font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
</table>{{-- JEANS 11-12-2020 --}}
<br>{{-- JEANS 11-12-2020 --}}
<table cellspacing="0" border="0"> {{-- JEANS 11-12-2020 --}}
	@foreach ($articulos as $key => $value)
		@if (count($value) > 0)
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="14" height="15" align="center" valign=middle bgcolor="#9DC3E6"><b>{{$key}}</b></td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" height="15" align="center" valign=middle bgcolor="#9DC3E6"><b>CODIGO WB</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign=middle bgcolor="#9DC3E6"><b>CANTIDAD</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign=middle bgcolor="#9DC3E6"><b>DESCRIPCION</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="center" valign=middle bgcolor="#9DC3E6"><b>Estado</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="center" valign=middle bgcolor="#9DC3E6"><b>Fecha Despacho</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="center" valign=middle bgcolor="#9DC3E6"><b>P. UNIT.</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" valign=middle bgcolor="#9DC3E6"><b>DESCUENTO %</b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign=middle bgcolor="#9DC3E6"><b>TOTAL</b></td>
			</tr>
			@foreach ($value as $v)
				@if ($v['MCODDFA'] != 'Bono')
				<tr @if (isset($v['estado']) && $v['estado'] == 1) style="background: #FFFF00" @endif>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign=bottom>{{ $v['MCODART'] }}</td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign=bottom sdval="10" sdnum="1033;"><b>{{ $v['MCANTIDAD'] }}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign=bottom><b>{{ $v['MDESCRI01'] }}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="left" valign=bottom><b>{{ $v['item_state'] }}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="left" valign=bottom><b>{{ $v['fecha_despacho'] }}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="1" align="right" valign=bottom sdval="144.923184" sdnum="1033;0;0.00_ ;[RED]-0.00 ">
						{{number_format($v['MPRECIO'], 2, '.', '')}}
					</td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign=bottom>{{ $v['descrip'] }}</td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="right" valign=bottom sdval="1449.23184" sdnum="1033;0;0.00_ ;[RED]-0.00 ">
						<b>
							{{number_format($v['precio_neto'], 2, '.', '')}}
						</b>
					</td>
				</tr>
				@else
				<tr @if (isset($v['estado']) && $v['estado'] == 1) style="background: #FFFF00" @endif>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="left" valign=bottom>{{$v['MCODART']}}</td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign=bottom sdval="10" sdnum="1033;"><b>{{ $v['MCANTIDAD'] }}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="left" valign=bottom><b>{{$v['MDESCRI01']}}</b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px susolid #000000; border-right: 1px solid #000000" colspan="1" align="right" valign=bottom sdval="144.923184" sdnum="1033;0;0.00_ ;[RED]-0.00 ">0.00</td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign=bottom></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="right" valign=bottom sdval="1449.23184" sdnum="1033;0;0.00_ ;[RED]-0.00 ">
						<b>
						0.00
						</b>
					</td>
				</tr>
				@endif
			@endforeach
			<tr>
    		    <td colspan=8 valign=bottom></td>
    			<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign=bottom sdnum="1033;0;@">
    				<b>SUB TOTAL</b>
    			</td>
    			<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="right" valign=bottom>
    				<b>
    					<font size=3>
							@if ($flavor == 'filtros')
								S/
							@else
								$
							@endif
							{{ number_format( array_reduce( $value, function($carry, $p) { return $carry + $p['precio_neto']; }), 2, '.', '' ) }}
						</font>
    				</b>
    			</td>
    		</tr>
		@endif
	@endforeach
	<tr>
		<td height="12" align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font size=1><br></font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
    <td colspan=2 height="20" align="center" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
    <td colspan=3 align="center" valign=bottom></td>
    <td align="left" valign=bottom><br></td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign=bottom sdnum="1033;0;@">
      <b>TOTAL ATENDIDO</b>
    </td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="right" valign=bottom>
      <b>{{ number_format($total_atendido, 2, '.', '') }}</b>
    </td>
  </tr>
  <tr>
    <td colspan=2 height="20" align="center" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
    <td colspan=3 align="center" valign=bottom></td>
    <td align="left" valign=bottom><br></td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign=bottom sdnum="1033;0;@">
      <b>TOTAL PENDIENTE</b>
    </td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="right" valign=bottom>
      <b>{{ number_format($total_pendiente, 2, '.', '') }}</b>
    </td>
  </tr>
  <tr>
    <td colspan=2 height="20" align="center" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
    <td colspan=3 align="center" valign=bottom></td>
    <td align="left" valign=bottom><br></td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign=bottom sdnum="1033;0;@">
      <b>TOTAL ANULADO</b>
    </td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="right" valign=bottom>
      <b>{{ number_format($total_anulado, 2, '.', '') }}</b>
    </td>
  </tr>
  <tr>
    <td colspan=2 height="20" align="center" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
    <td colspan=3 align="center" valign=bottom></td>
    <td align="left" valign=bottom><br></td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign=bottom sdnum="1033;0;@">
      <b>TOTAL A PAGAR</b>
    </td>
    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="right" valign=bottom>
      <b>
        <font size=3>
			@if ($flavor == 'filtros')
				S/
			@else
				$
			@endif
			@if ($total_atendido + $total_pendiente + $total_anulado == 0)
				{{ number_format($total, 2, '.', '') }}
			@else
				{{ number_format($total_atendido, 2, '.', '') }}
			@endif
		</font>
      </b>
    </td>
	</tr>
	<tr>
		<td style="border-top: 2px solid #000000" colspan=2 height="17" align="center" valign=bottom><b> {{ $flavor == 'filtros' ? 'I.' : '' }}W.B.</b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom bgcolor="#FFFFFF"><font color="#FFFFFF"><br></font></td>
	</tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  @if (count($instalments) > 0)
    <tr>
      <td colspan="2" align="left" valign=middle><b>Vencimientos: {{ array_sum(array_map(fn($a): int => count($a), $instalments)) }} cuota(s)</b></td>
    </tr>
	<tr>
		@foreach ($instalments as $inst)
			<td colspan="4" valign="top">
				@foreach ($inst as $i)
					<p><strong>{{ $i->date }}: </strong> @if ($flavor == 'filtros') S/ @else $ @endif {{ $i->amount }}</p>
				@endforeach
			</td>
		@endforeach
    </tr>
  @endif
</table>
<!-- ************************************************************************** -->
</body>

</html>
