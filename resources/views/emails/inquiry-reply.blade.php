@component('mail::message')
# Reply to Your Inquiry

Hello {{ $inquiry->first_name }} {{ $inquiry->last_name }},

Thank you for contacting us. We have received your inquiry and are pleased to provide you with the following response:

**Ticket ID:** {{ $inquiry->ticket_id }}  
**Subject:** {{ $inquiry->subject }}

## Our Response

{{ $reply->message }}

---

If you have any further questions or concerns, please don't hesitate to contact us by replying to this email.

Best regards,  
{{ config('app.name') }} Support Team

@component('mail::subcopy')
This is a response to your inquiry submitted on {{ $inquiry->created_at->format('M d, Y') }}. 
Your ticket ID is {{ $inquiry->ticket_id }} for future reference.
@endcomponent
@endcomponent