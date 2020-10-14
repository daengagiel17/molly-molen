@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Menu</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Menu</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Menu</h3>
                <div class="card-tools">
                  <a href="{{ route('menu.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Create</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  @foreach ($menus as $menu)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>
                        <img src="{{ asset($menu->image) }}" alt="" width="80">
                      </td>
                      <td>{{$menu->name}}</td>
                      <td>{{$menu->price}}</td>
                      <td>
                        <a href="{{ route('menu.show', ['id' => $menu->id]) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('menu.edit', ['id' => $menu->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="{{ route('menu.destroy', ['id' => $menu->id]) }}"
                            onclick="event.preventDefault();
                                          document.getElementById('destroy-form-{{$menu->id}}').submit();">
                            <i class="fas fa-trash"></i>
                        </a>
                        <form id="destroy-form-{{$menu->id}}" action="{{ route('menu.destroy', ['id' => $menu->id]) }}" method="POST" style="display: none;">
                            @csrf @method('DELETE')
                        </form>
                      </td>
                    </tr>                      
                  @endforeach
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection