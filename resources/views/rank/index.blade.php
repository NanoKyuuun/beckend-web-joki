<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Submit Information</h2>
    <form id="infoForm">
        <label for="game">Game</label>
        <select name="game_id" id="game">
            <option value="" selected>Select Game</option>
            @foreach ($game as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select><br><br>
        <label for="name">name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="harga">harga:</label>
        <input type="text" id="harga" name="harga"><br><br>

        <button type="submit">Submit</button>
    </form>
    <h2>Data Table</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>game</th>
                <th>name</th>
                <th>harga</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->game->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>
                        <a href="/rank/{{ $item->id }}/edit"> edit</a>
                        <a data-id="{{ $item->id }}" class="btn btn-danger btn-hapus">hapus</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#infoForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/api/rank',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Form submitted successfully!');
                        console.log(response);
                    },
                    error: function(xhr) {
                        alert('An error occurred!');
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        $(document).on('click', '.btn-hapus', function() {
            const id = $(this).data('id')
            const token = localStorage.getItem('token')

            confirm_dialog = confirm('Apakah anda yakin?');

            if (confirm_dialog) {
                $.ajax({
                    url: '/api/rank/' + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(response) {
                        alert('Form submitted successfully!');
                        console.log(response);
                    },
                });
            }
        });
    </script>
    </script>
</body>

</html>
