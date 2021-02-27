<table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>Particulars</th>
                           
                        <th>Type of Room </th>
                            <th>Rent/Day</th>
                            <th>Tax</th>
                            <th>No of Days</th>
                            <th>No of Rooms/Persons</th>
                            <th>Total amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total_amount=0)
                        @foreach($rents as $key=>$r)
                        <tr>
                        <td>Room Rent</td>
                        <td>{{ $r['room_type'] }}</td>
                            <td>{{ $r['room_rent'] }}</td>
                            <td>{{ round($r['tax_percentage'] * $r['room_rent'] /100,0) }} ({{ $r['tax_percentage'] }}%)</td>
                            <td>{{ $no_of_days }}</td>
                            <td>{{ $r['no_of_rooms'] }}</td>

                            @if($is_rent_payable==1)
                            @php($total_sub_amount=  ( $r['room_rent'] + round($r['tax_percentage'] * $r['room_rent'] /100,0) ) * $no_of_days * $r['no_of_rooms']   )
                            <td class="text-right">{{ $total_sub_amount }}</td>
                            @php($total_amount=$total_amount + $total_sub_amount)
                            @else 
                            <td class="text-right">0</td>
                            @endif 
                          

                        <input type="hidden" name="room_type_id[]" value="{{ $r['room_type_id'] }}" />
                        <input type="hidden" name="room_rent[]" value="{{ $r['room_rent'] }}" />
                        <input type="hidden" name="room_tax_percentage[]" value="{{ $r['tax_percentage'] }}" />
                        <input type="hidden" name="room_nos[]" value="{{ $r['no_of_rooms'] }}" />
                        <input type="hidden" name="room_extra_beds[]" value="0" />
                        <input type="hidden" name="room_extra_bed_amount[]" value="{{ $r['charges_extrabed'] }}" />
                      



                            </tr>
                        

                        @endforeach 

                        @if($food_amount!=0)

                        <tr>
                        <td>Food amount</td>
                        <td></td>
                            <td>{{ $food_amount }}</td>
                        <td>{{ round($food_amount* ($food_tax/100),0) }} ({{ $food_tax }}%)</td>
                            <td>{{ $food_no_of_days }}</td>
                            <td>{{ $no_of_persons }}</td>

                            @php($total_sub_amount=  ( $food_amount + round($food_amount*($food_tax/100),0) ) * $food_no_of_days * $no_of_persons   )

                            <td class="text-right">{{ $total_sub_amount }}</td>
                            @php($total_amount=$total_amount + $total_sub_amount)
                          
                            </tr>


                        @endif 

                        <tr>
                            <th colspan="6">Total Amount </th>
                            <th class="text-right">{{ $total_amount }}</th>
                        </tr>
                    </tbody>
</table>

* Food Charges not added for Sunday, CheckIn after 9.00 PM and Checkout before 1.00 PM



<input type="hidden" name="no_of_days" value="{{ $no_of_days }}" />
                     

