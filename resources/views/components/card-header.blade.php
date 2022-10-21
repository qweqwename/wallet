<div {{$attributes->merge([
    "class" => "card-header"
])}}>
    <div class="col">
        <div class="card-title">
            {{$slot}}
        </div>
    </div>
</div>
