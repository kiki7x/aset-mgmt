@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id
])

@section('content-tab')

@endsection