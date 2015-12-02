@extends('layout.base')

@section('content')
<div class="container">
    <form action="/register" method="POST" class="col-md-6 col-md-offset-3" id="form">
        <div class="form-group">
            <label for="email">Sähköpostiosoite</label>
            <input type="email" name="email" class="form-control" placeholder="Aseta käyttäjäsi sähköpostiosoite" />
        </div>
        <div class="form-group">
            <label for="password">Salasana</label>
            <div class="input-group">
                <input type="@{{shown?'text':'password'}}" name="password" class="form-control" placeholder="Aseta käyttäjäsi salasana">
                <span class="input-group-btn">
                    <button class="btn" type="button" :class="{'btn-primary': shown, 'btn-default': !shown}" @click="shown = !shown"><i class="fa fa-eye fa-fw"></i></button>
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Rekisteröidy</button>
    </form>
</div>
@stop

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.8/vue.min.js"></script>
<script type="text/javascript">
    var password = new Vue({
        el: '#form',

        data: {
            shown: false
        },
    });
</script>
@stop
