@extends('dashboard.layouts.main')
@section('container')
    <h1>Edit Staff</h1>
    <hr>

   <div class="card">
      <div class="card-body">
         <form action="{{route('staff.update', $user)}}" method="POST">
            @method('put')
            @csrf
            <div class="row">
               <div class="col-md-6">
                  <div class="mb-3">
                     <label for="name" class="form-label">Name</label>
                     <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                     @error('name')
                        <div id="name" class="form-text text-danger">{{ $message }}.</div>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="mb-3">
                     <label for="username" class="form-label">Username</label>
                     <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}">
                     @error('username')
                        <div id="username" class="form-text text-danger">{{ $message }}.</div>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="mb-3">
                     <label for="phone" class="form-label">Phone</label>
                     <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                     @error('phone')
                        <div id="phone" class="form-text text-danger">{{ $message }}.</div>
                     @enderror
                  </div>
               </div>
            </div>
            <a href="{{route('staff.index')}}" class="btn btn-danger me-2"><i class="ti ti-arrow-left"></i> Back</a>
            <button type="submit" class="btn btn-success">Update <i class="ti ti-check"></i></button>
         </form>
      </div>
   </div>
    
@endsection