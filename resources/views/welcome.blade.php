<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    {{-- BOotstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    
    @vite('resources/js/app.js')
</head>
<body>
    {{-- form and table for image file and content --}}
    <div class="container mt-5">
        @auth
            <div class="alert alert-info" role="alert">
                You have <span id="message-count">{{ $chats->count() }}</span> messages.
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('chat.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="image_path">
                                @error('image_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- FILE --}}
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="file" name="path_file">
                                @error('path_file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <form action="{{ route('chat.storePrivate') }}" method="post" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <div class="form-group row">
                            <label for="receiver_id" class="col-sm-2 col-form-label">Receiver</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="receiver_id" name="receiver_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('receiver_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="image_path">
                                @error('image_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- FILE --}}
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="file" name="path_file">
                                @error('path_file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Private Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">File</th>
                                <th scope="col">Content</th>
                            </tr>
                        </thead>
                        <tbody id="messages">
                            @foreach ($chats as $chat)
                                <tr>
                                    <td>
                                        @if ($chat->image_path)
                                            <img src="{{ asset('storage/' . $chat->image_path) }}" alt="Uploaded Image" style="width: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        @if ($chat->path_file)
                                            <a href="{{ asset('storage/' . $chat->path_file) }}" target="_blank" download>
                                                <i class="fas fa-file-download"></i> Download File
                                            </a>
                                        @else
                                            No File
                                        @endif
                                    </td>
                                    <td>{{ $chat->content }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                Please log in to view and send messages.
            </div>
        @endauth
    </div>
</body>
</html>