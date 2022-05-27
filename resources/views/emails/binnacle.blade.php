<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <th>Register num.</th>
            <th>Parking time (min)</th>
            <th>Total to pay</th>
        </tr>
        @forelse ($balance_data as $car_balance)
        <tr>
            <td>{{$car_balance['car_registration_number']}}</td>
            <td>{{$car_balance['total_minutes']}}</td>
            <td>{{$car_balance['total_to_pay']}}</td>
        </tr>
        @empty
            <p>Nothing to show</p>
        @endforelse
    </table>
</body>
</html>