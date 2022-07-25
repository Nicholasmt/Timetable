@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <strong ><li class="red">{{ $error }}</li></strong>
        @endforeach
    </div>
@endif
@if (session()->has('val_errors'))
    <div class="alert alert-danger alert-dismissable">
        @foreach (session()->get('val_errors') as $k=>$v)
            <?php
              if(gettype($v)=="array")
              {
                $msg=array_values($v);
                $msg=$msg[0][0];
              }
              else
              {
                $msg=$v;
              }

            ?>
            <strong><p>{{ $msg }}</p></strong>
        @endforeach
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('canvas'))
        {!! session()->get('canvas') !!}
@endif
