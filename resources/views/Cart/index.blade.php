@extends('layouts.home')

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <h3 style="margin-top:0px">Add Sale</h3>
    <!-- general form elements -->
    @if(session('statusSuccess'))
        <div class="box-body">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('statusSuccess') }}
            </div>
        </div>
    @elseif (session('statusFail'))
        <div class="box-body">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('statusFail') }}
            </div>
        </div>
    @endif

    <!-- form start -->
    <form role="form" method="POST" action="{{ route('Cart.store')  }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-4">
                <div class="box box-solid">
                    <div class="box-body">
                        <label>Date</label>
                        {{-- <p>{{ date('d/m/Y') }}</p> --}}
                        <p>{{ date('d/m/Y')}}</p>
                        <label>Cashier</label>
                        {{-- <p>{{ auth()->user()->name }}</p> --}}
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Barcode Number</label>
                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Enter barcode number" autofocus required >
                            @if ($errors->has('barcode'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong><i class="icon fa fa-ban"></i> Alert!</strong> &nbsp; {{ $errors->first('barcode') }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-shopping-cart"></i> ADD</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box box-solid">
                    <div class="box-body">
                        <h3>Total : <b>RM {{ Cart::subtotal() }}</b></h3>
                        <div class="box-header">
                            <a href="{{ route('Cart.create') }}" class="btn btn-success pull-right" ><i class="fa fa-money"></i> Pay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Carts</h3>
            <div class="pull-right box-tools">
                <form action="{{ route('Cart.destroy', [ 'id' => '1' ])}}" method="post" onsubmit="return confirm('Delete all cart items?')" >
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-danger" type="submit" ><i class="glyphicon glyphicon-trash"></i> CLEAR CART</button>
                </form>
            </div>
        </div>
        <!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="cart-table" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="40%">Name</th>
                        <th>Quantity</th>
                        {{-- <th>Change Qty</th> --}}
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $cart)
                        <tr>
                            <td>{{ $cart->name }}</td>
                            <td>{{ $cart->qty }}</td>
                            {{-- <td class="center">
                                <div class="form-group">
                                    <input rowId="{{ $cart->rowId }}" type="number" value="{{ $cart->qty }}" class="form-control prc" required>
                                </div>
                            </td> --}}
                            <td>
                                RM {{ number_format((float)$cart->price, 2, '.', '') }}
                            </td>
                            <td>
                                RM {{ number_format((float)$cart->subtotal, 2, '.', '') }}
                            </td>
                            <td class="center">
                                <button rowId="{{ $cart->rowId }}" type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box -->
@endsection

@section('bot')
    <!-- DataTables -->
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    <script>
        $(function () {
            $('#cart-table').DataTable(
                {searching: false}
            );
        })
    </script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.remove').click(function(e){
            e.preventDefault();
            var rowId = $(this).attr('rowId');
            window.location.href = "{{ url('Cart') }}"+'/'+rowId+'/edit';
        });
    });
</script>
<script>
    $('.form-group').on('input', '.prc', function(){
        var totalSum = 0;
        $('.form-group .prc').each(function(){
            var inputVal = $(this).val();
            if ($.isNumeric(inputVal)){
                totalSum += parseFloat(inputVal);
            }
        });
        $('#result').text(totalSum);
        var rowId = $(this).attr('rowId');
        var quantity = $(this).val();
        var prevQuantity = $(this).attr('value');
        if ($.isNumeric(quantity) && (quantity != prevQuantity) && (quantity != 0)){
            window.location.href = "{{ url('Cart/add') }}"+'/'+rowId+'/'+quantity; 
        }
    });
</script>
@endsection
