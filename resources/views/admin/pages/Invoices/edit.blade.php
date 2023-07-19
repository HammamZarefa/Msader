@extends('admin.layouts.app')
@section('title')
    @lang('Invoices')
@endsection
@section('content')

<div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body ">
<form action="{{route('admin.invoice_Update',$Invoice->id)}}" method="POST" >
    @method('PUT')

    @csrf

     <div class="form-row">
        <div class="form-group col-md-6">
            <label for="Name">Name</label>
            <input type="text" value={{$Invoice->Name}} class="form-control" name="Name" id="Name" placeholder="Name">
        </div>

        <div class="form-group col-md-6">
            <label for="Date">Date</label>
            <input type="date" value={{$Invoice->Date}} class="form-control" name="Date" id="Date" placeholder="Date">
        </div>

    </div>
    <div class="form-row">

    <div class="form-group col-md-6">
        <label for="inputState">Status</label>
        <select id="inputState"  value={{$Invoice->Status}} class="form-control" name="Status" >
          <option {{$Invoice->Status=="completed" ? 'selected':''}} >completed</option>
          <option {{$Invoice->Status=="pending" ? 'selected':''}} >pending</option>
          <option {{$Invoice->Status=="failed" ? 'selected':''}} >failed</option>

        </select>
        
    </div>

    <div class="form-group col-md-6">
      <label for="inputAddress2">Amount</label>
      <input type="text" value={{$Invoice->Amount}} class="form-control" name="Amount" id="Amount" placeholder="Amount">
    </div>

</div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputCity">Method</label>
        <input type="text" value={{$Invoice->Method}} class="form-control" name="Method" id="Method">
      </div>

      <div class="form-group col-md-6">
        <label for="inputCity">Description</label>
        <input type="text" value={{$Invoice->Description}} class="form-control" name="Description" id="Description">
      </div>
    </div> 
      
    <button type="submit" class="btn btn-primary">Update</button>

  </form>
        
    </div>
</div>
@endsection
