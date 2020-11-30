@extends ("potassium::admin.layout", ['page'=> '@page'])

@section('content')
    <div id="@page" v-cloak>
        <div class="content">
            <h1>{{ucwords("@page")}}</h1>
        </div>
    </div>
@endsection

