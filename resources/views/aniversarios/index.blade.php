@extends('adminlte::page')

@section('title', 'Nico Business')

@section('content_header')
    <h1>Lista de Aniversarios</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Add the evo-calendar.css for styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.midnight-blue.css"/>



@stop


@section('content')
<div id="calendar"></div>
<?php //echo  json_encode($dataAr) ?>


@stop



@section('js')

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for.. obviously, functionality! -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<script>
  $("#calendar").evoCalendar({
    theme: 'Midnight Blue',
    'language': 'pt',
    calendarEvents:{!! json_encode($dataAr) !!}

  });
</script>


<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>


@stop
