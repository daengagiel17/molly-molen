@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
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
                <h3 class="card-title">List of Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  @foreach ($orders as $order)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$order->customer->name}}</td>
                      <td>{{$order->customer->no_phone}}</td>
                      <td>
                        @if ($order->status == "wait")
                          <a href="" class="btn btn-sm btn-danger"><i class="fa fa-clock"></i> Wait</a>                          
                        @elseif($order->status == "send")
                          <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Send</a>                                                      
                        @else
                          <a href="" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> Finish</a>                          
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('order.show', ['id' => $order->id]) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                        @if ($order->status == "wait")
                          <a class="btn btn-sm btn-primary" href="{{ route('order.update', ['id' => $order->id]) }}"
                              onclick="event.preventDefault();
                                            document.getElementById('update-form-{{$order->id}}').submit();">
                              <i class="fa fa-paper-plane"></i>
                              Send
                          </a>
                          <form id="update-form-{{$order->id}}" action="{{ route('order.update', ['id' => $order->id]) }}" method="POST" style="display: none;">
                              @csrf @method('PUT')
                          </form>
                        @elseif($order->status == "send")
                          <a class="btn btn-sm btn-success" href="{{ route('order.update', ['id' => $order->id]) }}"
                              onclick="event.preventDefault();
                                            document.getElementById('update-form-{{$order->id}}').submit();">
                              <i class="fa fa-check-circle"></i>
                              Finish
                          </a>
                          <form id="update-form-{{$order->id}}" action="{{ route('order.update', ['id' => $order->id]) }}" method="POST" style="display: none;">
                              @csrf @method('PUT')
                          </form>
                        @endif
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