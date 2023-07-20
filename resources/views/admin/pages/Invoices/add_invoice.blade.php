@extends('admin.layouts.app')
@section('title')
    @lang('Invoices')
@endsection
@section('content')

<div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body ">

      

<form action="{{route('admin.invoice_create')}}" method="POST" >

    @csrf
   
     <div class="form-row">
        <div class="form-group col-md-6">
            
            <label for="Name">Name</label>
            <input type="text" class="form-control" name="Name" id="Name" placeholder="Name">
            @if($errors->has('Name'))
            <li style="color:rgb(199, 50, 50)">
              <strong>Warning! </strong>{{ $errors->first('Name') }}
            </li>
            @endif 
        </div>

        <div class="form-group col-md-6">
           
            <label for="Date">Date</label>
            <input type="date" class="form-control" name="Date" id="Date" placeholder="Date">
            @if($errors->has('Date'))
            <li style="color:rgb(199, 50, 50)">
              <strong>Warning! </strong>{{ $errors->first('Date') }}
            </li>
            @endif
        </div>

    </div>
    <div class="form-row">

    <div class="form-group col-md-6">
        <label for="inputState">Status</label>
        <select id="inputState" class="form-control" name="Status" >
          <option selected>completed</option>
          <option>pending</option>
          <option>failed</option>

        </select>
        
    </div>

    <div class="form-group col-md-6">
      
      <label for="inputAddress2">Amount</label>
      <input type="text" class="form-control" name="Amount" id="Amount" placeholder="Amount">
      @if($errors->has('Amount'))
            <li style="color:rgb(199, 50, 50)">
              <strong>Warning! </strong>{{ $errors->first('Amount') }}
            </li>
            @endif
    </div>

</div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputCity">Method</label>
        <input type="text" class="form-control" name="Method" id="Method">
      </div>

      <div class="form-group col-md-6">
        <label for="inputCity">Description</label>
        <input type="text" class="form-control" name="Description" id="Description">
      </div>
    </div> 
      
    <button type="submit" class="btn btn-primary">Create</button>

  </form>
        
    </div>
</div>
@endsection
