@extends('layout.base')

@section('content')
<div id="app" steps="{{ json_encode(old('steps')) }}" sourcecitations="{{ json_encode(old('sourcecitations')) }}">
<div class="container">
	<form action="/guides/create" method="POST">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<div class="form-group {{{ $errors->has('title') ? "has-error" : null }}}">
			<label for="title">Otsikko</label>
			<input class="form-control" type="text" name="title" id="title" placeholder="Aseta ohjeen nimi!" value="{{old('title')}}"/>
		</div>
		<div class="form-group">
			<label for="description">Kuvaus</label>
			<textarea class="form-control" name="description" id="description" placeholder="Aseta ohjeen kuvaus!">{{old('description')}}</textarea>
		</div>

	<hr/>
	<h2>Askeleet</h2>

	<section class="step" v-for="step in steps" track-by="$index">
		<step :index="$index + 1" :data="step"></step>
		<button v-if="$index + 1 != steps.length" class="btn btn-primary btn-block" @click.stop.prevent="addStep($index+1)"><i class="fa fa-plus fa-fw"></i> Lisää askel tähän</button>
		<hr/>
	</section>
	<button class="btn btn-primary btn-block" @click.stop.prevent="addStep(-1)"><i class="fa fa-plus fa-fw"></i> Lisää askel</button>

	<hr/>
	<h2>Lähteet ja viittaukset</h2>
	<ul class="list-group">
		<li class="list-group-item" v-for="sourcecitation in sourcecitations" track-by="$index">
			<div class="row">
				<div class="col-md-5">
					<input type="text" name="sourcecitations[@{{$index}}][text]" class="form-control" placeholder="Teksti" v-model="sourcecitation.text"/>
				</div>
				<div class="col-md-5">
					<input type="text" name="sourcecitations[@{{$index}}][link]" class="form-control" placeholder="Linkki" v-model="sourcecitation.link"/>
				</div>
				<div class="col-md-2">
					<button class="btn btn-danger btn-block" @click.stop.prevent="removeSourceCitation($index)"><i class="fa fa-times fa-fw"></i></span>
				</div>
			</div>
		</li>
	</ul>
	<button class="btn btn-primary btn-block" @click.stop.prevent="addSourceCitation"><i class="fa fa-plus fa-fw"></i> Lisää Lähde tai Viittaus</button>

	<hr/>
	<button type="submit" class="btn btn-success btn-block">Lisää Ohje</button>

	</form>
</div>

	<template id="step-template">
		<div class="panel panel-default">
			<div class="panel-heading">
				@{{index}}.
				<input class="form-control" type="text" name="steps[@{{index}}][title]" placeholder="Aseta askeleen otsikko" v-model="data.title">
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="image">Kuvalinkki</label>
					<input class="form-control" type="text" name="steps[@{{index}}][image]" placeholder="Voit asettaa askeleelle kuvan" v-model="data.image">
				</div>
				<div class="form-group">
					<label for="video">Videolinkki</label>
					<input class="form-control" type="text" name="steps[@{{index}}][video]" placeholder="Voit asettaa askeleelle videon" v-model="data.video">
				</div>
				<div class="form-group">
					<label for="content">Sisältö</label>
					<textarea class="form-control" name="steps[@{{index}}][content]" cols="30" rows="10" v-model="data.content"></textarea>
				</div>
			</div>
			<div class="panel-footer">
				<button class="btn btn-default btn-block" @click.stop.prevent="removeThisStep" v-if="!ready"><i class="fa fa-times fa-fw"></i> Poista askel</button>
				<button class="btn btn-danger btn-block" @click.stop.prevent="removeThisStep" v-if="ready"><i class="fa fa-times fa-fw"></i> Paina uudestaan poistaaksesi askel</button>
			</div>
		</div>
	</template>
</div>
@stop

@section('footer')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.js"></script>
<script>
	Vue.debug = true;
	Vue.component('step', {
		template: '#step-template',
		props: ['index', 'data'],

		data: function(){
			return {
				ready: false
			};
		},

		methods: {
			removeThisStep: function(){
				if(!this.ready){
					this.ready = true;
					setTimeout(function(){
						this.ready = false;
					}.bind(this), 3000);
				} else {
					this.$parent.steps.splice(this.index - 1, 1);
				}
			}
		}
	});

	var app = new Vue({
		el: '#app',

		props: ['steps', 'sourcecitations'],

		methods: {
			addStep: function(index){
				if(index < 1){
					this.steps.push({
						title: '',
						image: '',
						video: '',
						content: ''
					});
				} else {
					this.steps.splice(index, 0, {
						title: '',
						image: '',
						video: '',
						content: ''
					});
				}
			},

			addSourceCitation: function(){
				this.sourcecitations.push({
					text: '',
					link: '',
				});
			},

			removeSourceCitation: function(index){
				console.log(index);
				this.sourcecitations.splice(index, 1);
			}
		},

		ready: function(){
			if(this.steps == null || this.steps == 'null' || typeof this.steps == 'undefined' || this.steps == ''){
				this.steps = [];
			} else {
				this.steps = JSON.parse(this.steps);
			}

			if(this.sourcecitations == null || this.sourcecitations == 'null' || typeof this.sourcecitations == 'undefined' || this.sourcecitations == ''){
				this.sourcecitations = [];
			} else {
				this.sourcecitations = JSON.parse(this.sourcecitations);
			}
		}
	});
</script>
@stop
