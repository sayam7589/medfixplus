<!DOCTYPE html>
<html>
<head>
    <title>Create Medfix</title>
</head>
<body>
    <h1>Create Medfix</h1>
    <form action="{{ route('medfix.store') }}" method="POST">
        @csrf
        <!-- ใส่ฟิลด์ที่ต้องการที่นี่ -->
        <button type="submit">Save</button>
    </form>
</body>
</html>
