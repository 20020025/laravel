<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body class="background">

    <div class="container mt-5">
        <h1 style="color: violet">Welcome, {{Auth::user()->name}}</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group my-3">
                            <li class="list-group-item active">MAIN MENU</li>
                            <a href="{{ route('buku.index') }}" class="list-group-item">Dashboard</a>
                            <a href="{{ route('profile.index') }}" class="list-group-item">Profile</a>
                            <a href="{{ route('buku.logout') }}" class="list-group-item">Logout</a>
                        </ul>
                        <a href="{{ route('buku.create') }}" class="btn btn-md btn-success mb-3">TAMBAH DATA BUKU</a>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">GAMBAR</th>
                                <th scope="col">JUDUL</th>
                                <th scope="col">PENULIS</th>
                                <th scope="col">PENERBIT</th>
                                <th scope="col">KONTEN</th>
                                <th scope="col">OPSI</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($bukus as $buku)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ Storage::url('public/bukus/').$buku->image }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $buku->title }}</td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ $buku->penerbit }}</td>
                                    <td>{!! $buku->content !!}</td>

                                    <td class="text-center">
                                        <form onsubmit="return confirm('YAKIN MAU DI HAPUS..?');" action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-primary">UPDATE</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data buku belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{ $bukus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script>

</body>
</html>