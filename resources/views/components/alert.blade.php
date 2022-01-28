<div  {{ $attributes->merge(['class' => 'alert alert-'.$type]) }} >
    {{ $message }}
    {{ $slot??'' }}
    {{ $othertext??'' }}   
</div>
