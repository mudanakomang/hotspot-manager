@if (session()->has('flash.message'))
    <div class="flash-message">
        <div class="alert alert-{{ session()->get('flash.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session()->get('flash.message') }}
        </div>
    </div>
@endif
