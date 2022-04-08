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

<h2 style="text-align: center">User Table - Dukcapil</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
    </tr>
    @foreach ($users as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->roles->name }}</td>
            <td>{{ $item->status == '1' ? 'Active' : 'Non-Active' }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>

