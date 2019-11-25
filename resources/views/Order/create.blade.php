@extends ('layouts.home')

@section('content')
    <h1>Add Order</h1>
    <br>
    {!! Form::open(['action'=>'OrdersController@store','method'=>'POST'])!!}
        {{ csrf_field() }}
        <div class="form-group">
            <label>PIC</label>
                <select class="form-control" name="pic_id" id="pic_id" style="width:500px">
                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                </select>
        </div>
        <div class="form-group" style="width:500px">
            {{Form::label('item_id','ID')}}
            {{Form::text('item_id','',['class'=>'form-control','placeholder'=>'Scan the barcode'])}}
         </div>
        {{-- <div class="form-group" style="width:500px">
            {{Form::label('price','Price')}}
            {{Form::text('price','',['class'=>'form-control','placeholder'=>'Put the buying price'])}}
        </div> --}}
        <div class="form-group" style="width:500px">
            {{Form::label('quantity','Quantity')}}
            {{Form::text('quantity','',['class'=>'form-control','placeholder'=>'Put the quantity of item'])}}
        </div>
        <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" id="status" style="width:500px">
                    <option value="Incomplete">To receive</option>
                    <option value="Complete">Received</option>
                </select>
        </div>
        <br>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close()!!}
@endsection

@section('bottom')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    </script>
@endsection