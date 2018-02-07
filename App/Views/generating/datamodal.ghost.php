<div class="list-group">
    #foreach($objects as $object)
    <button class="list-group-item" type="button" data-element-id="{{$object['id']}}">{{$object['value']}}<span class="badge">{{$object['badge']}}</span></button>
    #endforeach
</div>
