@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Order Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <a href="{{ route('order.index') }}" class="btn btn-sm btn-danger">Back</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tr>
                    <th>#</th>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Jumlah</th>
                  </tr>
                  @foreach ($order->menu as $menu)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$menu->name}}</td>
                      <td>{{$menu->pivot->qty}}</td>
                      <td>{{$menu->price * $menu->pivot->qty}}</td>
                    </tr>                      
                  @endforeach
                  <tr>
                    <td colspan="3">Total</td>
                    <td>{{$order->total}}</td>
                  </tr>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-4">
            <!-- Customer Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{$order->customer->name}}</h3>

                <p class="text-muted text-center">{{$order->customer->no_phone}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Alamat</b> <a class="float-right">{{$order->customer->alamat}}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection