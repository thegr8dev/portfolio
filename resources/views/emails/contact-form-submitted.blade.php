<x-mail::message>
# New Contact Form Submission

We have received a new contact form submission with the following details:

**Ticket ID:** {{ $inquiry->ticket_id }}  
**Name:** {{ $inquiry->full_name }}  
**Email:** {{ $inquiry->email }}  
**Subject:** {{ $inquiry->subject }}  
**Status:** {{ $inquiry->status->value }}  
**Submitted:** {{ $inquiry->created_at->format('F j, Y \a\t g:i A') }}

## Message

{{ $inquiry->message }}

---

This is an automated notification. Please do not reply to this email directly. If you need to respond to this inquiry, please use the ticket ID {{ $inquiry->ticket_id }} for reference.

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
