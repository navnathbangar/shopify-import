<x-app-layout>

<x-slot name="header">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0 fw-bold">
            Shopify Import Dashboard
        </h3>
    </div>
</x-slot>

<div class="container-fluid mt-4" style="margin-bottom: 30px;">

    <div class="row g-4">

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-upload fa-2x mb-3"></i>
                    <h6>Total Uploads</h6>
                    <h2>{{ $totalUploads }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x mb-3"></i>
                    <h6>Total Products</h6>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-3"></i>
                    <h6>Success</h6>
                    <h2>{{ $successProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-warning">
                <div class="card-body text-center">
                    <i class="fas fa-sync-alt fa-2x mb-3"></i>
                    <h6>Updated</h6>
                    <h2>{{ $updatedProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x mb-3"></i>
                    <h6>Failed</h6>
                    <h2>{{ $failedProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card shadow border-0 bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <h6>Processing</h6>
                    <h2>{{ $processingProducts }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-4">

        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Import History</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>File</th>
                        <th>Total</th>
                        <th>Processed</th>
                        <th>Success</th>
                        <th>Failed</th>
                        <th>Status</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($uploads as $upload)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $upload->file_name }}</td>

                        <td>{{ $upload->total_records }}</td>

                        <td>{{ $upload->processed_records }}</td>

                        <td>{{ $upload->successful_records }}</td>

                        <td>{{ $upload->failed_records }}</td>

                        <td>

                            @if($upload->status=='completed')

                            <span class="badge bg-success">

                                Completed

                            </span>

                            @elseif($upload->status=='processing')

                            <span class="badge bg-primary">

                                Processing

                            </span>

                            @else

                            <span class="badge bg-danger">

                                Failed

                            </span>

                            @endif

                        </td>

                        <td>{{ $upload->created_at->format('d M Y H:i') }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $uploads->links() }}

        </div>

    </div>

    <div class="row mt-5" style="margin-bottom:10px !important">

        <div class="col-lg-12">

            <div class="card shadow">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Recent Uploads
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Total</th>
                            <th>Success</th>
                            <th>Failed</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>

                        </thead>

                        <tbody>

                        @forelse($uploads as $upload)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $upload->file_name }}</td>

                            <td>{{ $upload->total_records }}</td>

                            <td>{{ $upload->successful_records }}</td>

                            <td>{{ $upload->failed_records }}</td>

                            <td>

                                @if($upload->status=='completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($upload->status=='processing')
                                    <span class="badge bg-warning">Processing</span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($upload->status) }}
                                    </span>
                                @endif

                            </td>

                            <td>{{ $upload->created_at->format('d M Y') }}</td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No Upload Found

                            </td>

                        </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $uploads->links() }}
                </div>
                

            </div>

        </div>

    </div>



    <div class="row mt-5">

        <div class="col-lg-12">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Product Status
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered align-middle">

                        <thead>

                        <tr>

                            <th>#</th>

                            <th>Title</th>

                            <th>SKU</th>

                            <th>Shopify ID</th>

                            <th>Status</th>

                            <th>Error Message</th>

                        </tr>

                        </thead>

                        <tbody>

                        @forelse($products as $product)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $product->title }}</td>

                            <td>{{ $product->variant_sku }}</td>

                            <td>{{ $product->shopify_product_id }}</td>

                            <td>

                                @switch($product->status)

                                    @case('success')
                                        <span class="badge bg-success">Success</span>
                                        @break

                                    @case('updated')
                                        <span class="badge bg-warning">Updated</span>
                                        @break

                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break

                                    @case('processing')
                                        <span class="badge bg-info">Processing</span>
                                        @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($product->status) }}
                                        </span>

                                @endswitch

                            </td>

                            <td>
                            {{ $product->error_message ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No Products Found

                            </td>

                        </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>
                <div class="mt-3 d-flex justify-content-end" style="margin-bottom:10px !important">
                    {{ $products->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

</x-app-layout>