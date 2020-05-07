@if(count($errors))
    <div class="form-group">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


{{ Form::open([
                'url' => (empty($item)) ? '/add' : '/edit/'.$item['id'], 
                'id' => (empty($item)) ? 'add' : 'edit', 
                'files' => true,
                'enctype' => 'multipart/form-data',
                'class' => 'grid-x grid-padding-x', 
                'autocomplete' => 'off', 
                'name' => (empty($item)) ? 'add' : 'edit'
            ]) 
}}


@isset($item['id'])
    {{ Form::hidden(
            'id', 
            $value = $item['id'], 
            $attributes = array(
                'id'=>'item_id_hidden'
            )
    )}}
@endisset

<div class="cell small-12 parameter default" data-parameter-name="item">
{{ Form::text(
        'name', 
        $value = (isset($item['name'])) ? $item['name'] : '', 
        $attributes = array(
            'id'=>'name_text', 
            'placeholder'=>'Name', 
            'autocomplete'=>'off'
        )
)}}    
</div>

<div class="cell small-12 parameter" data-parameter-name="preposition">
    {{ Form::select(
            'item_type_id', 
            [
                '1' => 'System', 
                '2' => 'Component',
                '3' => 'Element',
            ], 
            (!empty($item['itemTypeId'])) ? $item['itemTypeId'] : null,
            (!empty($item['itemTypeId'])) ? [] : ['placeholder' => 'Type']
    )}}
</div>

<div class="cell small-12 parameter default" data-parameter-name="description">
    {{ Form::textarea(
                'description', 
                (isset($item['description'])) ? $item['description'] : null, 
                [
                    'placeholder'=>'Description'
                ]
    )}}
</div>


<div class="cell small-12 parameter default" data-parameter-name="images">
    {{ Form::file(
            'images'
    )}}
</div>

<div class="cell small-12 parameter default" data-parameter-name="tag_id">
    {{ Form::text(
            'tag_id', 
            $value = (isset($item['tagId'])) ? $item['tagId'] : '', 
            $attributes = array(
                'placeholder'=>'Tag ID'
            )
    )}}
</div>


<div class="cell small-12 parameter default">
    {{ Form::submit('Submit', ['class'=>'button cell small-12']) }}
</div>


{!! Form::close() !!}