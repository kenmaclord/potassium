@component('mail::message')
@foreach ($introLines as $line)
{!! $line !!}

@component('mail::panel')
**Nom** : {{$request['prenom']}} {{$request['nom']}}  
**Email** : {{$request['email']}}  
**Societe** : {{$request['societe']}}  
**Téléphone** : {{$request['telephone']}}  
**Adresse** : {{$request['adresse']}}  
**Localisation** : {{$request['ville']}}  
**Pays** : {{$request['pays']}}
@endcomponent
@endforeach

@endcomponent
