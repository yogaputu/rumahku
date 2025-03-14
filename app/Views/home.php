<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content mx-2">
    <div class="container-fcol-lg-4luid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-4">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $jumlahKecamatan ?></h3>

              <p>Jumlah Kecamatan Terinput</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-4">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $jumlahWarga ?></h3>

              <p>Jumlah Warga Terinput</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-4">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?= $jumlahRt ?></h3>

              <p>Jumlah RT Terinput</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <div class="col-6 col-lg-6">
          <!-- solid sales graph -->
          <div class="card bg-dark">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Jumlah Warga Tiap Kecamatan
              </h3>
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-6 col-lg-6">
          <!-- solid sales graph -->
          <div class="card bg-dark">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Jumlah RT Tiap Kecamatan
              </h3>
            </div>
            <div class="card-body">
              <canvas class="chart" id="bar-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
  // $('#revenue-chart').get(0).getContext('2d');

  const label = [];
  const data = [];
  <?php foreach ($kecamatan as $key => $kecamatan) : ?>
    label.push(`<?= $kecamatan['dis_name'] ?>`)
    data.push(<?= $kecamatan['warga'] ?>)
  <?php endforeach ?>
  var salesGraphChartData = {
    labels: label,
    datasets: [{
      label: 'Jumlah Warga',
      fill: false,
      borderWidth: 2,
      lineTension: 0,
      spanGaps: true,
      borderColor: '#efefef',
      pointRadius: 3,
      pointHoverRadius: 7,
      pointColor: '#efefef',
      pointBackgroundColor: '#00000',
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Background color for the bars
      data
    }]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5000,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: '#efefef',
          drawBorder: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'bar',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  })

  // Sales graph chart
  var barSalesGraphChartCanvas = $('#bar-chart').get(0).getContext('2d')
  // $('#revenue-chart').get(0).getContext('2d');

  const barLabel = [];
  const barData = [];
  <?php foreach ($rt as $key => $rt) : ?>
    barLabel.push(`<?= $rt['dis_name'] ?>`)
    barData.push(<?= $rt['rt'] ?>)
  <?php endforeach ?>
  var barSalesGraphChartData = {
    labels: barLabel,
    datasets: [{
      label: 'Jumlah RT',
      fill: false,
      borderWidth: 2,
      lineTension: 0,
      spanGaps: true,
      borderColor: '#efefef',
      pointRadius: 3,
      pointHoverRadius: 7,
      pointColor: '#efefef',
      pointBackgroundColor: '#00000',
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Background color for the bars
      data: barData
    }]
  }

  var barSalesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5000,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: '#efefef',
          drawBorder: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var barSalesGraphChart = new Chart(barSalesGraphChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'bar',
    data: barSalesGraphChartData,
    options: barSalesGraphChartOptions
  })
</script>
<?= $this->endSection() ?>