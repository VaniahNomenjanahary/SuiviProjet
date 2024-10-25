@extends('layout.init')
@section('content')

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Gestion Projet</h1>
    </a>

    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="{{url('get')}}"> <span>Appel Offre</span></a></li>
    </li>

      </ul>
    </nav><!-- .navbar -->

    <div class="position-relative">
      <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
      <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
      <a href="#" class="mx-2"><span class="bi-instagram"></span></a>

      <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
      <i class="bi bi-list mobile-nav-toggle"></i>

      <!-- ======= Search Form ======= -->
      <div class="search-form-wrap js-search-form-wrap">
        <form action="search-result.html" class="search-form">
          <span class="icon bi-search"></span>
          <input type="text" placeholder="Search" class="form-control">
          <button class="btn js-search-close"><span class="bi-x"></span></button>
        </form>
      </div><!-- End Search Form -->

    </div>

  </div>


  </header>
<main id="main" class="main">

<section class="section dashboard">
    <div class="row">
   <div class="card recent-sales overflow-auto">
 
                <div class="col-12">
                    <table class="table my-0" id="dataTable">
                     
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Type</th>
                                <th>Secteur</th>
                                <th>Localisation</th>
                                <th>Description</th>
                                <th>Etat</th>
                                <th>Date Publication</th>
                                <th>Date Limite</th>
                                <th>Description du marché</th>
                            </tr>
                            </thead>
                            <tbody>
                         @foreach($appels as $offrelot)
                                <tr>
                                    <!--
                                    <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg">Airi Satou</td>
                                    -->
                                    <td>{{$offrelot->id}}</td>
                                    <td>{{$offrelot->types}}</td>
                                    <td>{{$offrelot->intitule}}</td>
                                    <td>{{$offrelot->localisation}}</td>
                                    <td>{{$offrelot->descriptionlot}}</td>
                                    <td>{{$offrelot->typelot}}</td>
                                    <td>{{$offrelot->datepublication}}</td>
                                    <td>{{$offrelot->datelimite}}</td>
                                    <td>{{$offrelot->descriptions}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                        </div>
                </div>
            </form>
        </div>
</div>
    </section>
    </main>

