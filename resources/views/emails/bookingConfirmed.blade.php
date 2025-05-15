<x-mail::message>
# Booking Confirmed!

Thank you for booking with us. Your booking has been successfully confirmed.

## Booking Details:
- **Train Name**: {{ $booking['train_name'] }}
- **Departure**: {{ $booking['departure'] }}
- **Destination**: {{ $booking['destination'] }}
- **Date**: {{ $booking['date'] }}
- **Time**: {{ $booking['time'] }}
- **Class**: {{ $booking['class'] }}
- **Cost**: Rs.{{ $booking['cost'] }}


Thanks,<br>
{{ "Sri Lankan Railway" }}
</x-mail::message>
