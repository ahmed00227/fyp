<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Window</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        .chat-window {
            height: 80vh;
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            transition: transform 0.3s ease;
        }

        .chat-window:hover {
            transform: translateY(-5px);
        }

        .chat-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .chat-header a:hover {
            opacity: 0.8;
        }

        .chat-body {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .chat-body::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #6a11cb;
            border-radius: 4px;
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.3s ease;
        }

        .message.you {
            align-items: flex-end;
        }

        .message.other {
            align-items: flex-start;
        }

        .message-content {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            font-size: 0.95rem;
            line-height: 1.4;
            position: relative;
        }

        .message.you .message-content {
            background: #6a11cb;
            color: white;
            border-bottom-right-radius: 0.2rem;
        }

        .message.other .message-content {
            background: #ffffff;
            color: #333;
            border-bottom-left-radius: 0.2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message-sender {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            color: #555;
        }

        .chat-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #dee2e6;
            background: #ffffff;
        }

        .chat-footer form {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chat-footer input {
            border: 1px solid #dee2e6;
            border-radius: 2rem;
            padding: 0.75rem 1.25rem;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .chat-footer input:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.3);
            outline: none;
        }

        .chat-footer button {
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .chat-footer button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        <div class="chat-header">
            <div>{{ucwords($chat->user1->name)}}</div>
            <div><a href="{{route('doctor.dashboard')}}">Back</a></div>
        </div>

        <div class="chat-body" id="chatCard">
            @foreach($chat->messages as $message)
                <div class="message {{ $message->user_id == auth()->id() ? 'you' : 'other' }}">
                    <div class="message-sender">{{ $message->user_id == auth()->id() ? 'You' : ucwords($message->user->name) }}</div>
                    <div class="message-content">{{ $message->message }}</div>
                </div>
            @endforeach
        </div>
        <div class="chat-footer">
            <form class="d-flex">
                <input type="text" name="message" class="form-control" placeholder="Type your message...">
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
        var messageClass = data.sender.id == @json(auth()->id()) ? 'you' : 'other';
        var message = `
            <div class="message ${messageClass}">
                <div class="message-sender">${data.sender.id == @json(auth()->id()) ? 'You' : data.sender.name}</div>
                <div class="message-content">${data.message.message}</div>
            </div>`;
        card.innerHTML += message;
        card.scrollTop = card.scrollHeight;
    });
    card.scrollTop = card.scrollHeight;
</script>
</body>
</html>
