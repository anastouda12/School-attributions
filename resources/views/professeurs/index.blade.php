@extends('layout')

@section('title', 'Liste de professeurs')

@section('content')
@if(Session::has('warning'))
<p class="alert alert-danger csv-messages">{{ Session::get('warning') }}</p>
@endif
@if(Session::has('success'))
<p class="alert alert-success csv-messages">{{ Session::get('success') }}</p>
@endif
@if(Session::has('error'))
<div class="alert alert-danger csv-messages">{{ session('error') }}</div>
@endif

<h1>Liste de professeurs</h1>
@if (count($professeurs) == 0)
<h2>La liste est vide</h2>
<p>Pas de professeur disponible. </p>
@else
<table id="table-professors-list" class="table">
    <thead>
        <tr>
            <th>Acronyme</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($professeurs as $professeur)
        <tr id="row-{{$professeur["acronyme"]}}">
            <td scope="row">{{$professeur["acronyme"]}} </td>
            <td>{{$professeur["nom"]}} </td>
            <td>{{$professeur["prenom"]}} </td>
            <td>
                {{-- <a id="delete-button-{{$professeur["acronyme"]}}" name="deleteProf"
                class="btn btn-danger delete delete-button"
                href="{{ route('delete_professor', ['acronym' => $professeur["acronyme"]]) }}">
                Supprimer
                </a> --}}
                <a class="btn btn-danger delete delete-button" role="button"
                    data-acronyme="{{$professeur["acronyme"]}}">Supprimer</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<!-- Form -->
<form method='post' action='{{ route('upload_professor') }}' enctype='multipart/form-data'>
    @csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <input class="btn btn-info" type='submit' name='submit' value='Import' id='import-csv-button'> </div>
        <div class="custom-file">
            <input type="file" name="file" class="custom-file-input" id="import-csv">
            <label class="custom-file-label" for="import-csv">Choose csv file</label>
        </div>
    </div>
</form>


<div class="buttonBloc">
    <button type="button" id="accueilBtn" name="accueilBtn" onclick="window.location='{{ route('index') }}' "> > vers
        accueil </button>
    {{-- <button type="button" onclick="window.location='{{ route('courses.create') }}' "> > créer</button> --}}
</div>

<script>
    $("#import-csv").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(() => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        initDeleteButtons();
    });

    function initDeleteButtons() {
        $(".delete-button").each(function(elt) {
            console.log($(this).attr('id'));
            $(this).on('click', () => {
                let row = $(this);
                if(confirm("Voulez vous vraiment supprimer ce professeur?")){
                    $.ajax({
                        url: "/delete_professor/" + $(this).data('acronyme'),
                        type: 'DELETE',
                        success: function(result) {
                            row.parent().parent().remove();
                        },
                        error: function (request, status, error) {
                            console.log(request.responseText);
                        }
                    });
                }
            });
        });
    }
</script>
@endsection