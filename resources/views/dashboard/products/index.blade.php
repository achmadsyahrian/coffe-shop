@extends('dashboard.layouts.main')
@section('container')
    <h1>List Products</h1>
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
          <div class="d-flex justify-content-between mb-3">
            <form action="{{route('products.index')}}" method="get" class="d-flex align-items-center">
              <label class="label mb-0 me-2" for="search_name">Cari</label>
              <input type="text" class="form-control " id="search_name" name="name" value="{{request('name')}}">
              <button type="submit" class="btn btn-outline-primary ms-2">
                <i class="ti ti-search"></i>
              </button>
            </form>
            <a href="{{route('products.index')}}" class="btn btn-outline-primary ms-2">
              <i class="fas fa-undo-alt"></i>
            </a>
            
            <a href="/dashboard/products/create" class="btn btn-primary ms-auto"><i class="fas fa-shopping-bag me-2"></i> Add New Product</a>
          </div>    

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
                          <h6 class="fw-semibold mb-0">Stock</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Price</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Action</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $pageNumber = ($products->currentPage() - 1) * $products->perPage();
                        @endphp
                        @foreach ($products as $product)                            
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
                                    <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                                    @if ($product->category_id == null)  
                                      <span class="fw-normal">Catt: -</span>                          
                                    @else
                                      <span class="fw-normal">Catt: {{ $product->category->name }}</span>                          
                                    @endif
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-3 fw-semibold" style="background-color: #795548;">{{ $product->stock }}</span>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 fs-4">
                                        Rp. {{ number_format($product->harga, 2, ',', '.') }} {{-- format harga --}}
                                    </h6>
                                </td>
                                <td class="border-bottom-0">
                                    <a href="/dashboard/products/{{ $product->id }}" class="badge bg-info" style="text-decoration: none !important; color: white !important;">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="/dashboard/products/{{ $product->id }}/edit" class="badge bg-warning" style="text-decoration: none !important; color: white !important;">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="/dashboard/products/{{ $product->id }}" id="formDelete" method="POST" class="d-inline">
                                      @method('delete')
                                      @csrf
                                      <button type="submit" onclick="event.preventDefault(); deleteData();" class="badge bg-danger border-0">
                                        <i class="ti ti-trash"></i>
                                      </button>
                                    </form>
                                </td>
                            </tr>  
                        @endforeach
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-center mt-3">
                    {{ $products->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
    
@endsection