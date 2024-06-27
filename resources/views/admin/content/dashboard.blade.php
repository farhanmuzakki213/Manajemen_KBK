@extends('admin.admin_master')

@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
                @if (Session::has('success'))
                    <div id="delay" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div id="delay" class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="container-fluid">
                    <div class="container-fluid">
                        @hasanyrole('super-admin|admin|pimpinan-jurusan|pimpinan-prodi|dosen-pengampu|pengurus-kbk|dosen-kbk')
                            @hasrole('super-admin')
                                <h5>Dashboard super admin</h5>
                            @endhasrole
                            @hasrole('admin')
                                <h5>Dashboard admin</h5>
                            @endhasrole
                            @hasrole('pimpinan-jurusan')
                                <h5>Dashboard pimpinan jurusan</h5>
                            @endhasrole
                            @hasrole('pimpinan-prodi')
                                <h5>Dashboard pimpinan prodi</h5>
                            @endhasrole
                            @hasrole('dosen-pengampu')
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Dashboard dosen pengampu</h5>
                                        <div class="charts-row pt-3 pb-5">
                                            <div class="chart-container">
                                                <h3>RPS</h3>
                                                <div id="chartRpsPengampu"></div>
                                                @isset($banyak_pengunggahan_rps)
                                                    <p>Banyak Unggahan RPS: {{ $banyak_pengunggahan_rps }}</p>
                                                @endisset
                                                @isset($banyak_verifikasi_rps)
                                                    <p>Banyak Verifikasi RPS: {{ $banyak_verifikasi_rps }}</p>
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endhasrole
                            @hasrole('pengurus-kbk')
                                <h5>Dashboard pengurus kbk</h5>
                            @endhasrole
                            @hasrole('dosen-kbk')
                            <div class="card">
                                <div class="card-body">
                                    <h5>Dashboard dosen kbk</h5>
                                    <div class="charts-row pt-3 pb-5">
                                        <div class="chart-container">
                                            <h3>Proposal TA</h3>
                                            {{-- <div id="chartTADosenKbk"></div> --}}
                                            {{-- <p><strong>Penugasan:</strong> {{ $jumlah_proposal }}</p> --}}
                                            {{-- @foreach ($data as $kbk) --}}
                                            <p>Jumlah Proposal TA: {{ $jumlah_proposal }}</p>
                                            {{-- @endforeach --}}
                                            
                                            {{-- @if(isset($data)) --}}

    {{-- <p>Jumlah Proposal TA: {{ $data->jumlah_proposal }}</p>
    <p>Jumlah Review Proposal TA: {{ $data['jumlah_review_proposal'] }}</p>
    <p>Percent Proposal TA: {{ $data['percentProposalTA'] }}%</p>
    <p>Percent Review Proposal TA: {{ $data['percentReviewProposalTA'] }}%</p> --}}
{{-- @else
    <p>No data available</p>
@endif --}}

                                            
                                            {{-- @isset($jumlah_review_proposal)
                                                <p>Jumlah Proposal TA: {{ $jumlah_review_proposal }}</p>
                                            @endisset --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                                <script type="text/javascript">
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Define data from Blade variables
                                        var jumlahProposal = @json($jumlah_proposal ?? 0);
                                        var jumlahReviewProposal = @json($jumlah_review_proposal ?? 0);

                                        // Common chart options to ensure consistent appearance
                                        var commonOptions = {
                                            chart: {
                                                type: 'donut',
                                                height: 300,
                                                width: '100%'
                                            },
                                            plotOptions: {
                                                pie: {
                                                    donut: {
                                                        size: '65%',
                                                        labels: {
                                                            show: true,
                                                            total: {
                                                                show: true,
                                                                label: 'Total',
                                                                formatter: function (w) {
                                                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                y: {
                                                    formatter: function (value) {
                                                        return value + ' data';
                                                    }
                                                }
                                            },
                                            legend: {
                                                position: 'bottom'
                                            },
                                            colors: ['#008FFB', '#00E396']
                                        };

                                        // Options for Proposal TA Chart
                                        var optionsTA = {
                                            ...commonOptions,
                                            series: [jumlahProposal, jumlahReviewProposal],
                                            labels: ['Proposal', 'Review'],
                                            plotOptions: {
                                                pie: {
                                                    donut: {
                                                        size: '65%',
                                                        labels: {
                                                            show: true,
                                                            total: {
                                                                show: true,
                                                                label: 'Total',
                                                                formatter: function (w) {
                                                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                                }
                                                            }
                                                        },
                                                        minAngleToShowLabel: 0, // Ensure small slices are visible
                                                        expandOnClick: true // Allow slices to expand on click for better visibility
                                                    }
                                                }
                                            }
                                        };

                                        // Render Proposal TA Chart
                                        var chartTADosenKbk = new ApexCharts(document.querySelector("#chartTADosenKbk"), optionsTA);
                                        chartTADosenKbk.render();
                                    });
                                </script>
                            @endhasrole
                        @endhasanyrole
                        {{-- <div class="row">
                            <div class="col-lg-8 d-flex align-items-strech">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                                <h5 class="card-title fw-semibold">Sales Overview</h5>
                                            </div>
                                            <div>
                                                <select class="form-select">
                                                    <option value="1">March 2023</option>
                                                    <option value="2">April 2023</option>
                                                    <option value="3">May 2023</option>
                                                    <option value="4">June 2023</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Yearly Breakup -->
                                        <div class="card overflow-hidden">
                                            <div class="card-body p-4">
                                                <h5 class="card-title mb-9 fw-semibold">Yearly Breakup</h5>
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="fw-semibold mb-3">$36,358</h4>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <span
                                                                class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-arrow-up-left text-success"></i>
                                                            </span>
                                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                            <p class="fs-3 mb-0">last year</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-4">
                                                                <span
                                                                    class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                                <span class="fs-2">2023</span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                                <span class="fs-2">2023</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="d-flex justify-content-center">
                                                            <div id="breakup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <!-- Monthly Earnings -->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row alig n-items-start">
                                                    <div class="col-8">
                                                        <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                                                        <h4 class="fw-semibold mb-3">$6,820</h4>
                                                        <div class="d-flex align-items-center pb-1">
                                                            <span
                                                                class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-arrow-down-right text-danger"></i>
                                                            </span>
                                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                            <p class="fs-3 mb-0">last year</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="d-flex justify-content-end">
                                                            <div
                                                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-currency-dollar fs-6"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="earning"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <h5 class="card-title fw-semibold">Recent Transactions</h5>
                                        </div>
                                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-primary flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment received from John
                                                    Doe
                                                    of $385.90</div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">10:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-info flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale
                                                    recorded
                                                    <a href="javascript:void(0)"
                                                        class="text-primary d-block fw-normal">#ML-3467</a>
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-success flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment was made of $64.95
                                                    to
                                                    Michael</div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-warning flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale
                                                    recorded
                                                    <a href="javascript:void(0)"
                                                        class="text-primary d-block fw-normal">#ML-3467</a>
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-danger flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New arrival
                                                    recorded
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span
                                                        class="timeline-badge border-2 border-success flex-shrink-0 my-8"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment Done</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                                        <div class="table-responsive">
                                            <table class="table text-nowrap mb-0 align-middle">
                                                <thead class="text-dark fs-4">
                                                    <tr>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Id</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Assigned</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Name</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Priority</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Budget</h6>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">1</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                                                            <span class="fw-normal">Web Designer</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Elite Admin</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span
                                                                    class="badge bg-primary rounded-3 fw-semibold">Low</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$3.9</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">2</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Andrew McDownland</h6>
                                                            <span class="fw-normal">Project Manager</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Real Homes WP Theme</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span
                                                                    class="badge bg-secondary rounded-3 fw-semibold">Medium</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$24.5k</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">3</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Christopher Jamil</h6>
                                                            <span class="fw-normal">Project Manager</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">MedicalPro WP Theme</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span
                                                                    class="badge bg-danger rounded-3 fw-semibold">High</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$12.8k</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">4</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Nirav Joshi</h6>
                                                            <span class="fw-normal">Frontend Engineer</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Hosting Press HTML</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span
                                                                    class="badge bg-success rounded-3 fw-semibold">Critical</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$2.4k</h6>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        <a href="javascript:void(0)"><img
                                                src="{{ asset('backend/assets/images/products/s4.jpg') }}"
                                                class="card-img-top rounded-0" alt="..."></a>
                                        <a href="javascript:void(0)"
                                            class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">Boat Headphone</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold fs-4 mb-0">$50 <span
                                                    class="ms-2 fw-normal text-muted fs-3"><del>$65</del></span></h6>
                                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        <a href="javascript:void(0)"><img
                                                src="{{ asset('backend/assets/images/products/s5.jpg') }}"
                                                class="card-img-top rounded-0" alt="..."></a>
                                        <a href="javascript:void(0)"
                                            class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">MacBook Air Pro</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold fs-4 mb-0">$650 <span
                                                    class="ms-2 fw-normal text-muted fs-3"><del>$900</del></span></h6>
                                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        <a href="javascript:void(0)"><img
                                                src="{{ asset('backend/assets/images/products/s7.jpg') }}"
                                                class="card-img-top rounded-0" alt="..."></a>
                                        <a href="javascript:void(0)"
                                            class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">Red Valvet Dress</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold fs-4 mb-0">$150 <span
                                                    class="ms-2 fw-normal text-muted fs-3"><del>$200</del></span></h6>
                                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        <a href="javascript:void(0)"><img
                                                src="{{ asset('backend/assets/images/products/s11.jpg') }}"
                                                class="card-img-top rounded-0" alt="..."></a>
                                        <a href="javascript:void(0)"
                                            class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Add To Cart"><i class="ti ti-basket fs-4"></i></a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">Cute Soft Teddybear</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold fs-4 mb-0">$285 <span
                                                    class="ms-2 fw-normal text-muted fs-3"><del>$345</del></span></h6>
                                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="me-1" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                                <li><a class="" href="javascript:void(0)"><i
                                                            class="ti ti-star text-warning"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        var chart = {
            series: [{
                    name: "Earnings this month:",
                    data: [355, 390, 300, 350, 390, 180, 355, 390]
                },
                {
                    name: "Expense this month:",
                    data: [280, 250, 325, 215, 250, 310, 280, 250]
                },
            ],

            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: {
                    show: true
                },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: {
                    enabled: false
                },
            },


            colors: ["#5D87FF", "#49BEFF"],


            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "35%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: {
                size: 0
            },

            dataLabels: {
                enabled: false,
            },


            legend: {
                show: false,
            },


            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
            },

            xaxis: {
                type: "category",
                categories: ["16/08", "17/08", "18/08", "19/08", "20/08", "21/08", "22/08", "23/08"],
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color"
                    },
                },
            },


            yaxis: {
                show: true,
                min: 0,
                max: 400,
                tickAmount: 4,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color",
                    },
                },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"],
            },


            tooltip: {
                theme: "light"
            },

            responsive: [{
                breakpoint: 600,
                options: {
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                        }
                    },
                }
            }]


        };

        var chart = new ApexCharts(document.querySelector("#chart"), chart);
        chart.render();
    </script>
    <script>
        setTimeout(function() {
            var element = document.getElementById('delay');
            if (element) {
                element.parentNode.removeChild(element);
            }
        }, 5000);
    </script>
@endsection
