@extends('dashboard.layouts.main')
@section('container')
    <h1>Report</h1>
    <hr>

    <div class="row">
        <div class="col-lg-6 align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <form action="{{ route('report.print') }}" method="POST">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="from_date">Start Date</label>
                                <input type="date" id="from_date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="to_date">End Date</label>
                                <input type="date" id="to_date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    
@endsection
