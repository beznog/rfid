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
                'id' => (empty($item)) ? 'add_item' : 'edit_item', 
                'class' => 'grid-x', 
                'autocomplete' => 'off', 
                'name' => (empty($item)) ? 'add_item' : 'edit_item'
            ]) 
}}


@isset($item['id'])
    {{ Form::hidden(
            'item_id', 
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
            'preposition', 
            [
                'system' => 'System', 
                'component' => 'Component',
                'element' => 'Element',
            ], 
            (!empty($item['itemType'])) ? $word['itemType'] : null,
            (!empty($item['itemType'])) ? [] : ['placeholder' => 'Type']
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
    IMAGES TO DO
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


<div class="cell small-12">
    {{ Form::submit('Submit', ['class'=>'button cell small-12']) }}
</div>


{!! Form::close() !!}