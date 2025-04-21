<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Window</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-window {
            height: 80vh;
            display: flex;
            flex-direction: column;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .chat-header {
            background-color: #f8f9fa;
            padding: 1rem;
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
        }

        .chat-body {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            background-color: #ffffff;
        }

        .chat-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .chat-footer input {
            width: 100%;
            border-radius: 1.5rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-md-5 px-2">
    <img src="/images/images-removebg-preview.png" alt="" height="60px" width="60px">
    <div class="ms-auto">
        <a href="{{route('logout')}}" class="nav-link">Logout</a>
    </div>
</nav>

<!-- Chat Window -->
<div class="container mt-4">
    <div class="chat-window">
        <div class="chat-header d-flex justify-content-between">
            <div>
                {{ucwords($chat->user1->name)}}
            </div>
            <div>
                <a href="{{route('doctor.dashboard')}}" class="text-black" style="text-decoration: none">Back</a>
            </div>
        </div>

        <div class="chat-body" id="chatCard">
            @foreach($chat->messages as $message)
                <div class="mb-2"><strong>{{$message->user_id==auth()->id()? 'You': ucwords($message->user->name)}}
                        :</strong>
                    {{$message->message}}</div>
            @endforeach
            <!-- More messages here -->
        </div>
        <div class="chat-footer">
            <form class="d-flex">
                <input type="text" name="message" class="form-control me-2" placeholder="Type your message...">
                <button class="btn btn-primary" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('form').on('submit', function (e) {
        e.preventDefault();

        let message = $('input[name="message"]').val().trim();
        if (!message) return;
        $.ajax({
            url: '{{ route("chat.send", ["id" => $chat->id]) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message,
                chat_id: {{$chat->id}}

            },
            success: function () {
                $('input[name="message"]').val('');
            },
            error: function (xhr) {
                alert('Message failed to send!');
            }
        });
    });
</script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    var card = document.getElementById('chatCard');
    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
    });
    var channel = pusher.subscribe('Chat-' + '{{$chat->id}}');
    channel.bind('chat', function (data) {
        if (data.sender.id ==@json(auth()->id())) {
            var message = `<div class="mb-2"><strong>You:</strong>
                ${data.message.message}</div>`;
        } else {
            var message = `<div class="mb-2"><strong>${data.sender.name}:</strong>
                ${data.message.message}</div>`;
        }
        card.innerHTML+= message;
        card.scrollTop=card.scrollHeight;
    });
    card.scrollTop=card.scrollHeight;
</script>
</body>
</html>
