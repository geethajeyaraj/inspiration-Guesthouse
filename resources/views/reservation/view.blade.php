<div class="modal-dialog modal-lg" role="document" id="ajax-container">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Reservation Details</h5>
            <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>
        </div>
        <div class="modal-body">

            <div class="table-reponsive">

                <table class="table table-bordered mb-2">
                    <tr>
                        <th colspan=4>CheckIn Details</th>
                    </tr>
                    <tr>
                        <th>CheckIn Date</th>
                        <th>Checkout Date</th>
                        <th>Reserved By</th>
                 
                    </tr>
                    <tr>
                        <td>{{ viewDatewithTime($reservations->checkin_date) }}</td>
                        <td>{{ viewDatewithTime($reservations->checkout_date) }}</td>
                        <td>{{ $reservations->display_name }} <br> <i class="la la-phone"></i> {{ $reservations->mobile_no }} <br> <i class="la la-envelope"></i> {{ $reservations->email }} </td>
                 


                    </tr>
                </table>
                <table class="table table-bordered mb-2">
                    <tr>
                        <th>Program Purpose</th><td>{{ $reservations->program_purpose }}</td>
                        <th>Organisation</th><td>{{ $reservations->organization }}</td>
                        
                    </tr>
                    <tr>
                        <th>Contact Person</th><td>{{ $reservations->contact_person }}</td>
                        <th>Contact Email / Phone</th><td>{{ $reservations->contact_person_email }} / {{ $reservations->contact_person_mobileno }}</td>
                        
                    </tr>

                </table>


                <table class="table table-bordered mb-2">
                    <tr>
                        <th colspan=9>Guest Details</th>
                    </tr>
                    <tr>
                    <th>Room type</th>
                    <th>Payment Mode</th>
                    <th>Meal Needed</th>
                       
                        <th>Guest Name</th>
                        <th>Mobile No</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Id Proof</th>
                        <th>Id Proof No</th>
                    </tr>

                    @foreach($reservation_guests as $r)
                    <tr>
                    <td>{{ $r->room_type }}</td>
                    <td>{{ $r->payment_details }}</td>
                    <td>{{ $r->meal_needed ? 'Yes' : 'No' }}</td>
                       
                    <td>{{ $r->display_name }}</td>
                        <td>{{ $r->mobile_no }}</td>
                        <td>{{ $r->gender }} </td>
                        <td>{{ $r->nationality }}</td>
                        <td>{{ $r->id_proof }}</td>
                        <td>{{ $r->id_proof_no }}</td>
                    </tr>
                    @endforeach
                </table>


            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-clean pull-left ajax-close">Close</button>
        </div>
    </div>
</div>