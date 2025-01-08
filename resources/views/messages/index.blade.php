<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap with cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- form and table for messages and file and image -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('messages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-5">
                        <label for="message">Message</label>
                        <input type="text" name="content" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="file">File</label>
                        <input type="file" name="file_path" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="image">Image</label>
                        <input type="file" name="image_path" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>File</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->content }}</td>
                                <td>
                                    @if($message->file_path)
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">Download</a>
                                    @endif
                                </td>
                                <td>
                                    @if($message->image_path)
                                        <img src="{{ asset('storage/' . $message->image_path) }}" alt="image" style="width: 100px;">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap with cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>