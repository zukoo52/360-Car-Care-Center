<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto">
                <h4 class="mb-0">{{$page_name}}</h4>
            </div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                @foreach ($breadcrumbs as $br)
                <li class="breadcrumb-item"><a href="{{$br['url']}}">{{$br['name']}}</a></li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
