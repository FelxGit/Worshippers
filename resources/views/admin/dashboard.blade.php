@extends('admin.layouts.app')
@include('assets.jquery')
@include('assets.chartjs')
@include('assets.mdb')
@include('assets.page.dashboardJs')

@section('content')
  <div class="heading-dashboard">
    <div class="items bg-primary">
      <div>
        <p>{{ __('messages.TotalUsers') }}</p>
        <h2 id="total-user">{{ $totalUser ?? '' }}</h2>
      </div>
      <div>
        <i class="fa-solid fa-user fa-item"></i>
      </div>
    </div>
    <div class="items bg-info">
      <div>
        <p>{{ __('messages.TotalPosts') }}</p>
        <h2 id="total-post">{{ $totalPost ?? '' }}</h2>
      </div>
      <div>
        <i class="fa-solid fa-layer-group fa-item"></i>
      </div>
    </div>
    <div class="items bg-success">
      <div>
        <p>All Category</p>
        <h2 id="total-category">{{ $totalCategory ?? '' }}</h2>
      </div>
      <div>
        <i class="fa-solid fa-layer-group"></i>
      </div>
    </div>
  </div>
  <div class="graphs">
    <div class="grap-selection">
      <select id="graph-date" class="form-select" onChange="getGraphByDate(event)">
        <option value="{{ strtolower(\Globals::GRAPH_WEEK) }}">{{ \Globals::GRAPH_WEEK }}</option>
        <option value="{{ strtolower(\Globals::GRAPH_MONTH) }}">{{ \Globals::GRAPH_MONTH }}</option>
        <option value="{{ strtolower(\Globals::GRAPH_YEAR) }}" selected>{{ \Globals::GRAPH_YEAR }}</option>
      </select>
      <select id="graph-model" class="form-select" onChange="showGraphByModel()">
        <option value="{{ strtolower(\Globals::MODEL_USER) }}" selected>{{ \Globals::MODEL_USER }}</option>
        <option value="{{ strtolower(\Globals::MODEL_POST) }}">{{ \Globals::MODEL_POST }}</option>
      </select>
    </div>
    <div class="graph-view">
      <canvas id="graph-user" style="width: 100%; display: none" for="User"></canvas>
      <canvas id="graph-post" style="width: 100%; display: none" for="Post"></canvas>
    </div>
  </div>
@endsection

