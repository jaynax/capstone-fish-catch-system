@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">BFAR Regulations</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="h5 text-primary mb-3">Regulations of BFAR</h3>
                        <p class="mb-4">
                            The Bureau of Fisheries and Aquatic Resources (BFAR) is responsible for formulating rules and regulations for the conservation and management of straddling fish stocks and highly migratory fish stocks. BFAR also implements an inspection system for the import and export of fishery/aquatic products and fish processing establishments, ensuring product quality and safety.
                        </p>
                        <p class="mb-4">
                            The agency develops value-added fishery products for domestic consumption and export, providing advisory services and technical assistance on improving fish quality. BFAR assists local government units (LGUs) in developing their technical capability in the development, management, regulation, conservation, and protection of fishery resources.
                        </p>
                        <p>
                            Additionally, BFAR performs functions to promote the development, conservation, management, protection, and utilization of fisheries and aquatic resources.
                        </p>
                    </div>

                    <div class="mt-4">
                        <h4 class="h5 text-primary mb-3">Key Regulatory Functions:</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                Conservation and management of fishery resources
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                Inspection of fishery/aquatic products
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                Quality control and safety standards
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                Technical assistance to LGUs
                            </li>
                            <li class="list-group-item">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                Development of value-added fishery products
                            </li>
                        </ul>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class='bx bx-arrow-back me-2'></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
