<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</head>

<body>

    <div class="container">
        <div class="post" style="margin-top: 20px">
            <a href="" id="btn-add" class="btn btn-sm btn-primary">Add</a>
        </div>
        <div class="table">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="post-list" name="post-list">
                    @foreach ($posts as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>ADD</h3>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save
                            </button>
                            <input type="hidden" id="todo_id" name="todo_id" value="0">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-add').click(function(e) {
                e.preventDefault();
                $('#myModal').modal('show');
            });
            $('#btn-save').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                };
                var state = $('#btn-save').val();
                var type = 'POST';
                var ajaxUrl = "{{ route('store') }}";
                var todo_id = $('#todo_id').val();
                $.ajax({
                    type: type,
                    url: ajaxUrl,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        var post = '<tr id="todo' + response.id + '"><td>' + response.id + '</td><td>' +
                            response.name + '</td><td>' + response.description + '</td><td>' + response.slug + '</td>';
                            post += '<td><button class="btn btn-sm btn-warning edit-modal" value="' + response
                            .id + '">Edit</button>&nbsp;';
                            post += '<button class="btn btn-sm btn-danger delete-todo" value="' + response.id +
                            '">Delete</button></td></tr>';
                        if (state == "add") {
                            $('#post-list').append(post);
                        } else {
                            $("#todo" + todo_id).replaceWith(todo);
                        }
                        $('#myForm').trigger("reset");
                        $('#myModal').modal('hide')
                    }
                });
            });
        });
    </script>
</body>

</html>
