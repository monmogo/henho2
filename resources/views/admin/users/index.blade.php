@extends('layouts.admin')

@section('content')
<h1>Quản lý Người Dùng</h1>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm Người Dùng</a> class="btn btn-primary">Thêm Người Dùng</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Ảnh đại diện</th>
            <th>Điểm số</th>
            <th>Điểm tin cậy</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                     width="50" height="50">
            </td>
            <td>{{ $user->score }}</td>
            <td>{{ $user->trust_score }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Sửa</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
