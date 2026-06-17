    @extends('layouts.admin')
    @section('title', 'Data Karyawan')
    @section('content')
    <div class="page-header">
        <h1 class="page-title">👷 Data Karyawan</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Tambah Karyawan</a>
    </div>
    <div class="card">
        <table>
            <thead><tr><th>Nama</th><th>Username</th><th>Role</th><th>Cabang</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($employees as $e)
                <tr>
                    <td>{{ $e->name }}</td><td>{{ $e->username }}</td>
                    <td><span class="badge badge-success">{{ $e->role }}</span></td>
                    <td>{{ $e->branch->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $e) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('employees.destroy', $e) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                            @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection