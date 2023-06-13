@extends('layouts.app')

@section('content')
    <header>
        <div class="page-header min-vh-50" style="background-image: url('../assets/img/automotive.jpg');">
            <span class="mask bg-gradient-dark"></span>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8 d-flex justify-content-center flex-column text-center position-absolute top-0 h-100">
                        <div class="mx-auto text-start">
                            <h1 class="text-white">Belanja Obat Bisa Dari Web</h1>
                            <p class="text-white"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row bg-white shadow mt-n6 border-radius-md pb-4 p-3 mx-sm-0 mx-1 position-relative">
                <form action="{{route('landing.medicine.search')}}" method="post" class="d-flex">
                    @csrf
                    @method('post')
                <div class="col-lg-9 mt-lg-n2 mt-2">
                    <label>Nama Obat</label>
                        <input type="text" class="form-control" name="search" placeholder="Ketik Nama Obat">
                </div>
                    <div class="col-lg-3 d-flex align-items-center my-auto">
                        <button type="submit" class="btn bg-gradient-primary w-100 mb-0 m4 mt-3">Cari Obat</button>
                    </div>

                </form>
            </div>
        </div>
    </header>


    <div class="container">
        <div class="d-flex flex-wrap align-content-center center justify-content-center">
        @foreach($medicine as $m)
            <div class="card m-4" style="width: 20rem;">
                <img class="card-img-top h-75" src="{{asset('medicinePhoto/'.$m->photo)}}">
                <div class="card-body">
                    <h4 class="card-title">{{$m->name}}</h4>
                    <p class="card-text">
                        {{$m->description}}
                    </p>

                    <p class="btn btn-outline-success d-block mx-auto">
                        Price Rp {{$m->price}}
                    </p>

                    <p class="btn btn-outline-danger d-block mx-auto">
                       Stock {{$m->stock}}
                    </p>
                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#addCartModal{{$m->id}}">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>



                <div class="modal fade" id="addCartModal{{$m->id}}" tabindex="-1" aria-labelledby="addCartModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCartModalLabel">Tambah ke Keranjang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route('cart.add') }}" method="POST">
                                @csrf
                                @method('post')
                                <div class="modal-body">

                                        <input type="hidden" class="form-control" name="medicines_id" value="{{ $m->id }}">
                                        <div class="d-flex">
                                            <input type="number" class="form-control" name="quantity" value="1">
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary" >Masukan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

@endsection
