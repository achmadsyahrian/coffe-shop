@extends('dashboard.layouts.main')
@section('container')
    <h1>List Customers</h1>
    <hr>
    @if (session()->has('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
            <script>
                Swal.fire(
                    'Success!',
                    '{{ session('success') }}',
                    'success'
                )
            </script>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 align-items-stretch">

            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Phone</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Total Items Purchased</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pageNumber = ($customers->currentPage() - 1) * $customers->perPage();
                                @endphp
                                @foreach ($customers as $customer)
                                    @php
                                        $pageNumber++;
                                    @endphp
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">
                                                {{ $pageNumber }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $customer->name }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                            <span class="badge rounded-3 fw-semibold" style="background-color: #795548;"><i class="fas fa-phone fs-2 me-2"></i> {{ $customer->phone }}</span>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                             <span class="badge bg-success rounded-3 fw-semibold">
                                                {{ $customer->total_items_bought ?? 0 }}
                                             </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
