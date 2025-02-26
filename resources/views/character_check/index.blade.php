@extends('layouts.main')
@section('content')
  <div class="pagetitle">
    <h1>Dependent Dropdown</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Character Check</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cek Karakter</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Input 1</label>
              <input type="text" class="form-control" id="input1" name="input1" value="ABBCD">
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Input 2</label>
              <input type="text" class="form-control" id="input2" name="input2" value="Gallant Duck">
            </div>
            <div class="alert alert-success">
              <span id="textResult">Hasil :</span>
            </div>
            <button type="button" class="btn btn-primary" id="prosessCheck">Cek</button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <script>
    $('#prosessCheck').on('click', function() {
      let input1 = $('#input1').val();
      let input2 = $('#input2').val();
      
      let result = calculateCharacterMatchPercentage(input1, input2);
      $('#textResult').html('Hasil : ' + result + '%');
    })

    function calculateCharacterMatchPercentage(input1, input2) {
      input1 = input1.toLowerCase();
      input2 = input2.toLowerCase();

      let charCount = input1.length;
      if (charCount === 0) return 0;

      let uniqueMatches = []; 

      for (let i = 0; i < input1.length; i++) {
        let char = input1[i];

        if (input2.includes(char)) {
          let checkAdd = false;
          for (let j = 0; j < uniqueMatches.length; j++) {
            if (uniqueMatches[j] === char) {
              checkAdd = true;
                break;
            }
          }

          if (!checkAdd) {
            uniqueMatches.push(char);
          }
        }
      }

      return (uniqueMatches.length / charCount) * 100;
    }
  </script>
@endsection
