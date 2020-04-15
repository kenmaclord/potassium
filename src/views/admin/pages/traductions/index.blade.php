@extends ("potassium::admin.layout", ['page'=>'traductions'])

@section('content')
	<div id="traductions" v-cloak>
		<tabs :store="traductionsStore">
			<tab name="content" title="Traductions" :selected="true">
				<component is="traductions_content" tab="content" inline-template>
					@include('potassium::admin.pages.traductions.traductions')
				</component>
			</tab>

			<tab name="zones" title="Zones">
				<component is="zones" tab="zones" inline-template>
					@include('potassium::admin.pages.traductions.zones')
				</component>
			</tab>

			<tab name="langues" title="Langues">
				<component is="langues" tab="langues" inline-template>
					@include('potassium::admin.pages.traductions.langues')
				</component>
			</tab>
		</tabs>
	</div>
@endsection

