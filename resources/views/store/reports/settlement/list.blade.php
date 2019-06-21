<table class="table display nowrap dataTable">
    <thead>
      <tr>
        <th>Revenue</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Laundary Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$A}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Dry Clean Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$B}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Other Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$C}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Total</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$A+$B+$C}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000"><br></font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Collection</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Cash</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$D}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Online</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$E}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Total</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{ $D+$E}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000"><br></font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Franchisee Share in Revenue</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Laundry Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{round($shares->where('type', 1)->first()->percent * $A/100, 2) }} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Dry Cleaning Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{round($shares->where('type', 2)->first()->percent * $B/100, 2) }} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Other Services</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{round($shares->where('type', 3)->first()->percent * $C/100, 2) }} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Total</font></td>
          @php
            $K =  round($shares->where('type', 1)->first()->percent * $A/100, 2) +
            round($shares->where('type', 2)->first()->percent * $B/100, 2) +
            round($shares->where('type', 3)->first()->percent * $C/100, 2)
          @endphp
          <td align="left" valign="bottom"><font color="#000000">{{
           $K
          }} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000"><br></font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Billing</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        
        @foreach($items as $item)
          <tr>
            <td height="19" align="left" valign="bottom"><font color="#000000">{{ $item->name}}</font></td>
            <td align="left" valign="bottom"><font color="#000000"> @if($payments->count() && $payments->where('order_id', $item->id)) 
                {{$payments->where('order_id', $item->id)->first()->price}}
            Rs @else 0 Rs @endif</font></td>
          </tr>
        @endforeach
       
          <td height="19" align="left" valign="bottom"><font color="#000000">Gross Billing</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$total_billing}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">CGST</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$total_billing*$cgst/100}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">GST</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$total_billing*$gst/100}} Rs</font></td>
        </tr>
       <!--  <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">IGST</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr> -->
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Net Billing</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$total_billing+ ($total_billing*$cgst/100)+ ($total_billing*$gst/100) }} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000"><br></font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Franchisee payment</font></td>
          @php
            $R = (round($shares->where('type', 1)->first()->percent * $A/100, 2) +
             round($shares->where('type', 2)->first()->percent * $B/100, 2) +
             round($shares->where('type', 3)->first()->percent * $C/100, 2)) -
             ($total_billing+ ($total_billing*$cgst/100)+ ($total_billing*$gst/100))
          @endphp
          <td align="left" valign="bottom"><font color="#000000">{{ 
            $R
             }} 
           Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Payable amount to Franchisee/Amount to be collected from Franchisee</font></td>
          <td align="left" valign="bottom"><font color="#000000">{{$R-$D}} Rs</font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Carry Forward from previous Statement</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
        <tr>
          <td height="19" align="left" valign="bottom"><font color="#000000">Net outstanding amount for Franchisee/ to be collected from Franchisee</font></td>
          <td align="left" valign="bottom"><font color="#000000"><br></font></td>
        </tr>
    </tbody>
</table>
