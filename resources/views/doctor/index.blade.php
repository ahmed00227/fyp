<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .chat-content {
            flex-grow: 1;
            padding-right: 1rem;
        }
        .chat-title {
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        .chat-meta {
            font-size: 0.875rem;
            color: gray;
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

<!-- Main Container -->
<div class="container mt-4">
    <!-- Example Card -->
    @foreach($chats as $chat)
        @php $message = $chat->messages()->latest()->first(); @endphp
    <div class="chat-card">
        <div class="chat-content">
            <div class="chat-title">{{ucwords($message?->user!=auth()->user()? $message?->user->name : $chat->user1->name)}}</div>
            <div class="chat-meta">{{$message?->message}} • {{$message?->created_at->format('H:i A')}}</div>
        </div>
        <a class="btn btn-primary" href="{{route('chat',$chat->id)}}">Chat</a>
    </div>
    @endforeach
    @if(count($chats)==0)
        <div class="chat-card">
            <div class="chat-content">
                <div class="chat-title">You have no Chats</div>
            </div>
        </div>
    @endif
    <!-- Add more chat cards as needed -->
</div>
</body>
</html>
