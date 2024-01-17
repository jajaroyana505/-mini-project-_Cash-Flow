@extends("layout.main")



@section("container")
@if(session()->has('success'))
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="alert" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Successfully !!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body ">
            {{ session('success') }}
        </div>
    </div>
</div>

@endif




<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card shadow-lg">
            <div class="card-header">
                <h5>
                    Pemasukan
                </h5>
            </div>
            <div class="card-body">
                <canvas id="pemasukan"></canvas>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="text-center">
                    Mini Project
                </h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <p>Track your income and expense</p>
                    <h3> Total Balance Rp. {{$totalBalance}}</h3>
                </div>
                <hr>
                <form class="mb-4" method="post" action="/">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <select required name="type_id" class="form-select" id="type" aria-label="Floating label select example" onchange="loadCategories()">
                                </select>
                                <label for="type">Type</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <select required id="category" name="category_id" class="form-select" aria-label="Floating label select example">

                                </select>
                                <label for="category">Category</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input required name="amount" type="number" class="form-control" id="floatingPassword" placeholder="Password" value="0">
                                <label for="floatingPassword">Amount</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input required name="date" type="date" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" type="submit">Create</button>
                    </div>

                </form>

                <div style="height: 200px; overflow:auto; overflow-x: hidden;">
                    <ul class="list-group">
                        @foreach ($transactions as $transaction )
                        <li class="list-group-item row justify-content-between align-items-start">
                            <div class="d-flex align-items-center justify-content-between">
                                @switch($transaction->type->id)
                                @case(1)
                                <div class="m-0">
                                    <i class="bi fs-2 bi-arrow-up-circle-fill text-success"></i>
                                </div>
                                @break
                                @default
                                @case(1)
                                <div class="m-0">
                                    <i class="bi fs-2 bi-arrow-down-circle-fill text-warning"></i>
                                </div>
                                @endswitch

                                <div class="m-0">
                                    <div class="fw-bold">{{$transaction->category->name}}</div>
                                    <small>Rp. {{$transaction->amount}} / {{$transaction->date}}</small>
                                </div>
                                <form action="/{{$transaction->id}}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn" onclick="return confirm('Are you sure?')"><i class="fs-3 bi bi-trash-fill text-secondary"></i></button>
                                </form>



                                </a>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="card shadow-lg">
            <div class="card-header">
                <h5>
                    Pengeluaran

                </h5>
            </div>
            <div class="card-body">
                <canvas id="pengeluaran"></canvas>
            </div>
        </div>

    </div>

</div>

@endsection


@section('script')
<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<!-- CDN JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    const toastAlert = document.getElementById('alert')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastAlert)
    toastBootstrap.show()
</script>
<script>
    // Data transaksi
    const pemasukanData = {
        labels: [<?= "'" . implode("','", $dataIncome['label']) . "'" ?>],
        datasets: [{
            data: [<?= implode(",", $dataIncome['data']) ?>],
            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
            hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
        }],
    };
    const pengeluaranData = {
        labels: [<?= "'" . implode("','", $dataExpense['label']) . "'" ?>],
        datasets: [{
            data: [<?= implode(",", $dataExpense['data']) ?>],
            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
            hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
        }],
    };

    // Konfigurasi chart donat
    const pemasukan = {
        type: 'doughnut',
        data: pemasukanData,
    };
    const pengeluaran = {
        type: 'doughnut',
        data: pengeluaranData,
    };

    // Inisialisasi chart donat
    const pemasukanCtx = document.getElementById('pemasukan').getContext('2d');
    const pemasukanChart = new Chart(pemasukanCtx, pemasukan);

    const pengeluaranCtx = document.getElementById('pengeluaran').getContext('2d');
    const pengeluaranChart = new Chart(pengeluaranCtx, pengeluaran);
</script>



<!-- Dropdown Select Dinamic -->
<script>
    $(document).ready(function() {

        // Fungsi untuk memuat type
        loadTypes()

        function loadTypes() {
            $.ajax({
                url: "<?= url('get-types') ?>",
                type: 'GET',
                success: function(response) {
                    $('#type').append('<option value="">Pillih</option>');

                    console.log(response)
                    // Tambahkan opsi ke dropdown
                    $.each(response, function(key, value) {
                        $('#type').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            })
        }

    })

    // Fungsi untuk memuat category
    function loadCategories() {
        var idType = $('#type').val()
        console.log(idType)
        $.ajax({
            url: "<?= url('/get-categories?id=')  ?>" + idType,
            type: 'GET',
            success: function(response) {

                // Bersihkan opsi sebelum menambahkan yang baru
                $('#category').empty();

                console.log(response)
                // Tambahkan opsi ke dropdown
                $.each(response, function(key, value) {
                    $('#category').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }
</script>
@endsection