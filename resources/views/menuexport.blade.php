<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
</head>
<body>

<h2 style="text-align: center">Portal Tableau - Dukcapil</h2>

<table>
    <tr>
        {{-- <th>No</th> --}}
        <th>Name</th>
        <th>Site</th>
        <th>Roles</th>
        <th>Hide</th>
        <th>Number</th>
    </tr>
    @foreach ($menus as $item)
        <tr>
            {{-- <td>Number</td> --}}
            <td>{{ $item->name }}</td>
            <td>{{ $item->site_id == 0 ? '-' : $item->site_id }}</td>
            <td>
                @foreach ($item->roles as $roles)
                    {{ $roles->name }},
                @endforeach
            </td>
            <td>{{ $item->hide == 0 ? 'Tampilkan' : 'Sembunyikan' }}</td>
            <td>{{ $item->no }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>

