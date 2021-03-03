@extends('layouts.display')

@section('content')
    <div class="container-fluid row row-cols-2 display-4 text-white text-center">
        <div class="w-50">
            <span class="text-success">
                In progress
            </span>
        </div>
        <div class="w-50">
            <span class="text-warning">
                Upcoming
            </span>
        </div>
    </div>
    <div class="container-fluid row row-cols-2">
        <table class="table table-dark w-50">
            <thead>
            <tr>
                <th class="display-4" scope="col">Code</th>
                <th class="display-4" scope="col">Room</th>
            </tr>
            </thead>
            <tbody id="inProgressReservations">
            <tr>
                <td class="h3">
                    Loading...
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-dark w-50">
            <thead>
            <tr>
                <th class="display-2" scope="col">Code</th>
                <th class="display-2" scope="col">Room</th>
            </tr>
            </thead>
            <tbody id="receivedReservations">
            <tr>
                <td class="h3">
                    Loading...
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function(){
            setInterval(function(){
                $.ajax({
                    url:'/display',
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                        $('#receivedReservations').empty();
                        if(response.reservationsReceived.length>0){
                            var reservations ='';
                            for(var i=0;i<response.reservationsReceived.length;i++){
                                reservations=reservations+'<tr class="display-3"><li>'+response.reservationsReceived[i].id+'-'+response.reservationsReceived[i].user.room+'-'+response.reservationsReceived[i].status+'</li>';
                                reservations += '<th scope="row">' + response.reservationsReceived[i].id + '</th>'+
                                    '<td>' + response.reservationsReceived[i].room + '</td></tr>';
                            }
                            $('#receivedReservations').append(reservations);
                        }
                        $('#inProgressReservations').empty();
                        if(response.reservationsInProgress.length>0){
                            var reservations ='';
                            for(var i=0;i<response.reservationsInProgress.length;i++){
                                reservations=reservations+'<tr class="h1"><li>'+response.reservationsInProgress[i].id+'-'+response.reservationsInProgress[i].user.room+'-'+response.reservationsInProgress[i].status+'</li>';
                                reservations += '<th scope="row">' + response.reservationsInProgress[i].id + '</th>'+
                                    '<td>' + response.reservationsInProgress[i].room + '</td></tr>';
                            }
                            $('#inProgressReservations').append(reservations);
                        }
                    },error:function(err){
                        $('#receivedReservations').empty();
                        $('#receivedReservations').append('<tr><td class="text-danger h3"> Could not retrieve data.</td></tr>');
                    }
                })
            }, 5000);
        });
    </script>
@endsection
