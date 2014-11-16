<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3><a href="https://github.com/mohsen-shafiee/Zagros">{{trans('layout.zagros')}}</a><samll class="small"> {{ZA_VERSION}}</small></h3>
                <ul class="list-inline">
                    <li><a href="https://github.com/mohsen-shafiee/Zagros/issues">{{trans('layout.issue')}}</a></li>
                    <li><a href="https://github.com/mohsen-shafiee/Zagros/pulls">{{trans('layout.pull')}}</a></li>
                    <li><a href="https://github.com/mohsen-shafiee/Zagros">{{trans('layout.contact')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{HTML::script('scripts/jquery-1.11.1.min.js')}}
{{HTML::script('scripts/bootstrap.min.js')}}
{{HTML::script('scripts/magicsuggest-min.js')}}

@yield('footer')
